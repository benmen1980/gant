<?php 


function gant_ajax_enqueue() {
    global $wp_query; 
	// Enqueue javascript on the frontend.
    wp_enqueue_script('gant-ajax-scripts', get_stylesheet_directory_uri() . '/dist/js/ajax-scripts.js', array('jquery'));
    // The wp_localize_script allows us to output the ajax_url path for our script to use.
	wp_localize_script('gant-ajax-scripts', 'ajax_obj', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
    ));
}

add_action( 'wp_enqueue_scripts', 'gant_ajax_enqueue' );


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
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => '-1',
    's' => $search
    ));
    //print_r($q1);
    $q2 = get_posts(array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => '-1',
        'meta_query' => array(
            array(
            'key' => '_sku',
            'value' => $search,
            'compare' => 'LIKE'
            )
        )
    ));
    //print_r($q2);
    $merged = array_merge( $q1, $q2 );
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
        'post_type' => 'product',
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
        'key' => '_stock_status',
        'value' => 'instock',
        'compare' => '=',
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

    if(isset($_REQUEST['current_pdt_in_page']) && $_REQUEST['current_pdt_in_page'] != '') {
        $current_pdt_in_page = $_REQUEST['current_pdt_in_page'];
    }

    $query_type = '';
    if(isset($_REQUEST['query_type']) && $_REQUEST['query_type'] != '') {
        $query_type = $_REQUEST['query_type'];
    }
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

    }
    if($query_type == 'filter') {
        $paged = 1;
        $offset  = 0;
    }

    
    
    $args = array(
        'post_type' =>  array('product', 'product_variation'),
        'posts_per_page' => $current_pdt_in_page,
        'post_status' => array('publish'),
        'meta_key' => $meta_key,
        'orderby' => $order_by. ' name',
        'order' => $order,
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
        'orderby' => $order_by. ' name',
        'order' => $order,
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


add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');
add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');
        
function woocommerce_ajax_add_to_cart() {

    $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
    $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
    $variation_id = absint($_POST['variation_id']);
    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
    $product_status = get_post_status($product_id);

    if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {

        do_action('woocommerce_ajax_added_to_cart', $product_id);

        if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
            wc_add_to_cart_message(array($product_id => $quantity), true);
        }

        WC_AJAX :: get_refreshed_fragments();
    } else {

        $data = array(
            'error' => true,
            'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));

        echo wp_send_json($data);
    }

    wp_die();
}