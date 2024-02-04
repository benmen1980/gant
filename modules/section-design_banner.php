<section class="section_wrap banner_1">
    <?php if(get_sub_field('banner_design_hp')) : while(the_repeater_field('banner_design_hp')):  
        $img = get_sub_field('Image');
        $mobile_image = get_sub_field('mobile_image'); 
        $page = get_sub_field('choose_page');
        $link_title = $page['title'];
        $link_target = $page['target'] ? $page['target'] : '_self';
        $link_url = $page['url'];
    ?>
        <div class="hero_type_1  banner_with_txt">
            <a class="<?php echo empty($link_url) ? 'no_link' : '';?>" target="<?php echo esc_attr( $link_target ); ?>" href="<?php echo (!empty($link_url) ? $link_url : '#'); ?>" title="<?php echo $link_title; ?>">
                <div class="hero_background">
                    <?php if(!wp_is_mobile()): ?>
                        <div class="img_wrapper"  style="background-image:url('<?php echo $img; ?>')">
                            <img src="<?php echo $img; ?>" alt="<?php echo $title; ?>">
                        </div> 
                    <?php else: ?>
                        <div class="img_wrapper"  style="background-image:url('<?php echo ($mobile_image) ? $mobile_image : $img; ?>')">
                            <img src="<?php echo $mobile_image; ?>" alt="<?php echo $title; ?>">
                        </div>
                    <?php endif;?>
                </div>
            </a>
        </div>
    <?php endwhile; endif; ?>
</section>