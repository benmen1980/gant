<section class="section_wrap section_cat_and_link">
    <?php if(get_sub_field('select_category_link')):while(the_repeater_field('select_category_link')): 
        $cat_name = get_sub_field('category_name');
        if(get_sub_field('link')):
            $page = get_sub_field('link');
            $link_title = $page['title'];
            $link_target = $page['target'] ? $page['target'] : '_self';
            $link_url = $page['url'];
        endif;
    ?>
    <div class="cat_and_link_wrap">
        <h3><?php echo $cat_name; ?></h3>
        <?php if(get_sub_field('link')):?>
            <div class="arrow_btn">
                <a target="<?php echo esc_attr( $link_target ); ?>" href="<?php echo $link_url; ?>" title="<?php echo $link_title; ?>" class="button-secondary">
                    <span class="button_label"><?php echo $link_title; ?></span>
                    
                        <span class="btn_icon">
                            <svg focusable="false" class="c-icon icon--arrow-button" viewBox="0 0 42 10" width="15px" height="15px">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M40.0829 5.5H0V4.5H40.0829L36.9364 1.35359L37.6436 0.646484L41.9971 5.00004L37.6436 9.35359L36.9364 8.64649L40.0829 5.5Z" fill="currentColor"/>
                            </svg>
                        </span>
                    
                </a>
            </div>
        <?php endif; ?>
    </div>
    <?php endwhile;endif?>
</section>