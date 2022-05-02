<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( ! WC()->cart->is_empty() ) : ?>

	<ul class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">
		<?php
		do_action( 'woocommerce_before_mini_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
				$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
				$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
					<?php if ( empty( $product_permalink ) ) : ?>
						<div class="pdts_details">
							<img src="<?php echo wp_get_attachment_url( $_product->get_image_id() ); ?>" alt="">
							<div class="pdt_info">
								<div class="pdt_name_price_wrapper">
									<div class="product_name">
										<?php echo $product_name; ?>
									</div>
									<div class="product_price">
										<?php echo $product_price ?>
									</div>
								</div>
								
								<div class="product_color">
									<dl class="color">
										<dt class=""><?php esc_attr_e( 'מידה:', 'gant' ); ?></dt>
										<dd class="">
											<?php $color =   get_field('color', $product_id); ?>
											<p><?php  esc_attr_e( $color, 'gant' );  ?></p>
										</dd>
									</dl>
								</div>
								<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<div class="product_qtty">
									<dl class="color">
										<dt class=""><?php esc_attr_e( 'כמות:', 'gant' ); ?></dt>
										<dd class="">
											<p><?php  echo $cart_item['quantity'];  ?></p>
										</dd>
									</dl>
								</div>
							</div>
						</div>
						<?php
						echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							'woocommerce_cart_item_remove_link',
							sprintf(
								'<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><svg id="Capa_1" enable-background="new 0 0 507.918 507.918" height="512" viewBox="0 0 507.918 507.918" width="512" xmlns="http://www.w3.org/2000/svg"><g><path d="m484.831 92.349h-115.436v-69.262c0-12.751-10.337-23.087-23.087-23.087h-184.698c-12.751 0-23.087 10.336-23.087 23.087v69.262h-115.436c-12.75 0-23.087 10.336-23.087 23.087s10.336 23.087 23.087 23.087h24.495l21.679 347.762c.769 12.179 10.884 21.657 23.087 21.633h323.22c12.204.024 22.318-9.453 23.087-21.633l21.679-347.762h24.496c12.751 0 23.087-10.336 23.087-23.087s-10.336-23.087-23.086-23.087zm-300.134-46.175h138.523v46.174h-138.523zm209.193 415.57h-279.862l-20.201-323.22h320.265z"/><path d="m161.61 207.785c-12.751 0-23.087 10.336-23.087 23.087v138.523c0 12.751 10.336 23.087 23.087 23.087s23.087-10.336 23.087-23.087v-138.523c0-12.751-10.336-23.087-23.087-23.087z"/><path d="m253.959 207.785c-12.751 0-23.087 10.336-23.087 23.087v138.523c0 12.751 10.336 23.087 23.087 23.087s23.087-10.336 23.087-23.087v-138.523c0-12.751-10.336-23.087-23.087-23.087z"/><path d="m323.22 230.872v138.523c0 12.751 10.336 23.087 23.087 23.087s23.087-10.336 23.087-23.087v-138.523c0-12.751-10.336-23.087-23.087-23.087-12.75 0-23.087 10.336-23.087 23.087z"/></g></svg></a>',
								esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
								esc_attr__( 'Remove this item', 'woocommerce' ),
								esc_attr( $product_id ),
								esc_attr( $cart_item_key ),
								esc_attr( $_product->get_sku() )
							),
							$cart_item_key
						);?>
						<?php else : ?>
						<a href="<?php echo esc_url( $product_permalink ); ?>" class="pdts_details_wrapper">
							<img src="<?php echo wp_get_attachment_url( $_product->get_image_id(),'thumbnail' ); ?>" alt="">
							<div class="pdt_info">
								<div class="pdt_name_price_wrapper">
									<div class="product_name">
										<?php echo $product_name; ?>
									</div>
									<div class="product_price">
										<?php echo $product_price ?>
									</div>
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
								<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<div class="product_qtty">
									<dl class="color">
										<dt class=""><?php esc_attr_e( 'כמות:', 'gant' ); ?></dt>
										<dd class="">
											<p><?php  echo $cart_item['quantity'];  ?></p>
										</dd>
									</dl>
								</div>
							</div>
						</a>
					<?php endif; ?>
					<?php if(false): ?>
					<?php

					echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						'woocommerce_cart_item_remove_link',
						sprintf(
							'<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><svg id="Capa_1" enable-background="new 0 0 507.918 507.918" height="512" viewBox="0 0 507.918 507.918" width="512" xmlns="http://www.w3.org/2000/svg"><g><path d="m484.831 92.349h-115.436v-69.262c0-12.751-10.337-23.087-23.087-23.087h-184.698c-12.751 0-23.087 10.336-23.087 23.087v69.262h-115.436c-12.75 0-23.087 10.336-23.087 23.087s10.336 23.087 23.087 23.087h24.495l21.679 347.762c.769 12.179 10.884 21.657 23.087 21.633h323.22c12.204.024 22.318-9.453 23.087-21.633l21.679-347.762h24.496c12.751 0 23.087-10.336 23.087-23.087s-10.336-23.087-23.086-23.087zm-300.134-46.175h138.523v46.174h-138.523zm209.193 415.57h-279.862l-20.201-323.22h320.265z"/><path d="m161.61 207.785c-12.751 0-23.087 10.336-23.087 23.087v138.523c0 12.751 10.336 23.087 23.087 23.087s23.087-10.336 23.087-23.087v-138.523c0-12.751-10.336-23.087-23.087-23.087z"/><path d="m253.959 207.785c-12.751 0-23.087 10.336-23.087 23.087v138.523c0 12.751 10.336 23.087 23.087 23.087s23.087-10.336 23.087-23.087v-138.523c0-12.751-10.336-23.087-23.087-23.087z"/><path d="m323.22 230.872v138.523c0 12.751 10.336 23.087 23.087 23.087s23.087-10.336 23.087-23.087v-138.523c0-12.751-10.336-23.087-23.087-23.087-12.75 0-23.087 10.336-23.087 23.087z"/></g></svg></a>',
							esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
							esc_attr__( 'Remove this item', 'woocommerce' ),
							esc_attr( $product_id ),
							esc_attr( $cart_item_key ),
							esc_attr( $_product->get_sku() )
						),
						$cart_item_key
					);
					?>
					<?php endif; ?>
				</li>
				<?php
			}
		}

		do_action( 'woocommerce_mini_cart_contents' );
		?>
	</ul>
	<div class="modal_bottom_info">
		<?php if(false): ?>
			<p class="woocommerce-mini-cart__shipping shipping">
				<strong><?php _e( 'Subtotal', 'woocommerce' ); ?>:</strong>
				<?php echo WC()->cart->get_shipping_total(); ?>
			</p>
		<?php endif; ?>
		<p class="woocommerce-mini-cart__total total">
			<?php
			/**
			 * Hook: woocommerce_widget_shopping_cart_total.
			 *
			 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
			 */
			do_action( 'woocommerce_widget_shopping_cart_total' );
			?>
		</p>

		<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

		<div class="woocommerce-mini-cart__buttons buttons">
			<div class="btn_wrapper">
				<a href="<?php echo wc_get_checkout_url(); ?>" title="<?php _e( 'מעבר לתשלום', 'gant' ); ?>" class="button-secondary">
					<span class="button_label"><?php _e( 'מעבר לתשלום', 'gant' ); ?></span>
				</a>
			</div>
			<div class="btn_wrapper">
				<?php 
				global $woocommerce;
				$bag_count = $woocommerce->cart->cart_contents_count;  
				 ?>
				<a href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'סל הקניות', 'gant' ); ?>" class="button_underline">
					<span class="button_label"><?php _e( 'סל הקניות', 'gant' ); ?></span>
					<span class="misha-cart"><?php echo '('. $bag_count. ')'; ?></span>
				</a>
			</div>

			
		</div>

		<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>
	</div>


<?php else : ?>

	<p class="woocommerce-mini-cart__empty-message"><?php esc_html_e( 'No products in the cart.', 'woocommerce' ); ?></p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
