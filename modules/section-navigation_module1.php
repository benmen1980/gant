<section class="navigation_module section_wrap">
    <?php if(get_sub_field('navigation_module_two_columns')):while(the_repeater_field('navigation_module_two_columns')):  
        $col1_title_pos = get_sub_field('col1_title_pos');
        $title1 = get_sub_field('title_1');
        $sub_title1 = get_sub_field('sub_title_1');
        $img1 = get_sub_field('image_1');
        $link1 = get_sub_field('choose_page_1');
        $text_color1 = get_sub_field('color_text_1');

        $col2_title_pos = get_sub_field('col2_title_pos');
        $title2 = get_sub_field('title_2');
        $sub_title2 = get_sub_field('sub_title_2');
        $img2 = get_sub_field('image_2');
        $link2 = get_sub_field('choose_page_2');
        $text_color2 = get_sub_field('color_text_2');

        ?>
        <div class="navigation_module_two_cols navigation_module_wrapper">
            <div class="col_1 col_wrap <?php echo 'text_'.$col1_title_pos; ?>" >
                <a href="<?php echo $link1; ?>" title="<?php echo $link1; ?>">
                    <?php if($img1):?>
                        <div class="img_wrapper">
                            <figure>
                                <img src="<?php echo $img1; ?>" alt="<?php echo $title1; ?>">
                            </figure>  
                        </div> 
                    <?php endif;?>
                    <?php if($title1):?>
                        <div class="text_image_wrapper" style="color:<?php echo $text_color1; ?>">
                            <h6><?php echo $sub_title1; ?></h6>
                            <h5><?php echo $title1; ?></h5> 
                        </div>
                    <?php endif;?>
                </a>
            </div>
            <div class="col_2 col_wrap <?php echo 'text_'.$col2_title_pos; ?>">
                <a href="<?php echo $link2; ?>" title="<?php echo $link2; ?>">
                    <?php if($img2):?>
                        <div class="img_wrapper">
                            <figure>
                                <img src="<?php echo $img2; ?>" alt="<?php echo $title2; ?>">
                            </figure>  
                        </div> 
                    <?php endif;?>
                    <?php if($title2):?>
                        <div class="text_image_wrapper" style="color:<?php echo $text_color2; ?>">
                            <h6><?php echo $sub_title2; ?></h6>
                            <h5><?php echo $title2; ?></h5> 
                        </div>
                    <?php endif;?>
                </a>
            </div>
    
        </div>
    <?php endwhile;endif?>
</section>