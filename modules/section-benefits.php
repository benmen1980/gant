<div class="benefits_section">
    <?php $benefits = get_sub_field( 'select_dynamic_benefits' );
    if( $benefits ): ?>
        <div class="slider_benefits slider_wrap">
            <?php while(the_repeater_field('benefits','option')): 
                    $group_values = get_sub_field('group_benef');
                    $title = $group_values['title'];
                    if(in_array($title, $benefits )){
                        $title = $group_values['title'];
                        $description = $group_values['description'];
                        $club_type = $group_values['club_type']; ?>
                            <div class="benefit_item slide-content">
                            <?php if(!empty($club_type)):?>
                                <label class="club_type"><?php echo $club_type; ?></label>
                            <?php endif;?>
                            <h3 class="benefit_title"><?php echo $title; ?></h3>
                            <p class="benefit_desc"><?php echo $description; ?></p>
                        </div>
                    <?php }          
            endwhile; ?>
        </div>
    <?php endif; ?>
</div>