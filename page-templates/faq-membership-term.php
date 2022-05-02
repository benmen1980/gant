<?php
/*
Template Name: FAQ Membership Term Page

*/

get_header();
?>
<div class="faq_page">
    <div class="accordion">
        <?php 
            if( have_rows('group_question_membership_term', 'option') ) {
                // while has rows
                $parent_counter =0;while( have_rows('group_question_membership_term', 'option') ) {
                    // instantiate row
                    the_row(); ?>
                      <div class="section_header">
                        <h3 class="faq_title">
                            <?php echo get_sub_field('title', 'option') ?>
                        </h3>
                    </div>
                    <?php if(get_sub_field('question_and_answer', 'option')): ?>
                        
                        <?php $counter = 1; while(the_repeater_field('question_and_answer','option')): 
                            $group_values = get_sub_field('question_and_answer_group');
                            $question = $group_values['question'];
                            $answer = $group_values['response'];
                            ?>
                                <div class="section faq_item">
                                    <a class="section-title benefit_title" href="#accordion-<?php echo $parent_counter.'-'.$counter ?>" title="<?php echo $question; ?>"><?php echo $question; ?></a>
                                    <div id="accordion-<?php echo $parent_counter.'-'.$counter ?>" class="section-content">
                                        <p class="benefit_desc"><?php echo $answer; ?></p>
                                    </div>
                                </div>
                                      
                        <?php $counter++;endwhile;?>
                    <?php  endif; ?>
                <?php $parent_counter++;}
            }
            ?>
            </div>
    </div>
</div>

<?php get_footer(); ?>
