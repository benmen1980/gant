<section class="banner_2 section_wrap section_banner_register">
    <?php
        $img_text_side = get_field('img_txt_position','option');
        $title = get_field('title','option');
        $sub_title = get_field('sub_title','option');
        $img = get_field('Image','option','option');
        $btn_type = get_field('btn_type','option');
        $text_color = get_field('text_color','option');
        $bg_color = !empty(get_field('bg_color_box','option'))? get_field('bg_color_box','option') :'transparent';
        

        $bg_color_register = !empty(get_field('bg_color_register','option'))? get_field('bg_color_register','option') :'transparent';
        $bg_color_login = !empty(get_field('bg_color_login','option'))? get_field('bg_color_login','option') :'transparent';

        $btn_text_color_register = get_field('btn_text_color_register','option');
        $btn_text_color_login = get_field('btn_text_color_login','option');
        
        $border_color_register = get_field('border_color_register','option');
        $border_color_login = get_field('border_color_login','option');
    
        ?>
        <div class="hero_type_2 hero_wrapper" style="<?php echo ($img_text_side == "txt_right_img_left") ? 'flex-direction:row-reverse':'flex-direction:row'?>">
            <div class="hero_background">
                <?php if($img):?>
                    <div class="img_wrapper">
                        <img src="<?php echo $img; ?>" alt="<?php echo $title;?>" />
                    </div> 
                <?php endif;?>
            </div>
            <div class="hero_content" style="background-color:<?php echo $bg_color; ?>; color:<?php echo $text_color; ?>;">
                <div class="hero_titles">
                   
                    <h2><?php echo $title;?></h2> 
                    <h3 class=""><span><?php echo $sub_title ?></span></h3>
                </div>
                <div class="hero_buttons <?php echo $btn_type; ?>">
                <?php 
                    $register_page = get_field('register_link','option');
                    $register_link_title = $register_page['title'];
                    $register_link_target = $register_page['target'] ? $register_page['target'] : '_self';
                    $register_link_url = $register_page['url'];

                    $login_page = get_field('login_link','option');
                    $login_link_title = $login_page['title'];
                    $login_link_target = $login_page['target'] ? $login_page['target'] : '_self';
                    $login_link_url = $login_page['url'];
                ?>
                    <div class="btns_register_wrapper">
                        <a target="<?php echo esc_attr( $register_link_target ); ?>" style="background-color:<?php echo $bg_color_register; ?>; color:<?php echo (empty($border_color_register)) ? $bg_color_register : $btn_text_color_register; ?>;" href="<?php echo $register_link_url; ?>" title="<?php echo $register_link_title; ?>" class="<?php echo (empty($border_color_register)) ? 'button-secondary' : 'button-primary';?>">
                            <span class="button_label" style="color:<?php echo $btn_text_color_register; ?>;"><?php echo $register_link_title; ?></span>
                            <?php if($btn_type == "arrow_btn"){?>
                                <span class="btn_icon" style="color:<?php echo $btn_text_color_register; ?>;">
                                    <svg focusable="false" class="c-icon icon--arrow-button" viewBox="0 0 42 10" width="15px" height="15px">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M40.0829 5.5H0V4.5H40.0829L36.9364 1.35359L37.6436 0.646484L41.9971 5.00004L37.6436 9.35359L36.9364 8.64649L40.0829 5.5Z" fill="currentColor"/>
                                    </svg>
                                </span>
                            <?php }
                            ?>
                        </a>

                        <a target="<?php echo esc_attr( $login_link_target ); ?>" style="background-color:<?php echo $bg_color_login; ?>; color:<?php echo (!empty($border_color_login)) ? $btn_text_color_login : $bg_color_login; ?>; " href="<?php echo $login_link_url; ?>" title="<?php echo $login_link_title; ?>" class="<?php echo (empty($border_color_login)) ? 'button-secondary' : 'button-primary';?>">
                            <span class="button_label" style="color:<?php echo $btn_text_color_login; ?>;"><?php echo $login_link_title; ?></span>
                            <?php if($btn_type == "arrow_btn"){?>
                                <span class="btn_icon" style="color:<?php echo $btn_text_color_login; ?>;">
                                    <svg focusable="false" class="c-icon icon--arrow-button" viewBox="0 0 42 10" width="15px" height="15px">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M40.0829 5.5H0V4.5H40.0829L36.9364 1.35359L37.6436 0.646484L41.9971 5.00004L37.6436 9.35359L36.9364 8.64649L40.0829 5.5Z" fill="currentColor"/>
                                    </svg>
                                </span>
                            <?php }
                            ?>
                        </a>
                    </div>

                </div>
            </div>
        </div>

</section>