<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package gant
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>

	<!-- HolyClock.com <HEAD> code for dev-gant.tmpurl.co.il -->
	<script>/*<![CDATA[*/_holyclock_id="5afa1b48ce4ac7fe1f18443494e52348";_holyclock_tag='<s'+'cript src\x3d"//www.holyclock.com/holyclock.js?'+Math.floor(+new Date/864E5)+'">\x3c/script>';null!==document.cookie.match(/(?:^|;)\s*_holyclock_qr=\s*\w/)&&null===window.location.hash.match(/#holyclock=qr(?=#|$)/)&&document.write(_holyclock_tag);//]]></script>
	<!-- HolyClock.com <HEAD> code for dev-gant.tmpurl.co.il -->
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'gant' ); ?></a>

	<header id="masthead" class="site-header">
		<?php 
		if(get_field('bg_color','option')){
			$bg_color = get_field('bg_color','option');
		}
		if(get_field('text_color_top_line','option')){
			$text_color = get_field('text_color_top_line','option');
		}
		if(get_field('border_color','option')){
			$border_color = get_field('border_color','option');
		}
		?>
		<div class="top_banner_wrapper" style="background-color:<?php echo $bg_color; ?>; color:<?php echo $text_color; ?>; <?php echo (!empty($border_color)) ? 'border: 1px solid '.$border_color : ''?>">
			<div class="container">
			<?php $links = get_field('choose_links','option');


			if( $links ): ?>
				<ul>
					<?php  foreach( $links as $link ) :
						 $link_title = $link['link']['title'];
						 $link_target = $link['link']['target'] ? $link['link']['target'] : '_self';
						 $link_url = $link['link']['url'];
						 $link_target_not_login = $link['link_not_login']['target'] ? $link['link_not_login']['target'] : '_self';
						 $link_url_not_login = $link['link_not_login']['url'];
					?>
						<li>
							<?php 
							if(!empty( $link_url_not_login)):
								if ( is_user_logged_in() ) { ?>
										<a class="button"  style="color:<?php echo $text_color; ?>" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
								<?php } else { ?>
									<a class="button" style="color:<?php echo $text_color; ?>" href="<?php echo esc_url( $link_url_not_login ); ?>" target="<?php echo esc_attr( $link_target_not_login ); ?>"><?php echo esc_html( $link_title ); ?></a>
								<?php } 
							else:?>
								<a class="button" style="color:<?php echo $text_color; ?>" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			</div>
		</div>
		<div class="main_menu_wrapper">
			<nav class="right-navigation main-navigation">
				<button class="menu-toggle" aria-controls="primary-right-menu" aria-expanded="false">
					<span class="hamburger__bar"></span>
					<span class="hamburger__bar"></span>
				</button>
				<div class="mobile_navigation_background"></div>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-2',
						'menu_id'        => 'primary-right-menu',
					)
				);
				?>

			</nav><!-- #site-navigation -->
			<div class="site-branding">
				<a href="/" title="גאנט ישראל">
					<img src="<?php echo get_template_directory_uri();?>/dist/images/logo.svg" aria-hidden="false" alt="גאנט ישראל">
				</a>	
			</div><!-- .site-branding -->

			<div class="header_left">
				<nav class="main-navigation">
				<ul id="primary-left-menu" class="menu">
					<li class="menu-item ">
						<?php global $woocommerce;
						$bag_count = $woocommerce->cart->cart_contents_count;  
						?>
						<button type="button" class="bag_button" aria-label="סל קניות">
							<a href="javascript:void(0)" aria-label="<?php echo sprintf("%u פריטים בסל קניות",$bag_count); ?>" title="<?php echo sprintf("פריטים בסל קניות %u",$bag_count); ?>">
								<span class="btn_icon">
									<svg focusable="false" class="c-icon icon--basket" viewBox="0 0 20 20" width="20" height="20">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M7.2 5C7.2 3.4536 8.4536 2.2 10 2.2C11.5464 2.2 12.8 3.4536 12.8 5V6H7.2V5ZM6 7.2V8.99999H7.2V7.2H12.8V8.99999H14V7.2H16.8V15C16.8 16.5464 15.5464 17.8 14 17.8H6C4.4536 17.8 3.2 16.5464 3.2 15V7.2H6ZM6 6V5C6 2.79086 7.79086 1 10 1C12.2091 1 14 2.79086 14 5V6H18V15C18 17.2091 16.2091 19 14 19H6C3.79086 19 2 17.2091 2 15V6H6Z" fill="currentColor"></path>
									</svg>		
								</span>
								<span class="bag_label">סל קניות</span>
								<span class="misha-cart"><?php echo '<span>(</span>'. $bag_count. '<span>)</span>'; ?></span>
							</a>
						</button>
					</li>
					<li class="menu-item account_menu_wrapper">
						<?php if( is_user_logged_in() ): ?>
							<button type="button" class="open_login_popup" aria-label="חשבון שלי">
								<span class="btn_icon">
									<img src="<?php echo get_template_directory_uri();?>/dist/images/account.svg" aria-hidden="false" alt="חשבון שלי">
								</span>
								<span class="account_label">גאנט שלי</span>
							</button>
							<div class="popup_login_wrapper">
								<div class="popup_login ">
									<div class="popup_header">
										<button type="button" tabindex="0" aria-label="סגור" class="close">
											<svg focusable="false" class="c-icon icon--close" viewBox="0 0 26 27" width="12" height="12">
												<path fill-rule="evenodd" clip-rule="evenodd" d="M13 14.348l11.445 11.685L26 24.445 14.555 12.761 25.5 1.588 23.944 0 13 11.173 2.056 0 .501 1.588 11.445 12.76 0 24.444l1.555 1.588L13 14.348z" fill="currentColor"></path>
											</svg>
										</button>
									</div>
									<div class="popup_content">
										<div class="login_menu_wrapper">
											<?php 
											wp_nav_menu(
												array(
													'theme_location' => 'menu-3',
													'menu_id'        => 'login-menu',
												)
											); ?>
											
										</div>
										<a href="<?php echo wp_logout_url( get_permalink());?>" class="logout_btn"><?php esc_html_e( 'התנתקות', 'gant' ); ?></a>
									</div>
								</div>
							</div>
							
						<?php else: ?>
							<button type="button" class="open_login_popup" aria-label="חשבון שלי">
								<span class="btn_icon">
									<svg focusable="false" class="c-icon icon--user" viewBox="0 0 16 17" width="15" height="15">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M10.8 4a2.8 2.8 0 11-5.6 0 2.8 2.8 0 015.6 0zM12 4a4 4 0 11-8 0 4 4 0 018 0zM1.2 17a6.8 6.8 0 0113.6 0H16a8 8 0 10-16 0h1.2z" fill="currentColor"></path>
									</svg>
								</span>
								<span class="account_label">גאנט שלי</span>
							</button>
							<div class="popup_login_wrapper">
								<div class="popup_login ">
									<div class="popup_header">
										<button type="button" tabindex="0" aria-label="סגור" class="close">
											<svg focusable="false" class="c-icon icon--close" viewBox="0 0 26 27" width="12" height="12">
												<path fill-rule="evenodd" clip-rule="evenodd" d="M13 14.348l11.445 11.685L26 24.445 14.555 12.761 25.5 1.588 23.944 0 13 11.173 2.056 0 .501 1.588 11.445 12.76 0 24.444l1.555 1.588L13 14.348z" fill="currentColor"></path>
											</svg>
										</button>
									</div>
									<div class="popup_content">
										<a class="button-secondary" style="color:#000;" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">
											<span class="button_label" style=" color:#fff;">להתחבר</span>
										</a>
										<span class="login-status__divider">אוֹ</span>
										<a class="button-primary"  href="/register">
											<span class="button__label" >להרשם</span>
										</a>
									</div>
								</div>
							</div>
						<?php endif;?>
					</li>
					<li class="menu-item search_menu_wrapper">
						<button type="button" class="search_button" aria-label="חיפוש">
							<span class="btn_icon">
								<svg focusable="false" class="c-icon icon--search" viewBox="0 0 21 21" width="15px" height="15px">
									<g transform="translate(.75 1)" stroke="currentColor" stroke-width="1.8" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 14.497l4.25 4.003"></path><circle cx="8.5" cy="8.5" r="8.5"></circle></g>
								</svg>
							</span>
							<span class="search_label">חיפוש</span>
						</button>
					</li>
				</ul>
					<?php
					// wp_nav_menu(
					// 	array(
					// 		'theme_location' => 'menu-1',
					// 		'menu_id'        => 'primary-right-menu',
					// 	)
					// );
					?>
				</nav>
			</div> 
		</div>
		<div class="loader_wrap" >
			<div class="loader_spinner">
				<img src="https://dev-gant.tmpurl.co.il/wp-content/themes/gant/dist/images/loader.svg" alt="">
			</div>
		</div>
		<?php  $promo_link = get_field('popup_link','option');
		if(!empty($promo_link)):?>
			<div class="promotion_banner" style="color:<?php echo get_field('popup_bg_text','option'); ?>; background-color:<?php echo get_field('popup_bg_color','option');?>">
				<div class="promotion_banner_content">
					<?php 
						$promo_link_url = $promo_link['url'];
						$promo_link_title = $promo_link['title'];
						$promo_link_target = $promo_link['target'] ? $promo_link['target'] : '_self';
					?>
					<a  href="<?php echo esc_url( $promo_link_url ); ?>" target="<?php echo esc_attr( $promo_link_target ); ?>">
						<?php echo esc_html( $promo_link_title ); ?>
					</a>
				</div>
				<button aria-label="סגור" class="promotion_banner_close_button">
					<svg focusable="false" class="c-icon icon--close" viewBox="0 0 26 27" width="8px" height="8px">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M13 14.348l11.445 11.685L26 24.445 14.555 12.761 25.5 1.588 23.944 0 13 11.173 2.056 0 .501 1.588 11.445 12.76 0 24.444l1.555 1.588L13 14.348z" fill="currentColor"></path>
					</svg>
				</button>
			</div>
		<?php endif; ?>
		<div class="search_popup_wrapper" id="search_popup_wrapper">
			<div class="popup_container">
				<div class="popup_content">
					<div class="r_side" id="r_side">
						<?php echo do_shortcode( '[wpbsearch]' ); ?>
						<div class="popular_search">
							<p><?php echo __('מוצרים פופולרים','gant')?></p>
						<?php 
						$query_args = array(
							'posts_per_page' => 4,
							'post_status'    => 'publish',
							'post_type'      => 'product',
							'no_found_rows'  => 1,
							'meta_key'       => 'total_sales',
							'orderby'        => 'meta_value_num',
							'order'          => 'desc',
							'meta_query' => array(
								array(
									'key' => '_stock_status',
									'value' => 'instock'
								),
								// array(
								// 	'key' => '_thumbnail_id',
								// 	'compare' => 'EXISTS',
								// )
							)
						);
						$loop = new WP_Query( $query_args );
						while ( $loop->have_posts() ) : $loop->the_post(); 
						global $product; ?>
						<a href="<?php the_permalink(); ?>" id="id-<?php the_id(); ?>" title="<?php the_title(); ?>">
						<?php the_title(); ?>
						</a>
						<?php endwhile; ?>
						<?php wp_reset_query(); ?> 
						</div>
					</div>
					<div class="l_side" id="l_side">
						<div class="loader_wrap">
							<div class="loader_spinner">
								<img src="<?php echo get_template_directory_uri();?>/dist/images/loader.svg" alt="">
							</div>
						</div>
						<div class="top_results">
							<label class="search-reuslt-title"><?php echo __('מוצרים','gant')?></label>
							<div class="arrow_btn">
								<a class="button-secondary" href="#">
									<span class="button_label"><?php echo __('ראה כל המוצרים','gant')?></span>	
									<span class="btn_icon" style="color:rgb(0,0,0);">
										<svg focusable="false" class="c-icon icon--arrow-button" viewBox="0 0 42 10" width="15px" height="15px">
											<path fill-rule="evenodd" clip-rule="evenodd" d="M40.0829 5.5H0V4.5H40.0829L36.9364 1.35359L37.6436 0.646484L41.9971 5.00004L37.6436 9.35359L36.9364 8.64649L40.0829 5.5Z" fill="currentColor"></path>
										</svg>
									</span>
								</a>
							</div>
							
						</div>
						<div class="results_list"></div>
						<div class="msg_no_result">
							<p class="sorry_msg"><?php esc_html_e( 'מצטערים, לא מצאנו כלום עבור ', 'gant' ); ?>
								"<span class="search_term"></span>"
							</p>
							<?php echo get_field('desc_no_search_result','option') ?>
						</div>
					
					</div>
				</div>
			</div>
		</div>
	</header><!-- #masthead -->
	<?php if(get_field('banner_sale_active','option') == 1): 
		$current_term = get_queried_object();
		$current_term_name = $current_term->name;
		$current_term_id = $current_term->term_id;
		$parent_tag_id = $current_term->parent;
		$term = get_term_by( 'id', $parent_tag_id, 'product_cat' );
		if(!empty($term)){
			$parent_term_name = $term->name;
			$parent_term_id = $term->term_id;
			$parent_term_slug = get_term_link ($parent_tag_id, 'product_cat');
		}
	endif; ?>
	<?php if(is_page_template('page-templates/overview.php') || (is_account_page() && !empty( WC()->query->get_current_endpoint() ) )):?>
		<div class="account_nav_wrapper">
			<div class="l_side number_points">
				<?php 
				$user_id = get_current_user_id();
				if(!empty(get_user_meta($user_id, 'points_club', true))):
					echo get_user_meta($user_id, 'points_club', true).' ';
				else: 
					echo '0 ';
				endif;
				esc_html_e( 'נקודות', 'gant' );
				?>
			</div>
			<div class="account_nav_menu_wrapper">
			<?php 				
				wp_nav_menu(
					array(
						'theme_location' => 'menu-4',
						'menu_id'        => 'account-nav-menu',
					)
				); ?>
			</div>
			<div class="r_side">
				<a href="<?php echo wp_logout_url( get_permalink());?>" class="button_underline"><?php esc_html_e( 'התנתק', 'gant' ); ?></a>
			</div>
		</div>
	<?php endif; ?>
