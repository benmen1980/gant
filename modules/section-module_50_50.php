<section class="module_50_50 section_wrap">
    <?php if(get_sub_field('module_50_50')):while(the_repeater_field('module_50_50')):  
        $img_text_side = get_sub_field('img_txt_position');
        //$title = get_sub_field('title');
        $group_values_title = get_sub_field('typography_title');
        $title = $group_values_title['title'];
        $title_font_family = $group_values_title['select_txt_font'];

        //sub-title
        $group_values_subtitle = get_sub_field('typography_subtitle');
        $sub_title = $group_values_subtitle['title'];
        $subtitle_font_family = $group_values_subtitle['select_txt_font'];
        
        $size_title = get_sub_field('choose_title_size');
        $img = get_sub_field('image');
        $vid_file = get_sub_field('video');
        $vid_url = get_sub_field('video_iframe');
        $btn_type = get_sub_field('btn_type');
        $url_img = get_sub_field('url_img');
        $bg_color = !empty(get_sub_field('bg_color'))? get_sub_field('bg_color') :'transparent';
        $bg_color_txt = !empty(get_sub_field('bg_color_txt'))? get_sub_field('bg_color_txt') :'transparent';
        $text_color = get_sub_field('text_color');
        $text_color_btn = get_sub_field('txt_color_btn');
        $btn_font_family = get_sub_field('select_btn_font');

        $separator_line = get_sub_field('sepearator_line');
        $description = get_sub_field('description');
        $sustainability_flag = get_sub_field('sustainability_flag');
        
        if(get_sub_field('border_color') && $btn_type == "basic_btn"){
            $border_color = get_sub_field('border_color');
        }
        else{
            $border_color = '';
        }
        ?>
        <div class="module_50_50_content hero_type_2" style="<?php echo ($img_text_side == "txt_right_img_left") ? 'flex-direction:row-reverse':'flex-direction:row'?>">
            <div class="hero_background">
                <?php if($sustainability_flag == 1): ?>
                <div class="flag_sustainability">
                    <img src="<?php echo get_template_directory_uri();?>/dist/images/sustainability_flag.png" aria-hidden="false" alt="<?php echo __('דגל קיימות','gant')?>">
                </div>
                <?php endif;?>
                <?php if($url_img): ?>
                    <a href="<?php echo $url_img; ?>" title="<?php echo $url_img; ?>">
                <?php endif;?>
                <?php if($vid_file):?>
                    <video muted autoplay loop class="" width="100%" height="auto" poster="<?php !empty(the_sub_field('image')) ? the_sub_field('image') : '' ;?>" > 
                        <source src="<?php echo $vid_file; ?>" type="video/mp4"/>         
                    </video>
                <?php elseif($vid_url):?>
                    <iframe width="100%" height="auto" src="//www.youtube.com/embed/<?php echo $vid_url;?>?autoplay=1&loop=1&controls=0"> </iframe>
                <?php else: ?>
                    <div class="img_wrapper">
                        <img src="<?php echo $img; ?>" alt="<?php echo $title; ?>">
                    </div> 
                <?php endif;?>
                <?php if($url_img): ?>
                    </a>
                <?php endif;?>
            </div>
            <div class="hero_content" style="direction:<?php echo (($title_font_family != 'almoni') ? 'ltr' : 'rtl');?>;background-color:<?php echo $bg_color_txt; ?>; color:<?php echo $text_color; ?>;">
                <div class="hero_titles">
                    <h2 class="<?php echo $subtitle_font_family; ?>"><span><?php echo $sub_title ?></span></h2>
                    <h3 class="<?php echo ($size_title == "normal_size") ? $title_font_family.' '.'normal_size': $title_font_family;?>"><?php echo $title;?></h3> 
                </div>
                <div class="bottom_wrapper">
                <?php if(!empty($description)):?>
                    <div class="description_wrapper">
                        <?php if(!empty($separator_line)):?>
                            <div class="separator_line" style="background-color:<?php echo $text_color; ?>;"></div>
                        <?php endif;?>
                        <p><?php echo $description;?></p>
                    </div>
                <?php endif;?>
                <div class="hero_buttons <?php echo $btn_type; ?>">
                    <?php if(get_sub_field('choose_links')):while(the_repeater_field('choose_links')):
                        $page = get_sub_field('link');
                        $link_title = $page['title'];
                        $link_target = $page['target'] ? $page['target'] : '_self';
                        $link_url = $page['url'];
                    ?>
                    <a target="<?php echo esc_attr( $link_target ); ?>" style="background-color:<?php echo $bg_color; ?>; color:<?php echo (empty($border_color)) ? $bg_color : $text_color_btn; ?>;" href="<?php echo $link_url; ?>" title="<?php echo $link_title; ?>" class="<?php echo (empty($border_color)) ? 'button-secondary' : 'button-primary';?>">
                    <span class="button_label <?php echo  $btn_font_family;?>"  style="color:<?php echo $text_color_btn; ?>;"><?php echo $link_title; ?></span>
                    <?php if($btn_type == "arrow_btn"){?>
                      
                        <span class="btn_icon" style=" color:<?php echo $text_color_btn; ?>;">
                            <svg style="transform:<?php echo (($title_font_family != 'almoni') ? 'none' : 'rotate(180deg)');?>;" focusable="false" class="c-icon icon--arrow-button" viewBox="0 0 42 10" width="15px" height="15px">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M40.0829 5.5H0V4.5H40.0829L36.9364 1.35359L37.6436 0.646484L41.9971 5.00004L37.6436 9.35359L36.9364 8.64649L40.0829 5.5Z" fill="currentColor"/>
                            </svg>
        
                        </span>
                       
                    <?php }
                     ?>
                    </a>

                <?php endwhile;endif?>
                </div>
                </div>
            </div>
        </div>
    <?php endwhile;endif?>
</section>