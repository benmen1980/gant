<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.3.6
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<!-- <h2><?//php esc_html_e( 'Cart totals', 'woocommerce' ); ?></h2> -->

	<table cellspacing="0" class="shop_table shop_table_responsive">
		<tr>
			<th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-total"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
		</tr>
		<?php 
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
					<td class="product-name">
						<?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</td>
					<td class="product-total">
						<?php 
						$pdt_regular_price = $_product->get_regular_price();
						//echo $pdt_regular_price;
						if($cart_item['data']->get_price() != $pdt_regular_price){
							$price = '<del>' . wc_price($pdt_regular_price * $cart_item['quantity']). '</del> <ins>' . apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ) . '</ins>'; ?>
							<div data-sku="<?php echo $_product->get_sku(); ?>" class="product-sale-desc">
									<?//php esc_attr_e( 'מבצע:', 'gant' ); ?>
								</div>
							<?php 
						}
						else
							$price = apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
						echo $price; ?>
					</td>
				</tr>
				<?php
			}
		}

		 ?>
		<tr class="cart-subtotal">
			<th><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
			<td data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>"><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>"><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>
		<!-- dana asker to hide shiiping method on cart page so add false to condition -->
		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>

			<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

		<?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

			<tr class="shipping">
				<th><?php esc_html_e( 'Shipping', 'woocommerce' ); ?></th>
				<td data-title="<?php esc_attr_e( 'Shipping', 'woocommerce' ); ?>"><?php woocommerce_shipping_calculator(); ?></td>
			</tr>

		<?php endif; ?>
		<?php 
		if ( WC()->cart->get_cart_contents_count() > 0 ) {
			foreach ( WC()->cart->get_cart_contents() as $cart_item ) {
				if($i == 0){
					$last_update_transaction = $cart_item['lastupdate_transaction']['Transaction'];
					$i ++;
				}
			} 
			$coupons = $last_update_transaction['Coupons'];
			if(!empty($coupons)){
				foreach ($coupons as $coupon){
					$coupon_code = $coupon['CouponCode'];
					$unique_num = $coupon['UniqueNumber'];
					if($unique_num != ""){
						$coupon_code = $coupon_code.'-'.$unique_num;
					}
					$coupon_desc = $coupon['Description']; ?>
					<tr class="fee coupon_sale gg" data-fee="">
						<th><?php echo $coupon_desc ?></th>
						<td data-title="">
							<button class="remove_coupon"  data-coupon="<?php echo $coupon_code; ?>"><?php  echo __( '[Remove]', 'woocommerce' )  ?></button>
						</td>
					</tr>
				<?php }
			}
			
		}
		?>
		<?php if((isset($_SESSION['coupon_birthday_code']) || isset($_SESSION['coupon_code'])) && false): ?>
			<tr class="fee coupon_sale" data-fee="">
				<th></th>
				<td data-title="">
					<?php if(isset($_SESSION['coupon_birthday_code']) && isset($_SESSION['coupon_code'])): ?>
						<button class="remove_coupon" data-coupon-code ="<?php echo $_SESSION['coupon_birthday_code']; ?>" data-coupon="<?php echo $_SESSION['coupon_code']; ?>"><?php  echo __( '[הסר קופונים]', 'gant' )  ?></button>
					<?php elseif (isset($_SESSION['coupon_code'])): ?>
						<button class="remove_coupon" data-coupon-code ="<?php echo $_SESSION['coupon_code']; ?>" data-coupon="<?php echo $_SESSION['coupon_code']; ?>"><?php  echo __( '[Remove]', 'woocommerce' )  ?></button>
					<?php elseif (isset($_SESSION['coupon_birthday_code'])): ?>
						<button class="remove_coupon" data-coupon="<?php echo $_SESSION['coupon_birthday_code']; ?>"><?php  echo __( '[Remove]', 'woocommerce' )  ?></button>
					<?php endif; ?>
				</td>
			</tr>
		<?php endif;  ?>



		<?php
		if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
			$taxable_address = WC()->customer->get_taxable_address();
			$estimated_text  = '';

			if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
				/* translators: %s location. */
				$estimated_text = sprintf( ' <small>' . esc_html__( '(estimated for %s)', 'woocommerce' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] );
			}

			if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
				foreach ( WC()->cart->get_tax_totals() as $code => $tax ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					?>
					<tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
						<th><?php echo esc_html( $tax->label ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></th>
						<td data-title="<?php echo esc_attr( $tax->label ); ?>"><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
					</tr>
					<?php
				}
			} else {
				?>
				<tr class="tax-total">
					<th><?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></th>
					<td data-title="<?php echo esc_attr( WC()->countries->tax_or_vat() ); ?>"><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
				<?php
			}
		}
		?>

		<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

		<?php if ( WC()->cart->get_cart_contents_count() > 0 ) {
			foreach ( WC()->cart->get_cart_contents() as $cart_item ) {
				if($i == 0){
					$last_update_transaction = $cart_item['lastupdate_transaction']['Transaction'];
					$i ++;
				}
			} 
			$coupons = $last_update_transaction['Coupons'];
			if(!empty($coupons)){
				foreach ($coupons as $coupon):
					$coupon_code = $coupon['CouponCode'];
					$coupon_desc = $coupon['Description'];
					if($coupon_code == '0015'){
					?>
						<tr class="display_coupon_btn_wrapper">
							<th>
								<button type="button" class="button_underline display_coupon_btn">
								<?php esc_html_e( 'הכנס קוד קופון', 'woocommerce' ); ?></th>
								</button>
							<th>
							<td></td>
						</tr>
					<?php 
					}
				endforeach;

			}
			else{
				?>
				<tr class="display_coupon_btn_wrapper">
					<th>
						<button type="button" class="button_underline display_coupon_btn">
						<?php esc_html_e( 'הכנס קוד קופון', 'woocommerce' ); ?></th>
						</button>
					<th>
					<td></td>
				</tr>
			<?php
			}
		}?>
				
				
			<tr class="coupon">
				<th>	
					<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> 
					<div class="error_msg_coupon_empty">
						<?php esc_attr_e( 'הכנס  קופון כדי להמשיך', 'gant' ); ?>
					</div>
				</th>
				<td>
				<button type="submit"  class="button_underline apply_coupon" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>">
					<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>
				</button>
				</td>
				<?php do_action( 'woocommerce_cart_coupon' ); ?>
				
			</tr>
				
				
		
		<?//php } ?>
		<?php  if( get_user_meta( get_current_user_id(), 'birthday_coupon', true ) != '') : ?>
			<tr  class="birthday_coupon_wrapper">
			<th >
				<input type="checkbox" id="birthday_coupon" name="birthday_coupon" data-coupon="<?php echo esc_attr(get_user_meta( get_current_user_id(), 'birthday_coupon', true )); ?>">
				<label for="birthday_coupon"><?php esc_html_e( 'הפעלת הנחה יום הולדת', 'woocommerce' ); ?></label>
			</th>
			<td></td>
			</tr>

		<?php endif;?>
		<tr class="order-total">
			<th><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
			<td data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>"><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>
		<tr class="accumulated_point">
			<?php  if( is_user_logged_in()) : 
				if ( WC()->cart->get_cart_contents_count() > 0 ) {
					foreach ( WC()->cart->get_cart_contents() as $cart_item ) {
						if($i == 0){
							$last_update_transaction = $cart_item['lastupdate_transaction']['Transaction'];
							$i ++;
						}
					} 
				}
				$points = number_format($last_update_transaction['AccumulatedClubPointsValue'],2);?>
				<th><?php printf( __( 'ברכישה זו תצבור %s נקודות' ),  $points );  ?></th>
			<?php else: ?>
				<th><?php esc_html_e( 'חברי מועדון צוברים 15% בנקודות', 'woocommerce' ); ?></th>
			<?php endif;?>
		</tr>
		<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

	</table>

	<div class="wc-proceed-to-checkout">
		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
	</div>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>
	<div class="desc_under_total">
		<?php echo get_field('desc_shipping'); ?>
	</div>

</div>
