<section class="section_wrap banner_1">
    <?php if(get_sub_field('banner_hp')):while(the_repeater_field('banner_hp')):  
        $title = get_sub_field('title');
        $title_pos = get_sub_field('title_position');
        $sub_title = get_sub_field('sub_title');
        if( $sub_title){
            if(get_sub_field('sub_title_position_top') && $title_pos == "top"){
                $sub_title_pos = get_sub_field('sub_title_position_top');
            }
            elseif(get_sub_field('sub_title_position_bottom') && $title_pos == "bottom"){
                $sub_title_pos = get_sub_field('sub_title_position_bottom');
            }
            elseif(get_sub_field('sub_title_position_center') && $title_pos == "center"){
                $sub_title_pos = get_sub_field('sub_title_position_center');
            }
        }
        $sub_title_pos = str_replace(' ','_',$sub_title_pos);
        $img = get_sub_field('Image');
        $vid_file = get_sub_field('video');
        $vid_url = get_sub_field('video_iframe');
        if(get_sub_field('bg_color')){
            $bg_color = get_sub_field('bg_color');
        }
        else{
            $bg_color = 'transparent';
        }
        if(get_sub_field('text_color')){
            $text_color = get_sub_field('text_color');
        }
        else{
            $bg_color = 'transparent';
        }
        if(get_sub_field('border_color')){
            $border_color = get_sub_field('border_color');
        }
       
        $banner_height = get_sub_field('banner_height');
            
        
        ?>
        <div class="hero_type_1  <?php echo ($banner_height == 1) ? 'half_height': ''; ?>">
            <div class="hero_background">
                <?php if($vid_file):?>
                    <video autoplay loop poster="<?php !empty(the_sub_field('image')) ? the_sub_field('image') : '' ;?>" > 
                        <source src="<?php echo $vid_file; ?>" type="video/mp4"/>         
                    </video>
                <?php elseif($vid_url):?>
                    <iframe width="100%" height="auto" src="//www.youtube.com/embed/<?php echo $vid_url;?>?autoplay=1&loop=1&controls=0"> </iframe>
                <?php else: ?>
                    <div class="img_wrapper"  style="background-image:url('<?php echo $img; ?>')">
                        <img src="<?php echo $img; ?>" alt="<?php echo $title; ?>">
                    </div> 
                <?php endif;?>

                <?php ?>
            </div>
            <div class="hero_content" style="background-color:<?php echo $bg_color; ?>; color:<?php echo $text_color; ?>;">
                <div class="hero_titles <?php echo 'title_'.$title_pos.' sub_title_'.$sub_title_pos; ?>">
                    <h1><?php echo $title;?></h1>
                    <h2 class="<?php echo $sub_title_pos; ?>"><span><?php echo $sub_title ?></span></h2>
                </div>
                <div class="hero_buttons">
                <?php if(get_sub_field('choose_link')):while(the_repeater_field('choose_link')):
                    $page = get_sub_field('choose_page');
                    $link_title = $page['title'];
                    $link_target = $page['target'] ? $page['target'] : '_self';
                    $link_url = $page['url'];
                ?>
                    <a  target="<?php echo esc_attr( $link_target ); ?>" style="background-color:<?php echo $bg_color; ?>; color:<?php echo $bg_color; ?>; <?php echo (!empty($border_color)) ? 'border: 1px solid '.$border_color : ''?>" href="<?php echo $link_url; ?>" title="<?php echo $link_title; ?>" class="button-secondary">
                        <!-- <div class="button_animation" aria-hidden="true" style="background-color:<?//php echo $bg_color; ?>; color:<?//php echo $text_color; ?>;" href="<?php echo get_permalink($page->ID); ?>" title="<?php echo $page->post_title; ?>" class="button-secondary"></div> -->
                        <span class="button_label" style="color:<?php echo $text_color; ?>;"><?php echo $link_title; ?></span>
                    </a>

                <?php endwhile;endif?>

                </div>
            </div>
        </div>
    <?php endwhile;endif?>
</section>