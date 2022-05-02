<section class="module_30_70 section_wrap">
    <?php if(get_sub_field('module_30_70')): 
        $banner_top = get_sub_field('module_30_70');
        $banner_type = $banner_top['select_filter_type'];
        $one_img = $banner_top['one_img'];
        $two_img = $banner_top['two_img'];
        $bg_color = $banner_top['bg_color'];
        $text_color = $banner_top['bg_text'];
        $desc = $banner_top['description'];
        $title = $banner_top['title'];


        if($banner_type == 'no-img'){
            $width = 'full_width';
        }
        elseif($banner_type == 'one-img'){
            $width = 'two_third_width';
        }
        else{
            $width = 'third_width';
        }
    endif;?>
    <div class="top_header <?php echo $width ?>" style="background-color:<?php echo $bg_color; ?>; color:<?php echo $text_color; ?>;">
        <div class="r_side titles">
            <h1><?php echo  $title;  ?></h1>
            <p><?php echo $desc; ?></p>
        </div>
        <?php if($banner_type == 'one-img' || $banner_type == 'two-img'): ?>
            <div class="l_side">
                <div class="img_wrapper">
                    <img src="<?php echo $one_img; ?>" alt=""/>
                </div>
            </div>

        <?php endif; ?>
        <?php if($banner_type == 'two-img'): ?>
            <div class="l_side">
                <div class="img_wrapper">
                    <img src="<?php echo $two_img; ?>" alt=""/>
                </div>
            </div>
        <?php endif; ?>
    </div>

</section>