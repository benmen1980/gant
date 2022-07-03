<?php
/*
Template Name: Overview Page

*/


get_header();



if ( !is_user_logged_in() ){
    wp_redirect ( home_url("/my-account") );
    exit;
}

?>

<div class="overview_page">
    <div class="section_modules_wrapper">
        <?php get_template_part('modules/section','case'); ?>
    </div>
    <?php if(false): ?>
    <div class="benefits_section">
        <?php $benefits = get_field('benefits','option');
        if( $benefits ): ?>
            <div class="slider_benefits slider_wrap">
                <?php while(the_repeater_field('benefits','option')): 
                    $group_values = get_sub_field('group_benef');
                    $title = $group_values['title'];
                    $description = $group_values['description'];
                    $club_type = $group_values['club_type'];
                    ?>
                        
                    <div class="benefit_item slide-content">
                        <?php if(!empty($club_type)):?>
                            <label class="club_type"><?php echo $club_type; ?></label>
                        <?php endif;?>
                        <h3 class="benefit_title"><?php echo $title; ?></h3>
                        <p class="benefit_desc"><?php echo $description; ?></p>
                    </div> 
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>