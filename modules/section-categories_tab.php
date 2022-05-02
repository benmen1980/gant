<section class="section_wrap section_tabs_cat">
    <?php if(get_sub_field('select_categories_tabs')):while(the_repeater_field('select_categories_tabs')): 
        $cat_name = get_sub_field('title');
        $btn_type = get_sub_field('select_design_link');
        $categories = get_sub_field('select_cat');

        //print_r($categories);

    ?>
    <div class="tabs_cat_wrap">
        <?php if(!empty($cat_name)): ?>
            <div class="section_header">
                <h3><?php echo $cat_name; ?></h3>
            </div>
        <?php endif;?>
        <div class="tabs_wrapper <?php echo $btn_type; ?>">
            <div class="btn_holder">
                <?php foreach($categories as $key => $cat){
                    $cat_name = $cat->name; 
                    $cat_slug = get_term_link($cat->term_id);
                ?>   
                    <a href="<?php echo $cat_slug; ?>" class="rounded_btn" title="<?php echo $cat_name;?>">
                        <?php echo $cat_name;?>
                        <?php if(($btn_type == 'simple') && ($key !== array_key_last($categories)) ): 
                            echo ',';
                        endif;?>
                    </a>
                <?php }?>
            </div>
        </div>
        
    </div>
    <?php endwhile;endif?>
</section>