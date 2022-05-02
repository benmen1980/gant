<?php 
$related_categories = get_sub_field('select_pdts_slider');
$radio_selected = $related_categories['select_cat_or_pdt'];
 ?>
<section class="slider_section section_wrap">
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



