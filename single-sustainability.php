<?php

get_header();


// get the current taxonomy term

//$category = get_category( get_query_var( 'cat' ) );
//$cat_id = $category->cat_ID;
$sustainability_link = get_permalink( 932);
$categories = get_the_category();
$cat_name = $categories[0]->name;
$cat_slug = get_term_link($categories[0]->term_id);

?>
<div class="breadcrumb_sub_wrapper">
	<nav class="breadcrumb">
		<div class="arrow_btn">
			<a href="<?php  echo  $cat_slug; ?>" title="<?php echo $cat_name; ?>" class="button-secondary">
				<span class="btn_icon">
					<svg focusable="false" class="c-icon icon--arrow-button" viewBox="0 0 42 10" width="15px" height="15px">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M40.0829 5.5H0V4.5H40.0829L36.9364 1.35359L37.6436 0.646484L41.9971 5.00004L37.6436 9.35359L36.9364 8.64649L40.0829 5.5Z" fill="currentColor"></path>
					</svg>
				</span>
				<span class="button_label"> <?php echo $cat_name; ?></span>
			</a>
		</div>
	</nav>
</div>

<div class="container">
    <div class="section_modules_wrapper">
        <?php get_template_part('modules/section','case'); ?>

    </div>
</div>


<?php

get_footer();