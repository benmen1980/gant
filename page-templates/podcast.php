<?php
/*
Template Name: Podcast Page

*/

get_header();

$banner = get_field('main_banner');
$title = get_field('title');
$sub_title = get_field('sub_title');

$apple_img = get_field('apple_img');
$apple_link = get_field('aplle_link');

$play_img = get_field('google_play_img');
$play_link = get_field('google_play_link');

$spotify_img = get_field('spotify_img');
$spotify_link = get_field('spotify_link');

$deezer_img = get_field('deezer_img');
$deezer_link = get_field('deezer_link');

$yt_img = get_field('youtube_img');
$yt_link = get_field('yt_link');

?>

<div class="podcast_page">
    <?php if($banner):?>
        <div class="hero_type_1">
            <div class="hero_background">
                <div class="img_wrapper" style="background-image:url('<?php echo $banner; ?>')">
                    <img src="<?php echo $banner; ?>" alt="">
                </div> 
            </div>
        </div>
    <?php endif;?>
    <?php if($title): ?>
        <h1 class="main_title"><?php echo $title; ?></h1>
    <?php endif;?>   
    <?php if($sub_title): ?>
        <h2 class="sub_title"><?php echo $sub_title; ?></h2>
    <?php endif;?>    
    <div class="applications_wrapper">
        <a class="app_item" href="<?php echo $apple_link ?>" title="<?php echo $apple_link ?>">
            <img src="<?php echo $apple_img ; ?>" alt=""/>
        </a>
        <a class="app_item" href="<?php echo $play_link ?>" title="<?php echo $play_link ?>">
            <img src="<?php echo $play_img ; ?>" alt=""/>
        </a>
        <a class="app_item" href="<?php echo $spotify_link ?>" title="<?php echo $spotify_link ?>">
            <img src="<?php echo $spotify_img ; ?>" alt=""/>
        </a>
        <a class="app_item" href="<?php echo $deezer_link ?>" title="<?php echo $deezer_link ?>">
            <img src="<?php echo $deezer_img ; ?>" alt=""/>
        </a>
        <a class="app_item" href="<?php echo $yt_link ?>" title="<?php echo $yt_link ?>">
            <img src="<?php echo $yt_img ; ?>" alt=""/>
        </a>
    </div>
    <div class="podcast_wrapper">
        <?php 
        if( have_rows('podcast_items') ):
            while( have_rows('podcast_items') ) : the_row(); 
                $title = get_sub_field('title');
                $description = get_sub_field('description');
                $image = get_sub_field('img');
                $link = get_sub_field('link'); ?>

                <a href="<?php echo $link ?>" target="_blank" title="<?php echo $link ?>" class="podcast_item">
                    <div class="r_side">
                        <img src="<?php echo $image; ?>" alt="">
                    </div>
                    <div class="l_side">
                        <h4><?php echo $title; ?></h4>
                        <p><?php echo $description; ?></p>
                    </div>
                </a>
            <?php endwhile;
        endif; ?>
    </div>
    <div class="bottom_banner">
        <img src="<?php echo get_field('banner_bottom') ?>" alt="">
    </div>
</div>