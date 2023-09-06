<?php $current_term = get_queried_object();
//print_r($current_term);
$taxonomy = $current_term->taxonomy;
$current_term_name = $current_term->name;
$current_term_id = $current_term->term_id;
$current_term_slug = $current_term->slug;
$parent_tag_id = $current_term->parent;
$term = get_term_by( 'id', $parent_tag_id, 'product_cat' );
$parent_term_name = $term->name;
$parent_term_id = $term->term_id;
$parent_term_slug = get_term_link ($parent_tag_id, 'product_cat');



$posts_per_page = get_option('posts_per_page');
//$posts_per_page  = -1;
$args_cat = array(
    'post_type' =>  array('product', 'product_variation'),
    'post_status' => array('publish'),
    'product_cat' => $current_term->slug,
    'posts_per_page' => $posts_per_page,
    'paged' => 1,
    'meta_key'       => 'total_sales',
    'orderby'        => 'meta_value_num',
    'order'          => 'DESC',
    'meta_query' => array(
        array(
            'key' => '_stock_status',
            'value' => 'instock',
            'compare' => '=',
        ),
        // array(
        //     'key' => '_thumbnail_id',
        //     'compare' => 'EXISTS',
        // )
    )
);



$arr_posts = new WP_Query( $args_cat );
$total_count = $arr_posts->found_posts;
$current_count = $arr_posts->post_count;
$max_page = $arr_posts->max_num_pages;

?>
<?php if(true): ?>
<div class="r_side">
    <?php if(!empty(get_term_meta($current_term_id, 'size_filter', true))): ?>
        <div class="dropdown">
            <button class="dropbtn">
                <span aria-label="<?php echo get_field('title_filter_size','option') ?>" ><?php echo get_field('title_filter_size','option') ?></span>
                <span class="selected_choices" id="select_size"></span>
                <svg focusable="false" class="c-icon icon--chevron-down" viewBox="0 0 14 9" width="10px" height="6px">
                    <g fill="currentColor"><polygon points="0 1.89221557 1.977 0 6.987 5.05489022 12.024 8.86405608e-16 14 1.89221557 6.986 9"></polygon></g>
                </svg>
            </button>
            <div class="dropdown_wrapper">
                <div class="dropdown_box">
                    <div class="dropdown_header">
                        <span aria-label="<?php echo get_field('title_filter_size','option') ?>" ><?php echo get_field('title_filter_size','option') ?></span>
                        <button type="button" tabindex="0" aria-label="סגור" class="close">
                            <svg focusable="false" class="c-icon icon--close" viewBox="0 0 26 27" width="12" height="12">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13 14.348l11.445 11.685L26 24.445 14.555 12.761 25.5 1.588 23.944 0 13 11.173 2.056 0 .501 1.588 11.445 12.76 0 24.444l1.555 1.588L13 14.348z" fill="currentColor"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="dropdown_content">
                        <?php  $catSizes =  get_term_meta($current_term_id, 'size_filter', true); 
                        $sizes = getOrderedBySize($catSizes);
                        if(empty($sizes)){
                            $sizes = getOrderedBySizeChild($catSizes);
                            if(empty($sizes)){
                                $sizes = $catSizes;
                            }
                        }
                        
                        ?>
                        <?php $counter_size = 0;foreach($sizes as $key=>$size): ?>
                        <button role="menuitemcheckbox" class="menu_item_checkbox" aria-checked="false" data-section="size" aria-label="מידה: <?php echo $key;?>">
                            <p class="row_checkbox_wrapper">
                                <span class=" checkbox_wrapper">
                                    <input class="checkbox_size" id="checkbox_size_<?php echo $counter_size?>" type="checkbox" name="checkbox_size" value="<?php echo $key ?>">	
                                    <label for="checkbox_size_<?php echo $counter_size?>">
                                        
                                        <?php 
                                        global $product;
                                        $term = get_term_by('slug', $key , 'pa_size');
                                        if ( !empty( $term->description ) && ($parent_tag_id == 2076 || $parent_tag_id == 2081)){
                                            echo $key.' -'.$term->description;
                                        }
                                        else{
                                            echo $key;
                                        }
                                         ?>
                                    </label>
                                </span>
                            </p>
                            <span class="checkbox_count">(<?php echo $size; ?>)</span></span>
                        </button>
                        <?php $counter_size++; endforeach; ?>
                    </div>

                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if(!empty(get_term_meta($current_term_id, 'cut_filter', true))): ?>
        <div class="dropdown">
            <button class="dropbtn">
                <span aria-label="<?php echo get_field('title_filter_cut','option') ?>" ><?php echo get_field('title_filter_cut','option') ?></span>
                <span class="selected_choices" id="select_cut"></span>
                <span class="btn_icon">
                    <svg focusable="false" class="c-icon icon--chevron-down" viewBox="0 0 14 9" width="10px" height="6px">
                        <g fill="currentColor"><polygon points="0 1.89221557 1.977 0 6.987 5.05489022 12.024 8.86405608e-16 14 1.89221557 6.986 9"></polygon></g>
                    </svg>
                </span>
            </button>
            <div class="dropdown_wrapper">
                <div class="dropdown_box">
                    <div class="dropdown_header">
                        <span aria-label="<?php echo get_field('title_filter_cut','option') ?>" ><?php echo get_field('title_filter_cut','option') ?></span>
                        <button type="button" tabindex="0" aria-label="סגור" class="close">
                            <svg focusable="false" class="c-icon icon--close" viewBox="0 0 26 27" width="12" height="12">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13 14.348l11.445 11.685L26 24.445 14.555 12.761 25.5 1.588 23.944 0 13 11.173 2.056 0 .501 1.588 11.445 12.76 0 24.444l1.555 1.588L13 14.348z" fill="currentColor"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="dropdown_content">
                        <?php  $cuts = get_term_meta($current_term_id, 'cut_filter', true);?>
                        <?php $counter_cut = 0;foreach($cuts as $key=>$cut): ?>
                            <button role="menuitemcheckbox" class="menu_item_checkbox checkbox_cut_wrapper" aria-checked="false" data-section="size" aria-label="גיזרה: <?php echo $key;?>">
                                <p class="row_checkbox_wrapper">
                                    <span class=" checkbox_wrapper">
                                        <input class="checkbox_cut" id="checkbox_cut_<?php echo $counter_cut;?>" type="checkbox" name="checkbox_cut" value="<?php echo $key ?>">	
                                        <label for="checkbox_cut_<?php echo $counter_cut;?>"><?php echo $key ?></label>
                                    </span>
                                </p>
                                <span class="checkbox_count">(<?php echo $cut; ?>)</span></span>
                            </button>
                        <?php $counter_cut++; endforeach; ?>
                    </div>

                </div>
            </div>

        </div>
    <?php endif; ?>
    <?php if(!empty(get_term_meta($current_term_id, 'color_filter', true))): ?>
        <div class="dropdown">
            <button class="dropbtn">
                <span aria-label="<?php echo get_field('title_filter_color','option') ?>" ><?php echo get_field('title_filter_color','option') ?></span>
                <span class="selected_choices" id="select_color"></span>
                <span class="btn_icon">
                    <svg focusable="false" class="c-icon icon--chevron-down" viewBox="0 0 14 9" width="10px" height="6px">
                        <g fill="currentColor"><polygon points="0 1.89221557 1.977 0 6.987 5.05489022 12.024 8.86405608e-16 14 1.89221557 6.986 9"></polygon></g>
                    </svg>
                </span>
            </button>
            <div class="dropdown_wrapper">
                <div class="dropdown_box">
                    <div class="dropdown_header">
                        <span aria-label="<?php echo get_field('title_filter_color','option') ?>" ><?php echo get_field('title_filter_color','option') ?></span>
                        <button type="button" tabindex="0" aria-label="סגור" class="close">
                            <svg focusable="false" class="c-icon icon--close" viewBox="0 0 26 27" width="12" height="12">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13 14.348l11.445 11.685L26 24.445 14.555 12.761 25.5 1.588 23.944 0 13 11.173 2.056 0 .501 1.588 11.445 12.76 0 24.444l1.555 1.588L13 14.348z" fill="currentColor"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="dropdown_content checkbox_color_dropdown">
                        <?php  //$colors = get_field('color_filter'); var_dump($colors);
                        $colors = get_term_meta($current_term_id, 'color_filter', true); ?>
                        <?php $counter_color = 0; foreach($colors as $key=>$color): ?>
                            <?php 
                            if($key == 'multi color'){
                                $color_class = 'multicolor_row';
                            }
                            else{
                                $color_class = $key;
                            }
                            ?>
                            <button role="menuitemcheckbox" class="menu_item_checkbox checkbox_color_wrapper" aria-checked="false" data-section="size" aria-label="צבע: <?php echo $key;?>">
                                <p class="row_checkbox_wrapper <?php echo $color_class; ?>">
                                    <span class=" checkbox_wrapper">
                                        <input class="checkbox_color"  data-paged="1" total_pdts="<?php echo $color;?>" posts_per_page="<?php echo $posts_per_page;?>" id="checkbox_color_<?php echo $counter_color;?>" type="checkbox" name="checkbox_color" value="<?php echo $key ?>">	
                                        <label for="checkbox_color_<?php echo $counter_color;?>" style="color:<?php echo  $key;?>">
                                            <span><?php esc_html_e( $key, 'gant' ); ?></span>
                                        </label>
                                    </span>
                                </p>
                                <span class="checkbox_count">(<?php echo $color; ?>)</span></span>
                            </button>
                        <?php $counter_color++; endforeach; ?>
                    </div>

                </div>
            </div>

        </div>
    <?php endif; ?>
    <?php if(!empty(get_term_meta($current_term_id, 'price_filter', true))): ?>
        <div class="dropdown">
            <button class="dropbtn">
                <span aria-label="<?php echo get_field('title_filter_price','option') ?>" ><?php echo get_field('title_filter_price','option') ?></span>
                <span class="selected_choices" id="select_price"></span>
                <span class="btn_icon">
                    <svg focusable="false" class="c-icon icon--chevron-down" viewBox="0 0 14 9" width="10px" height="6px">
                        <g fill="currentColor"><polygon points="0 1.89221557 1.977 0 6.987 5.05489022 12.024 8.86405608e-16 14 1.89221557 6.986 9"></polygon></g>
                    </svg>
                </span>
            </button>
            <div class="dropdown_wrapper">
                <div class="dropdown_box">
                    <div class="dropdown_header">
                        <span aria-label="<?php echo get_field('title_filter_price','option') ?>" ><?php echo get_field('title_filter_price','option') ?></span>
                        <button type="button" tabindex="0" aria-label="סגור" class="close">
                            <svg focusable="false" class="c-icon icon--close" viewBox="0 0 26 27" width="12" height="12">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13 14.348l11.445 11.685L26 24.445 14.555 12.761 25.5 1.588 23.944 0 13 11.173 2.056 0 .501 1.588 11.445 12.76 0 24.444l1.555 1.588L13 14.348z" fill="currentColor"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="dropdown_content checkbox_price_dropdown">
                        <?php  
                        $prices = get_term_meta($current_term_id, 'price_filter', true); ?>
                        <?php $counter_price = 0; foreach($prices as $val=>$count): 
                            $range =  str_replace(array('-', '+'),array(',',''),$val);
                            //$range =  str_replace('+','',$val);
                            ?>
                            <?php if($count > 0) :?>
                                <button role="menuitemcheckbox" class="menu_item_checkbox checkbox_price_wrapper" aria-checked="false" data-section="size" aria-label="מחיר: <?php echo $val;?>">
                                    <p class="row_radio_wrapper">
                                        <span class="radio_wrapper">
                                            <input class="radio_price"  data-paged="1" total_pdts="<?php echo $count;?>" posts_per_page="<?php echo $posts_per_page;?>" id="checkbox_price_<?php echo $counter_price;?>" type="radio" name="checkbox_price" value="<?php echo $range ?>">	
                                            <label for="checkbox_price_<?php echo $counter_price;?>"><?php echo $val ?></label>
                                        </span>
                                    </p>
                                    <span class="checkbox_count">(<?php echo $count; ?>)</span></span>
                                </button>
                            <?php endif;?>
                        <?php $counter_price++; endforeach; ?>
                    </div>

                </div>
            </div>

        </div>
    <?php endif; ?>
    <?php if(get_field('substainable_filter')!= 0): ?>
        <div class="dropdown">
            <button class="dropbtn">
                <span aria-label="<?php echo get_field('title_filter_substainility','option') ?>" ><?php echo get_field('title_filter_substainility','option') ?></span>
                <span class="selected_choices" id="select_sub"></span>
                <span class="btn_icon">
                    <svg focusable="false" class="c-icon icon--chevron-down" viewBox="0 0 14 9" width="10px" height="6px">
                        <g fill="currentColor"><polygon points="0 1.89221557 1.977 0 6.987 5.05489022 12.024 8.86405608e-16 14 1.89221557 6.986 9"></polygon></g>
                    </svg>
                </span>
            </button>
            <div class="dropdown_wrapper">
                <div class="dropdown_box">
                    <div class="dropdown_header">
                        <span aria-label="<?php echo get_field('title_filter_substainility','option') ?>" ><?php echo get_field('title_filter_substainility','option') ?></span>
                        <button type="button" tabindex="0" aria-label="סגור" class="close">
                            <svg focusable="false" class="c-icon icon--close" viewBox="0 0 26 27" width="12" height="12">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13 14.348l11.445 11.685L26 24.445 14.555 12.761 25.5 1.588 23.944 0 13 11.173 2.056 0 .501 1.588 11.445 12.76 0 24.444l1.555 1.588L13 14.348z" fill="currentColor"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="dropdown_content">
                        <?php  $substainable = get_field('substainable_filter'); ?>
                        
                        <button role="menuitemcheckbox" class="menu_item_checkbox checkbox_substainable_wrapper" aria-checked="false" data-section="size" aria-label="בחירת בת קיימא: <?php echo $key;?>">
                            <p class="row_checkbox_wrapper">
                                <span class=" checkbox_wrapper">
                                    <input id="checkbox_substainable" type="checkbox" name="checkbox_substainable" value="29">	
                                    <label for="checkbox_substainable"><?php echo get_field('title_filter_substainility','option') ?></label>
                                </span>
                            </p>
                            <span class="checkbox_count">(<?php echo $substainable; ?>)</span></span>
                        </button>
                        
                    </div>

                </div>
            </div>

        </div>
    <?php endif; ?>
    <?php if(!empty(get_field('select_categories_filter'))): ?>
        <div class="dropdown">
            <button class="dropbtn">
                <span aria-label="קטגוריות" >קטגוריות</span>
                <span class="selected_choices" id="select_cat"></span>
                <span class="btn_icon">
                    <svg focusable="false" class="c-icon icon--chevron-down" viewBox="0 0 14 9" width="10px" height="6px">
                        <g fill="currentColor"><polygon points="0 1.89221557 1.977 0 6.987 5.05489022 12.024 8.86405608e-16 14 1.89221557 6.986 9"></polygon></g>
                    </svg>
                </span>
            </button>
            <div class="dropdown_wrapper">
                <div class="dropdown_box">
                    <div class="dropdown_header">
                        <span aria-label="קטגוריות" >קטגוריות</span>
                        <button type="button" tabindex="0" aria-label="סגור" class="close">
                            <svg focusable="false" class="c-icon icon--close" viewBox="0 0 26 27" width="12" height="12">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13 14.348l11.445 11.685L26 24.445 14.555 12.761 25.5 1.588 23.944 0 13 11.173 2.056 0 .501 1.588 11.445 12.76 0 24.444l1.555 1.588L13 14.348z" fill="currentColor"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="dropdown_content">
                        <?php  $select_categories_filter = get_field('select_categories_filter'); 
                        $counter_cat = 0;
                        foreach($select_categories_filter as $cat):

                            $args = array(
                                'posts_per_page' => -1,
                                'post_type'      => 'product',
                                'hide_empty'     => 1,        
                                'tax_query'  => array(
                                    array(
                                        'taxonomy' => 'product_cat',
                                        'field' => 'term_id',
                                        'terms' => array($cat->term_id),
                                        'operator' => 'IN',
                                    )
                                ),
                                'meta_query' => array(
                                    array(
                                        'key' => '_stock_status',
                                        'value' => 'instock',
                                        'compare' => '=',
                                    )
                                    // array(
                                    //     'key' => '_thumbnail_id',
                                    //     'compare' => 'EXISTS',
                                    // )
                                )
                            );
                            $my_query = new WP_Query( $args );
                            wp_reset_query();
                            $found_post = $my_query->found_posts; 
                            ?>
                                <button role="menuitemcheckbox" class="menu_item_checkbox" aria-checked="false" data-section="size" aria-label="קטגוריה: <?php echo $cat->name;?>">
                                <p class="row_checkbox_wrapper">
                                    <span class=" checkbox_wrapper">
                                        <input class="checkbox_category"  data-cat="<?php echo $current_term_id ?>" data-catid="<?php echo $cat->term_id;?>" data-paged="1" total_pdts="<?php echo $cat->count;?>" posts_per_page="<?php echo $posts_per_page;?>" id="checkbox_category_<?php echo $counter_cat;?>" type="checkbox" name="checkbox_category" value="<?php echo $cat->name ?>">	
                                        <label for="checkbox_category_<?php echo $counter_cat;?>"><?php echo $cat->name ?></label>
                                    </span>
                                </p>
                                <span class="checkbox_count">(<?php echo $found_post; ?>)</span></span>
                            </button>
                            <?php $counter_cat++; endforeach; ?>
                    </div>
                </div>
            </div>

        </div>
    <?php endif; ?>
    <div class="filter_reset">
        <button class="button_underline">
            <span class="button__label">נקה הכל</span>
        </button>
    </div>
</div>
<?php endif; ?>
<div class="l_side">
    <?php if(wp_is_mobile()): ?>
        <div class="count_wrapper_mobile">
        <div class="count_wrapper">
            <span> הצג </span><span id="count"><?php echo $total_count; ?></span><span class="found">המוצרים </span>
        </div>
        </div>

    <?php else:?>
        <div class="count_wrapper">
            <span id="count"><?php echo $total_count; ?></span><span class="found">מוצרים</span>
        </div>
    <?php endif;?>
    <div class="sort_wrapper">
        <div class="dropdown">
            <button class="dropbtn">
                <span class="selected_order" aria-label="<?php esc_html_e( 'פופולרי', 'gant' ); ?>" ><?php esc_html_e( 'פופולרי', 'gant' ); ?></span>
                <span class="btn_icon">
                    <svg focusable="false" class="c-icon icon--chevron-down" viewBox="0 0 14 9" width="10px" height="6px">
                        <g fill="currentColor"><polygon points="0 1.89221557 1.977 0 6.987 5.05489022 12.024 8.86405608e-16 14 1.89221557 6.986 9"></polygon></g>
                    </svg>
                </span>
            </button>
            <div class="dropdown_wrapper">
                <div class="dropdown_box">
                    <div class="dropdown_header">
                        <button type="button" tabindex="0" aria-label="סגור" class="close">
                            <svg focusable="false" class="c-icon icon--close" viewBox="0 0 26 27" width="12" height="12">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13 14.348l11.445 11.685L26 24.445 14.555 12.761 25.5 1.588 23.944 0 13 11.173 2.056 0 .501 1.588 11.445 12.76 0 24.444l1.555 1.588L13 14.348z" fill="currentColor"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="dropdown_content">
                        <button  id="popularity" role="menuitemcheckbox" class="menu_item_checkbox" aria-checked="false"  aria-label="<?php esc_html_e( 'פופולרי', 'gant' ); ?>">
                            <p class="row_radio_wrapper">
                                <span class="radio_wrapper">
                                    <input checked class="radio_sort"  id="radio_sort_popularity" type="radio" name="radio_sort" value="popularity">	
                                    <label for="radio_sort_popularity"><?php esc_html_e( 'פופולרי', 'gant' ); ?></label>
                                </span>
                            </p>  
                        </button>
                        <button  id="desc" role="menuitemcheckbox" class="menu_item_checkbox" aria-checked="false"  aria-label="<?php esc_html_e( 'המחיר הכי יקר', 'gant' ); ?>">
                            <p class="row_radio_wrapper">
                                <span class="radio_wrapper">
                                    <input class="radio_sort"  id="radio_sort_desc" type="radio" name="radio_sort" value="DESC">	
                                    <label for="radio_sort_desc"><?php esc_html_e( 'המחיר הכי יקר', 'gant' ); ?></label>
                                </span>
                            </p>
                        </button>
                        <button  id="asc" role="menuitemcheckbox" class="menu_item_checkbox" aria-checked="false"  aria-label="<?php esc_html_e( 'המחיר הכי זןל', 'gant' ); ?>">
                            <p class="row_radio_wrapper">
                                <span class="radio_wrapper">
                                    <input class="radio_sort"  id="radio_sort_asc" type="radio" name="radio_sort" value="ASC">	
                                    <label for="radio_sort_asc"><?php esc_html_e( 'המחיר הכי זול', 'gant' ); ?></label>
                                </span>
                            </p> 
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <?php if(wp_is_mobile()): ?>
    <div class="count_wrapper">
        <span id="count"><?php echo $total_count; ?></span><span class="found">מוצרים</span>
    </div>
<?php endif;?> -->
<div class="loader_wrap">
    <div class="loader_spinner">
        <img src="<?php echo get_template_directory_uri();?>/dist/images/loader.svg" alt="">
    </div>
</div>