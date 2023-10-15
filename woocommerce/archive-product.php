<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

get_header();

$current_term = get_queried_object();
//print_r($current_term);
$taxonomy = $current_term->taxonomy;
$current_term_name = $current_term->name;
$current_term_id = $current_term->term_id;
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
                    <nav class="breadcrumb">
                        <div class="arrow_btn">
                            <a href="<?php  echo  $parent_term_slug; ?>" title="<?php echo $parent_term_name; ?>" class="button-secondary" style="background-color:<?php echo $bg_color; ?>; color:<?php echo $bg_color; ?>;">
                                <span class="btn_icon" style="color:<?php echo $text_color; ?>;">
                                    <svg focusable="false" class="c-icon icon--arrow-button" viewBox="0 0 42 10" width="15px" height="15px">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M40.0829 5.5H0V4.5H40.0829L36.9364 1.35359L37.6436 0.646484L41.9971 5.00004L37.6436 9.35359L36.9364 8.64649L40.0829 5.5Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                <span class="button_label" style="color:<?php echo $text_color; ?>;"><?php echo $parent_term_name; ?></span>
                            </a>
                        </div>
                        
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
                        <span class="button__label"><?php echo esc_html__( 'נקה הכל', 'gant' ) ?></span>
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
        <?php  ?>
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
	<?php
	if ( woocommerce_product_loop() ) {

		/**
		 * Hook: woocommerce_before_shop_loop.
		 *
		 * @hooked woocommerce_output_all_notices - 10
		 * @hooked woocommerce_result_count - 20
		 * @hooked woocommerce_catalog_ordering - 30
		 */
		do_action( 'woocommerce_before_shop_loop' );

		woocommerce_product_loop_start();

		if ( wc_get_loop_prop( 'total' ) ) {
			while ( have_posts() ) {
				the_post();

				/**
				 * Hook: woocommerce_shop_loop.
				 */
				do_action( 'woocommerce_shop_loop' );

				wc_get_template_part( 'content', 'product' );
			}
		}

		woocommerce_product_loop_end();

		/**
		 * Hook: woocommerce_after_shop_loop.
		 *
		 * @hooked woocommerce_pagination - 10
		 */
		do_action( 'woocommerce_after_shop_loop' );
	} else {
		/**
		 * Hook: woocommerce_no_products_found.
		 *
		 * @hooked wc_no_products_found - 10
		 */
		do_action( 'woocommerce_no_products_found' );
	}?>
</div>


