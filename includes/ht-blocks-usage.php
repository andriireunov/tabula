<?php
///**
// * Plugin Name: ACF Blocks Usage Report
// * Description: Displays a list of ACF Gutenberg blocks and the pages where they are used.
// * Version: 1.0
// * Author: Your Name
// */

// Add admin menu item under "Tools"
add_action('admin_menu', function() {
    add_submenu_page(
        'tools.php',
        'ACF Blocks Usage',
        'ACF Blocks Usage',
        'manage_options',
        'acf-blocks-usage',
        'acf_blocks_usage_page'
    );
});

// Render admin page
function acf_blocks_usage_page() {
    echo '<div class="wrap">';
    echo '<h1>ACF Blocks Usage</h1>';

    $blocks_usage = get_acf_blocks_usage();

    if (empty($blocks_usage)) {
        echo '<p>No ACF blocks found in pages.</p>';
        echo '</div>';
        return;
    }

    echo '<table class="widefat fixed">
            <thead>
                <tr>
                    <th>ACF Block</th>
                    <th>Used on Pages</th>
                </tr>
            </thead>
            <tbody>';

    foreach ($blocks_usage as $block_name => $pages) {
        echo '<tr>
                <td>' . esc_html($block_name) . '</td>
                <td>' . (!empty($pages) ? implode(', ', $pages) : 'Not used') . '</td>
              </tr>';
    }

    echo '</tbody></table></div>';
}

// Get all ACF blocks and their usage in pages
function get_acf_blocks_usage() {
    $acf_blocks = [];

    // Get all pages
    $pages = get_posts([
        'post_type' => 'page',
        'posts_per_page' => -1
    ]);

    foreach ($pages as $page) {
        $content = $page->post_content;

        // Match ACF Gutenberg blocks in the content
        preg_match_all('/<!-- wp:acf\/([a-z0-9\-]+) /', $content, $matches);

        if (!empty($matches[1])) {
            foreach ($matches[1] as $block_name) {
                $acf_blocks[$block_name][] = '<a href="' . get_edit_post_link($page->ID) . '">' . esc_html(get_the_title($page->ID)) . '</a>';
            }
        }
    }

    return $acf_blocks;
}
