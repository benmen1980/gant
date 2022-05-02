<div class="faq_section">
    <?php $faq = get_sub_field( 'select_dynamic' );
    if( $faq ): ?>
        <div class="faq_wrap">
            <div class="section_header">
                <h3 class="faq_title">
                    <?php echo get_field('title_faq', 'option') ?>
                </h3>
            </div>
            <div class="accordion">
                <?php 
                    if( have_rows('group_question', 'option') ) {
                        // while has rows
                        $parent_counter =0;while( have_rows('group_question', 'option') ) {
                            // instantiate row
                            the_row(); ?>
                            <?php if(get_sub_field('question_and_answer')): ?>
                                
                                <?php $counter = 1; while(the_repeater_field('question_and_answer','option')): 
                                    $group_values = get_sub_field('question_and_answer_group');
                                    $question = $group_values['question'];
                                    if(in_array($question, $faq )){
                                        $question = $group_values['question'];
                                        $answer = $group_values['response'];
                                        ?>
                                            <div class="section faq_item">
                                                <a class="section-title benefit_title" href="#accordion-<?php echo $parent_counter.'-'.$counter ?>" title="<?php echo $question; ?>"><?php echo $question; ?></a>
                                                <div id="accordion-<?php echo $parent_counter.'-'.$counter ?>" class="section-content">
                                                    <p class="benefit_desc"><?php echo $answer; ?></p>
                                                </div>
                                            </div>
                                    <?php  }          
                                $counter++;endwhile;?>
                            <?php  endif; ?>
                        <?php $parent_counter++;}
                    }
                    if( have_rows('group_question_club', 'option') ) {
                        // while has rows
                        $parent_counter = 0;while( have_rows('group_question_club', 'option') ) {
                            // instantiate row
                            the_row(); ?>
                            <?php if(get_sub_field('question_and_answer')): ?>
                                
                                <?php $counter = 1; while(the_repeater_field('question_and_answer','option')): 
                                    $group_values = get_sub_field('question_and_answer_group');
                                    $question = $group_values['question'];
                                    if(in_array($question, $faq )){
                                        $question = $group_values['question'];
                                        $answer = $group_values['response'];
                                        ?>
                                            <div class="section faq_item">
                                                <a class="section-title benefit_title" href="#accordion-club<?php echo $parent_counter.'-'.$counter ?>" title="<?php echo $question; ?>"><?php echo $question; ?></a>
                                                <div id="accordion-club<?php echo $parent_counter.'-'.$counter ?>" class="section-content">
                                                    <p class="benefit_desc"><?php echo $answer; ?></p>
                                                </div>
                                            </div>
                                    <?php  }          
                                $counter++;endwhile;?>
                            <?php  endif; ?>
                        <?php $parent_counter++;}
                    }
                    if( have_rows('group_question_info_client', 'option') ) {
                        // while has rows
                        $parent_counter = 0;while( have_rows('group_question_info_client', 'option') ) {
                            // instantiate row
                            the_row(); ?>
                            <?php if(get_sub_field('question_and_answer')): ?>
                                
                                <?php $counter = 1; while(the_repeater_field('question_and_answer','option')): 
                                    $group_values = get_sub_field('question_and_answer_group');
                                    $question = $group_values['question'];
                                    if(in_array($question, $faq )){
                                        $question = $group_values['question'];
                                        $answer = $group_values['response'];
                                        ?>
                                            <div class="section faq_item">
                                                <a class="section-title benefit_title" href="#accordion-club<?php echo $parent_counter.'-'.$counter ?>" title="<?php echo $question; ?>"><?php echo $question; ?></a>
                                                <div id="accordion-club<?php echo $parent_counter.'-'.$counter ?>" class="section-content">
                                                    <p class="benefit_desc"><?php echo $answer; ?></p>
                                                </div>
                                            </div>
                                    <?php  }          
                                $counter++;endwhile;?>
                            <?php  endif; ?>
                        <?php $parent_counter++;}
                    }
                    if( have_rows('group_question_membership_term', 'option') ) {
                        // while has rows
                        $parent_counter = 0;while( have_rows('group_question_membership_term', 'option') ) {
                            // instantiate row
                            the_row(); ?>
                            <?php if(get_sub_field('question_and_answer')): ?>
                                
                                <?php $counter = 1; while(the_repeater_field('question_and_answer','option')): 
                                    $group_values = get_sub_field('question_and_answer_group');
                                    $question = $group_values['question'];
                                    if(in_array($question, $faq )){
                                        $question = $group_values['question'];
                                        $answer = $group_values['response'];
                                        ?>
                                            <div class="section faq_item">
                                                <a class="section-title benefit_title" href="#accordion-club<?php echo $parent_counter.'-'.$counter ?>" title="<?php echo $question; ?>"><?php echo $question; ?></a>
                                                <div id="accordion-club<?php echo $parent_counter.'-'.$counter ?>" class="section-content">
                                                    <p class="benefit_desc"><?php echo $answer; ?></p>
                                                </div>
                                            </div>
                                    <?php  }          
                                $counter++;endwhile;?>
                            <?php  endif; ?>
                        <?php $parent_counter++;}
                    }
                    if( have_rows('group_question_purchase_term', 'option') ) {
                        // while has rows
                        $parent_counter = 0;while( have_rows('group_question_purchase_term', 'option') ) {
                            // instantiate row
                            the_row(); ?>
                            <?php if(get_sub_field('question_and_answer')): ?>
                                
                                <?php $counter = 1; while(the_repeater_field('question_and_answer','option')): 
                                    $group_values = get_sub_field('question_and_answer_group');
                                    $question = $group_values['question'];
                                    if(in_array($question, $faq )){
                                        $question = $group_values['question'];
                                        $answer = $group_values['response'];
                                        ?>
                                            <div class="section faq_item">
                                                <a class="section-title benefit_title" href="#accordion-club<?php echo $parent_counter.'-'.$counter ?>" title="<?php echo $question; ?>"><?php echo $question; ?></a>
                                                <div id="accordion-club<?php echo $parent_counter.'-'.$counter ?>" class="section-content">
                                                    <p class="benefit_desc"><?php echo $answer; ?></p>
                                                </div>
                                            </div>
                                    <?php  }          
                                $counter++;endwhile;?>
                            <?php  endif; ?>
                        <?php $parent_counter++;}
                    }
                    if( have_rows('group_question_privacy_policy', 'option') ) {
                        // while has rows
                        $parent_counter = 0;while( have_rows('group_question_privacy_policy', 'option') ) {
                            // instantiate row
                            the_row(); ?>
                            <?php if(get_sub_field('question_and_answer')): ?>
                                
                                <?php $counter = 1; while(the_repeater_field('question_and_answer','option')): 
                                    $group_values = get_sub_field('question_and_answer_group');
                                    $question = $group_values['question'];
                                    if(in_array($question, $faq )){
                                        $question = $group_values['question'];
                                        $answer = $group_values['response'];
                                        ?>
                                            <div class="section faq_item">
                                                <a class="section-title benefit_title" href="#accordion-club<?php echo $parent_counter.'-'.$counter ?>" title="<?php echo $question; ?>"><?php echo $question; ?></a>
                                                <div id="accordion-club<?php echo $parent_counter.'-'.$counter ?>" class="section-content">
                                                    <p class="benefit_desc"><?php echo $answer; ?></p>
                                                </div>
                                            </div>
                                    <?php  }          
                                $counter++;endwhile;?>
                            <?php  endif; ?>
                        <?php $parent_counter++;}
                    }
                    ?>
                    </div>
            </div>
    <?php endif; ?>
</div>