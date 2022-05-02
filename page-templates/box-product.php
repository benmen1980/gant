<?php global $product; 
//if ((!$product->is_type('variable') && $product->is_in_stock()) || ($product->is_type('variable') && !is_variable_product_out_of_stock($product))):?>
    <div class="search_suggestions_product">
        <?php 
        $pdt_name = $product->get_name();
        $pdt_permalink = get_permalink( $product->get_id() );
        //print_r($product);
        if ( $product->is_type( 'variable' ) ) {
            $regular_price = $product->get_variation_regular_price();
            $sale_price = ($regular_price != $product->get_variation_sale_price())? $product->get_variation_sale_price() : '';
            if(!empty($sale_price)){
                $percent = round((($regular_price - $sale_price)*100) / $regular_price) ;
            }
        }
        else{
            $regular_price = $product->get_regular_price();
            $sale_price = $product->get_sale_price();
        }
        $attachment_ids = $product->get_gallery_image_ids();
        
        if ( is_array( $attachment_ids ) && !empty($attachment_ids) ) {
            //check if image has hover image    
            if(strpos(wp_get_attachment_url( $attachment_ids[0] ), 'model-bv-1') !== false){
                $first_image_url = wp_get_attachment_url( $attachment_ids[0] );
            }


       

            
        }
        ?>
        <div class="box_product" id="<?php echo $product->get_id();?>">
            <a href="<?php echo $pdt_permalink; ?>" title="<?php echo $pdt_name;?>">
                <?php if(!empty($sale_price)){ ?>
                    <div class="sale_tag">
                        <?php echo $percent.'%'; ?>
                    </div>
                <?php } ?>
                <div class="thumbnail <?php echo !empty($first_image_url) ? 'has-hover' :'' ?>">
                    <img src="<?php echo wp_get_attachment_url( $product->get_image_id() ); ?>" alt="">
                </div> 
                <?//php if(!empty($first_image_url)): ?>
                    <div class="thumbnail-hover">
                        <img src="<?php echo  $first_image_url; ?>" alt="">
                    </div> 
                <?//php endif; ?>
            </a>
            <?php $group_values = get_field('dynamic_product_related',$product->get_id() ); ?>
            <div class="product_details_wrapper">
                <a  class="product_details <?php echo (!empty($group_values) && count($group_values) > 1)? 'has-hover': ''?>" href="<?php echo $pdt_permalink?>" title="<?php echo $pdt_name;?>">
                    
                    <?php if(has_term( '29', 'product_tag',$product->get_id() )){ 
                        $term_data = get_term_by('id', '29', 'product_tag');
                        ?>
                        <h3 class="sustainable_choice_title"><?php echo $term_data->name; ?></h3>
                    <?php } ?>
                    <h3 class="name"><?php echo $pdt_name;?></h3>  
                    <div class="pdt_price_wrapper">
                        <h4 class="regular_price <?php  echo (!empty($sale_price)) ? 'line-through' : '' ?>"><?php echo wc_price($regular_price); ?></h4>
                        <?php if(!empty($sale_price)): ?>
                            <h4 class="sale_price"><?php echo wc_price($sale_price); ?></h4>
                        <?php endif; ?>
                    </div> 
                </a>
                <?php 
                if(!empty($group_values) && count($group_values) > 1) {?>
                    <div class="product_details_hover">
                        <?php $count_related = count($group_values); 
                        if($count_related > 5):
                            $shows = $count_related - 5;
                        ?>
                        <a href="<?php echo $pdt_permalink;?>" title="<?php echo $pdt_name; ?>" class="more_color_num">
                            <?php  echo sprintf("+ %u",$shows); ?>
                        </a>
                        <?php endif; ?>
                        <div class="colors_wrapper">
                            <?php 
                            foreach($group_values as $product_id){
                                $current_product = wc_get_product($product_id);
                                $slug = get_permalink( $product_id );
                                $color = get_field('grouped_color',$product_id);
                                $id = $current_product->get_id();
                                $current_id = $product->get_id();
                                $sku = $current_product->get_sku();

                                // get product image color
                                $attachment_id = get_attachment_id_by_slug($sku.'-thumb-fv-1');
                                $pdt_image_color = wp_get_attachment_url($attachment_id );
                                ?>
                                <a data-slug="<?php echo $slug ?>" data-img="<?php echo wp_get_attachment_url( $current_product->get_image_id() ); ?>"  href="<?php echo $slug?>" class="checkbox_color_wrapper <?php echo (($current_id == $id)? 'current_pdt_color':'')?> <?php echo (is_variable_product_out_of_stock($current_product))? 'out_of_stock':'';?>">
                                    <p class="row_radio_wrapper">
                                        <span class="radio_wrapper">
                                            <input class="radio_price" id="radio_color_<?php echo $sku;?>" type="radio" name="checkbox_price" value="<?php echo $sku ?>">	
                                            <label for="radio_color_<?php echo $sku;?>" style="background-image:url('<?php echo $pdt_image_color;?>');color:<?php echo  $color;?>"><?php echo $val ?></label>
                                        </span>
                                    </p>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?//php endif; ?>
