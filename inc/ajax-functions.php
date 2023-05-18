<?php 

use PriorityWoocommerceAPI\WooAPI;
//use PriorityWoocommerceAPI\CardPOS;

function gant_ajax_enqueue() {
    global $wp_query; 
	// Enqueue javascript on the frontend.
    wp_enqueue_script('gant-ajax-scripts', get_stylesheet_directory_uri() . '/dist/js/ajax-scripts.js', array('jquery'));
    // The wp_localize_script allows us to output the ajax_url path for our script to use.
	wp_localize_script('gant-ajax-scripts', 'ajax_obj', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
        'woo_shop_url' => get_permalink( wc_get_page_id( 'cart' ) )
    ));
}

add_action( 'wp_enqueue_scripts', 'gant_ajax_enqueue' );

/**
 * send sms before registration
 */
add_action( 'wp_ajax_send_sms', 'send_sms' );
// for non-logged in users:
add_action( 'wp_ajax_nopriv_send_sms', 'send_sms' );

function send_sms(){
    session_start();
    // if ( isset( $_POST['user_fname'] ) && empty( $_POST['user_fname'] ) ) {
    //     $validation_errors->add( 'billing_first_name_error', __( 'First name cannot be left blank.', 'woocommerce' ) );
    // }
    if(isset($_REQUEST['user_phone']) && $_REQUEST['user_phone'] != '') {
        $user_phone = $_REQUEST["user_phone"];
        $fourRandomDigit = rand(1000,9999);
        $msg = __('Validation code is: ', 'gant').$fourRandomDigit;
        SendSMS($msg,$user_phone);
        //SendSMS($msg,'0556642589');
        $_SESSION['code'] = $fourRandomDigit;

    }
}

/**
 * check code equal to sms
 */
add_action( 'wp_ajax_check_code', 'check_code' );
// for non-logged in users:
add_action( 'wp_ajax_nopriv_check_code', 'check_code' );

function check_code(){
    session_start();
    if(isset($_REQUEST['enter_code']) && $_REQUEST['enter_code'] != '') {
        $enter_code = $_REQUEST["enter_code"];
        if($enter_code == $_SESSION['code']){
            $msg =  __('אימות בוצע בהצלחה','gant');
            if ( is_user_logged_in() ) {
                $user = wp_get_current_user();
                update_user_meta( $user->ID, 'sms_code', $_SESSION['code'] );
            }
            wp_send_json_success(['msg' => $msg, 'code' => $_SESSION['code'],'response' => true]);
        }
        else{
            $msg =  __('מספר אימות לא תקין.','gant');
            wp_send_json_success(['msg' => $msg,'response' => false]);
        }
        //unset($_SESSION['code']);
    }
}

//check if user data  are same thatn priority and check if is club

add_action( 'wp_ajax_check_user_data_and_club', 'check_user_data_and_club' );
// for non-logged in users:
add_action( 'wp_ajax_nopriv_check_user_data_and_club', 'check_user_data_and_club' );

function check_user_data_and_club(){
    if(isset($_REQUEST['user_phone']) && $_REQUEST['user_phone'] != '') {
        $user_phone = $_REQUEST["user_phone"];
    }
    if(isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != '') {
        $user_id = $_REQUEST["user_id"];
    }
    $result = CardPOS::instance()->check_user_by_mobile_phone_and_id($user_phone,$user_id);
    $error_code = $result["ErrorCode"];
    if ($error_code == 0) {
        $PosCustomersResult = $result["POSCustomersMembershipDetails"][0];
        //the user exist we have to check if is club
        if(!empty($PosCustomersResult)){
            $is_club = $PosCustomersResult["ClubsMemberships"];
            if(!empty($is_club)){
                //user data match and is club so we create this user
                

                $priority_customer_number = $PosCustomersResult["POSCustomerBasicDetails"]["POSCustomerNumber"];
                $username = $PosCustomersResult["POSCustomerBasicDetails"]["MobileNumber"];
                $email = $PosCustomersResult["POSCustomerBasicDetails"]["Email"];
                $fname = $PosCustomersResult["POSCustomerBasicDetails"]["FirstName"];
                $lname = $PosCustomersResult["POSCustomerBasicDetails"]["LastName"];
                $fullname = $PosCustomersResult["POSCustomerBasicDetails"]["FullName"];
                $displayname = $PosCustomersResult["POSCustomerBasicDetails"]["FirstName"];
                $user_city = $PosCustomersResult["POSCustomerBasicDetails"]["City"];
                $user_address_1 = $PosCustomersResult["POSCustomerBasicDetails"]["Address"];
                $user_address_2 = $PosCustomersResult["POSCustomerBasicDetails"]["Address2"];
                $user_city = $PosCustomersResult["POSCustomerBasicDetails"]["City"];
                $user_zipcode = $PosCustomersResult["POSCustomerBasicDetails"]["ZipCode"];
                $user_birthId = $PosCustomersResult["POSCustomerBasicDetails"]["BirthID"];
                $user_birthDate = $PosCustomersResult["POSCustomerBasicDetails"]["BirthDate"];
    
                $encryption_key = "my_secret_key";

                // Get the encrypted number from the session
                $encrypted_number = $_SESSION['encrypted_number'];

                // Decrypt the number using the AES algorithm
                $user_password = openssl_decrypt($encrypted_number, "AES-256-CBC", $encryption_key);

        
                $user_id = wp_insert_user(array(
                    'user_login'  =>  $username,
                    'user_email'  =>  (!empty($email)) ? $email : $username.'@gmail.com',
                    'user_pass' => $user_password,
                    'first_name'  =>  $fname,
                    'last_name'  =>  $lname,
                    'role' => 'customer',
                    'user_nicename' => $fullname,
                    'display_name'  => $fullname,
                ));
                if (is_wp_error($user_id)) {
                    $multiple_recipients = array(
                        get_bloginfo('admin_email')
                    );
                    $subj = 'Error creating user from priority';
                    $body = $user_id->get_error_message().'</br>';
                    $body.= 'username:'.$username.', first name:'.$fname.',last_name: '.$lname;
                    wp_mail( $multiple_recipients, $subj, $body );
                }
                else{
                    $user = get_user_by('id', $user_id);
                    $user_login = $user->user_login;
                    wp_set_current_user($user_id, $user_login);
                    wp_set_auth_cookie($user_id);
                    do_action('wp_login', $user_login,$user);

                    //$wc = new WC_Emails();
                    //$wc->customer_new_account($user_id);
                }
                
                update_user_meta($user_id, 'priority_customer_number', $priority_customer_number);
                update_user_meta($user_id, 'billing_address_1', $user_address_1);
                update_user_meta($user_id, 'billing_address_2', $user_address_2);
                update_user_meta($user_id, 'billing_city', $user_city);
                update_user_meta($user_id, 'billing_phone', $username);
                update_user_meta($user_id, 'billing_postcode', $user_zipcode);
                update_user_meta($user_id, 'account_id', $user_birthId);
                update_user_meta($user_id, 'reg_birthday', $user_birthDate);
                update_user_meta($user_id, 'has_to_edit_details', 1);

                //update club
                update_user_meta($user_id, 'is_club', 1);
                update_user_meta($user_id, 'club_fee_paid', 1);

               


                //update user points and birthday
                $raw_option = WooAPI::instance()->option('setting-config');
                $raw_option = str_replace(array("\n", "\t", "\r"), '', $raw_option);
                $config = json_decode(stripslashes($raw_option));
                $branch_num = $config->BranchNumber;
                $unique_id = $config->UniqueIdentifier;
                $pos_num = $config->POSNumber;

                $priority_customer_number = get_user_meta($user_id, 'priority_customer_number', true);

                $data["POSCustomerNumber"] = $priority_customer_number;
                $data["ClubCode"] = "01";
                $data['UniquePOSIdentifier'] = [
                    "BranchNumber" => $branch_num,
                    "POSNumber" => $pos_num,
                    "UniqueIdentifier" => $unique_id,
                    "ChannelCode" => "",
                    "VendorCode" => "",
                    "ExternalAccountID" => ""
                ];

                $form_name =  'PosCustomers';

                $form_action = 'GetPOSCustomerWithExtendedDetails';

                $body_array = CardPOS::instance()->makeRequestCardPos('POST', $form_name , $form_action, ['body' => json_encode($data)], true);
                $error_code = $body_array["ErrorCode"];
                if($error_code == 0){
                    if(!empty($body_array["POSCustomerExtendedDetails"]["PointsPerPointsTypeDetails"])){
                        $points = $body_array["POSCustomerExtendedDetails"]["PointsPerPointsTypeDetails"][0]["TotalPoints"];
                        update_user_meta( $user_id, 'points_club', $points);
                    } 
                    if(!empty($body_array["POSCustomerExtendedDetails"]["CouponEligibilities"])){
                        $coupon = $body_array["POSCustomerExtendedDetails"]["CouponEligibilities"][0]["OriginalCouponDescription"];
                        $coupon_code = $body_array["POSCustomerExtendedDetails"]["CouponEligibilities"][0]["CouponCode"];
                        if($coupon == "יומהולדת"){
                            update_user_meta( $user_id, 'birthday_coupon', $coupon_code);
                        }

                    }
                    else{
                        if(get_user_meta( $user_id, 'birthday_coupon', true ))
                            delete_user_meta( $user_id, 'birthday_coupon' );
                    }
                }
                else{
                    $message = $body_array['EdeaError']['DisplayErrorMessage'];
                    $multiple_recipients = array(
                        get_bloginfo('admin_email')
                    );
                    $subj = 'Error sync user with extended details1: '.$user_id;
                    wp_mail( $multiple_recipients, $subj, $message );
                }
                

                $response = array(
                    'message' => 'is_club',
                );
            }
            else{
                $response = array(
                    'message' => 'is_not_club',
                );
                
            }
        }

        //user data not match priority data or doesnt exit in priority
        else{
            $result = CardPOS::instance()->check_user_by_mobile_phone($user_phone);
            $error_code = $result["ErrorCode"];
            if ($error_code == 0) {
                $PosCustomersResult = $result["POSCustomersMembershipDetails"][0];
                if(empty($PosCustomersResult)){
                    $result =  CardPOS::instance()->check_user_by_id_num($user_id);
                    $error_code = $result["ErrorCode"];
                    if ($error_code == 0) {
                        $PosCustomersResult = $result["POSCustomersMembershipDetails"][0];
                        if(empty($PosCustomersResult)){
                            $response = array(
                                'message' => 'is_not_exist',
                            );
                        }
                        else{
                            //user exit by id but not by id and phone so he has to call client service to update details
                            $response = array(
                                'message' => 'is_not_match',
                            );
                        }
                    }
                    else{
                        $message = $result['EdeaError']['DisplayErrorMessage'];
                        $multiple_recipients = array(
                            get_bloginfo('admin_email')
                        );
                        $subj = 'Error check user exist with id number in priority';
                        wp_mail( $multiple_recipients, $subj, $message );
                    }
                }
                else{
                    //user exit by phone but not by id and phone so he has to call client service to update details
                    $response = array(
                        'message' => 'is_not_match',
                    );
                }
            }
            else{
                $message = $result['EdeaError']['DisplayErrorMessage'];
                $multiple_recipients = array(
                    get_bloginfo('admin_email')
                );
                $subj = 'Error check user exist with mobile phone in priority';
                wp_mail( $multiple_recipients, $subj, $message );
            }
        }
        wp_send_json($response);
        wp_die();
    }
    else{
        $message = $result['EdeaError']['DisplayErrorMessage'];
        $multiple_recipients = array(
            get_bloginfo('admin_email')
        );
        $subj = 'Error check user exist with phone and id in priority';
        wp_mail( $multiple_recipients, $subj, $message );
    }
}

/**
 * search result in menu
 */
add_action( 'wp_ajax_get_search_ajax_query', 'get_search_ajax_query' );
// for non-logged in users:
add_action( 'wp_ajax_nopriv_get_search_ajax_query', 'get_search_ajax_query' );

function get_search_ajax_query(){
   $sterm = '';
   if(isset($_REQUEST['sterm']) && $_REQUEST['sterm'] != '') {
       $search = sanitize_text_field($_REQUEST["sterm"]);
   }
   $q1 = get_posts(array(
    'post_type' => array('product', 'product_variation'),
    'post_status' => 'publish',
    'posts_per_page' => '-1',
    's' => $search
    ));
    //print_r($q1);
    $q2 = get_posts(array(
        'post_type' => array('product', 'product_variation'),
        //'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query' => array(
            'relation' => 'OR',
            array(
            'key' => '_sku',
            'value' => $search,
            'compare' => '='
            ),
            array(
                'key' => '_variable_sku',
                'value' => $search,
                'compare' => '='
            )
        )
    ));
    //print_r($q2);
    $merged = array_merge( $q1, $q2 );
    //print_r($merged);
    $post_ids = array();
    foreach( $merged as $item ) {
        $post_ids[] = $item->ID;
    }
    //print_r($post_ids);
    $unique = array_unique($post_ids);
    if(!$unique){
        $unique=array('0');
    }
    //print_r($unique);
    $args = array(
        'post_type' => array('product', 'product_variation'),
        'posts_per_page' => '4',
        'post__in' => $unique,
        'paged' => get_query_var('paged'),
    );

    $search_query = new WP_Query($args);
    ob_start();
    if($search_query->have_posts()) {
        $html .= "<div class='search_suggestions_products_wrapper'>";
        while ($search_query->have_posts()) :
            $search_query->the_post();
            get_template_part('page-templates/box-product');
            
        endwhile;
        $html .= ob_get_clean();
        $html .= "</div>";
    }

    echo json_encode(
        array(
            'success' => true,
            'result' => $html,
        )
    );
    wp_reset_query();
    die();
}

//add_action('wp_ajax_loadmore', 'loadmore'); // wp_ajax_{action}
//add_action('wp_ajax_nopriv_loadmore', 'loadmore'); 

function loadmore(){
    // prepare our arguments for the query
	if(isset($_REQUEST['page']) && $_REQUEST['page'] != '') {
        $paged = $_REQUEST['page'] + 1;
    }
    if(isset($_REQUEST['pdt_cat']) && $_REQUEST['pdt_cat'] != '') {
        $pdt_cat = $_REQUEST['pdt_cat'];
    }
    $args = array(
        'post_type' => 'product',
        'product_cat' => $pdt_cat ,
        'posts_per_page' => get_option('posts_per_page'),
        'paged' => $paged,
        'post_status' => array('publish'),
    );

	query_posts( $args );
 
	if( have_posts() ) :
 
		// run the loop
		while( have_posts() ): the_post();
			get_template_part( 'page-templates/box-product' );
		endwhile;
	endif;
	die; 
}

// Utility function to get the parent variable product IDs for a any term of a taxonomy
function get_variation_parent_ids_from_term( $term, $taxonomy, $type ){
    global $wpdb;

    return $wpdb->get_col( "
        SELECT DISTINCT p.ID
        FROM {$wpdb->prefix}posts as p
        INNER JOIN {$wpdb->prefix}posts as p2 ON p2.post_parent = p.ID
        INNER JOIN {$wpdb->prefix}term_relationships as tr ON p.ID = tr.object_id
        INNER JOIN {$wpdb->prefix}term_taxonomy as tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
        INNER JOIN {$wpdb->prefix}terms as t ON tt.term_id = t.term_id
        WHERE p.post_type = 'product'
        AND p.post_status = 'publish'
        AND p2.post_status = 'publish'
        AND tt.taxonomy = '$taxonomy'
        AND t.$type = '$term'
    " );
}


add_action( 'wp_ajax_filter_products', 'filter_products' );
add_action( 'wp_ajax_nopriv_filter_products', 'filter_products' );
function filter_products(){
    $meta_qry[] = array(
        array(
            'key' => '_stock_status',
            'value' => 'instock',
            'compare' => '=',
        ),
        // array(
        //     'key' => '_thumbnail_id',
        //     'compare' => 'EXISTS',
        // )
    );
    $clr = $_REQUEST["colors"];
    if (isset( $_REQUEST['colors'] )  && $_REQUEST['colors'] != ''){  
        $meta_qry[] =          array(
            'key'	 	=> 'grouped_color',
            'value'	  	=> $clr ,
            //'compare' 	=> '=',
        );
            
    }
    if (isset( $_REQUEST['order'] )  && $_REQUEST['order'] != ''){  
        if($_REQUEST['order'] == 'popularity'){
            $meta_key= 'total_sales';
            $order_by = 'meta_value_num';
            $order = 'DESC';
            
        }
        else{
            $order = $_REQUEST['order'];
            $order_by = 'meta_value_num';
            $meta_key= '_price';
        }

    }

    if (isset( $_REQUEST['prices'] )  && $_REQUEST['prices'] != ''){  
        if($_REQUEST['prices'] == '1000'){
            $meta_qry[] =          array(
                'key'	 	=> '_price',
                'value'	  	=>  $_REQUEST['prices'],
                'compare' 	=> '>=',
                'type' => 'NUMERIC'
            );
        }
        else{
            $price_arr = explode (",", $_REQUEST['prices']); 
            $meta_qry[] =          array(
                    'key'	 	=> '_price',
                    'value'	  	=>  $price_arr,
                    'compare' 	=> 'BETWEEN',
                    'type' => 'NUMERIC'
            );    
        }
    }

    $cuts = $_REQUEST["cuts"];
    if (isset( $_REQUEST['cuts'] )  && $_REQUEST['cuts'] != ''){  
        $meta_qry[] =            array(
            'key'	 	=> 'cut',
            'value'	  	=> $cuts ,
            //'compare' 	=> '=',
        );    
    }
   
    if (isset( $_REQUEST['categories'] )  && $_REQUEST['categories'] != ''){ 
        $cat = $_REQUEST["categories"];
        foreach($cat as $item){
            $cat_name[] = get_the_category_by_ID($item);
        }

    }
    if (isset( $_REQUEST['substainility'] )  && $_REQUEST['substainility'] != ''){  
        $tax_qry[] = array(
            'taxonomy' => 'product_tag',
            'field' => 'term_id',
            'terms' =>  $_REQUEST['substainility'],
        );
    }
    
    if (isset( $_REQUEST['categories'] )  && $_REQUEST['categories'] != ''){  
        $tax_qry[] = array(
            'taxonomy' => 'product_cat',
            'field' => 'term_id',
            'terms' => $cat,
            'operator' => 'IN',
        );
    }
    
    if (isset( $_REQUEST['sizes'] )  && $_REQUEST['sizes'] != ''){  
        $size = $_REQUEST["sizes"];
        $tax_qry = array();
        unset($tax_qry);
        $post_parent_in=[];
        $post_parent_in2 = [];
        foreach( $cat_name as $name){
            $post_parent_in1    = array_merge($post_parent_in,get_variation_parent_ids_from_term($name, 'product_cat', 'name' )); // Variations
        }
        if (isset( $_REQUEST['substainility'] )  && $_REQUEST['substainility'] != ''){ 
            $post_parent_in2    = get_variation_parent_ids_from_term('sustainable-choice', 'product_tag', 'slug' );
        }
        if(!empty($post_parent_in2))
            $post_parent_in = array_intersect($post_parent_in1,$post_parent_in2);
        else
        $post_parent_in = $post_parent_in1;
        $meta_qry[] =  array(
            'key'     => 'attribute_pa_size',
            'value'   => $size,
            'compare' => 'IN',
        );
    }


    $query_type = '';
    if(isset($_REQUEST['query_type']) && $_REQUEST['query_type'] != '') {
        $query_type = $_REQUEST['query_type'];
    }
    // if(isset($_REQUEST['current_pdt_in_page']) && $_REQUEST['current_pdt_in_page'] != '') {
    //     $current_pdt_in_page = $_REQUEST['current_pdt_in_page'];
    // }

    $filters = false;
    if(isset($_REQUEST['filters']) && $_REQUEST['filters'] != '') {
        if($_REQUEST['filters'] == 'false') {
            $filters = false;
        } else {
            $filters = true;
        }
    }
    // Load More Query
    if($query_type == 'load_more') {
        $paged = $_REQUEST['paged'] + 1;
        $offset = $_REQUEST['paged'] * get_option('posts_per_page');
        $current_pdt_in_page = (int)get_option('posts_per_page');

    }
    if($query_type == 'filter') {
        $paged = 1;
        $offset  = 0;
        $current_pdt_in_page = (int)get_option('posts_per_page');
        $actual_link = $_SERVER["HTTP_REFERER"];
        if (strpos($actual_link,'pdts') !== false) {
            $current_pdt_in_page = (int)ltrim(strstr($actual_link, '='), '='); 
            //$paged = (int)$_REQUEST['paged'];
        }
        
        
    }

    
    
    $args = array(
        'post_type' =>  array('product', 'product_variation'),
        'posts_per_page' =>  $current_pdt_in_page,
        'post_status' => array('publish'),
        'meta_key' => $meta_key,
        'orderby'  => array(
            $order_by => $order,
            'menu_order'      => 'ASC',
        ),
        //'orderby' => $order_by. ' menu_order',
        //'order' => $order,
        'post_parent__in' => (!empty($post_parent_in)) ? $post_parent_in : null,
        'meta_query'	=> array(
            'relation'		=> 'AND',
            $meta_qry
        ),
        'tax_query'  => array(
            'relation'		=> 'AND',
            $tax_qry,
        ),

        'paged' => $paged,
        //'offset' => $offset
    );
    
    $args_without_paged = array(
        'post_type' =>  array('product', 'product_variation'),
        'posts_per_page' => -1,
        'post_status' => array('publish'),
        'meta_key' => $meta_key,
        'orderby'  => array(
            $order_by => $order,
            'menu_order'      => 'ASC',
        ),
        // 'orderby' => $order_by. ' menu_order',
        // 'order' => $order,
        'post_parent__in' => (!empty($post_parent_in)) ? $post_parent_in : null,
        'meta_query'	=> array(
            'relation'		=> 'AND',
            $meta_qry
        ),
        'tax_query'  => array(
            'relation'		=> 'AND',
            $tax_qry,
        ),
        
        //'paged' => $paged,
    );

    // echo "<pre>";
    // print_r($args_without_paged);
    // echo "</pre>";

    if($query_type == 'query' && isset($_REQUEST['paged']) && $_REQUEST['paged'] != '') {
        $paged = $_REQUEST['paged'] + 1;
    }

    $html .= "";
    $dl_query = new WP_Query($args);
    $dl_query_without_paged = new WP_Query($args_without_paged);


    $post_ids = wp_list_pluck( $dl_query->posts, 'ID' );
    //print_r($post_ids);
    $tot_post_ids = wp_list_pluck( $dl_query_without_paged->posts, 'ID' );
    $tot_pdts_result = array();
    foreach($tot_post_ids as $variation_id){
        $variation  = wc_get_product( $variation_id );
        if(!empty($variation->get_parent_id())){
            $product = wc_get_product( $variation->get_parent_id() );
        }
        else{
            $product = wc_get_product( $variation_id );
        }
        $tot_pdts_result[] = $product->get_id();
        //echo $product->get_id().',';
    }
    $tot_pdts_result = array_unique($tot_pdts_result);
    // echo 'tot_pdts_result';
    // echo '<pre>';
    // print_r( $tot_pdts_result);
    // echo '</pre>';


  
    $pdts_result = array();
    foreach($post_ids as $variation_id){
        $variation  = wc_get_product( $variation_id );
        if(!empty($variation->get_parent_id())){
            $product = wc_get_product( $variation->get_parent_id() );
        }
        else{
            $product = wc_get_product( $variation_id );
        }
        $pdts_result[] = $product->get_id();
        //echo $product->get_id().',';
    }
    $featured_pdts = array_unique($pdts_result);


    // echo 'featured_pdts';
    // echo '<pre>';
    // print_r( $featured_pdts);
    // echo '</pre>';



    
    foreach( $featured_pdts as $product ):
        setup_postdata( $product );
        get_template_part('page-templates/box-product'); 
        wp_reset_postdata(); 
    endforeach;
    $found_posts = count($tot_pdts_result);
    $max_page = $found_posts / get_option( 'posts_per_page' );


    $html .= ob_get_clean();
    $html .= "";

    $more_items = false;    
    if($paged >= $max_page) {
        $more_items = false;
    } else {
        $more_items = true;
        
    }
    
    $no_results = false;
    if($dl_query->post_count == 0) {
        $no_results = '<div class="no_result_txt">'.get_field('empty_search_text', 'options').'<div>';    
    }
    echo json_encode(
        array(
            'success' => true,
            '$query_type' => $query_type,
            'more_items' => $more_items,
            'max_page'  => ceil($max_page),
            'total_results' => $dl_query->post_count,
            'found_posts' => $found_posts,
            'paged' => $paged,
            'result' => $html,
            'args' => $args,
            'no_results' => $no_results
        )
    );
    
    
    wp_reset_query();
	die; 
}
add_action( 'plugins_loaded', 'check_plugin_loaded' );

function check_plugin_loadedcheck_plugin_loaded() {
    require_once WP_PLUGIN_DIR. '/WooCommercePriorityAPI/includes/classes/card_pos/card_pos.php';
    //require_once WP_PLUGIN_DIR. '/WooCommercePriorityAPI/includes/classes/wooapi.php';
}

//on remove product, we need:
//1- to check that the bag is not locked

add_action( 'wp_ajax_product_remove', 'product_remove' );
add_action( 'wp_ajax_nopriv_product_remove', 'product_remove' );
function product_remove() {
    global $wpdb, $woocommerce;
    $count = $woocommerce->cart->get_cart_contents_count();
    $product_id = absint($_POST['product_id']); 
    

    //before removing check if bag is locked 
    $form_name = 'Transactions';
    $form_action = 'UpdateTransaction';
    $data = CardPOS::instance()->openOrUpdateTransaction(0,0,0);
    //print_r($data);die;
    $data = json_encode($data);
    $result = CardPOS::instance()->makeRequestCardPos('POST', $form_name , $form_action,  ['body' => $data], true);
    $error_code = $result["ErrorCode"];
    //print_r($result);die;
    //$error_src = $result['EdeaError']['ErrorSource'];
    if ($error_code != 0) {
        // the order is locked so cancel
        if($error_code == 59){
            CardPOS::instance()->cancel_transaction();
            
        }
    }

    
    foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item){
        $temporarytransactionnumber = $cart_item['temporary_transaction_num'];
        if($cart_item['variation_id'] == $product_id ){
            // Remove product in the cart using  cart_item_key.
            $woocommerce->cart->remove_cart_item( $cart_item_key );
        }
    }
    //save in temporary array the new bag 
    $data = CardPOS::instance()->openOrUpdateTransaction(0,0,0);
    $data['temporaryTransactionNumber'] = $temporarytransactionnumber ;
    $check = $temporarytransactionnumber;
    $form_name = 'Transactions';

    $form_action = 'UpdateTransaction';
    $data = json_encode($data);
    $result = CardPOS::instance()->makeRequestCardPos('POST', $form_name , $form_action,  ['body' => $data], true);
    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity,$cart_item_data);
    $product_status = get_post_status($product_id);
        //$result =  CardPOS::instance()->openOrUpdateTransaction($product_id,$quantity, $variation_id );
    $error_code = $result["ErrorCode"];
    if ($error_code == 0) {
        update_bag_after_sync($passed_validation,$product_status,$result);
        //$result_order_items = $result["Transaction"]["OrderItems"];
        //if cart is not empty, before adding to bag , remove all products from bag
        // if ( WC()->cart->get_cart_contents_count() != 0 ) {
        //     foreach ( WC()->cart->get_cart_contents() as $key => $cart_item ) {
        //         WC()->cart->remove_cart_item($key);
        //     }
        //     if(!empty($result_order_items)){
        //         foreach($result_order_items as $key=>$item){
        //             //save transaction array to first product in cart data to send id to approve
        //             if($key == 0){
        //                 //$lastupdate_transaction_array = [];
        //                 $lastupdate_transaction_array = array('lastupdate_transaction' => $result);
        //                 $lastappprove_transaction_array = array('lastapprove_transaction' => array());
        //                 $cart_item_data  = array_merge($cart_item_data, $lastupdate_transaction_array,$lastappprove_transaction_array); 
        //             }
        //             $sku = $item['ItemCode'];  //2201666S
        //             $current_variation_id = wc_get_product_id_by_sku($sku); //4836
        //             $current_product_id = wp_get_post_parent_id($current_variation_id); //4830
        //             //if($current_product_id == $product_id){
        //             $qtty = $item['ItemQuantity'];
        //             $price = $item['PricePerItem'];
        //             $tot_price = $item['TotalPrice']; // price after discount for all quantity 
        //             $final_price = $item['FinalPrice']; //price after discount for one product
        //             // Cart item data to send & save in order
        //             //if sale price
        //             if($final_price != $price){
        //                 $edea_price = array('edea_price' => $final_price);
        //                 $cart_item_data  = array_merge($cart_item_data, $edea_price);
        //             }
        
        //             //just for test because I dont have price sale
        //             //$edea_price = array('edea_price' => 100);
        //             //$cart_item_data  = array_merge($cart_item_data, $edea_price);
            
        //             WC()->cart->add_to_cart($current_product_id, $qtty, $current_variation_id,array(),$cart_item_data);
        //         }
        //     }
        // }
        WC_AJAX :: get_refreshed_fragments();
    }
    
    else{
        
        $error_msg = $result['EdeaError']['DisplayErrorMessage'];
        wc_add_notice( 'error in update transaction when removing product from bag: '.$error_msg, 'error' );
        exit;
    }


    
    exit();
}

// add_action( 'wp_ajax_update_cart_item_quantity', 'update_cart_item_quantity' );
// add_action( 'wp_ajax_nopriv_update_cart_item_quantity', 'update_cart_item_quantity' );

// function update_cart_item_quantity() {
//     $product_id = intval( $_POST['product_id'] );
//     $quantity = intval( $_POST['quantity'] );
//     $cart_item_key = WC()->cart->generate_cart_id( $product_id );
//     $cart_item = WC()->cart->get_cart_item( $cart_item_key );
//     if ( $cart_item ) {
//         WC()->cart->set_quantity( $cart_item_key, $quantity );
//         echo 'success';
//     }
//     wp_die();
// }



add_action('wp_ajax_update_bag', 'update_bag');
add_action('wp_ajax_nopriv_update_bag', 'update_bag');


        
function update_bag() {
    global $woocommerce;

    $data = CardPOS::instance()->openOrUpdateTransaction(0,0, 0 );
    $temporarytransactionnumber = $data['temporaryTransactionNumber'];
    $form_name = 'Transactions';

    if($temporarytransactionnumber == null){
        $form_action = 'OpenTransaction';
    }
    else{
        $form_action = 'UpdateTransaction';
    }
    $data = json_encode($data);
  
    $result = CardPOS::instance()->makeRequestCardPos('POST', $form_name , $form_action,  ['body' => $data], true);
    //$result =  CardPOS::instance()->openOrUpdateTransaction($product_id,$quantity, $variation_id );
    $error_code = $result["ErrorCode"];
    $product_status = 'publish';
    $passed_validation = true;
    if ($error_code == 0) {
        update_bag_after_sync($passed_validation,$product_status,$result);
        $i = 0;
        if ( WC()->cart->get_cart_contents_count() > 0 ) {
            foreach ( WC()->cart->get_cart_contents() as $cart_item ) {
                if($i == 0){
                    $last_update_transaction = $cart_item['lastupdate_transaction']['Transaction'];
                    $i ++;
                }
            }
            echo wp_send_json($last_update_transaction);
        }
    }
    else {
        //$error_src = $result['EdeaError']['ErrorSource'];
        // the order is locked so cancel
        if($error_code == 59){
            $i = 0;
            foreach ( WC()->cart->get_cart_contents() as $key =>$cart_item ) {
                //iterate only once, to get transaction array
                if($i!=0)  break;
                $raw_option = WooAPI::instance()->option('setting-config');
                $raw_option = str_replace(array("\n", "\t", "\r"), '', $raw_option);
                $config = json_decode(stripslashes($raw_option));
                $branch_num = $config->BranchNumber;
                $unique_id = $config->UniqueIdentifier;
                $pos_num = $config->POSNumber;
                //retrieve approve result from cart to send it to cancel to allow adding product to bag after that te btransaction was locked
                $data = $cart_item['lastapprove_transaction'];
                $data['UniquePOSIdentifier'] = [
                    "BranchNumber" => $branch_num,
                    "POSNumber" => $pos_num,
                    "UniqueIdentifier" => $unique_id,
                    "ChannelCode" => "",
                    "VendorCode" => "",
                    "ExternalAccountID" => ""
                ];
        
                $form_name = 'Transactions';
                $form_action = 'CancelTransactionApproval';
        
        
                $data = json_encode($data);
                $result_cancel = CardPOS::instance()->makeRequestCardPos('POST', $form_name , $form_action,  ['body' => $data], true);
                $error_code = $result_cancel["ErrorCode"];
                if ($error_code == 0) {
                 //echo 'enter if';
                    $cart_item['lastapprove_transaction'] =  $result_cancel; 
                    //$cart_item['cart_locked'] =  'true';    
                    WC()->cart->cart_contents[$key] = $cart_item;
                    
                    update_bag_after_sync($passed_validation,$product_status,$result_cancel);
                }
                else{
                    //echo 'enter else';
                    $error_msg = $result['EdeaError']['DisplayErrorMessage'];
                    wc_add_notice( 'error cancel transaction before adding to bag: '.$error_msg, 'error' );
                    exit;
                }
                $i++;
            }
            WC()->cart->set_session();
            wp_die();
        }
        else{
           
            $error_msg = $result['EdeaError']['DisplayErrorMessage'];
            wc_add_notice( 'error adding product to bag: '.$error_msg, 'error' );
            $html_msg = wc_print_notices(1);
            //echo $html_msg;die;
            $data = array(
                'error' => true,
                'error_msg' => $html_msg,
                'data' => $data
                //'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
            );
            
            echo wp_send_json($data);
            wp_die();
            
        }
    }

    wp_die();
}



add_action('wp_ajax_update_transaction_from_cart', 'update_transaction_from_cart');
add_action('wp_ajax_nopriv_update_transaction_from_cart', 'update_transaction_from_cart');

function update_transaction_from_cart(){
    foreach ( WC()->cart->get_cart_contents() as $cart_item ) {
        if($i == 0){
            $temporarytransactionnumber = $cart_item['temporary_transaction_num'];
            $i ++;
        }
    }
    $cart_item_array = $_POST['cart_item_array'];
    //print_r( $_POST['cart_item_array']);
    foreach($cart_item_array as  $cart_item){
        $quantity = $cart_item['quantity'];
        $variation_id = $cart_item['product_id'];
        $price = get_post_meta($variation_id, '_price', true);
        $sku = get_post_meta( $variation_id, '_sku', true );
        if($quantity == 0) continue;
        $items_in_bag [] = [
            'OrderItemBasicInputDetails' => [
                "ItemCode" => $sku,
                "Barcode" => "",
                "ItemQuantity" => $quantity,
                "PricePerItem" => $price,
                "CalculatePrice" => false,
                "IsManualPrice" => false,
                "IsManualDiscount" => false,
                "VATPercent" => 17,
                "ClubCode" => ""
            ],
            "PointsPerType" => []
        ];
    }
    $raw_option = WooAPI::instance()->option('setting-config');
    $raw_option = str_replace(array("\n", "\t", "\r"), '', $raw_option);
    $config = json_decode(stripslashes($raw_option));
    $branch_num = $config->BranchNumber;
    $unique_id = $config->UniqueIdentifier;
    $pos_num = $config->POSNumber;

    if (is_user_logged_in() ) {
        $current_user = wp_get_current_user();
        $user_id = $current_user->ID;
        $cust_priority_number = get_user_meta($user_id, 'priority_customer_number', true);
        $cust_name = $current_user->user_firstname.' '.$current_user->user_lastname;
        $billing_address_1 = get_user_meta($user_id, 'billing_address_1', true);
        $billing_city = get_user_meta($user_id, 'billing_city', true);
        $billing_postcode = get_user_meta($user_id, 'billing_postcode', true);
        $cust_phone = get_user_meta($user_id, 'billing_phone', true);
        $cust_id_number = get_user_meta($user_id, 'account_id', true);
        $is_club = get_user_meta($user_id, 'is_club', true);
        $has_paid_club = get_user_meta( $user_id, 'club_fee_paid', true );
    }
    else{
        $cust_priority_number = '';
        $cust_name = '';
        $billing_address_1 = '';
        $billing_city = '';
        $billing_postcode = '';
        $cust_phone = '';
        $cust_id_number = '';
        $is_club = '';
        $has_paid_club = 1;
    }

    if(!empty($is_club)){
        $club_code = '01';
    }
    else{
        $club_code = '';
    }

    $data['Transaction']['TransactionBasicDetails'] = [
        "TemporaryTransactionNumber" => $temporarytransactionnumber,
        "TransactionDateTime" => "2022-11-06T10:12:54.619Z",
        "IsOrder" => true,
        "IsCancelTransaction" => false,
        "POSCustomerNumber" => $cust_priority_number,
        "ClubCode" => $club_code,
        "IsManualDiscount" => false,
        "SupplyBranch" => ""
    ];
    $data['Transaction']['TransactionItems'] = [];

    $data['Transaction']['ShippingDetails'] = [
        "City" => "",
        "ForeignLanguageCity" => "",
        "Address" => "",
        "ForeignLanguageAddress" => "",
        "HouseNumber" => 0,
        "ApartmentNumber" => 0,
        "ZipCode" => "",
        "ContactPersonName" => "",
        "ForeignLanguageContactPersonName" => "",
        "Mail" => "",
        "Fax" => "",
        "SupplyDate" => "2022-11-06T10:12:54.619Z",
        "FromSupplyHour" => "2022-11-06T10:12:54.619Z",
        "ToSupplyHour" => "2022-11-06T10:12:54.619Z",
        "Remark" => "",
        "ForeignLanguageRemark" => "",
        "FirstPhoneNumber" => "",
        "SecondPhoneNumber" => "",
        "ShipMethod" => "",
        "Address2" => "",
        "Address3" => "",
        "Email" => ""
    ];

    $data['Transaction']['OrderItems'] = $items_in_bag;

    $default_club = '777';
    $default_club = $config->CLUB_DEFAULT_PARTNAME ?? $default_club;
    $fee_amount  = get_field('club_cost','option');
    if($has_paid_club == 0 && $club_code == '01'){
        $data['Transaction']['OrderItems'][] = [
            'OrderItemBasicInputDetails' => [
                "ItemCode" => $default_club,
                "Barcode" => "",
                "ItemQuantity" => 1,
                "PricePerItem" => $fee_amount,
                "CalculatePrice" => false,
                "IsManualPrice" => false,
                "IsManualDiscount" => false,
                "VATPercent" => 17,
                "ClubCode" => "01"
            ],
            "PointsPerType" => []
        ];
    }

    $data['Transaction']['Remark'] = [
        "CustomerName" => $cust_name,
        "CustomerIDNumber" => $cust_id_number,
        "CustomerPhone" => $cust_phone,
        "CustomerAddress" => $billing_address_1,
        "CustomerCity" => $billing_city,
        "CustomerZipCode" => $billing_postcode
    ];

    $data['temporaryTransactionNumber'] = $temporarytransactionnumber;

    $data['TransactionProcessingSettings'] = [
        "CalculateSales" => true,
        "ContainExternalMetaData" => false,
        "RegisterByGeneralPosCustomer" => !empty($cust_priority_number) ? false : true,
        "RetrieveItemPictureFilename" => false,
        "CalculateTax" => 0
    ];

    $data['UniquePOSIdentifier'] = [
        "BranchNumber" => $branch_num,
        "POSNumber" => $pos_num,
        "UniqueIdentifier" => $unique_id,
        "ChannelCode" => "",
        "VendorCode" => "",
        "ExternalAccountID" => ""
    ];

    $form_name = 'Transactions';

    $form_action = 'UpdateTransaction';
    //print_r($data);die;
    $data = json_encode($data);
    //print_r($data);
    $result = CardPOS::instance()->makeRequestCardPos('POST', $form_name , $form_action,  ['body' => $data], true);
    //$result =  CardPOS::instance()->openOrUpdateTransaction($product_id,$quantity, $variation_id );
    //print_r($result);die;
    $error_code = $result["ErrorCode"];
    $product_status = 'publish';
    $passed_validation = true;

    if ($error_code == 0) {
        update_bag_after_sync($passed_validation,$product_status,$result);
        $i = 0;
        foreach ( WC()->cart->get_cart_contents() as $cart_item ) {
            if($i == 0){
                $last_update_transaction = $cart_item['lastupdate_transaction']['Transaction'];
                $i ++;
            }
        }
        echo wp_send_json($last_update_transaction);
    }
    else {
        //$error_src = $result['EdeaError']['ErrorSource'];
        // the order is locked so cancel
        if($error_code == 59){
            $i = 0;
            foreach ( WC()->cart->get_cart_contents() as $key =>$cart_item ) {
                //iterate only once, to get transaction array
                if($i!=0)  break;
                //retrieve approve result from cart to send it to cancel to allow adding product to bag after that te btransaction was locked
                $data = $cart_item['lastapprove_transaction'];
                $data['UniquePOSIdentifier'] = [
                    "BranchNumber" => $branch_num,
                    "POSNumber" => $pos_num,
                    "UniqueIdentifier" => $unique_id,
                    "ChannelCode" => "",
                    "VendorCode" => "",
                    "ExternalAccountID" => ""
                ];
        
                $form_name = 'Transactions';
                $form_action = 'CancelTransactionApproval';
        
        
                $data = json_encode($data);
                $result_cancel = CardPOS::instance()->makeRequestCardPos('POST', $form_name , $form_action,  ['body' => $data], true);
                $error_code = $result_cancel["ErrorCode"];
                if ($error_code == 0) {
                 
                    $cart_item['lastapprove_transaction'] =  $result_cancel; 
                    //$cart_item['cart_locked'] =  'true';    
                    WC()->cart->cart_contents[$key] = $cart_item;
                    
                    update_bag_after_sync($passed_validation,$product_status,$result);
                }
                else{
                    $error_msg = $result['EdeaError']['DisplayErrorMessage'];
                    wc_add_notice( 'error cancel transaction before adding to bag: '.$error_msg, 'error' );
                    exit;
                }
                $i++;
            }
            WC()->cart->set_session();
            wp_die();
        }
        else{
           
            $error_msg = $result['EdeaError']['DisplayErrorMessage'];
            wc_add_notice( 'error adding product to bag: '.$error_msg, 'error' );
            $html_msg = wc_print_notices(1);
            //echo $html_msg;die;
            $data = array(
                'error' => true,
                'error_msg' => $html_msg,
                //'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
            );
            
            echo wp_send_json($data);
            wp_die();
            
        }
    }

    wp_die();
}


add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');
add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');

function woocommerce_ajax_add_to_cart() {
    global $woocommerce;

    $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id'])); //624
    $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
    $variation_id = absint($_POST['variation_id']); //630
    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity,$cart_item_data);
    $product_status = get_post_status($product_id);
    // if ( WC()->cart->get_cart_contents_count() > 0 ) {
    //     foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
    //         if ( $cart_item['data']->get_id() == $product_id ) {
    //         //if ( $cart_item['data']->get_data() == wc_get_product( $product_id )->get_data() ) {    
    //             WC()->cart->set_quantity( $cart_item_key, $quantity ); 
    //             $updated_qty  = true;
    //             WC()->cart->calculate_totals();
    //             wp_die();
    //         }
           
    //     }
        
        
    // }
    
    if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {

        do_action('woocommerce_ajax_added_to_cart', $product_id);

        //if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
            wc_add_to_cart_message(array($variation_id => $quantity), true);
        //}
  
        $data =  wc_print_notices(true); 
        echo wp_send_json($data);
        wc_clear_notices();
        WC_AJAX :: get_refreshed_fragments();
        //die();
    } else {

        $data = array(
            'error' => true,
            'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id),
            'error_msg' => wc_print_notices(true)); 
        echo wp_send_json($data);
        wc_clear_notices();

    }

    wp_die();

}

function update_bag_after_sync($passed_validation,$product_status,$result){
    $transaction_number = $result["Transaction"]["TemporaryTransactionNumber"]; //T0771012198
    $cart_item_data = array('temporary_transaction_num' => $transaction_number);

    $result_order_items = $result["Transaction"]["OrderItems"];
    //print_r($result_order_items);
    //before adding to bag , remove all products from bag
    if ( WC()->cart->get_cart_contents_count() > 0 ) {
        foreach ( WC()->cart->get_cart_contents() as $key => $cart_item ) {
            WC()->cart->remove_cart_item($key);
        }
    }
   // echo 'enter here1';
   if(!empty($result_order_items)){
    foreach($result_order_items as $key=>$item){
        //echo 'enter here2';
       //save transaction array to first product in cart data to send id to approve
       if($key == 0){
           //$lastupdate_transaction_array = [];
           $lastupdate_transaction_array = array('lastupdate_transaction' => $result);
           $lastappprove_transaction_array = array('lastapprove_transaction' => array());
           $cart_item_data  = array_merge($cart_item_data, $lastupdate_transaction_array,$lastappprove_transaction_array); 
       }
       $sku = $item['ItemCode'];  //2201666S
       $current_variation_id = wc_get_product_id_by_sku($sku); //4836
       $current_product_id = wp_get_post_parent_id($current_variation_id); //4830
       //if($current_product_id == $product_id){
           $qtty = $item['ItemQuantity'];
           $price = $item['PricePerItem'];
           $tot_price = $item['TotalPrice']; // price after discount for all quantity 
           $final_price = $item['FinalPrice']; //price after discount for one product
           // Cart item data to send & save in order
           //if sale price
           //if($final_price != $price){
               $edea_price = array('edea_price' => $final_price);
               $cart_item_data  = array_merge($cart_item_data, $edea_price);
           //}

           //just for test because I dont have price sale
           //$edea_price = array('edea_price' => 100);
           //$cart_item_data  = array_merge($cart_item_data, $edea_price);
           
           if ($passed_validation && WC()->cart->add_to_cart($current_product_id, $qtty, $current_variation_id,array(),$cart_item_data) && 'publish' === $product_status) {

               do_action('woocommerce_ajax_added_to_cart', $current_product_id);
               // Calculate totals
               //$woocommerce->cart->calculate_totals();
               // Save cart to session
               //$woocommerce->cart->set_session();
               // Maybe set cart cookies
               //$woocommerce->cart->maybe_set_cart_cookies();
       
               if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
                   wc_add_to_cart_message(array($current_product_id => $qtty), true);
               }
        

           } 
           else {
               wc_print_notices('error updating bag');
               // $data = array(
               //     'error' => true,
               //     'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($current_product_id), $current_product_id),
               //     'error_msg' => wc_print_notices(true)); 
               // echo wp_send_json($data);
               // wc_clear_notices();
           }

       //}

    }
   }


    //WC_AJAX :: get_refreshed_fragments();
    
}


function woocommerce_custom_price_to_cart_item( $cart_object ) {  
    //if( !WC()->session->__isset( "reload_checkout" )) {
        foreach ( $cart_object->cart_contents as $key => $value ) {
            if( isset( $value["edea_price"] ) ) {
                //for woocommerce version lower than 3
                //$value['data']->price = $value["custom_price"];
                //for woocommerce version +3
                $value['data']->set_price($value["edea_price"]);
               
            }
        }  
    //}  
}
add_action( 'woocommerce_before_calculate_totals', 'woocommerce_custom_price_to_cart_item', 99 );


add_action('wp_ajax_apply_coupon_programatically', 'apply_coupon_programatically');
add_action('wp_ajax_nopriv_apply_coupon_programatically', 'apply_coupon_programatically');
        
function apply_coupon_programatically() {
    if (isset($_POST['coupon_code'])){
        $coupon_code = $_POST['coupon_code'];
        $result =  CardPOS::instance()->getCoupons($coupon_code );
        $error_code = $result["ErrorCode"];
        if ($error_code == 0) {
            // //get coupon value and set it in session to add it in fee
            $_SESSION['coupon_code'] = $coupon_code;
            $msg = __( 'Coupon code applied successfully.', 'woocommerce' );
            wc_add_notice( $msg );
            $product_status = 'publish';
            $passed_validation = true;
    
            update_bag_after_sync($passed_validation,$product_status,$result);
            $i = 0;
            if ( WC()->cart->get_cart_contents_count() > 0 ) {
                foreach ( WC()->cart->get_cart_contents() as $cart_item ) {
                    if($i == 0){
                        $last_update_transaction = $cart_item['lastupdate_transaction']['Transaction'];
                        $i ++;
                    }
                }
                echo wp_send_json($last_update_transaction);
            }
        
        }
        //coupon code not valid or error
        else {
            if($error_code == 59){
                CardPOS::instance()->cancel_transaction();   
            }
            else{
                $response = $result['EdeaError']['DisplayErrorMessage'];
                if(!empty($result["FailedCoupons"]["FailedCouponsToAdd"])){
                    $failedCouponMsg = $result["FailedCoupons"]["FailedCouponsToAdd"][0]["CouponError"]["DisplayErrorMessage"];
                    wc_add_notice( $failedCouponMsg, 'error' );
                }
                // שגיאה כללית
                else{
                    wc_add_notice( $response, 'error' );
                                
                    $multiple_recipients = array(
                        get_bloginfo('admin_email')
                    );
                    $subj = 'Error set coupon from priority';
                    wp_mail( $multiple_recipients, $subj, $message );
                }
            }

        }
        //$_SESSION['api_fee'] = $_POST['coupon_code'];
        wp_die();
    }

}

add_action('wp_ajax_apply_coupon_birthday_programatically', 'apply_coupon_birthday_programatically');
add_action('wp_ajax_nopriv_apply_coupon_birthday_programatically', 'apply_coupon_birthday_programatically');
        
function apply_coupon_birthday_programatically() {
    if (isset($_POST['coupon_code'])){
        $coupon_code = $_POST['coupon_code'];
        $result =  CardPOS::instance()->getCoupons($coupon_code );
        $error_code = $result["ErrorCode"];
    if ($error_code == 0) {
        //get coupon value and set it in session to add it in fee
        $_SESSION['coupon_birthday_code'] = $coupon_code;
        $msg = __( 'Coupon code applied successfully.', 'woocommerce' );
        wc_add_notice( $msg ); 

    }
    //coupon code not valid or error
    else {
        $response = $result['EdeaError']['DisplayErrorMessage'];
        if(!empty($result["FailedCoupons"]["FailedCouponsToAdd"])){
            $failedCouponMsg = $result["FailedCoupons"]["FailedCouponsToAdd"][0]["CouponError"]["DisplayErrorMessage"];
            wc_add_notice( $failedCouponMsg, 'error' );
        }
        // שגיאה כללית
        else{
            wc_add_notice( $response, 'error' );
                        
            $multiple_recipients = array(
                get_bloginfo('admin_email')
            );
            $subj = 'Error set coupon from priority';
            wp_mail( $multiple_recipients, $subj, $message );
        }
    }
    //$_SESSION['api_fee'] = $_POST['coupon_code'];
    wp_die();
    }

}



add_action('wp_ajax_remove_coupon_programatically', 'remove_coupon_programatically');
add_action('wp_ajax_nopriv_remove_coupon_programatically', 'remove_coupon_programatically');
        
function remove_coupon_programatically() {
    if(isset($_SESSION['coupon_code'])){
        WC()->cart->calculate_totals(); // Refresh cart
        $coupon_code = $_SESSION['coupon_code'];
   
        $result =  CardPOS::instance()->removeCoupons($coupon_code );
        $error_code = $result["ErrorCode"];
        if ($error_code == 0) {
            global $woocommerce;
            $form_name = 'Transactions';
            $form_action = 'UpdateTransaction';
            $data = CardPOS::instance()->openOrUpdateTransaction(0,0,0);
            //print_r($data);die;
            $data = json_encode($data);
            $result = CardPOS::instance()->makeRequestCardPos('POST', $form_name , $form_action,  ['body' => $data], true);
            $error_code = $result["ErrorCode"];
            //print_r($result);die;
            //$error_src = $result['EdeaError']['ErrorSource'];
            if ($error_code == 0) {  
                $total_before_general_discount = $result["Transaction"]["TotalBeforeGeneralDiscountIncludingVAT"];
                $total_after_general_discount = $result["Transaction"]["TotalAfterGeneralDiscountIncludingVAT"];
                //general sale
                if($total_after_general_discount == $total_before_general_discount){
                    $fees = WC()->cart->get_fees();
                    foreach ($fees as $key => $fee) {
                        if($fees[$key]->name === $_SESSION['api_fee']) {
                            unset($fees[$key]);
                            //remove coupon from session
                           
                            $msg = __( 'Coupon code removed successfully.', 'woocommerce' );
                            wc_add_notice( $msg );
                        }
                    }
                }
                unset($_SESSION['coupon_code']);

                
                $product_status = 'publish';
                $passed_validation = true;
            
                update_bag_after_sync($passed_validation,$product_status,$result);
                $i = 0;
                if ( WC()->cart->get_cart_contents_count() > 0 ) {
                    foreach ( WC()->cart->get_cart_contents() as $cart_item ) {
                        if($i == 0){
                            $last_update_transaction = $cart_item['lastupdate_transaction']['Transaction'];
                            $i ++;
                        }
                    }
                    echo wp_send_json($last_update_transaction);
                }
            }
            else{
        
                $error_msg = $result['EdeaError']['DisplayErrorMessage'];
                wc_add_notice( 'error in update transaction when removing coupon: '.$error_msg, 'error' );
                $multiple_recipients = array(
                    get_bloginfo('admin_email')
                );
                $subj = 'Error set coupon from priority';
                wp_mail( $multiple_recipients, $subj, $error_msg );
            }

        }
        //coupon code not valid
        else {
            $response = $result['EdeaError']['DisplayErrorMessage'];
            if(!empty($result["FailedCoupons"]["FailedCouponsToRemove"])){
                $failedCouponMsg = $result["FailedCoupons"]["FailedCouponsToRemove"][0]["CouponError"]["DisplayErrorMessage"];
                wc_add_notice( $failedCouponMsg, 'error' );
            }
            // שגיאה כללית
            else{
                wc_add_notice( $response, 'error' );
                
                $multiple_recipients = array(
                    get_bloginfo('admin_email')
                );
                $subj = 'Error remove coupon from priority';
                wp_mail( $multiple_recipients, $subj, $message );
                }
        }

    }
    if(isset($_SESSION['coupon_birthday_code'])){
        WC()->cart->calculate_totals(); // Refresh cart
        $coupon_code = $_SESSION['coupon_birthday_code'];
        $result =  CardPOS::instance()->removeCoupons($coupon_code );
        $error_code = $result["ErrorCode"];
        if ($error_code == 0) {
            global $woocommerce;
            $form_name = 'Transactions';
            $form_action = 'UpdateTransaction';
            $data = CardPOS::instance()->openOrUpdateTransaction(0,0,0);
            //print_r($data);die;
            $data = json_encode($data);
            $result = CardPOS::instance()->makeRequestCardPos('POST', $form_name , $form_action,  ['body' => $data], true);
            $error_code = $result["ErrorCode"];
            //print_r($result);die;
            //$error_src = $result['EdeaError']['ErrorSource'];
            if ($error_code == 0) {  
                $total_before_general_discount = $result["Transaction"]["TotalBeforeGeneralDiscountIncludingVAT"];
                $total_after_general_discount = $result["Transaction"]["TotalAfterGeneralDiscountIncludingVAT"];
                //general sale
                if($total_after_general_discount == $total_before_general_discount){
                    $fees = WC()->cart->get_fees();
                    foreach ($fees as $key => $fee) {
                        if($fees[$key]->name === $_SESSION['api_fee']) {
                            unset($fees[$key]);
                            //remove coupon from session
                          
                            $msg = __( 'Coupon code removed successfully.', 'woocommerce' );
                            wc_add_notice( $msg );
                        }
                    }
                }
                unset($_SESSION['coupon_birthday_code']);
            }
            else{
        
                $error_msg = $result['EdeaError']['DisplayErrorMessage'];
                wc_add_notice( 'error in update transaction when removing coupon: '.$error_msg, 'error' );
                $multiple_recipients = array(
                    get_bloginfo('admin_email')
                );
                $subj = 'Error set coupon from priority';
                wp_mail( $multiple_recipients, $subj, $error_msg );
            }

        }
        //coupon code not valid
        else {
            $response = $result['EdeaError']['DisplayErrorMessage'];
            if(!empty($result["FailedCoupons"]["FailedCouponsToRemove"])){
                $failedCouponMsg = $result["FailedCoupons"]["FailedCouponsToRemove"][0]["CouponError"]["DisplayErrorMessage"];
                wc_add_notice( $failedCouponMsg, 'error' );
            }
            // שגיאה כללית
            else{
                wc_add_notice( $response, 'error' );
                
                $multiple_recipients = array(
                    get_bloginfo('admin_email')
                );
                $subj = 'Error remove coupon from priority';
                wp_mail( $multiple_recipients, $subj, $message );
                }
        }

    }


}


/**
 * WooCommerce Extra Feature
 * --------------------------
*
* Add custom fee to cart automatically
*
*/
function woo_add_cart_fee() {
   global $woocommerce;
   //remove coupon fee after logut because session is cleared
   if( (WC()->cart->get_cart_contents_count() > 0) && (!isset( $_SESSION['coupon_code']) || !isset( $_SESSION['coupon_birthday_code']))){
    foreach(  WC()->cart->get_fees() as $fee_key => $fee ) {
        if ( $fee->amount < 0 ){
            WC()->cart->remove_fee( $fee_key );
        }
    }
   }
   $data = CardPOS::instance()->openOrUpdateTransaction(0,0, 0 );
   $temporarytransactionnumber = $data['temporaryTransactionNumber'];
   $form_name = 'Transactions';

   if($temporarytransactionnumber == null){
       $form_action = 'OpenTransaction';
   }
   else{
       $form_action = 'UpdateTransaction';
   }
//    echo "<pre>";
//    print_r($data);
//    echo "</pre>";
//    die;
   $data = json_encode($data);
   $result = CardPOS::instance()->makeRequestCardPos('POST', $form_name , $form_action,  ['body' => $data], true);
   $error_code = $result["ErrorCode"];
   //print_r($result);die;
   //$error_src = $result['EdeaError']['ErrorSource'];
   if ($error_code == 0) {  
       $total_before_general_discount = $result["Transaction"]["TotalBeforeGeneralDiscountIncludingVAT"];
       $total_after_general_discount = $result["Transaction"]["TotalAfterGeneralDiscountIncludingVAT"];
       $general_discount_sum = $result["Transaction"]["GeneralDiscountSum"];
       //general sale
       if(($total_after_general_discount < $total_before_general_discount) ){
           $desc_sale = $result["Transaction"]["FirstSaleDescription"];
           if($result["Transaction"]["SecondSaleDescription"] != ''){
               $desc_sale = $result["Transaction"]["FirstSaleDescription"].', '.$result["Transaction"]["SecondSaleDescription"];
           }
           //$sale = $total_before_general_discount - $total_after_general_discount;
           $sale = $general_discount_sum;
           $woocommerce->cart->add_fee( __($desc_sale, 'woocommerce'), -$sale );
           $_SESSION['api_fee'] = $desc_sale;
       }
       // else{
       //     $fees = WC()->cart->get_fees();
       //     foreach ($fees as $key => $fee) {
       //         if($fees[$key]->name === $_SESSION['api_fee']) {
       //             unset($fees[$key]);
       //         }
       //     }
       // }
       
   }
   else{
    if ($error_code == 59) {  
        CardPOS::instance()->cancel_transaction();
    }
    else{
        $error_msg = $result['EdeaError']['DisplayErrorMessage'];
        wc_add_notice( 'error in update transaction when adding general discount: '.$error_msg, 'error' );
        $multiple_recipients = array(
         get_bloginfo('admin_email')
         );
         $subj = 'Error set coupon from priority';
         wp_mail( $multiple_recipients, $subj, $error_msg );
    }
   
       //exit;
   }
     
 }
 add_action( 'woocommerce_cart_calculate_fees', 'woo_add_cart_fee' );


//add_filter('woocommerce_checkout_cart_item_quantity','twf_display_custom_data_in_cart',1,3); 
//add_filter('woocommerce_cart_item_price', 'twf_display_custom_data_in_cart',1,3);
 
function twf_display_custom_data_in_cart( $product_name, $values, $cart_item_key )
{
    global $wpdb;
 
    if(!empty($values['temporary_transaction_num']))
    {
        $return_string = "<table>
                            <tr>
                              <th>transaction num:</th>"
                             ."<td>" . $values['temporary_transaction_num'] . "</td>
                            </tr>
                          </table>";
        return $return_string;
 
    }
}