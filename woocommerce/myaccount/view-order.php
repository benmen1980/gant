<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

defined( 'ABSPATH' ) || exit;

$notes = $order->get_customer_order_notes();
?>
<div class="top_view_order_details_wrapper">
	<div class="breadcrumb_wrapper">
		<nav class="breadcrumb">
			<div class="arrow_btn">
				<a href="<?php  echo  home_url('my-account/orders') ?>" title="" class="button-secondary">
					<span class="btn_icon">
						<svg focusable="false" class="c-icon icon--arrow-button" viewBox="0 0 42 10" width="15px" height="15px">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M40.0829 5.5H0V4.5H40.0829L36.9364 1.35359L37.6436 0.646484L41.9971 5.00004L37.6436 9.35359L36.9364 8.64649L40.0829 5.5Z" fill="currentColor"></path>
						</svg>
					</span>
					<span class="button_label"> <?php esc_html_e( 'כל ההזמנות', 'gant' ); ?></span>
				</a>
			</div>
			
		</nav>
		<h1><?php esc_html_e( 'מספר הזמנה:', 'gant' ); ?><?php echo $order->get_order_number(); ?></h1>
	</div>
	<div class="wc_order_row_item">
		<div class="r_side">
			<dl>
				<div class="item_wrapper">
					<dt><?php esc_html_e( 'תאריך הזמנה: ', 'gant' ); ?></dt>
					<dd><?php echo wc_format_datetime( $order->get_date_created() ); ?></dd>
				</div>
				<div class="item_wrapper">
					<dt><?php esc_html_e( 'סה"כ: ', 'gant' ); ?></dt>
					<dd> <?php echo $order->get_formatted_order_total(); ?></dd>
				</div>
				<div class="item_wrapper status_wrapper">
					<dt><?php esc_html_e( 'סטטוס: ', 'gant' ); ?></dt>
					<dd class="<?php echo $order->get_status(); ?>"><?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?></dd>
				</div>
			</dl>
		</div>
	</div>
</div>

<?php if ( $notes ) : ?>
	<h2><?php esc_html_e( 'Order updates', 'woocommerce' ); ?></h2>
	<ol class="woocommerce-OrderUpdates commentlist notes">
		<?php foreach ( $notes as $note ) : ?>
		<li class="woocommerce-OrderUpdate comment note">
			<div class="woocommerce-OrderUpdate-inner comment_container">
				<div class="woocommerce-OrderUpdate-text comment-text">
					<p class="woocommerce-OrderUpdate-meta meta"><?php echo date_i18n( esc_html__( 'l jS \o\f F Y, h:ia', 'woocommerce' ), strtotime( $note->comment_date ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
					<div class="woocommerce-OrderUpdate-description description">
						<?php echo wpautop( wptexturize( $note->comment_content ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
		</li>
		<?php endforeach; ?>
	</ol>
<?php endif; ?>

<?php do_action( 'woocommerce_view_order', $order_id ); ?>
