<section class="sale_banner section_wrap">
    <?php if(get_sub_field('sale_banner')): 
        $sale_banner = get_sub_field('sale_banner');
        $sale_active = $sale_banner['banner_sale_active'];
        $sale_txt_align = $sale_banner['select_txt_direction'];
        $sale_txt_lang = $sale_banner['select_lang_direction'];
        $select_txt_font = $sale_banner['select_txt_font'];
        if($select_txt_font == "hebrew "){
            $font_family = "almoni-dl";
        }
        elseif($select_txt_font == "english "){
            $font_family = "gantmodern";
        }
        else{
            $font_family = "gantserif";
        }
        $select_sub_txt_font = $sale_banner['select_sub_txt_font'];
        if($select_sub_txt_font == "hebrew "){
            $font_family_subtxt = "almoni-dl";
        }
        elseif($select_sub_txt_font == "english"){
            $font_family_subtxt = "gantmodern";
        }
        else{
            $font_family_subtxt = "gantserif";
        }

        $font_size_title = $sale_banner['select_txt_font_size'];
        $font_size_sub_title = $sale_banner['select_sub_txt_font_size'];

        $sale_title = $sale_banner['title_sale'];
        $sale_sub_title = $sale_banner['sub_title_sale'];
        $sale_bg = $sale_banner['bg_sale'];
        $sale_img_bg = $sale_banner['bg_img_sale'];
        $sale_color = $sale_banner['bg_txt'];
        $sale_bg_btn = $sale_banner['bg_btn_color'];
        $sale_clr_txt = $sale_banner['btn_color_txt'];
        $links = $sale_banner['choose_sale_link'];
        $sale_border_color = $sale_banner['btn_border_clr'];
        $comment = $sale_banner['comments'];
        $counter_links = count($links);
        $current_term = get_queried_object();
        //print_r($current_term);
        $current_term_name = $current_term->name;
        $current_term_id = $current_term->term_id;
        $parent_tag_id = $current_term->parent;
        $term = get_term_by( 'id', $parent_tag_id, 'product_cat' );
        //print_r($term);
        if(!empty( $term)){
            $parent_term_name = $term->name;
            $parent_term_id = $term->term_id;
            $parent_term_slug = get_term_link ($parent_tag_id, 'product_cat');
        }
        ?>
    
        <div class="sale_banner_content" style="text-align:<?php echo $sale_txt_align;?>; background-color:<?php echo $sale_bg; ?>; color : <?php echo $sale_color; ?>; background-image:url('<?php echo !empty($sale_img_bg) ? $sale_img_bg : '' ?>'); ">
            <?php if(!empty($term)): ?>
                <nav class="breadcrumb">
                    <div class="arrow_btn">
                        <a href="<?php  echo  $parent_term_slug; ?>" title="<?php echo $parent_term_name; ?>" class="button-secondary" style="background-color:<?php echo $sale_bg; ?>; color:<?php echo $sale_color; ?>;">
                            <span class="btn_icon" style="color:<?php echo $sale_color; ?>;">
                                <svg focusable="false" class="c-icon icon--arrow-button" viewBox="0 0 42 10" width="15px" height="15px">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M40.0829 5.5H0V4.5H40.0829L36.9364 1.35359L37.6436 0.646484L41.9971 5.00004L37.6436 9.35359L36.9364 8.64649L40.0829 5.5Z" fill="currentColor"></path>
                                </svg>
                            </span>
                            <span class="button_label" style="color:<?php echo $sale_color; ?>;"><?php echo $parent_term_name; ?></span>
                        </a>
                    </div>
                    
                </nav>
            <?php endif; ?>
            <div class="sale_titles_wrapper font_<?php echo $select_txt_font; ?>" style="direction:<?php echo ($sale_txt_lang == 'hebrew') ? 'rtl' : 'ltr'; ?>">
                <h2 style="font-family:<?php echo $font_family;?>; font-size:<?php echo  $font_size_title; ?>px; font-weight: normal;"><?php echo $sale_title; ?></h2>
                <h3 style="font-family:<?php echo $font_family_subtxt;?>; font-size:<?php echo  $font_size_sub_title; ?>px; font-weight: normal;"><?php echo $sale_sub_title; ?></h3>
            </div>
            <?php 
            if($sale_txt_align == 'right'){
                $margin_left = "margin-left: auto;";
                $margin_right = "margin-right: initial;";
            }
            elseif($sale_txt_align == 'left'){
                $margin_left = "margin-left: initial;";
                $margin_right = "margin-right: auto;";
            }
            else{
                $margin_left = "margin-left: auto;";
                $margin_right = "margin-right: auto;";
            }
             ?>
            <div class="sale_btns_wrapper" style="justify-content:<?php echo $sale_txt_align;?>; <?php echo $margin_left . $margin_right; ?>">
                <?php 
                foreach($links as $link) {
                    $page = $link['choose_page'];
                    $link_title = $page['title'];
                    $link_target = $page['target'] ? $page['target'] : '_self';
                    $link_url = $page['url'];
                    $term = get_term_by('slug',$link_url,'product_cat'); 
                    //print_r($page);
                    global $post;
                    $post_slug = $post->post_name;
                    $url_path = parse_url($link_url, PHP_URL_PATH);
                    $basename = pathinfo($url_path, PATHINFO_BASENAME);
                    if($post_slug == $basename && $counter_links > 1){
                        $sale_bg_btn = $sale_banner['btn_color_txt'];
                        $sale_clr_txt = $sale_banner['bg_btn_color'];
                    }
                    else{
                        $sale_bg_btn = $sale_banner['bg_btn_color'];
                        $sale_clr_txt = $sale_banner['btn_color_txt'];
                    }

                ?>
                    <a class="button-secondary <?php echo  ($post_slug == $basename) ? 'active' : ''?>" target="<?php echo esc_attr( $link_target ); ?>" style="background-color:<?php echo $sale_bg_btn; ?>; color:<?php echo (empty($sale_border_color)) ? $sale_bg_btn : $sale_clr_txt; ?>; <?//php echo (!empty($sale_border_color)) ? 'border: 1px solid '.$sale_border_color : ''?>" 
                    href="<?php echo $link_url; ?>" title="<?php echo $link_title; ?>">
                        <span class="button_label" style="color:<?php echo $sale_clr_txt; ?>;"><?php echo $link_title; ?></span>
                    </a>
                <?php } ?>
            </div>
            <div class="comment_promotion font_hebrew" style="direction:rtl">
                <span><?php echo $comment; ?></span>
            </div>
        </div>
       
    <?php endif;?>
</section>