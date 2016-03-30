<?php
/**
 * _kellee functions and definitions
 *
 * @package _kellee
 */

define( 'ASSETS_VERSION', '1.0.0' );

if ( ! function_exists( '_kellee_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function _kellee_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on _kellee, use a find and replace
	 * to change '_kellee' to the name of your theme in all the template files
	 */
	load_theme_textdomain( '_kellee', get_template_directory() . '/languages' );

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
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', '_kellee' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( '_kellee_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // _kellee_setup
add_action( 'after_setup_theme', '_kellee_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function _kellee_content_width() {
	$GLOBALS['content_width'] = apply_filters( '_kellee_content_width', 640 );
}
add_action( 'after_setup_theme', '_kellee_content_width', 0 );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function _kellee_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', '_kellee' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', '_kellee_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function _kellee_scripts() {
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		wp_enqueue_style( '_kellee-style-dev', get_stylesheet_directory_uri() . '/assets/build/styles.css', array(), ASSETS_VERSION );
		wp_enqueue_script( '_kellee-scripts-dev', get_template_directory_uri() . '/assets/build/scripts.js', array(), ASSETS_VERSION, true );
	} else {
		wp_enqueue_style( '_kellee-style', get_template_directory_uri() . '/assets/dist/styles.min.css', array(), ASSETS_VERSION );
		wp_enqueue_script( '_kellee-scripts', get_template_directory_uri() . '/assets/dist/scripts.min.js', array(), ASSETS_VERSION, true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', '_kellee_scripts' );

show_admin_bar( false );

/**
 * CMB2 plugin
 */
if ( file_exists( get_template_directory() . '/cmb2/init.php' ) ) {
	require get_template_directory() . '/cmb2/init.php';
}

/**
 * Custom metaboxes
 */
require get_template_directory() . '/inc/cmb2-metaboxes.php';

/**
 * Implement the Custom Data.
 */
require get_template_directory() . '/inc/custom-data.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
