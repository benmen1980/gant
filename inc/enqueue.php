<?php
/**
 * Enqueue scripts and styles.
 */

$theme_data = wp_get_theme();
define( 'THEME_VERSION', $theme_data->Version );


function gant_custom_scripts() {
    
    wp_enqueue_style( 'slick-css', get_template_directory_uri() . '/dist/css/slick.css' );
	wp_enqueue_style( 'slick-theme-css', get_template_directory_uri() . '/dist/css/slick-theme.css' );
	wp_enqueue_style( 'jquery-ui', get_template_directory_uri() . '/dist/css/jquery-ui-1.13.2.min.css' );
    wp_enqueue_style( 'gant-style-min', get_template_directory_uri() . '/dist/css/style.min.css', array(), '1.0.23' );
    wp_enqueue_style( 'gant-style', get_template_directory_uri() . '/dist/css/style.min.css' );
	wp_enqueue_script('jquery', get_template_directory_uri() . '/js/jquery-3.6.0.min.js', false, '1.12.4',true);
    wp_enqueue_script('jquery-ui-datepicker', get_template_directory_uri() . '/js/jquery-ui-1.13.2.min.js', false, '1.13.2',true);
    wp_enqueue_script( 'gant-scripts', get_template_directory_uri() . '/dist/js/scripts.js', array(), '1.0.13' );
    wp_enqueue_script( 'gant-slick', get_template_directory_uri() . '/dist/js/slick.min.js', array(), '', false );
	

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
    
    // Enqueue the 'wc-cart-fragments' script
    wp_enqueue_script( 'wc-cart-fragments' );
    
}
add_action( 'wp_enqueue_scripts', 'gant_custom_scripts' );

/**
 * Enqueue  Admin Scripts
 */
function gant_admin_script( $hook ) {
    wp_enqueue_script( 'admin_scripts', get_template_directory_uri() . '/dist/js/admin-scripts.js', array(), '1.0' );
    wp_enqueue_style( 'admin_styles', get_template_directory_uri() . '/dist/css/admin.css', false, '1.0' );
}
add_action( 'admin_enqueue_scripts', 'gant_admin_script' );











