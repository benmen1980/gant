<?php
if(is_category()){
    $category = get_category( get_query_var( 'cat' ) );
    $cat_id = $category->cat_ID;
    $choose_module = get_field('choose_module' ,'category_'. $cat_id .'');
    $post_id = 'category_'. $cat_id;
}
else{
    $choose_module = get_field('choose_module');
    $post_id = $post_id;
} 

if($choose_module): 
    while(the_repeater_field('choose_module',  $post_id)): 
        $mod = get_sub_field('module_list');
        $mod= explode(':', $mod);
        switch ($mod[0]) {
            case 'banner_1':
                get_template_part('modules/section','banner_1');
                break;
            case 'design_banner':
                get_template_part('modules/section','design_banner');
                break;
            case 'banner_2':
                get_template_part('modules/section','banner_2');
                break;
            case 'banner_reg_club':
                get_template_part('modules/section','banner_register_club');
                break;
            case 'banner_after_reg_club':
                get_template_part('modules/section','banner_after_register_club');
                break;
            case 'navigation_module_1':
                get_template_part('modules/section','navigation_module1');
                break;
            case 'navigation_module_2':
                get_template_part('modules/section','navigation_module2');
                break;
            case 'navigation_module_3':
                get_template_part('modules/section','navigation_module3');
                break;
            case 'module_50_50':
                get_template_part('modules/section','module_50_50');
                break;
            case 'module_30_70':
                get_template_part('modules/section','module_30_70');
                break;
            case 'slider_pdts':
                get_template_part('modules/section','slider_pdts');
                break;
            case 'category_link':
                get_template_part('modules/section','category_link');
                break;
            case 'categories_tab':
                get_template_part('modules/section','categories_tab');
                break;
            case 'benefits':
                get_template_part('modules/section','benefits');
                break;
            case 'title_benefit':
                get_template_part('modules/section','title_benefit');
                break;
            case 'faq':
                get_template_part('modules/section','faq');
                break;
            case 'text_editor':
                get_template_part('modules/section','text_editor');
                break;
            case 'sales_banner':
                get_template_part('modules/section','sales_banner');
                break;
        }
    endwhile;
endif;