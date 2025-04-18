<?php
define('THEME_DIR', get_stylesheet_directory());
define('THEME_URI', get_stylesheet_directory_uri());
define('TEXT_DOMAIN', 'TABULA');
define('THEME_VER', '1.0.0');

function tabula_theme_setup()
{

	/*this is fix for content block editor look and add style support for editor.css files*/
	add_theme_support("align-wide");

	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on react-blocks, use a find and replace
		* to change _TEXT_DOMAIN to the name of your theme in all the template files.
		*/
	load_theme_textdomain(TEXT_DOMAIN, get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support('title-tag');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support('post-thumbnails');
//	add_image_size('blog-post-thumbnail', 347, 188, true);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'primary-menu' => esc_html__('Primary', TEXT_DOMAIN),
			'secondary-menu' => esc_html__('Secondary', TEXT_DOMAIN),
			'footer-menu-1' => esc_html__('Footer 1', TEXT_DOMAIN),
			'footer-menu-2' => esc_html__('Footer 2', TEXT_DOMAIN),
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
	add_theme_support( 'custom-logo', array(
		'height'      => 108,
		'width'       => 240,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );
}

add_action('after_setup_theme', 'tabula_theme_setup');


add_filter( 'acf/settings/save_json', 'json_acf_save' );
add_filter( 'acf/settings/load_json', 'json_acf_load' );
function json_acf_save( $path ) {
	$path = get_stylesheet_directory() . '/fields';
	if ( ! file_exists( $path ) ) {
		mkdir( $path, 0777 );
	}

	return $path;
}

function json_acf_load( $paths ) {
	unset( $paths[ 0 ] );
	$paths[] = get_stylesheet_directory() . '/fields';

	return $paths;
}

add_filter('acf/settings/show_admin', '__return_false');

/** ======================================================
*       THEME MODULES
* ===================================================== */

/**
 * Removes WP RSS feed, jQuery migrate etc.
 */
require THEME_DIR . "/includes/wp-cleanup.php";

/**
 * Adds SVG support for Media Library upload
 */
require THEME_DIR . "/includes/svg-support.php";

/**
 * Registers ACF Blocks support. See README for more info
 */
require THEME_DIR . '/includes/register-json-blocks.php';

/**
 * Disables Emoji support in comments and content
 */
require THEME_DIR . '/includes/ht-disable-emoji.php';

/**
 * Removes all default Dashboard widgets except 'Site health'
 */
require THEME_DIR . '/includes/ht-dashboard-cleanup.php';

/**
 * Adds 'Duplicate post/page' functionality
 */
require THEME_DIR . '/includes/ht-post-duplicator.php';

/**
 * Adds 'ACF Block usage page in Tools admin menu'
 */
require THEME_DIR . '/includes/ht-blocks-usage.php';

/**
 * Adds 'Adds options to Customizer'
 */
require THEME_DIR . '/includes/customizer.php';

