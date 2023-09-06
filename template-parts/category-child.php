<?php 
get_header();

$categories = get_the_category();
$category_id = $categories[0]->cat_ID;
echo $category_id;
?>

<nav class="breadcrumb">
    <div class="arrow_btn">
        <a href="" class="button-secondary">
            <span class="button_label"></span>
            <span class="btn_icon">
                <svg focusable="false" class="c-icon icon--arrow-button" viewBox="0 0 42 10" width="15px" height="15px">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M40.0829 5.5H0V4.5H40.0829L36.9364 1.35359L37.6436 0.646484L41.9971 5.00004L37.6436 9.35359L36.9364 8.64649L40.0829 5.5Z" fill="currentColor"></path>
                </svg>
            </span>
        </a>
    </div>
    
</div>


<?php
//get_sidebar();
get_footer();