<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package gant
 */

get_header();



// in your taxonomy/term template file
$current_term = get_queried_object();
$term = get_queried_object();
//print_r($term);
$child_template = get_field('display_cat_child_template', $term->taxonomy . '_' . $term->term_id);
// parent property is either 0 or the parent ID
if(is_product_category()){
  if ( $current_term->parent || $child_template == 1 ) {
    get_template_part( 'template-parts/content', 'child' );
    exit;
  } else {
    get_template_part('modules/section','case');
    get_footer();
    exit;
  }
}






while ( have_posts() ) :
  the_post();

  get_template_part( 'template-parts/content', 'page' );

  // If comments are open or we have at least one comment, load up the comment template.
  if ( comments_open() || get_comments_number() ) :
    comments_template();
  endif;

endwhile; // End of the loop.

?>



<?php
//get_sidebar();
get_footer();
