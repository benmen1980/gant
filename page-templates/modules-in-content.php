<?php
/*
Template Name: Modules in Content
Template Post Type: post, page

*/

get_header();
//get_template_part( 'template-parts/content', 'page' );
?>

<div class="container">
    <div class="section_modules_wrapper">
        <?php get_template_part('modules/section','case'); ?>
    </div>
</div>

<?php
get_footer();