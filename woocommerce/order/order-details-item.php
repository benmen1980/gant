<?php
/**
 * Order Item Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-item.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
	return;
}
?>
<?php 
$order_id = $order->get_id();

$update_result = get_post_meta($order_id, 'response_transaction_update', true); 
$order_items = $update_result['Transaction']['OrderItems'];
?>
<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'woocommerce-table__line-item order_item', $item, $order ) ); ?>">

	<td class="woocommerce-table__product-name product-name">
		<?php
		$is_visible        = $product && $product->is_visible();
		$product_permalink = apply_filters( 'woocommerce_order_item_permalink', $is_visible ? $product->get_permalink( $item ) : '', $item, $order );
		?>
		<div class="img_wrapper">
			<?php echo  $product->get_image('thumbnail'); ?>
		</div>
		<div class="desc_pdt">
			<?php  
				echo apply_filters( 'woocommerce_order_item_name', $product_permalink ? sprintf( '<a href="%s">%s</a>', $product_permalink, $item->get_name() ) : $item->get_name(), $item, $is_visible );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

				$qty          = $item->get_quantity();
				$refunded_qty = $order->get_qty_refunded_for_item( $item_id );
		
		
				if ( $refunded_qty ) {
					$qty_display = '<del>' . esc_html( $qty ) . '</del> <ins>' . esc_html( $qty - ( $refunded_qty * -1 ) ) . '</ins>';
				} else {
					$qty_display = esc_html( $qty );
				}
		
				//echo apply_filters( 'woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $qty_display ) . '</strong>', $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		
				do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, false );
		
				wc_display_item_meta( $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		
				do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, false );
	
			?>
			<div class="product_color">
				<dl class="color">
					<div class="detail_wrapper">
						<dt class=""><?php esc_attr_e( 'צבע:', 'gant' ); ?></dt>
						<dd class="">
							<?php $color =   get_field('color', $product->id); ?>
							<p><?php  esc_attr_e( $color, 'gant' );  ?></p>
						</dd>
					</div>
					<?php if(wp_is_mobile()): ?>
						<div class="detail_wrapper">
							<dt class=""><?php esc_attr_e( 'מק"ט:', 'gant' ); ?></dt>
							<dd class="">
								<p><?php echo $product->get_sku(); ?></p>
							</dd>
						</div>
						<div class="detail_wrapper">
							<dt class=""><?php esc_attr_e( 'כמות:', 'gant' ); ?></dt>
							<dd class="">
								<p><?php echo $qty_display; ?></p>
							</dd>
						</div>
						<div class="detail_wrapper">
							<dt class=""><?php esc_attr_e( 'סה"כ:', 'gant' ); ?></dt>
							<dd class="">
							<?php 
								$order_id = $order->get_id();
								$update_result = get_post_meta($order_id, 'response_transaction_update', true); 
								$order_items = $update_result['Transaction']['OrderItems'];
								if(!empty($order_items)){
									foreach ($order_items as $order_item){
										$item_sku = $order_item['ItemCode'];
										if($item_sku == $product->get_sku()){
											$tot_price = $order_item['TotalPrice']; // price after discount for all quantity);
											if(wc_price($order_item['PricePerItem'] * $order_item['ItemQuantity'])  != $order->get_formatted_line_subtotal( $item )) { 
												$price = '<del>' . wc_price($order_item['PricePerItem'] * $order_item['ItemQuantity']). '</del> <ins>' . $order->get_formatted_line_subtotal( $item ) . '</ins>'; ?>
												
											<?php }
											else{
												$price = $order->get_formatted_line_subtotal( $item );
											}
											?>
											<p><?php  echo $price;?></p>
											<div class="product-sale-desc">
												<?php echo $order_item['FirstSaleDescription']; ?>
											</div>
											<?php break;
										}
										
									}
								}?>
							</dd>
						</div>
					<?php endif; ?>
				</dl>

			</div>
		</div>
	</td>
	<?php if(!wp_is_mobile()): ?>
		<td class="woocommerce-table__product-sku product-sku"> 
			<?php echo $product->get_sku(); ?>
		</td>
		<td class="woocommerce-table__product-qtty product-qtty">
			<?php echo  $qty_display; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</td>
		<?php if(false): ?>
		<td class="woocommerce-table__product-total product-total">
			<?php echo $order->get_formatted_line_subtotal( $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</td>
		<?php endif; ?>
		
		<td class="woocommerce-table__product-total product-total">
			<?php
				if(!empty($order_items)){
					foreach ($order_items as $order_item){
						$item_sku = $order_item['ItemCode'];
						if($item_sku == $product->get_sku()){
							$tot_price = $order_item['TotalPrice']; // price after discount for all quantity);
							if(wc_price($order_item['PricePerItem'] * $order_item['ItemQuantity'])  != $order->get_formatted_line_subtotal( $item )) { 
								$price = '<del>' . wc_price($order_item['PricePerItem'] * $order_item['ItemQuantity']). '</del> <ins>' . $order->get_formatted_line_subtotal( $item ) . '</ins>'; ?>
								
							<?php }
							else{
								$price = $order->get_formatted_line_subtotal( $item );
							}
							echo $price;?>
							<div class="product-sale-desc">
								<?php echo $order_item['FirstSaleDescription']; ?>
							</div>
							<?php break;
						}
						
					}
				} 
			?>
			<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</td>
	<?php endif; ?>
</tr>

<?php if ( $show_purchase_note && $purchase_note ) : ?>

<tr class="woocommerce-table__product-purchase-note product-purchase-note">

	<td colspan="2"><?php echo wpautop( do_shortcode( wp_kses_post( $purchase_note ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>

</tr>

<?php endif; ?>
