<section class="banner_2 section_wrap">
    <?php if(get_sub_field('banner_after_register_club')):while(the_repeater_field('banner_after_register_club')):  
        $title = get_sub_field('title');
        $sub_title = get_sub_field('sub_title');
        $img = get_sub_field('Image');
        $img_under_txt = get_sub_field('bg_under_text');
        $text_color = get_sub_field('text_color');
        $bg_color = !empty(get_sub_field('bg_color_box'))? get_sub_field('bg_color_box') :'transparent';
        $title_point = get_sub_field('title_point');
        $desc_point = get_sub_field('desc_point');
        $title_no_club = get_sub_field('title_no_club');
    ?>
        <div class="<?php echo (!empty($img_under_txt) ? 'hero_type_2' : 'hero_type_2'); ?> hero_wrapper">
            <div class="hero_background">
                <?php if($img):?>
                    <div class="img_wrapper">
                        <img src="<?php echo $img; ?>" alt="<?php echo $title; ?>">
                    </div> 
                <?php endif;?>
            </div>
            <div class="hero_content" style="background-color:<?php echo $bg_color; ?>; color:<?php echo $text_color; ?>;">
                <div class="hero_background">
                    <?php if($img_under_txt):?>
                        <div class="img_wrapper">
                            <img src="<?php echo $img_under_txt; ?>" alt="<?php echo $title; ?>">
                        </div> 
                    <?php endif;?>
                </div>
                <div class="hero_titles">
                    <h1><?php 
                    $current_user = wp_get_current_user();
                    $first_name = $current_user->user_firstname;
                    echo 'היי '.$first_name.', '.$title;
                    ?>
                    </h1> 
                </div>
                <div class="hero_bottom">
                    <?php if( has_bought() ):?>
                        <div>
                            <h3><?php echo $title_point.': '?></h3>
                            <h3><?php echo $desc_point; ?></h3>
                        </div>
                    <?php else:?>
                        <h3><?php echo $title_no_club; ?></h3>
                    <?php endif;?>
                </div>
            </div>
        </div>
    <?php endwhile;endif?>
</section>