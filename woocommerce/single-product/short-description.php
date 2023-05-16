<?php
/**
 * Single product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post,$product;

$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );

// if ( ! $short_description ) {
// 	return;
// }

?>
<?php if(!wp_is_mobile()): ?>
	<h3 class="product_detail_id">
		<em>
			<?php echo __('דגם מספר','gant')?>
			<?php echo $product->get_sku(); ?>
		</em>
	</h3>
<?php endif; ?>
<div class="woocommerce-product-details__short-description">
	<?php echo $short_description; // WPCS: XSS ok. ?>
	<?php echo get_field('short_desc_from_file'); ?>
	<?php echo get_field('model_desc'); ?>
</div>
<a class="product_detail_more_details" href="#product-description-accordion" >
	<span class="button_underline"><?php esc_html_e( 'מידע מפורט', 'gant' ); ?></span>
	<svg focusable="false" class="c-icon icon--arrow-short" viewBox="0 0 11 12" width="10" height="10">
	<path d="m5 11 5-5-5-5M10 6H0" stroke="currentColor" fill="none"></path>
	</svg>
</a>