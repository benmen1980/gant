<?php 
get_header();

$current_term = get_queried_object();
$taxonomy = $current_term->taxonomy;
$current_term_name = $current_term->name;
$current_term_id = $current_term->term_id;
$current_term_slug = $current_term->slug;
$parent_tag_id = $current_term->parent;
$term = get_term_by( 'id', $parent_tag_id, 'product_cat' );

$parent_term_name = $term->name;
$parent_term_id = $term->term_id;
$parent_term_slug = get_term_link ($parent_tag_id, 'product_cat');



$posts_per_page = (int)get_option('posts_per_page');
//$posts_per_page  = -1;
$args_cat = array(
    'post_type' =>  array('product', 'product_variation'),
    'post_status' => array('publish'),
    //'product_cat' => $current_term->slug,
    'posts_per_page' => $posts_per_page,
    'paged' => 1,
    'meta_key'       => 'total_sales',
    //'orderby'        => 'meta_value_num menu_order',
    'orderby'  => array(
		'meta_value_num' => 'DESC',
		'menu_order'      => 'ASC',
	),
    'meta_query' => array(
        'relation'		=> 'AND',
        array(
            'key' => '_stock_status',
            'value' => 'instock',
            'compare' => '=',
        ),
        // array(
        //     'key' => '_thumbnail_id',
        //     'compare' => 'EXISTS',
        // )
    ), 
    'tax_query'  => array(
        'relation'		=> 'AND',
        array(
            'taxonomy' => 'product_cat',
            'field' => 'term_id',
            'terms' => [$current_term_id],
            'operator' => 'IN'
        )
    ),
);



$arr_posts = new WP_Query( $args_cat );
wp_reset_query();
//print_r(wp_list_pluck($arr_posts->posts, 'ID'));
$total_count = $arr_posts->found_posts;
$current_count = $arr_posts->post_count;
$max_page = $arr_posts->max_num_pages;


$filter_top = get_field('top_filter_category');
if(!empty($filter_top)){
    $filter_type = $filter_top['select_filter_type'];
    $one_img = $filter_top['one_img'];
    $two_img = $filter_top['two_img'];
    $bg_color = $filter_top['bg_color'];
    $text_color = $filter_top['bg_text'];
    $filter_cat = $filter_top['select_cat'];

    if($filter_type == 'no-img'){
        $width = 'full_width';
    }
    elseif($filter_type == 'one-img'){
        $width = 'two_third_width';
    }
    else{
        $width = 'third_width';
    }
}




$seo_group = get_field('seo_content');
$seo_title = $seo_group['title'];
$seo_description = $seo_group['description'];


$related_categories = get_field('related_categories');
$categories = $related_categories['enter_category'];


$related_product = get_field('related_pdt');
//print_r($related_product );
$related_title = $related_product['title'];
$radio_selected = $related_product['select_cat_or_pdt'];
 
?>

<div class="container">
    <div class="section_modules_wrapper">
        <?php 
        get_template_part('modules/section','case'); 
        ?>
    </div>
</div>
<div class="child_category_wrapper" id="<?php echo 'term-'.$current_term_id;?>">

    <?php 	
    $choose_module = get_field('choose_module');
    if($choose_module[0]['module_list'] != 'sales_banner'):
        $current_term = get_queried_object();
        $current_term_name = $current_term->name;
        $current_term_id = $current_term->term_id;
        $parent_tag_id = $current_term->parent; ?>
        
        <section class="module_30_70">
            <div class="top_header <?php echo $width ?>" style="background-color:<?php echo $bg_color; ?>; color:<?php echo $text_color; ?>;">
                <div class="r_side">
                    <?php if(!empty($term)): ?>
                        <nav class="breadcrumb_pdt">
                            <a class="button_underline" href="/"><?php echo __( 'בית', 'gant' ); ?></a>
                            <span class="delimiter" aria-hidden="true">></span>
                            <?php if($parent_term_id): ?>
                                <a class="button_underline" <?php echo $parent_term_name; ?> href="<?php  echo  $parent_term_slug; ?>">
                                    <?php echo $parent_term_name; ?>
                                </a>
                                <span class="delimiter" aria-hidden="true">></span>
                            <?php endif; ?>
                            <?php if($current_term_id): ?>
                                <?php echo $current_term_name; ?>
                                <span class="delimiter" aria-hidden="true">></span>
                            <?php endif; ?>
                        </nav>
                    <?php endif; ?>
                    <h1><?php echo $current_term_name ?></h1>
                    <?php if(!empty($filter_cat)): ?>
                        <div class="tabs_cat_wrap">
                            <div class="tabs_wrapper rounded_btn">
                                <div class="btn_holder">
                                    <?php
                                    global $post;
                                    $post_slug = $post->post_name;
                                   ?>
                                    <a class="all_filter" href="<?php the_permalink();?>" style="background-color:<?php echo $text_color; ?>; color:<?php echo $bg_color; ?>;"  title="<?php echo __('הכל','gant')?>"><?php echo __('הכל','gant')?></a>
                                    <?php foreach($filter_cat as $filter){
                                        $cat_id = $filter->term_id;
                                        $cat_name = $filter->name;
                                        $cat_slug = $filter->slug;
                                        global $post;
                                        $post_slug = $post->post_name;
                                        if( $post_slug  == $cat_slug){
                                            $bg_color = $filter_top['bg_text'];
                                            $text_color = $filter_top['bg_color'];
                                        }
                                        else{
                                            $bg_color = $filter_top['bg_color'];
                                            $text_color = $filter_top['bg_text'];
                                        }
                                        ?>  
                                        <a style="background-color:<?php echo $bg_color; ?>; color:<?php echo $text_color; ?>; border: 1px solid;" href="<?php echo $cat_slug; ?>" class="rounded_btn" title="<?php echo $cat_name;?>"><?php echo $cat_name;?></a>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if($filter_type == 'one-img' || $filter_type == 'two-img'): ?>
                    <div class="l_side">
                        <div class="img_wrapper">
                            <img src="<?php echo $one_img; ?>" alt=""/>
                        </div>
                    </div>

                <?php endif; ?>
                <?php if($filter_type == 'two-img'): ?>
                    <div class="l_side">
                        <div class="img_wrapper">
                            <img src="<?php echo $two_img; ?>" alt=""/>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php endif;  ?>

    <div class="filter_wrapper_mobile visible-mobile">
        <div class="filters_title">
            <div class="r_side">
                <button class="open_filter_modal">
                    <?php echo esc_html__( 'סינון', 'gant' ) ?>            
                </button>
                <div class="filter_reset">
                    <button class="button_underline">
                        <span class="button__label">נקה הכל</span>
                    </button>
                </div>
            </div>
            <div class="l_side">
                <div class="count_wrapper">
                    <span id="count"><?php echo $total_count; ?></span><span class="found">מוצרים</span>
                </div>
            </div>

           
        </div>
    </div>
    <?php if(!wp_is_mobile()): ?>
    <div class="filter_wrapper">
        <?php get_template_part( 'template-parts/content', 'filter' ); ?>
    </div>

    <?php else: ?>
        <div class="modal" id="filter_modal">
            <div class="modal_container">
                <header class="section_header">
                    <h3><?php echo esc_html__( 'סינון', 'gant' ) ?></h3>
                    <button type="button" tabindex="0" aria-label="סגור" class="close">
                        <svg focusable="false" class="c-icon icon--close" viewBox="0 0 26 27" width="12" height="12">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M13 14.348l11.445 11.685L26 24.445 14.555 12.761 25.5 1.588 23.944 0 13 11.173 2.056 0 .501 1.588 11.445 12.76 0 24.444l1.555 1.588L13 14.348z" fill="currentColor"></path>
                        </svg>
                    </button>
                </header>
                <div class="modal_content" role="dialog">
                    <?php get_template_part( 'template-parts/content', 'filter' ); ?>
                </div>
            </div>
            <div class="modal_bg"></div>
        </div>
    <?php endif;?>
    <?php if(true): ?>
    <div class="pdts_wrapper">
        <?php 
        if ( $arr_posts->have_posts() ) :?>
            <div class="search_suggestions_products_wrapper">
                <?php $counter_post = 0;
                
                $display_banner_row_5 = get_field( 'display_banner_row_5');
                $banner_active = $display_banner_row_5['active_banner'];
                $banner_img = $display_banner_row_5['img'];
                $banner_link = $display_banner_row_5['link'];
                $link_title = $banner_link['title'];
                $link_target = $banner_link['target'] ? $banner_link['target'] : '_self';
                $link_url = $banner_link['url'];
                 while ( $arr_posts->have_posts() ) :
                    $arr_posts->the_post();
                    //echo  $counter_post;
                    if( $banner_active == 1){
                        if($counter_post == 15){ ?>
                            <div class="search_suggestions_product banner_row_5">
                                <div class="box_product">
                                    <a href="<?php echo $link_url; ?>" title="<?php echo $link_title;?>">
                                        <div class="thumbnail">
                                            <img src="<?php echo $banner_img;?>" alt="">
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php }
                    }
                    get_template_part('page-templates/box-product');
                    ?>
                    <?php
                    $counter_post ++;
                endwhile;?>
            </div>
            <div class="loader_wrap gg">
                <div class="loader_spinner">
                    <img src="<?php echo get_template_directory_uri();?>/dist/images/loader.svg" alt="">
                </div>
            </div>

            <?php if($max_page > 1): ?>
                <div class="load_more_pdts_wrapper">
                    <p>
                        <span><?php echo __('מציג','gant')?></span>
                        <span class="current_number_pdt_in_page"><?php echo $current_count ?></span>
                        <span><?php echo __('מתוך','gant')?></span>
                        <span class="count_result"><?php echo $total_count ?></span>
                        <span><?php echo __('מוצרים','gant')?></span>
                    </p>
                    <button type="button" class="button-secondary load_more_pdts" data-cat="<?php echo $current_term_id ?>" data-paged="1" total_pdts="<?php echo $count;?>" posts_per_page="<?php echo $posts_per_page;?>" max_page="<?php echo $max_page;?>">
                        <span class="button_label">
                            <span> <?php echo __('הצג','gant')?></span>
                            <span class="more_pdt_to_show"> <?php echo (($total_count - $current_count) <  $posts_per_page) ? ($total_count - $current_count) : $posts_per_page; ?></span>
                            <span class="more_pdt_title"> <?php echo ($total_count - $current_count == 1) ?  __('מוצר נוסף','gant') : __('מוצרים נוספים','gant')?></span>
                        </span>
                        <div class="loader_wrap">
                            <div class="loader_spinner">
                                <img src="<?php echo get_template_directory_uri();?>/dist/images/loader.svg" alt="">
                            </div>
                        </div>
                    </button>	
                </div>
            <?php endif; ?>
        <?php endif;?>

    </div>
    <?php endif; ?>
    <button class="button_underline" id="back_to_top" aria-label="<?php echo __('חזרה למעלה','gant')?>">
            <?php echo __('חזרה למעלה','gant')?>
    </button>
    <?php if(!empty($categories)): ?>
        <div class="section_related_cat">
            <div class="cat_wrapper">
            <?php foreach($categories as $filter){
                $cat_id = $filter->term_id;
                $cat_name = $filter->name;
                $cat_slug = $filter->slug;
            ?>
                 <a href="<?php echo $cat_slug; ?>" class="related_cat_link" title="<?php echo $cat_name;?>"><?php echo $cat_name;?></a>
            <?php } ?> 
            </div>

        </div>
    <?php endif;?>
    <?php if(!empty($related_title)): ?>
        <div class="pdts_related_wrapper">
            <section class="slider_section section_wrap">
                <?php if(!empty($radio_selected)): ?>
                    <div class="section_header">
                        <h3><?php echo $related_title; ?></h3>
                    </div>
                <?php endif; ?>
                <?php if($radio_selected == 'select_pdts'):
                    $featured_pdts =  $related_product['select_products'];
                else:
                    $selected_cat =  $related_product['select_category'];
                    
                    $term = get_term( $selected_cat, 'product_cat' );
                    $slug = $term->slug;

                    $args_cat = array(
                        'post_type' =>  array('product', 'product_variation'),
                        'post_status' => array('publish'),
                        'product_cat' => $slug,
                        'posts_per_page' => 10,
                        // 'meta_query' => array(
                        // 	array(
                        // 		'key' => '_stock_status',
                        // 		'value' => 'instock',
                        // 		'compare' => '=',
                        // 	)
                        // )
                    );
                    $featured_pdts = get_posts( $args_cat );
                endif;
                if( $featured_pdts ):?>
                    <div class="slider_pdts slider_wrap">
                        <?php 
                        foreach( $featured_pdts as $product ):
                            setup_postdata( $product );
                            get_template_part('page-templates/box-product'); 
                            wp_reset_postdata(); 
                        endforeach;
                        ?>
                    </div>
                <?php endif; ?>
            </section>		
        </div>
    <?php endif;?>
    <?php if(!empty($seo_title) || !empty($seo_description)): ?>
        <div class="section_seo_wrapper">
            <?php if(!empty($seo_title)): ?>
            <header class="section_header">
                <h3><?php echo $seo_title; ?></h3>
            </header>
            <?php endif; ?>
            <?php if(!empty($seo_description)): ?>
            <div class="seo_desc">
                <p><?php echo $seo_description; ?></p>
            </div>
            <?php endif; ?>
        </div>
    <?php endif;?>
</div>




<?php
//get_sidebar();
get_footer();













