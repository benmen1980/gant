<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit; 
global $woocommerce;
$count = $woocommerce->cart->cart_contents_count; 
?>

<div class="top_header">
	<nav class="breadcrumb">
		<div class="arrow_btn">
			<a href="<?php echo home_url(); ?>" title="<?php  esc_attr_e( 'המשך בקניות', 'gant' );  ?>" class="button-secondary">
				<span class="btn_icon">
					<svg focusable="false" class="c-icon icon--arrow-button" viewBox="0 0 42 10" width="15px" height="15px">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M40.0829 5.5H0V4.5H40.0829L36.9364 1.35359L37.6436 0.646484L41.9971 5.00004L37.6436 9.35359L36.9364 8.64649L40.0829 5.5Z" fill="currentColor"></path>
					</svg>
				</span>
				<span class="button_label"><?php  esc_attr_e( 'המשך בקניות', 'gant' );  ?></span>
			</a>
		</div>
	</nav>
	<h1>
		<?php the_title(); ?>
		<span class="misha-cart"><?php echo '('. $count. ')'; ?></span>
	</h1>
</div>

<?php do_action( 'woocommerce_before_cart' );
//woocommerce_output_all_notices ?>
<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>
	<div class="cart_content_wrap">
		<div class="pdts_content">
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>
			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				}?>
				<div class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
					<div class="cart_product_thumbnail">
						<?php
						$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );?>
						
						<?php if ( ! $product_permalink ) { ?>
						
						<?php } else { ?>
						<a href="<?php echo $product_permalink?>">
							<img src="<?php echo wp_get_attachment_url( $_product->get_image_id() ); ?>" alt="">
						</a>
						<?php }
						?>
					</div>
					<div class="cart_product_info">
						<div class="product_name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
							<?php
							if ( ! $product_permalink ) {
								echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
							} else {
								//echo $_product->get_name();
								echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
							}

							do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

							// Meta data.
							echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

							// Backorder notification.
							if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
								echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
							}
							?>
						</div>
						<div class="product_color">
							<dl class="color">
								<dt class=""><?php esc_attr_e( 'צבע:', 'gant' ); ?></dt>
								<dd class="">
									<?php $color =   get_field('color', $product_id); ?>
									<p><?php  esc_attr_e( $color, 'gant' );  ?></p>
								</dd>
							</dl>
						</div>
						<div class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
							<?php
							echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</div>
						<div class="cart_product_quantity_remove_wrapper">
							<div class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
								<?php
								if ( $_product->is_sold_individually() ) {
									$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
								} else {
									$product_quantity = woocommerce_quantity_input(
										array(
											'input_name'   => "cart[{$cart_item_key}][qty]",
											'input_value'  => $cart_item['quantity'],
											'max_value'    => $_product->get_max_purchase_quantity(),
											'min_value'    => '0',
											'product_name' => $_product->get_name(),
										),
										$_product,
										false
									);
								}

								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
								?>
							</div>
							<div class="product-remove">
								<?php
									echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										'woocommerce_cart_item_remove_link',
										sprintf(
											'<a href="%s" class="button_underline" aria-label="%s" data-product_id="%s" data-product_sku="%s">'.esc_attr_e( 'Remove', 'woocommerce' ).'</a>',
											esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
											esc_html__( 'Remove this item', 'woocommerce' ),
											esc_attr( $product_id ),
											esc_attr( $_product->get_sku() )
										),
										$cart_item_key
									);
								?>
							</div>
						</div>
					</div>
				</div>
				
			<?php } ?>
			
			<?php do_action( 'woocommerce_cart_contents' ); ?>
			
				<button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>">
					<?php esc_html_e( 'Update cart', 'woocommerce' ); ?>
				</button>

				<?php do_action( 'woocommerce_cart_actions' ); ?>

				<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
			
			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
			<?php do_action( 'woocommerce_after_cart_table' ); ?>
		</div>
		<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>
		<div class="cart_summary">
			<div class="cart_summary_content">
				<?php
				/**
				 * Cart collaterals hook.
				 *
				 * @hooked woocommerce_cross_sell_display
				 * @hooked woocommerce_cart_totals - 10
				 */
				do_action( 'woocommerce_cart_collaterals' );
				?>
				<div class="desc_under_total">
					<?php echo get_field('desc_under_summary'); ?>
				</div>
			</div>
		</div>
	</div>
</form>

<?php do_action( 'woocommerce_after_cart' ); ?>

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
