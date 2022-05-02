<?php
/*
Template Name: Contact Page

*/

get_header();
?>
<div class="contact_page">
    <div class="container_w_gutter">
        <div class="top_txt_contact">
            <h1><?php echo get_field('title'); ?></h1>
            <div class="top_txt_desc">
                <?php echo get_field('description') ?>
            </div>
        </div>
        <div class="contact_form_wrapper">
            <?php echo do_shortcode('[contact-form-7 id="845" title="טופס יצירת קשר"]'); ?>
        </div>
    </div>

</div>

<?php get_footer(); ?>
