<?php

/*
* Create search form shortcode
*/
function wpbsearchform( $form ) {

    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >

    <label class="screen-reader-text" for="s">' . __('Search for:') . '</label>

    <input type="text" placeholder="חיפוש" value="' . get_search_query() . '" name="s" id="s" />
    <button class="input_icon_clear" aria-label="נקה מילות מפתח" type="button" tabindex="0">
        <svg focusable="false" class="c-icon icon--close" viewBox="0 0 26 27" width="15px" height="15px">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M13 14.348l11.445 11.685L26 24.445 14.555 12.761 25.5 1.588 23.944 0 13 11.173 2.056 0 .501 1.588 11.445 12.76 0 24.444l1.555 1.588L13 14.348z" fill="currentColor"></path>
        </svg>
    </button>
    <button type="submit" id="searchsubmit">
        <svg focusable="false" class="c-icon icon--search" viewBox="0 0 21 21" width="15px" height="15px">
            <g transform="translate(.75 1)" stroke="currentColor" stroke-width="1.8" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 14.497l4.25 4.003"></path><circle cx="8.5" cy="8.5" r="8.5"></circle></g>
        </svg>
    </button>
    </form>';

    return $form;
}

add_shortcode('wpbsearch', 'wpbsearchform');

// add WooCommerce SKU to search query
function extend_search_by_sku( $search, &$query_vars ) {
    global $wpdb;
    if(isset($query_vars->query['s']) && !empty($query_vars->query['s'])){
        $args = array(
            'posts_per_page'  => -1,
            'post_type'       => 'product',
            'meta_query' => array(
                array(
                    'key' => '_sku',
                    'value' => $query_vars->query['s'],
                    'compare' => 'LIKE'
                )
            )
        );
        $posts = get_posts($args);
        if(empty($posts)) return $search;
        $get_post_ids = array();
        foreach($posts as $post){
            $get_post_ids[] = $post->ID;
        }
        if(sizeof( $get_post_ids ) > 0 ) {
                $search = str_replace( 'AND (((', "AND ((({$wpdb->posts}.ID IN (" . implode( ',', $get_post_ids ) . ")) OR (", $search);
        }
    }
    return $search;
    
}
add_filter( 'posts_search', 'extend_search_by_sku', 999, 2 );





/**
* register fields Validating.
*/
function wooc_validate_extra_register_fields( $username, $email, $validation_errors ) {
    if ( isset( $_POST['first_name'] ) && empty( $_POST['first_name'] ) ) {
        $validation_errors->add( 'first_name_error', __( 'שם פרטי הינו שדה חובה', 'gant' ) );
    }
    if ( isset( $_POST['last_name'] ) && empty( $_POST['last_name'] ) ) {
           $validation_errors->add( 'last_name_error', __( 'שם משפחה הינו שדה חובה', 'gant' ) );
    }
    if ( isset($_POST['billing_phone']) && empty($_POST['billing_phone']) )
        $validation_errors->add( 'billing_phone_error', __( 'טלפון הינו שדה חובה', 'gant' ) );
    
    if ( isset($_POST['account_id']) && empty($_POST['account_id']) ){
        $validation_errors->add( 'account_id_error', __( 'ת"ז הינו שדה חובה', 'gant' ) );  
    }
    return $validation_errors;
}
add_action( 'woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3 );

// Save the extra field value to user data
add_action( 'woocommerce_created_customer', 'my_account_saving_extra_field' );
add_action( 'woocommerce_save_account_details', 'my_account_saving_extra_field', 20, 1 );
add_action( 'personal_options_update', 'my_account_saving_extra_field' );
add_action( 'edit_user_profile_update', 'my_account_saving_extra_field' );
function my_account_saving_extra_field( $user_id ) {
    if ( isset( $_POST['first_name'] ) ) {
		update_user_meta( $user_id, 'first_name', wc_clean( $_POST['first_name'] ) );
	}
    if ( isset( $_POST['last_name'] ) ) {
		update_user_meta( $user_id, 'last_name', wc_clean( $_POST['last_name'] ) );
	}
    if( isset($_POST['billing_phone']) && ! empty($_POST['billing_phone']) )
        update_user_meta( $user_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']) );
    if( isset($_POST['account_id']) && ! empty($_POST['account_id']) )
        update_user_meta( $user_id, 'account_id', sanitize_text_field($_POST['account_id']) );
    if( isset($_POST['agree_business_owner']) )
        update_user_meta( $user_id, 'agree_business_owner', $_POST['agree_business_owner'] );
    else{
        update_user_meta( $user_id, 'agree_business_owner', 'off' );
    }
     
}


// ADDING CUSTOM FIELD TO INDIVIDUAL USER SETTINGS PAGE IN BACKEND
add_action( 'show_user_profile', 'add_extra_fields' );
add_action( 'edit_user_profile', 'add_extra_fields' );
function add_extra_fields( $user )
{
    ?>
        <h3><?php _e("Extra fields", "gant"); ?></h3>
        <table class="form-table">
            <tr>
                <th><label for="account_id"><?php _e("ת\"ז", "gant"); ?> </label></th>
                <td><input type="text" name="account_id" value="<?php echo esc_attr(get_user_meta( $user->ID, 'account_id', true )); ?>" class="regular-text" /></td>
            </tr>
            <tr>
                <th><label for="agree_business_owner"><?php echo __('הירשם לניוזלטר Gant','gant')?></label></th>
                <td> 
                    <input type="checkbox" name="agree_business_owner"   <?php  checked( get_user_meta( $user->ID, 'agree_business_owner', true ), 'on' ); ?> value="on" />
                </td>   
            </tr>
        </table>
        <br />
    <?php
}

//redirect to my account after success registration
function registration_redirect() {
    return home_url( '/overview' );
}

add_filter( 'registration_redirect', 'registration_redirect' );





//Stay on same url after edit-account form submission
//add_action( 'profile_update', 'custom_profile_redirect', 12 );
function custom_profile_redirect() {
    if ( is_edit_account_page() ) {
        wp_redirect( trailingslashit( home_url('/my-account/edit-account/') ) );
        exit;
    }
}




/**
* @snippet       Merge Two "My Account" Tabs @ WooCommerce Account
* @how-to        Get CustomizeWoo.com FREE
* @author        Rodolfo Melogli
* @compatible    WooCommerce 5.0
* @donate $9     https://businessbloomer.com/bloomer-armada/
*/
 
// -------------------------------
// 1. First, hide the tab that needs to be merged/moved (edit-address in this case)
 
add_filter( 'woocommerce_account_menu_items', 'bbloomer_remove_address_my_account', 999 );
 
function bbloomer_remove_address_my_account( $items ) {
    unset( $items['dashboard'] );
    unset( $items['edit-address'] );
    return $items;
}
 
// -------------------------------
// 2. Second, print the ex tab content (woocommerce_account_edit_address) into an existing tab (woocommerce_account_edit-account_endpoint). See notes below!
 
add_action( 'woocommerce_account_edit-account_endpoint', 'woocommerce_account_edit_address' );



// Account Edit Adresses: Remove and reorder addresses fields
add_filter(  'woocommerce_default_address_fields', 'custom_default_address_fields', 20, 1 );
function custom_default_address_fields( $fields ) {
    // Only on account pages
    //if( ! is_account_page() ) return $fields;
    unset($fields['company']);
    unset($fields['address_2']);

    return $fields;
}

//redirect login user to overview page
add_action('template_redirect', 'misha_redirect_to_home_from_dashboard' );

function misha_redirect_to_home_from_dashboard(){
    global $wp;
    $current_url = home_url( $wp->request );
    $overview_template = get_page_template_slug( );
    if($overview_template == 'page-templates/overview.php'){
        if( !is_user_logged_in()){
            wp_safe_redirect( home_url('/my-account') );
            exit;
        }
    }

	if( is_user_logged_in() && is_account_page() && empty( WC()->query->get_current_endpoint() ) ){
		wp_safe_redirect( home_url('/overview') );
		exit;
	}

}




// Checking if customer has already bought something in WooCommerce
function has_bought( $value = 0 ) {
    if ( ! is_user_logged_in() && $value === 0 ) {
        return false;
    }

    global $wpdb;
    
    // Based on user ID (registered users)
    if ( is_numeric( $value) ) { 
        $meta_key   = '_customer_user';
        $meta_value = $value == 0 ? (int) get_current_user_id() : (int) $value;
    } 
    // Based on billing email (Guest users)
    else { 
        $meta_key   = '_billing_email';
        $meta_value = sanitize_email( $value );
    }
    
    $paid_order_statuses = array_map( 'esc_sql', wc_get_is_paid_statuses() );

    $count = $wpdb->get_var( $wpdb->prepare("
        SELECT COUNT(p.ID) FROM {$wpdb->prefix}posts AS p
        INNER JOIN {$wpdb->prefix}postmeta AS pm ON p.ID = pm.post_id
        WHERE p.post_status IN ( 'wc-" . implode( "','wc-", $paid_order_statuses ) . "' )
        AND p.post_type LIKE 'shop_order'
        AND pm.meta_key = '%s'
        AND pm.meta_value = %s
        LIMIT 1
    ", $meta_key, $meta_value ) );

    // Return a boolean value based on orders count
    return $count > 0;
}

// add id to each care instruction item in loop
add_filter('acf/load_value/name=icon_id',  'afc_load_bf_test_repeater_value', 10, 3);
function afc_load_bf_test_repeater_value($value, $post_id, $field) {
    //print_r($field);
    $value = $field["name"];
   // $field['readonly'] = 1;
    return $value;
}


/* make_care_id_read_only */
function make_care_id_read_only( $field ) {
  $field['readonly'] = 1;
  return $field;
}
add_filter('acf/load_field/name=icon_id', 'make_care_id_read_only');









//select dynamic model for care instructions acf - not in use - 
function acf_load_dynamic_models_field_choices( $field ) {
    global $post,  $pagenow;
    $models = array();
    $field['choices'] = array();
   
    
    $args = array(
        "post_type" => "product",
    );
    $posts = get_posts( $args );
    foreach( $posts as $post ) : 
        setup_postdata( $post );
        $pdt_id = $post->ID;
        $model = get_field('model', $pdt_id);
        if(!in_array( $model, $models))
        array_push($models,$model);
        //$field['default_value'][ $model ] = $model;
        $field['choices'][ $model ] = $model;
        wp_reset_postdata(); 
    endforeach;
    


    return $field;


    
}

//add_filter('acf/load_field/name=select_models', 'acf_load_dynamic_models_field_choices');




//select dynamic acf
function acf_load_select_dynamic_field_choices( $field ) {
    
    // reset choices
    $field['choices'] = array();


    // if has rows
    if( have_rows('group_question', 'option') ) {
        
        // while has rows
        while( have_rows('group_question', 'option') ) {
            
            // instantiate row
            the_row();
            
            // vars
            while( have_rows('question_and_answer', 'option') ) {
                the_row();
                $question = get_sub_field('question_and_answer_group')['question'];
                // append to choices
                $field['choices'][ $question ] = $question;
            }   
        }
        
    }
    if( have_rows('group_question_club', 'option') ) {
        
        // while has rows
        while( have_rows('group_question_club', 'option') ) {
            
            // instantiate row
            the_row();
            
            // vars
            while( have_rows('question_and_answer', 'option') ) {
                the_row();
                $question = get_sub_field('question_and_answer_group')['question'];
                // append to choices
                $field['choices'][ $question ] = $question;
            }   
        }
        
    }
    if( have_rows('group_question_info_client', 'option') ) {
        
        // while has rows
        while( have_rows('group_question_info_client', 'option') ) {
            
            // instantiate row
            the_row();
            
            // vars
            while( have_rows('question_and_answer', 'option') ) {
                the_row();
                $question = get_sub_field('question_and_answer_group')['question'];
                // append to choices
                $field['choices'][ $question ] = $question;
            }   
        }
        
    }
    if( have_rows('group_question_membership_term', 'option') ) {
        
        // while has rows
        while( have_rows('group_question_membership_term', 'option') ) {
            
            // instantiate row
            the_row();
            
            // vars
            while( have_rows('question_and_answer', 'option') ) {
                the_row();
                $question = get_sub_field('question_and_answer_group')['question'];
                // append to choices
                $field['choices'][ $question ] = $question;
            }   
        }
        
    }
    if( have_rows('group_question_purchase_term', 'option') ) {
        
        // while has rows
        while( have_rows('group_question_purchase_term', 'option') ) {
            
            // instantiate row
            the_row();
            
            // vars
            while( have_rows('question_and_answer', 'option') ) {
                the_row();
                $question = get_sub_field('question_and_answer_group')['question'];
                // append to choices
                $field['choices'][ $question ] = $question;
            }   
        }
        
    }
    if( have_rows('group_question_privacy_policy', 'option') ) {
        
        // while has rows
        while( have_rows('group_question_privacy_policy', 'option') ) {
            
            // instantiate row
            the_row();
            
            // vars
            while( have_rows('question_and_answer', 'option') ) {
                the_row();
                $question = get_sub_field('question_and_answer_group')['question'];
                // append to choices
                $field['choices'][ $question ] = $question;
            }   
        }
        
    }

    // return the field
    return $field;
    
}

add_filter('acf/load_field/name=select_dynamic', 'acf_load_select_dynamic_field_choices');

//select dynamic benefits
function acf_load_select_dynamic_benefits_field_choices( $field ) {
    
    // reset choices
    $field['choices'] = array();


    // if has rows
    if( have_rows('benefits', 'option') ) {
        
        // while has rows
        while( have_rows('benefits', 'option') ) {
            
            // instantiate row
            the_row();
            
            
            // vars
     
            //$title = get_sub_field('title');
            $group_values = get_sub_field('group_benef')['title'];
            // append to choices
            $field['choices'][ $group_values ] = $group_values;
               
        }
        
    }


    // return the field
    return $field;
    
}

add_filter('acf/load_field/name=select_dynamic_benefits', 'acf_load_select_dynamic_benefits_field_choices');


//select dynamic product related acf
function acf_load_dynamic_product_related_field_choices( $field ) {
    global $post,  $pagenow;
    $pdts_related = array();
    $post_id = $post->ID;
    $model = get_field('model', $post_id);
    $title = get_the_title( $post_id );
    if(!empty($model)){
        $args = array(
            "post_type" => "product",
            'posts_per_page' => -1,
            'meta_key'=> 'model', 
            'meta_value'	=> $model, 
            //'post__not_in'   => array($post_id)
        );
        $posts = get_posts( $args );
        //print_r($posts);
        foreach( $posts as $post ) : 
            setup_postdata( $post );
            $pdt_id = $post->ID;
            array_push($pdts_related,$pdt_id);
            wp_reset_postdata(); 
        endforeach;
    }
    $field['value'] = $pdts_related;
    //$field['value'] = implode(",",$pdts_related);
    $field['readonly'] = 1;
    update_post_meta( $post_id, "dynamic_product_related", $field['value'] );
    return $field;


    
}

add_filter('acf/load_field/name=dynamic_product_related', 'acf_load_dynamic_product_related_field_choices');



function get_cuts_filter($cat_id){
    $cuts = array();
    $term = get_term_by('id', $cat_id , 'product_cat' );
    $product_cat = $term->slug;
    $args_cat = array(
        'post_type' => 'product',
        'product_cat' => $product_cat,
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_stock_status',
                'value' => 'instock',
                'compare' => '=',
            )
        )
    );
    $arr_posts = new WP_Query( $args_cat );

    while ( $arr_posts->have_posts() ) :
        $arr_posts->the_post();
        //$_product = wc_get_product( get_the_id() );
        $post_id = get_the_id();
        $cut = get_field('cut', $post_id );
        //echo $color.',';
        if(!empty($cut))
            array_push($cuts, $cut );
            
    endwhile; 
    update_term_meta($cat_id, 'cut_filter',array_count_values($cuts));
}
function get_colors_filter($cat_id){
    $colors = array();
    $term = get_term_by('id', $cat_id , 'product_cat' );
    $product_cat = $term->slug;
    $args_cat = array(
        'post_type' => 'product',
        'product_cat' => $product_cat,
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_stock_status',
                'value' => 'instock',
                'compare' => '=',
            )
        )
    );
    $arr_posts = new WP_Query( $args_cat );

    while ( $arr_posts->have_posts() ) :
        $arr_posts->the_post();
        //$_product = wc_get_product( get_the_id() );
        $post_id = get_the_id();
        //$color = get_field('color', $post_id );
        $color = strtolower(get_field('grouped_color', $post_id ));
        //echo $color.',';
        if(!empty($color))
            array_push($colors, $color );
            
    endwhile; 
    update_term_meta($cat_id, 'color_filter',array_count_values($colors));
}
function  get_substainable_filter($cat_id){
    
    $term = get_term_by('id', $cat_id , 'product_cat' );
    $product_cat = $term->slug;
    $args_cat = array(
        'post_type' => 'product',
        'product_cat' => $product_cat,
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_stock_status',
                'value' => 'instock',
                'compare' => '=',
            )
        )
    );
    $arr_posts = new WP_Query( $args_cat );
    $counter = 0;
    while ( $arr_posts->have_posts() ) :
        $arr_posts->the_post();
        $terms = get_the_terms( get_the_ID(), 'product_tag' );
        foreach($terms as $term){
            if ($term->term_id == 29){
                $counter ++;
            }
        }   
    endwhile; 
    update_term_meta($cat_id, 'substainable_filter',$counter);
}
function get_sizes_filter($cat_id){
    $sizes = array();
    $term = get_term_by('id', $cat_id , 'product_cat' );

    $product_cat = $term->slug;
   
    $args_cat = array(
        'post_type' => array('product', 'product_variation'),
        'product_cat' => $product_cat,
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_stock_status',
                'value' => 'instock',
                'compare' => '=',
            )
        )
    );
   
    $arr_posts = new WP_Query( $args_cat );
    $post_ids = wp_list_pluck( $arr_posts->posts, 'ID' );
    //print_r($post_ids);
    while ( $arr_posts->have_posts() ) :
        $arr_posts->the_post();
        $_product = wc_get_product( get_the_id() );
        if ( $_product->is_type( 'variable' )) {
            $variations = $_product->get_available_variations();
            foreach($variations as $variation){
                if( $variation['is_in_stock'] == 1 ) {
                    array_push($sizes,$variation['attributes']['attribute_pa_size']);
                }
            }
        }
    endwhile; 
    update_term_meta($cat_id, 'size_filter',array_count_values($sizes));
}
function get_prices_filter($cat_id){
    $prices = array();
    $term = get_term_by('id', $cat_id , 'product_cat' );
    $product_cat = $term->slug;
    $args_cat = array(
        'post_type' => 'product',
        'product_cat' => $product_cat,
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_stock_status',
                'value' => 'instock',
                'compare' => '=',
            )
        )
    );
    $arr_posts = new WP_Query( $args_cat );

    while ( $arr_posts->have_posts() ) :
        $arr_posts->the_post();
        global $product;
        if ( $product->is_type( 'variable' ) && !is_variable_product_out_of_stock($product)) {
            $regular_price = $product->get_variation_regular_price();
            $sale_price = $product->get_variation_sale_price();
        }
        else{
            $regular_price = $product->get_regular_price();
            $sale_price = $product->get_sale_price();
        }
        $price = (!empty($sale_price) ? $sale_price : $regular_price);
        if(!empty($price))
            array_push($prices, $price );
            
    endwhile; 
    $counter_range1 = 0;
    $counter_range2 = 0;
    $counter_range3 = 0;
    $counter_range4 = 0;
    $counter_range5 = 0;
    $price_ranges = array();
    foreach($prices as $price){
        switch($price) {
            case in_array($price, range(0,199)): //the range from range of 0-20
                $counter_range1 ++;
            break;
            case in_array($price, range(200,399)): //range of 21-40
                $counter_range2 ++;
                break;
            case in_array($price, range(400,699)): //range of 21-40
                $counter_range3 ++;
                break;
            case in_array($price, range(700,999)): //range of 21-40
                $counter_range4 ++;
                break;
            case $price >= 1000: //range of 21-40
                $counter_range5 ++;
                break;
        }  
    }
    $price_ranges = array('0-199' => $counter_range1, '200-399' => $counter_range2, '400-699' => $counter_range3, '700-999' => $counter_range4, '1000+' => $counter_range5,);
    update_term_meta($cat_id, 'price_filter',$price_ranges);
}



// after product update recalculate filter and related product
function afterPostUpdated($meta_id, $post_id, $meta_key='', $meta_value=''){
    //global $post;
    $terms = get_the_terms( $post_id, 'product_cat' );
    foreach ($terms as $term) {
        $product_cat_id = $term->term_id;
        get_colors_filter( $product_cat_id);
        get_sizes_filter($product_cat_id);
        get_cuts_filter($product_cat_id);
        get_prices_filter($product_cat_id);
        get_substainable_filter($product_cat_id);
    }
}
add_action('updated_post_meta', 'afterPostUpdated', 10, 4);







//redirect to hp after logout
//add_action('wp_logout','auto_redirect_after_logout');

function auto_redirect_after_logout(){
  wp_safe_redirect( home_url() );
  exit;
}

/**
 * Prevent update notification for plugin woocommerce multiple address
 * http://www.thecreativedev.com/disable-updates-for-specific-plugin-in-wordpress/
 * Place in theme functions.php or at bottom of wp-config.php
 */
function disable_plugin_updates( $value ) {
	if ( isset($value) && is_object($value) ) {
	  if ( isset( $value->response['woocommerce-multiple-addresses-pro/woocommerce-multiple-addresses-pro.php'] ) ) {
		unset( $value->response['woocommerce-multiple-addresses-pro/woocommerce-multiple-addresses-pro.php'] );
	  }
	}
	return $value;
}
add_filter( 'site_transient_update_plugins', 'disable_plugin_updates' );


//Append ACF Fields to Child Product Categories only
add_filter('acf/location/rule_types', 'acf_location_rules_types');
function acf_location_rules_types( $choices ) {
  $choices[ 'Post' ][ 'taxonomy_term_child' ] = 'Taxonomy Term Child';
  return $choices;
}


add_filter('acf/location/rule_values/taxonomy_term_child', 'acf_location_rules_values_taxonomy_term_child');
function acf_location_rules_values_taxonomy_term_child( $choices ) {
  if ( $taxonomies = get_taxonomies( array(), 'objects' ) ) {
    foreach( $taxonomies as $taxonomy ) {
      $choices[ $taxonomy->name ] = sprintf( '%s (%s)', $taxonomy->label, $taxonomy->name );
    }
  }

  return $choices;
}

add_filter('acf/location/rule_match/taxonomy_term_child', 'acf_location_rules_match_taxonomy_term_child', 10, 3);
function acf_location_rules_match_taxonomy_term_child( $match, $rule, $options ) {

  // Apply for taxonomies and only to single term edit screen
  if ( ! isset( $options[ 'taxonomy' ] ) || ! isset( $_GET[ 'tag_ID' ] ) ) {
    return $match;
  }

  // Ensure that taxonomy matches the rule
  if ( ( $rule[ 'operator' ] === "==" ) && ( $rule[ 'value' ] !== $options[ 'taxonomy' ] ) ) {
    return $match;
  }
  elseif ( ( $rule[ 'operator' ] === "!=" ) && ( $rule[ 'value' ] === $options[ 'taxonomy' ] ) ) {
    return $match;
  }

  // Get the term and ensure it's valid
  $term = get_term( $_GET[ 'tag_ID' ], $rule[ 'value' ] );
  if ( ! is_a( $term, 'WP_Term' ) ) {
    return $match;
  }

  // Apply for those that have parent only
  if ( $term->parent ) {
    $match = true;
  }
  else {
    $match = false;
  }
  $child_template = get_field('display_cat_child_template', $term->taxonomy . '_' . $term->term_id);
  if($child_template == 1){
    $match = true;
  }
  return $match;
}

//add_filter('show_admin_bar', '__return_false');




//change select size to radio button in single product page
function variation_radio_buttons($html, $args) {
    $args = wp_parse_args(apply_filters('woocommerce_dropdown_variation_attribute_options_args', $args), array(
      'options'          => false,
      'attribute'        => false,
      'product'          => false,
      'selected'         => false,
      'name'             => '',
      'id'               => '',
      'class'            => '',
      'show_option_none' => __('Choose an option', 'woocommerce'),
    ));
  
    if(false === $args['selected'] && $args['attribute'] && $args['product'] instanceof WC_Product) {
      $selected_key     = 'attribute_'.sanitize_title($args['attribute']);
      $args['selected'] = isset($_REQUEST[$selected_key]) ? wc_clean(wp_unslash($_REQUEST[$selected_key])) : $args['product']->get_variation_default_attribute($args['attribute']);
    }
  
    $options               = $args['options'];
    $product               = $args['product'];
    $attribute             = $args['attribute'];
    $name                  = $args['name'] ? $args['name'] : 'attribute_'.sanitize_title($attribute);
    $id                    = $args['id'] ? $args['id'] : sanitize_title($attribute);
    $class                 = $args['class'];
    $show_option_none      = (bool)$args['show_option_none'];
    $show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : __('Choose an option', 'woocommerce');
  
    if(empty($options) && !empty($product) && !empty($attribute)) {
      $attributes = $product->get_variation_attributes();
      $options    = $attributes[$attribute];
    }
  
    $radios = '<div class="variation-radios">';
  
    if(!empty($options)) {
      if($product && taxonomy_exists($attribute)) {
        $terms = wc_get_product_terms($product->get_id(), $attribute, array(
          'fields' => 'all',
        ));
  
        foreach($terms as $term) {
          if(in_array($term->slug, $options, true)) {
            $id = $name.'-'.$term->slug;
            $radios .= '<input type="radio" id="'.esc_attr($id).'" name="'.esc_attr($name).'" value="'.esc_attr($term->slug).'" '.checked(sanitize_title($args['selected']), $term->slug, false).'><label for="'.esc_attr($id).'">'.esc_html(apply_filters('woocommerce_variation_option_name', $term->name)).'</label>';
          }
        }
      } else {
        foreach($options as $option) {
          $id = $name.'-'.$option;
          $checked    = sanitize_title($args['selected']) === $args['selected'] ? checked($args['selected'], sanitize_title($option), false) : checked($args['selected'], $option, false);
          $radios    .= '<input type="radio" id="'.esc_attr($id).'" name="'.esc_attr($name).'" value="'.esc_attr($option).'" id="'.sanitize_title($option).'" '.$checked.'><label for="'.esc_attr($id).'">'.esc_html(apply_filters('woocommerce_variation_option_name', $option)).'</label>';
        }
      }
    }
  
    $radios .= '</div>';
      
    return $html.$radios;
}
add_filter('woocommerce_dropdown_variation_attribute_options_html', 'variation_radio_buttons', 20, 2);
 

function variation_check($active, $variation) {
    if(!$variation->is_in_stock() && !$variation->backorders_allowed()) {
        return false;
    }
    return $active;
}
add_filter('woocommerce_variation_is_active', 'variation_check', 10, 2);

// change order of description
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

// display always price in single product page
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action('woocommerce_before_single_product', 'check_if_variable_first');

function check_if_variable_first()
{
    if (is_product()) {
        global $post;
        $product = wc_get_product($post->ID);
        if ($product->is_type('variable')) {
            // removing the price of variable products
            // Change location of
            add_action('woocommerce_before_single_variation', 'custom_wc_template_single_price', 25);
            function custom_wc_template_single_price()
            {
                global $product;
                // Variable product only
                if ($product->is_type('variable')):
                    // Main Price

                    $prices = array($product->get_variation_price('min', true), $product->get_variation_price('max', true));
                    //$price = $prices[0] !== $prices[1] ? sprintf(__('od %1$s <small>s DPH</small>', 'woocommerce'), wc_price($prices[0])) : wc_price($prices[0]);
                    $price = wc_price($prices[0]);
                    // Sale Price
                    $prices = array($product->get_variation_regular_price('min', true), $product->get_variation_regular_price('max', true));
                    sort($prices);
                    $saleprice = $prices[0] !== $prices[1] ? sprintf(__('od %1$s', 'woocommerce'), wc_price($prices[0])) : wc_price($prices[0]);

                    if ($price !== $saleprice && $product->is_on_sale()) {
                        $price = '<del>' . $saleprice . $product->get_price_suffix() . '</del> <ins>' . $price . $product->get_price_suffix() . '</ins>';
                    }
                    ?>
                    <?php
                    echo '<p class="price">' . $price . '</p>';
                endif;
            }
        }
    }
}


// add related products color
function woocommerce_template_single_title_custom(){?>
    <div class="product_attribute_wrapper">
        <div class="product_attribute product_attribute_color">
            <h3 class="attribute_title">
                <span><?php esc_html_e( 'צבע: ', 'gant' ); ?></span>
                <span><?php echo get_field('color'); ?></span>
            </h3>
            <div class="attributes_values_wrapper">
            <?php
                $group_values = get_field('dynamic_product_related');
                if(!empty($group_values)) {
                    $count_related = count($group_values); 
                    if($count_related > 8):
                        $shows = $count_related -8;
                    ?>
                    <button class="show_more_color">
                        <?php 
                        if( $shows == 1){
                            echo sprintf("+ %u נוסף",$shows); 
                        }
                        else{
                            echo sprintf("+ %u נוספים",$shows); 
                        }
                        
                        ?>
                    </button>
                    <?php endif; ?>
                    <?php foreach($group_values as $product_id){
                        $product = wc_get_product($product_id);
                        $slug = $product->get_slug();
                        $title = $product->get_name();
                        $sku = $product->get_sku();
                        $color = get_field('grouped_color',$product_id);
                        $id = $product->get_id();
                        $current_id = get_the_ID();

                        // get product image color
                        // $pdt_attachment_ids = $product->get_gallery_image_ids();
                        // foreach($pdt_attachment_ids as $attach_id){
                        //     $attach_url = wp_get_attachment_url( $attach_id);
                        //     if(strpos( $attach_url, 'thumb-fv-1') !== false){
                        //         $pdt_image_color  = $attach_url;
                        //     }
                        // }
                        $attachment_id = get_attachment_id_by_slug($sku.'-thumb-fv-1');
                        $pdt_image_color = wp_get_attachment_url($attachment_id );
                        ?>
                        <a href="<?php echo $slug; ?>" class="checkbox_color_wrapper <?php echo (($current_id == $id) ? 'current_pdt_color':'')?> <?php echo (is_variable_product_out_of_stock($product))? 'out_of_stock':'';?>">
                            <p class="row_radio_wrapper">
                                <span class="radio_wrapper">
                                    <input class="radio_price" id="radio_color_<?php echo $sku;?>" type="radio" name="checkbox_price" value="<?php echo $sku ?>">	
                                    <label for="radio_color_<?php echo $sku;?>" style="background-image:url('<?php echo $pdt_image_color;?>');color:<?php echo  $color;?>"><?php echo $val ?></label>
                                </span>
                            </p>
                        </a>
                    <?php } ?>
                
                <?php } ?>
            </div>
        </div>
    </div>
<?php }
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title_custom', 20);


/**
 * @snippet       Always Show Variation Price @ WooCommerce Single Product
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 3.8
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
  
add_filter( 'woocommerce_show_variation_price', '__return_true' );

// Get top level Category of Product
function wdo_get_product_top_level_category ( $product_id ) {
	$product_top_category='';
 	$prod_terms = get_the_terms( $product_id, 'product_cat' );
     //print_r($prod_terms );
	foreach ($prod_terms as $prod_term) {
		$product_cat_id = $prod_term->term_id;
		$product_parent_categories_all_hierachy = get_ancestors( $product_cat_id, 'product_cat' );  
		$last_parent_cat = array_slice($product_parent_categories_all_hierachy, -1, 1, true);
		foreach($last_parent_cat as $last_parent_cat_value){
			$product_top_category =  $last_parent_cat_value;
		}
	}
	return $product_top_category;
}

// remove variation from title
add_filter( 'woocommerce_product_variation_title_include_attributes', '__return_false' );

/**
 * @snippet       Add to Cart Quantity drop-down - WooCommerce
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 5.0
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
  
function woocommerce_quantity_input( $args = array(), $product = null, $echo = true ) {
  
    if ( is_null( $product ) ) {
       $product = $GLOBALS['product'];
    }
  
    $defaults = array(
       'input_id' => uniqid( 'quantity_' ),
       'input_name' => 'quantity',
       'input_value' => '1',
       'classes' => apply_filters( 'woocommerce_quantity_input_classes', array( 'input-text', 'qty', 'text' ), $product ),
       'max_value' => apply_filters( 'woocommerce_quantity_input_max', -1, $product ),
       'min_value' => apply_filters( 'woocommerce_quantity_input_min', 0, $product ),
       'step' => apply_filters( 'woocommerce_quantity_input_step', 1, $product ),
       'pattern' => apply_filters( 'woocommerce_quantity_input_pattern', has_filter( 'woocommerce_stock_amount', 'intval' ) ? '[0-9]*' : '' ),
       'inputmode' => apply_filters( 'woocommerce_quantity_input_inputmode', has_filter( 'woocommerce_stock_amount', 'intval' ) ? 'numeric' : '' ),
       'product_name' => $product ? $product->get_title() : '',
    );
  
    $args = apply_filters( 'woocommerce_quantity_input_args', wp_parse_args( $args, $defaults ), $product );
   
    // Apply sanity to min/max args - min cannot be lower than 0.
    $args['min_value'] = max( $args['min_value'], 0 );
    // Note: change 20 to whatever you like
    $args['max_value'] = 0 < $args['max_value'] ? $args['max_value'] : 10;
  
    // Max cannot be lower than min if defined.
    if ( '' !== $args['max_value'] && $args['max_value'] < $args['min_value'] ) {
       $args['max_value'] = $args['min_value'];
    }
   
    $options = '';
     
    for ( $count = $args['min_value']; $count <= $args['max_value']; $count = $count + $args['step'] ) {
  
       // Cart item quantity defined?
       if ( '' !== $args['input_value'] && $args['input_value'] >= 1 && $count == $args['input_value'] ) {
         $selected = 'selected';      
       } else $selected = '';
  
       $options .= '<option value="' . $count . '"' . $selected . '>' . $count . '</option>';
  
    }
      
    $string = '<div class="quantity"><select class="qty" name="' . $args['input_name'] . '">' . $options . '</select><span class="cart_product_quantity_icon">
    <svg focusable="false" class="c-icon icon--chevron-down" viewBox="0 0 14 9" width="6px" height="4px">
    <g fill="currentColor"><polygon points="0 1.89221557 1.977 0 6.987 5.05489022 12.024 8.86405608e-16 14 1.89221557 6.986 9"></polygon></g>
    </svg>
    </span></div>';
  
    if ( $echo ) {
       echo $string;
    } else {
       return $string;
    }
   
}

// update count products in cart on update quantity

add_filter( 'woocommerce_add_to_cart_fragments', 'misha_add_to_cart_fragment' );

function misha_add_to_cart_fragment( $fragments ) {

	global $woocommerce;
    $count = $woocommerce->cart->cart_contents_count; 

	$fragments['.misha-cart'] = '<span class="misha-cart">'.'<span>(</span>'. $count. '<span>)</span>'.'</span>';
 	return $fragments;
}



// Output dropdown Store list
add_action('woocommerce_after_shipping_rate', 'output_dropdown_stores_list', 10, 2);
function output_dropdown_stores_list( $shipping_rate, $index )  {
    $chosen_shipping_rate_id = WC()->session->get('chosen_shipping_methods')[0];
    $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
    $chosen_shipping = $chosen_methods[0]; 
    if ( $shipping_rate->id === $chosen_shipping_rate_id ) {
        $stores_array = array();
        if( have_rows('stores',771) ) {
            // while has rows
            $counter =0;while( have_rows('stores',771) ) {
                the_row(); 
                $store_name = get_sub_field('store_name');
                $store_can_shipping = get_sub_field('can_ship');
                if($store_can_shipping == 1){
                    $stores_array[] =  $store_name;
                }
            }
        }
        //if (!empty( $stores_list)) :
        if($chosen_shipping == 'local_pickup:3'):
            
        ?>
        <select id="storelist" name="storelist">
            <option value=""><?php _e("בחר סניף", "gant"); ?></option>
        <?php foreach( $stores_array as $key => $store ) {
            echo '<option value="'.$store.'">'.$store.'</option>';
        } ?>
        </select>
        <script>
        jQuery(function($){
            var label = '<?php echo $shipping_rate->label; ?>';
            $(document.body).on('change', 'select#storelist', function(){
                $(this).parent().find('label').text(label+': '+$(this).val());
            });
        });
        </script>
        <?php
        endif;
    }
}


// Pickup store Validation
add_action( 'woocommerce_checkout_process', 'validate_pickup_store' );
function validate_pickup_store() {
    $chosen_shipping_rate_id = WC()->session->get('chosen_shipping_methods')[0];

    if ( false !== strpos( $chosen_shipping_rate_id, 'local_pickup:3' )
    && isset($_POST['storelist']) && empty($_POST['storelist']) ) {
        wc_add_notice( __( 'אנא בחר סניף', 'gant' ), 'error' );
    }
}


// Save chosen pickup store as order meta
add_action( 'woocommerce_checkout_create_order', 'save_pickup_stores_to_order', 10, 2 );
function save_pickup_stores_to_order( $order, $data ) {
    if ( isset($_POST['storelist']) && ! empty($_POST['storelist']) ) {
        $order->update_meta_data('pickup_store', esc_attr($_POST['storelist']) );
    }
}


// Save chosen pickup store as order shipping item meta
add_action( 'woocommerce_checkout_create_order_shipping_item', 'save_pickup_stores_to_order_item_shipping', 10, 4 );
function save_pickup_stores_to_order_item_shipping( $item, $package_key, $package, $order ) {
    if ( isset($_POST['storelist']) && ! empty($_POST['storelist']) ) {
        $item->update_meta_data('_pickup_store', esc_attr($_POST['storelist']) );
    }
}

// Admin: Change store order shipping item displayed meta key label to something readable
add_filter('woocommerce_order_item_display_meta_key', 'filter_order_item_displayed_meta_key', 20, 3 );
function filter_order_item_displayed_meta_key( $displayed_key, $meta, $item ) {
    // Change displayed meta key label for specific order item meta key
    if( $item->get_type() === 'shipping' && $meta->key === '_pickup_store' ) {
        $displayed_key = __("סניף", "gant");
    }
    return $displayed_key;
}

// Customer: Display Store below shipping method on orders and email notifications
add_filter( 'woocommerce_get_order_item_totals', 'display_pickup_store_on_order_item_totals', 10, 3 );
function display_pickup_store_on_order_item_totals( $total_rows, $order, $tax_display ){
    $chosen_store   = $order->get_meta('pickup_store'); // Get pickup store
    $new_total_rows = array(); // Initializing

    if( empty($chosen_store) )
        return $total_rows; // Exit

    // Loop through total rows
    foreach( $total_rows as $key => $value ){
        if( 'shipping' == $key ) {
            $new_total_rows['pickup_store'] = array(
                'label' => __("משלוח סניף", "gant") . ':',
                'value' => $chosen_store,
            );
        } else {
            $new_total_rows[$key] = $value;
        }
    }
    return $new_total_rows;
}

//Add  Custom Checkout Fields

// add checkbox field
add_action( 'woocommerce_after_checkout_billing_form', 'gift_wrap_checkbox' );
function gift_wrap_checkbox( $checkout ) {

	woocommerce_form_field( 'gift_wrap', array(
		'type'	=> 'checkbox',
		'class'	=> array('gift_wrap form-row-wide'),
		'label'	=>  __("אריזת מתנה", "gant"),
		), $checkout->get_value( 'gift_wrap' ) );

    woocommerce_form_field( 'greeting_card', array(
        'type'	=> 'checkbox',
        'class'	=> array('greeting_card form-row-wide'),
        'label'	=>  __("כרטיס ברכה", "gant"),
        ), $checkout->get_value( 'greeting_card' ) );

    woocommerce_form_field( 'greeting_card_txt', array(
        'type'	=> 'textarea',
        'class'	=> array('greeting_card_txt form-row-wide'),
        'label'	=>  __("הכנס ברכה", "gant"),
        ), $checkout->get_value( 'greeting_card_txt' ) );
        
}

// save fields to order meta
add_action( 'woocommerce_checkout_update_order_meta', 'save_gift_wrap' );
function save_gift_wrap( $order_id ){
	if( !empty( $_POST['gift_wrap'] ) && $_POST['gift_wrap'] == 1 )
		update_post_meta( $order_id, 'gift_wrap', 1 );
    if( !empty( $_POST['greeting_card_txt'] ))
		update_post_meta( $order_id, 'greeting_card_txt', $_POST['greeting_card_txt'] );
}


add_action( 'woocommerce_admin_order_data_after_billing_address', 'bbloomer_show_new_checkout_field_order', 10, 1 );
   
function bbloomer_show_new_checkout_field_order( $order ) {    
   $order_id = $order->get_id();
   if ( get_post_meta( $order_id, 'gift_wrap', true ) && get_post_meta( $order_id, 'gift_wrap', true ) == 1) echo '<p><strong>אריזה למתנה</strong></p>';
   if ( get_post_meta( $order_id, 'greeting_card_txt', true ) ) echo '<p><strong>'.__("כרטיס ברכה", "gant").'</strong> ' . get_post_meta( $order_id, 'greeting_card_txt', true ) . '</p>';
}


/**
 * @snippet       Add a Checkbox to Hide/Show Checkout Field - WooCommerce - Greeting Card 
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WC 4.1
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
  
  
add_action( 'woocommerce_after_checkout_form', 'bbloomer_conditionally_hide_show_new_field', 9999 );
  
function bbloomer_conditionally_hide_show_new_field() {
    
  wc_enqueue_js( "
      jQuery('input#greeting_card').change(function(){
           
         if (! this.checked) {
            // HIDE IF NOT CHECKED
            jQuery('#greeting_card_txt_field').fadeOut();
            jQuery('#greeting_card_txt_field textarea').val('');         
         } else {
            // SHOW IF CHECKED
            jQuery('#greeting_card_txt_field').fadeIn();
         }
           
      }).change();
  ");
       
}


/**
* @snippet Remove the Postcode Field on the WooCommerce Checkout
* @how-to Get CustomizeWoo.com FREE
* @sourcecode https://businessbloomer.com/?p=461
* @author Rodolfo Melogli
* @testedwith WooCommerce 3.5.1
*/
 
add_filter( 'woocommerce_checkout_fields' , 'bbloomer_remove_billing_postcode_checkout' );
 
function bbloomer_remove_billing_postcode_checkout( $fields ) {
  unset($fields['billing']['billing_postcode']);
  return $fields;
}

//Remove Coupon Form @ WooCommerce Checkout
//remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
// add_action( 'woocommerce_after_checkout_form', 'woocommerce_checkout_coupon_form', 5 );


 

 
add_filter('next_posts_link_attributes', 'posts_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_link_attributes');

function posts_link_attributes() {
  return 'class="button-secondary"';
}

add_filter('acf/fields/taxonomy/query', 'my_acf_fields_taxonomy_query', 10, 3);
function my_acf_fields_taxonomy_query( $args, $field, $post_id ) {

    // Show 40 terms per AJAX call.
    $args['number'] = 40;

    // Order by most used.
    $args['orderby'] = 'count';
    $args['order'] = 'DESC';

    return $args;
}


/* footer_function_cookie_notice */
add_action('wp_footer', 'footer_function_cookie_notice');
function footer_function_cookie_notice(){
?>
    <script src="https://cdn.websitepolicies.io/lib/cookieconsent/1.0.3/cookieconsent.min.js" defer></script>
    <script>window.addEventListener("load",
        function(){
            window.wpcc.init({"border":"thin","corners":"small","colors":{"popup":{"background":"#f6f6f6","text":"#000000","border":"#555555"},"button":{"background":"#555555","text":"#ffffff"}}})
        });
    </script>
<?php
};


// replace default WC header action with a custom one
add_action( 'init', 'ml_replace_email_header_hook' );    
function ml_replace_email_header_hook(){
    remove_action( 'woocommerce_email_header', array( WC()->mailer(), 'email_header' ) );
    add_action( 'woocommerce_email_header', 'ml_woocommerce_email_header', 10, 2 );
}

// replace default WC header action with a custom one
add_action( 'init', 'ml_replace_email_footer_hook' );    
function ml_replace_email_footer_hook(){
    remove_action( 'woocommerce_email_footer', array( WC()->mailer(), 'email_footer' ) );
    add_action( 'woocommerce_email_footer', 'ml_woocommerce_email_footer', 10, 2 );
}

// new function that will switch template based on email type
function ml_woocommerce_email_header( $email_heading, $email ) {
    // var_dump($email); die; // see what variables you have, $email->id contains type
    switch($email->id) {
        // case 'new_order':
        //     $template = 'emails/email-header-new-order.php';
        //     break;
        case 'customer_new_account':
            $template = 'emails/email-header-new-account.php';
            break;
        default:
            $template = 'emails/email-header.php';
    }
    wc_get_template( $template, array( 'email_heading' => $email_heading ) );
}

// new function that will switch template based on email type
function ml_woocommerce_email_footer( $email_heading, $email ) {
    // var_dump($email); die; // see what variables you have, $email->id contains type
    switch($email->id) {
        // case 'new_order':
        //     $template = 'emails/email-header-new-order.php';
        //     break;
        case 'customer_new_account':
            $template = 'emails/email-footer-new-account.php';
            break;
        default:
            $template = 'emails/email-footer.php';
    }
    wc_get_template( $template, array( 'email_heading' => $email_heading ) );
}



if ( is_admin() ) {
    add_action( 'admin_menu', 'add_products_menu_entry_description', 100 );
    add_action( 'admin_menu', 'add_products_menu_entry_care_icon', 100 );
}
function add_products_menu_entry_care_icon() {
    add_submenu_page(
        'edit.php?post_type=product',
        __( 'Set product cares icon' ),
        __( 'Set product cares icon' ),
        'manage_woocommerce', // Required user capability
        'set-product-care-icon',
        'set_product_care_icon'
    );
}

function add_products_menu_entry_description() {
    add_submenu_page(
        'edit.php?post_type=product',
        __( 'Set product description' ),
        __( 'Set product description' ),
        'manage_woocommerce', // Required user capability
        'set-product-desc',
        'set_product_desc'
    );
}

function set_product_care_icon(){ ?>
    <div class="btns_wrapper_desc">
        <button type='button' class='set_product_care_icon'>הגדר אייקוני הוראות כביסה של המוצר </button>
        
        <div class="loader_wrap">
            <div class="loader_spinner">
                <img src="<?php echo get_template_directory_uri();?>/dist/images/loader.svg" alt="">
            </div>
        </div>
<?php }

function set_product_desc(){ ?>
    <div class="btns_wrapper_desc">
        <button type='button' class='set_product_long_desc'>הגדר תיאור ארוך של המוצר </button>
        <button type='button' class='set_product_short_desc'>הגדר תיאור קצר של המוצר </button>
        <div class="loader_wrap">
            <div class="loader_spinner">
                <img src="<?php echo get_template_directory_uri();?>/dist/images/loader.svg" alt="">
            </div>
        </div>
<?php }

add_action( 'wp_ajax_set_pdt_care_icon', 'set_pdt_care_icon' );
// for non-logged in users:
add_action( 'wp_ajax_nopriv_set_pdt_care_icon', 'set_pdt_care_icon' );

function set_pdt_care_icon(){  
    $csv = get_field('excel_file', 'option')['url'];


    $array_cares_ids = array();
    $array_cares_skus = array();
    if(($handle = fopen($csv, "r")) !== FALSE) {
        $count=0;
        while(($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

            $icon_id = $data[0];
            $icon_sku = $data[1];
            $array_cares_ids[] = $icon_id;
            $array_cares_skus[] = $icon_sku;

        }	
        fclose($handle);
    }

    $combine_array = array_combine_($array_cares_skus, $array_cares_ids);
    // echo '<pre>';
    // print_r($combine_array);
    // echo '</pre>';die;
    foreach($combine_array as $key=>$value){
        if(is_array($value))
            $value = implode(",", $value);

        $args = array(
            'posts_per_page'	=> -1,
            "post_type" => "product",
            'meta_key'=> 'model', 
            'meta_value'	=> $key, 
        );
        $posts = get_posts( $args );
        // echo '<pre>';
        // print_r($posts);
        // echo '</pre>';die;
        foreach( $posts as $post ) : 
            setup_postdata( $post );
            $pdt_id = $post->ID;
            update_post_meta( $pdt_id, "related_care_sku",  $value );
            //update_field( 'related_care_sku',$value, $pdt_id );
            wp_reset_postdata(); 
        endforeach;
    }
}


add_action( 'wp_ajax_set_pdt_long_desc', 'set_pdt_long_desc' );
// for non-logged in users:
add_action( 'wp_ajax_nopriv_set_pdt_long_desc', 'set_pdt_long_desc' );

function set_pdt_long_desc(){  
    $csv = get_field('long_desc_file', 'option')['url'];
    if(($handle = fopen($csv, "r")) !== FALSE) {
        $count=0;
        while(($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

            
            $sku = $data[0];
            $desc = $data[1];
            $args = array(
                "post_type" => "product",
                'meta_key'=> 'model', 
                'meta_value'	=> $sku, 
                
            );
            $posts = get_posts( $args );
            foreach( $posts as $post ) : 
                setup_postdata( $post );
                $pdt_id = $post->ID;
                update_field( 'full_desc',$desc, $pdt_id );
                wp_reset_postdata();
            endforeach;
        }	
        fclose($handle);
    }
}


add_action( 'wp_ajax_set_pdt_short_desc', 'set_pdt_short_desc' );
// for non-logged in users:
add_action( 'wp_ajax_nopriv_set_pdt_short_desc', 'set_pdt_short_desc' );

function set_pdt_short_desc(){  
    $csv = get_field('short_desc_file', 'option')['url'];
    if(($handle = fopen($csv, "r")) !== FALSE) {
        $count=0;
        while(($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

            
            $sku = $data[0];
            $desc = $data[1];
            $args = array(
                "post_type" => "product",
                'meta_key'=> 'model', 
                'meta_value'	=> $sku, 
                
            );
            $posts = get_posts( $args );
            foreach( $posts as $post ) : 
                setup_postdata( $post );
                $pdt_id = $post->ID;
                $the_post = array(
                    'ID'           => $pdt_id,//the ID of the Post
                    'post_excerpt' => $desc,
                );
                wp_update_post( $the_post );
                wp_reset_postdata();
            endforeach;
        }	
        fclose($handle);
    }
}