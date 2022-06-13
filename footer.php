<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package gant
 */

?>
	<?php if ( !is_user_logged_in() && !is_account_page() && !is_page_template('page-templates/register.php') ) : 
		get_template_part('modules/section','banner_register');
	endif; ?>
	<footer id="colophon" class="site-footer">
		<div class="footer_content">
			<?php 
				for ($i = 1; $i < 6; $i++) {
					if (has_nav_menu('footer_navigation' . $i)) {
						//echo wp_get_nav_menu_name('footer_navigation' . $i);
						wp_nav_menu(
						array(
							'theme_location' => 'footer_navigation' . $i,
							'menu_class' => 'footer-menu',
							'menu_id' => 'f_menu_' . $i
						));
					}
				}
			?>
			<div class="customer_service_footer_menu">
				<ul class="footer-menu"> 
					<li class="menu-item menu-item-has-children">
						<a href="#">
							<?php echo get_field('menu_title','option'); ?>
						</a>
						<ul class="sub-menu">
							<li>	
								<?php echo get_field('menu_desc','option'); ?>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
		<div class="footer_content_bottom">
			<div class="r_side">
				<button class="open_language_modal">
					<div class="current_lang_wrapper">
						<img src="<?php echo get_template_directory_uri();?>/dist/images/Isreal.svg" alt="">
						<?php esc_html_e( 'ישראל', 'gant' ); ?>
					</div>
				</button>
				<a class="find_store_wrap" href="/store" title="<?php esc_html_e( 'מצא חנויות', 'gant' ); ?>">
					<img src="<?php echo get_template_directory_uri();?>/dist/images/map.svg" alt="">
					<?php esc_html_e( 'מצא חנויות', 'gant' ); ?>
				</a>
			</div>
			<div class="center_logo">
				<a href="/" title="גאנט ישראל">
					<img src="<?php echo get_template_directory_uri();?>/dist/images/GANT-Logo.svg" aria-hidden="false" alt="">
				</a>
			</div>
			<div class="l_side">
				<div class="social_link_wrap">
					<a href="<?php echo get_field('instagram_link','option'); ?>" target="_blank" ari-label="<?php esc_html_e( 'איסטגרם', 'gant' ); ?>">
						<img src="<?php echo get_template_directory_uri();?>/dist/images/instagram.svg" aria-hidden="false" alt="">
					</a>
					<a href="<?php echo get_field('youtube_link','option'); ?>" target="_blank" ari-label="<?php esc_html_e( 'יוטיוב', 'gant' ); ?>">
						<img src="<?php echo get_template_directory_uri();?>/dist/images/youtube.svg" aria-hidden="false" alt="">
					</a>
					<a href="<?php echo get_field('facebook_link','option'); ?>" target="_blank" ari-label="<?php esc_html_e( 'פייסבוק', 'gant' ); ?>">
						<img src="<?php echo get_template_directory_uri();?>/dist/images/facebook.svg" aria-hidden="false" alt="">
					</a>
				</div>
				<div class="copyright_wrap">
					<p>© 2022 GANT</p>
				</div>
			</div>
		</div>
		<div class="footer_legal_links">
			<?php 
			wp_nav_menu(
				array(
					'theme_location' => 'footer_bottom',
					'menu_id'        => 'consent-menu',
				)
			); ?>
		</div>
		<div class="modal" id="language_modal">
			<div class="modal_container">
				<header class="section_header">
					<h3><?php echo get_field('title_popup_language','option') ?></h3>
					<button type="button" tabindex="0" aria-label="סגור" class="close">
						<svg focusable="false" class="c-icon icon--close" viewBox="0 0 26 27" width="12" height="12">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M13 14.348l11.445 11.685L26 24.445 14.555 12.761 25.5 1.588 23.944 0 13 11.173 2.056 0 .501 1.588 11.445 12.76 0 24.444l1.555 1.588L13 14.348z" fill="currentColor"></path>
						</svg>
					</button>
				</header>
				<div class="modal_content" role="dialog">
					<div class="country_selector">
						<ul class="country_selector_list">
							<?php 
							if( have_rows('countries_site','option') ):
								while( have_rows('countries_site','option') ) : the_row();
									$icon = get_sub_field('country_icon');
									$site = get_sub_field('country_link');
									$name = get_sub_field('country_name'); ?>
									<li class="country_selector_item">
										<a href="<?php echo $site; ?>">
											<img src="<?php echo $icon;?>" alt="">
											<span><?php echo $name; ?></span>
										</a>
									</li>
								<?php endwhile;
							endif;?>
						</ul>
					</div>
				</div>
    		</div>
    		<div class="modal_bg"></div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
<!-- HolyClock.com <BODY> code -->
<script>document.write(typeof _holyclock_tag=="string"?_holyclock_tag:'HolyClock \x26lt;head\x26gt; tag missing!');</script>
<!-- HolyClock.com <BODY> code -->

</body>
</html>
