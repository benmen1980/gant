<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package gant
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'תוצאות חיפוש עבור: "%s"', 'gant' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</header><!-- .page-header -->
			<div class="search_suggestions_products_wrapper">
				<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					/**
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
					//get_template_part( 'template-parts/content', 'search' );
					get_template_part('page-templates/box-product'); 

				endwhile;?>
			</div>
			<nav class="navigation paging-navigation" role="navigation">
				<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'aj' ); ?></h1>
				<div class="nav-links">
					<?php if ( get_next_posts_link() ) : ?>
						<div class="nav-previous ">
							<?php next_posts_link(  '<span class="button_label">'.__( 'הבא', 'gant' ).'</span>' ); ?>
						</div>
					<?php endif; ?>

					<?php if ( get_previous_posts_link() ) : ?>
						<div class="nav-next"><?php previous_posts_link( '<span class="button_label">'.__( 'הקודם', 'gant' ).'</span>' ); ?></div>
					<?php endif; ?>
				</div><!-- .nav-links -->
			</nav>

			<?php //the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
		

	</main><!-- #main -->

<?php
//get_sidebar();
get_footer();
