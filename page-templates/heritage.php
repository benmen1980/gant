<?php
/*
Template Name: Heritage Page

*/

get_header();
?>

<div class="heritage_page">
    <?php 
    $banner = get_field('top_banner');
    $banner_title = $banner['title'];
    $banner_sub_title = $banner['sub_title'];
    $banner_desc = $banner['desc'];
    $banner_img = $banner['bg_img'];
    ?>
    <div class="hero_type_1">
        <div class="hero_background">
            <?php if($banner_img):?>
                <div class="img_wrapper" style="background-image:url('<?php echo $banner_img; ?>')">
                    <img src="<?php echo $img; ?>" alt="<?php echo $title; ?>">
                </div> 
            <?php endif;?>
        </div>
        <div class="hero_content">
            <div class="hero_titles title_center sub_title_center_under_title">
                <h2 class="center_under_title"><span><?php echo $banner_sub_title ?></span></h2>
                <h1><?php echo $banner_title;?></h1>
                <p  class="hero_desc"><?php echo $banner_desc ?></p>
            </div> 
        </div>
    </div>
    <div class="heritage_section_wrapper">
        <?php 
        if( have_rows('section_content') ):
            while( have_rows('section_content') ) : the_row();

                $date = get_sub_field('date_title');
                $title = get_sub_field('title');
                $description = get_sub_field('description');
                $image = get_sub_field('image');?>
                <div class="row_wrapper">
                    <div class="r_side">
                        <div class="top_txt">
                            <h4><?php echo $date; ?></h4>
                            <h3><?php echo $title; ?></h3>
                        </div>
                        <div class="bottom_txt">
                        <p><?php echo $description; ?></p>
                        </div>
                        
                    </div>
                    <div class="l_side">
                        <img src="<?php echo $image ?>" alt="">
                    </div>
                </div>
            <?php endwhile;
        endif; 
?>
    </div>
</div>

<?php get_footer(); ?>