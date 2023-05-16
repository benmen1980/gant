<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.4
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
	return;
}

?>


<form class="woocommerce-form-coupon" method="post" >
	<!-- <h3 class="coupon_title"><?php esc_html_e( 'קופון:', 'gant' ); ?></h3> -->
	<button type="button" class="display_coupon_btn">
		<?php esc_html_e( 'הכנס קוד קופון', 'woocommerce' ); ?>
	</button>
	<div class="coupon">
		<div class="form-row form-row-first">
			<input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" />
			<div class="error_msg_coupon_empty">
				<?php esc_attr_e( 'הכנס  קופון כדי להמשיך', 'gant' ); ?>
			</div>
		</div>
		<div class="form-row form-row-last">
			<button type="submit" class="button_underline apply_coupon" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply coupon', 'woocommerce' ); ?></button>
		</div>
	</div>

	<div class="clear"></div>
</form>
