<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package gant
 */

?>
<?php 
// if ( is_edit_account_page() &&  !is_user_logged_in()) {  
// 	echo 'enter gere';
// 	wp_redirect ( home_url("/my-account") );
// 	exit;
// } 
if ( is_edit_account_page() ) {  ?>
<div class="banner_account_page">
	<h1><?php echo get_field('title_detail_account','option') ?></h1>
	<p><?php echo get_field('desc_detail_account','option') ?></p>
</div>
<?php } ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if(!is_cart()): ?>
		<header class="entry-header">
			<?php if ( !is_account_page() ) {  ?>
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			<?php }
			else{?>
				<?php the_title( '<h3 class="entry-title">', '</h3>' ); ?>
			<?php } ?>
		</header><!-- .entry-header -->
		<?php gant_post_thumbnail(); ?>
	<?php endif; ?>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'gant' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'gant' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
