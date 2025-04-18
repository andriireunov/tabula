<?php
/**
 * Plugin name: Dashboard cleaner
 * Description: Removes unused WordPress Dashboard widgets
 * Version: 0.1
 * Author: Andrey Reunov
 * Author URI: mailto:andrey.reunov@gmail.com
 */

add_action( 'wp_dashboard_setup', 'remove_dashboard_widgets', 15 );

function remove_dashboard_widgets() {
	global $wp_meta_boxes;

	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity'] );
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'] );
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'] );

	// Elementor
	unset( $wp_meta_boxes['dashboard']['normal']['core']['e-dashboard-overview'] );
}
