<?php
/**
 * Edit address form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;?>
<div class="border-top"></div>
<div class="address_title_wrapper">
	<h3 class="entry-title"><?php echo __( 'פנקס הכתובות', 'gant' ) ?></h3>
</div>
<?php $page_title = ( 'billing' === $load_address ) ? esc_html__( 'Billing address', 'woocommerce' ) : esc_html__( 'Shipping address', 'woocommerce' );
do_action( 'woocommerce_before_edit_account_address_form' );
 ?>

<?php if ( ! $load_address ) : ?>
	<?php wc_get_template( 'myaccount/my-address.php' ); ?>
<?php else : ?>
	<div class="modal is_modal_showing" id="modal_address">
		<div class="modal_container">
			<header class="section_header">
				<h3><?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title, $load_address ); ?></h3><?php // @codingStandardsIgnoreLine ?>
				<button type="button" tabindex="0" aria-label="סגור" class="close">
					<svg focusable="false" class="c-icon icon--close" viewBox="0 0 26 27" width="12" height="12">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M13 14.348l11.445 11.685L26 24.445 14.555 12.761 25.5 1.588 23.944 0 13 11.173 2.056 0 .501 1.588 11.445 12.76 0 24.444l1.555 1.588L13 14.348z" fill="currentColor"></path>
					</svg>
				</button>
			</header>

			<div class="modal_content" role="dialog">
				<?php  ?>
				<form method="post" class="edit_address_form">
					<div class="woocommerce-address-fields">
						<?php do_action( "woocommerce_before_edit_address_form_{$load_address}" ); ?>
						<div class="woocommerce-address-fields__field-wrapper">
							<?php
							foreach ( $address as $key => $field ) {
								woocommerce_form_field( $key, $field, wc_get_post_data_by_key( $key, $field['value'] ) );
							}
							?>
						</div>

						<?php do_action( "woocommerce_after_edit_address_form_{$load_address}" ); ?>
						<!-- <p class="default_address">
							<?//php echo apply_filters( 'woocommerce_my_account_my_address_description', esc_html__( 'The following addresses will be used on the checkout page by default.', 'woocommerce' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</p> -->
						<p>
							<button type="submit" class="button-secondary" name="save_address" value="<?php esc_attr_e( 'Save address', 'woocommerce' ); ?>">
							<span class="button_label"><?php esc_html_e( 'Save address', 'woocommerce' ); ?></span>
							</button>
							<?php wp_nonce_field( 'woocommerce-edit_address', 'woocommerce-edit-address-nonce' ); ?>
							<input type="hidden" name="action" value="edit_address" />
						</p>
					</div>
					
				</form>
				<?php do_action( 'woocommerce_after_edit_account_address_form' ); ?>
			</div>
		</div>
		<div class="modal_bg"></div>
	</div>

<?php endif; ?>







