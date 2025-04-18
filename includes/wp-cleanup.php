<?php

/**
 * Functions & Hooks which remove unncessary Wordpress functionality
 *
 * @package WordPress
 * @subpackage Surprise
 * @since Surprise 1.0
 */


// remove wordpress meta generator
remove_action('wp_head', 'wp_generator');
// remove wordpress rsd link
remove_action('wp_head', 'rsd_link');
// remove Windows Live Writer Manifest Link
remove_action('wp_head', 'wlwmanifest_link');
// remove WordPress Page/Post Shortlinks
remove_action('wp_head', 'wp_shortlink_wp_head');
// Disable REST API link tag
remove_action('wp_head', 'rest_output_link_wp_head', 10);
// Disable oEmbed Discovery Links
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
// Disable REST API link in HTTP headers
remove_action('template_redirect', 'rest_output_link_header', 11, 0);



/**
 * Disable feed
 */

// Redirect to the homepage all users trying to access feeds.
function disable_feeds()
{
  wp_redirect(home_url());
  die;
}
// Disable global RSS, RDF & Atom feeds.
add_action('do_feed',      'disable_feeds', -1);
add_action('do_feed_rdf',  'disable_feeds', -1);
add_action('do_feed_rss',  'disable_feeds', -1);
add_action('do_feed_rss2', 'disable_feeds', -1);
add_action('do_feed_atom', 'disable_feeds', -1);

// Disable comment feeds.
add_action('do_feed_rss2_comments', 'disable_feeds', -1);
add_action('do_feed_atom_comments', 'disable_feeds', -1);

// Prevent feed links from being inserted in the <head> of the page.
add_action('feed_links_show_posts_feed',    '__return_false', -1);
add_action('feed_links_show_comments_feed', '__return_false', -1);
remove_action('wp_head', 'feed_links',       2);
remove_action('wp_head', 'feed_links_extra', 3);

/**
 * Remove JQuery migrate
 */
add_action('wp_default_scripts', 'tabula_remove_jquery_migrate');
function tabula_remove_jquery_migrate($scripts)
{
  if (!is_admin() && isset($scripts->registered['jquery'])) {
    $script = $scripts->registered['jquery'];
    if ($script->deps) { // Check whether the script has any dependencies
      $script->deps = array_diff($script->deps, array('jquery-migrate'));
    }
  }
}
function wps_deregister_styles() {
	wp_dequeue_style( 'global-styles' );
}
add_action( 'wp_enqueue_scripts', 'wps_deregister_styles', 100 );