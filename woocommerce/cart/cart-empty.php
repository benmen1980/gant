<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */
do_action( 'woocommerce_cart_is_empty' );

if ( wc_get_page_id( 'shop' ) > 0 ) : ?>

	<div class="return-to-shop">
		<div class="arrow_btn">
			<a class="button-secondary wc-backward" href="<?php echo  home_url(); ?>">
				<span class="btn_icon">
				<svg focusable="false" class="c-icon icon--arrow-button" viewBox="0 0 42 10" width="15px" height="15px">
					<path fill-rule="evenodd" clip-rule="evenodd" d="M40.0829 5.5H0V4.5H40.0829L36.9364 1.35359L37.6436 0.646484L41.9971 5.00004L37.6436 9.35359L36.9364 8.64649L40.0829 5.5Z" fill="currentColor"></path>
				</svg>
				</span>
				<span class="button_label"> 
				<?php esc_html_e( 'המשך בקניות', 'gant' ) ?>
				</span>
			</a>
		</div>
		<h1><?php esc_html_e( 'העגלה שלך ריקה', 'gant' ) ?></h1>
	</div>
	<div class="pdts_related_wrapper">
		<?php 
		$related_categories = get_field('related_pdt');
		$categorie_title = $related_categories['title'];
		$radio_selected = $related_categories['select_cat_or_pdt'];
		?>
		<section class="slider_section section_wrap">
			<?php if(!empty($radio_selected)): ?>
				<div class="section_header">
					<h3><?php echo $categorie_title; ?></h3>
				</div>
			<?php endif; ?>
			<?php if($radio_selected == 'select_pdts'):
				$featured_pdts =  $related_categories['select_products'];
			else:
				$selected_cat =  $related_categories['select_category'];
				$term = get_term( $selected_cat, 'product_cat' );
				$slug = $term->slug;

				$args_cat = array(
					'post_type' =>  array('product', 'product_variation'),
					'post_status' => array('publish'),
					'product_cat' => $slug,
					'posts_per_page' => 10,
					'meta_query' => array(
						array(
							'key' => '_stock_status',
							'value' => 'instock',
							'compare' => '=',
						)
					)
				);
				$featured_pdts = get_posts( $args_cat );
			endif;
			if( $featured_pdts ): ?>
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
	
<?php endif; ?>
