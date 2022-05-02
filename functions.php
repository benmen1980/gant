<?php
/**
 * gant functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package gant
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'gant_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function gant_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on gant, use a find and replace
		 * to change 'gant' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'gant', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				//'menu-1' => esc_html__( 'Primary Right', 'gant' ),
				'menu-2' => esc_html__( 'Primary Right', 'gant' ),
				'menu-3' => esc_html__( 'Primary login user', 'gant' ),
				'menu-4' => esc_html__( 'My Account menu', 'gant' ),
				//'mobile-menu' => esc_html__( 'Mobile menu', 'gant' ),
				'footer_navigation1' => esc_html__('First Footer Navigation', 'gant'),
				'footer_navigation2' => esc_html__('Second Footer Navigation', 'gant'),
				'footer_navigation3' => esc_html__('Third Footer Navigation', 'gant'),
				'footer_navigation4' => esc_html__('Fourth Footer Navigation', 'gant'),
				'footer_navigation5' => esc_html__('Fifth Footer Navigation', 'gant'),
				'footer_bottom' => esc_html__('Footer legal links', 'gant'),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'gant_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'gant_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function gant_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'gant_content_width', 640 );
}
add_action( 'after_setup_theme', 'gant_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function gant_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'gant' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'gant' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'gant_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function gant_scripts() {
	wp_enqueue_style( 'gant-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'gant-style', 'rtl', 'replace' );

	wp_enqueue_script( 'gant-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'gant_scripts' );



/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Custom Post Types
 */
require get_template_directory() . '/inc/cpt.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
//Disable Gutenberg editor
add_filter('use_block_editor_for_post', '__return_false', 10);


/**
 * Enquque Scripts and Styles
 */
require get_template_directory() . '/inc/enqueue.php';

/**
 * Custom Functions
 */
require get_template_directory() . '/inc/custom-functions.php';


/**
 * ACF Functions
 */
require get_template_directory() . '/inc/acf-functions.php';

/**
 * Ajax Functions
 */
require get_template_directory() . '/inc/ajax-functions.php';


function is_variable_product_out_of_stock($product) {
    $variation_ids = $product->get_visible_children();
    foreach($variation_ids as $variation_id) {
        $variation = wc_get_product($variation_id);
        if ($variation->is_in_stock()){
			return false;
		}
            
    }
    return true;
}

//set product images dynamically
function get_attachment_url_by_slug( $slug ) {
    $args = array(
        'post_type' => 'attachment',
        'name' => sanitize_title($slug),
        'posts_per_page' => 1,
        'post_status' => 'inherit',
    );
    $_header = get_posts( $args );
    $header = $_header ? array_pop($_header) : null;
    return $header ? wp_get_attachment_url($header->ID) : '';
}
function get_attachment_gant_main($sku){
   $pic_siffix = 'gsflat-fv-1';
   $url = get_attachment_url_by_slug($sku.'-'.$pic_siffix);
   if(!empty($url)){
       return $url;
   }
   $pic_siffix = 'model-fv-1';
    $url = get_attachment_url_by_slug($sku.'-'.$pic_siffix);
    if(!empty($url)){
        return $url;
    }
   $pic_siffix = 'flat-fv-1';
    $url = get_attachment_url_by_slug($sku.'-'.$pic_siffix);
    if(!empty($url)){
        return $url;
    }
}


function simply_add_featured_images($product_id,$slugs){
    $_pf = new WC_Product_Factory();
    $product = $_pf->get_product( $product_id );
    $sku = $product->get_sku();
    $list_id = [];
    foreach ($slugs as $slug){
        $attachment_id = get_attachment_id_by_slug($sku.'-'.$slug);
        // should check if attach_id is same as product main image
        if($attachment_id>0 && $attachment_id != $product->get_image_id()){
            array_push($list_id,$attachment_id);
        }
    }
    if(sizeof($list_id)>0){
        update_post_meta($product_id,'_product_image_gallery',implode(',', $list_id));
    }
};
function get_attachment_id_by_slug( $slug ) {
    $args = array(
        'post_type' => 'attachment',
        'name' => sanitize_title($slug),
        'posts_per_page' => 1,
        'post_status' => 'inherit',
    );
    $_header = get_posts( $args );
    $header = $_header ? array_pop($_header) : null;
    return $header->ID ?? 0;
}

if ( is_admin() ) {
    add_action( 'admin_menu', 'add_products_menu_entry', 100 );
}

function add_products_menu_entry() {
    add_submenu_page(
        'edit.php?post_type=product',
        __( 'Set product images' ),
        __( 'Set product images' ),
        'manage_woocommerce', // Required user capability
        'set-product-img',
        'set_product_image'
    );
}


function set_product_image(){ ?>
    <button type='button' class='set_pdt_imgs'>הגדר תמונות מוצר</button>
    <div class="loader_wrap">
        <div class="loader_spinner">
            <img src="<?php echo get_template_directory_uri();?>/dist/images/loader.svg" alt="">
        </div>
    </div>
<?php }


add_action( 'wp_ajax_set_pdt_imgs', 'set_pdt_imgs' );
// for non-logged in users:
add_action( 'wp_ajax_nopriv_set_pdt_imgs', 'set_pdt_imgs' );

function set_pdt_imgs(){
    $slugs = [
        'model-fv-1',
        'model-bv-1',
        'flat-fv-1',
        'flat-bv-1',
        'look-fv-1',
        'look-bv-1',
        'detail-fv-1',
        'detail-fv-2',
        'detail-fv-3',
        'detail-fv-4',
        'thumb-fv-1',
        'crmodel-fv-1',
        'gsflat-fv-1'
    ];
    $args_pdt = array(
        'post_type' =>  array('product', 'product_variation'),
        'post_status' => array('publish'),
        'posts_per_page' => -1,
    );
    $pdts = get_posts( $args_pdt );
    foreach( $pdts as $pdt ):
        $pdt_id = $pdt->ID;
        $current_product = wc_get_product($pdt_id);
        $pdt_sku = $current_product->get_sku();
        set_post_thumbnail( $pdt_id, attachment_url_to_postid(get_attachment_gant_main($pdt_sku)) );
        simply_add_featured_images($pdt_id,$slugs);
    endforeach;
}

// aray combine and preserve same key;
function array_combine_($keys, $values)
{
    $result = array();
    foreach ($keys as $i => $k) {
        $result[$k][] = $values[$i];
    }
    array_walk($result, create_function('&$v', '$v = (count($v) == 1)? array_pop($v): $v;'));
    return    $result;
}

