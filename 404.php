<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package gant
 */

get_header();
?>
<div class="container">
    <div class="section_modules_wrapper">
		<section class="section_wrap banner_1">
			<?php 
			$error_title = get_field('error_title','option');
			$title = get_field('404_title','option');
			$sub_title = get_field('sub_title_404','option');
			$img = get_field('bg_img_404','option');
			
			?>
			<div class="hero_type_1">
				<div class="hero_background">
					<div class="img_wrapper"  style="background-image:url('<?php echo $img; ?>')">
						<img src="<?php echo $img; ?>" alt="<?php echo $title; ?>">
					</div> 
				</div>
				<div class="hero_content">
					<div class="hero_titles title_center">
						<h4><?php echo $error_title;?></h4>
						<h1><?php echo $title;?></h1>
						<h2 class=""><span><?php echo $sub_title ?></span></h2>
						<div class="hero_buttons">
						<?php if(get_field('choose_link_404','option')):while(the_repeater_field('choose_link_404','option')):
							$page = get_sub_field('choose_page');
							$link_title = $page['title'];
							$link_target = $page['target'] ? $page['target'] : '_self';
							$link_url = $page['url'];
						?>
							<a  target="<?php echo esc_attr( $link_target ); ?>" style="background-color:<?php echo $bg_color; ?>; color:<?php echo $bg_color; ?>; <?php echo (!empty($border_color)) ? 'border: 1px solid '.$border_color : ''?>" href="<?php echo $link_url; ?>" title="<?php echo $link_title; ?>" class="button-secondary">
								<!-- <div class="button_animation" aria-hidden="true" style="background-color:<?//php echo $bg_color; ?>; color:<?//php echo $text_color; ?>;" href="<?php echo get_permalink($page->ID); ?>" title="<?php echo $page->post_title; ?>" class="button-secondary"></div> -->
								<span class="button_label" style="color:<?php echo $text_color; ?>;"><?php echo $link_title; ?></span>
							</a>

						<?php endwhile;endif?>

					</div>
					</div>
		
				</div>
			</div>
	
		</section>
    </div>
</div>
	<?php if(false): ?>
	<main id="primary" class="site-main">

		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'gant' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">
				<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'gant' ); ?></p>

					<?php
					get_search_form();

					the_widget( 'WP_Widget_Recent_Posts' );
					?>

					<div class="widget widget_categories">
						<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'gant' ); ?></h2>
						<ul>
							<?php
							wp_list_categories(
								array(
									'orderby'    => 'count',
									'order'      => 'DESC',
									'show_count' => 1,
									'title_li'   => '',
									'number'     => 10,
								)
							);
							?>
						</ul>
					</div><!-- .widget -->

					<?php
					/* translators: %1$s: smiley */
					$gant_archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'gant' ), convert_smilies( ':)' ) ) . '</p>';
					the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$gant_archive_content" );

					the_widget( 'WP_Widget_Tag_Cloud' );
					?>

			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->
	<?php endif; ?>

<?php
get_footer();
