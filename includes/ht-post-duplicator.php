<?php

function duplicate_post_as_draft() {
    if (!isset($_GET['post']) || !isset($_GET['action']) || $_GET['action'] !== 'duplicate_post_as_draft') {
        return;
    }

    // Проверяем nonce для безопасности
    if (!wp_verify_nonce($_GET['_wpnonce'], basename(__FILE__))) {
        wp_die('Ошибка безопасности, попробуйте снова.');
    }

    $post_id = absint($_GET['post']);
    $post = get_post($post_id);

    if (!$post) {
        wp_die('Ошибка: Пост не найден.');
    }

    // Проверяем права пользователя
    if (!current_user_can('edit_posts')) {
        wp_die('Недостаточно прав для выполнения этой операции.');
    }

    // Дублируем пост
    $new_post = [
        'post_title'   => $post->post_title . ' (Копия)',
        'post_content' => $post->post_content,
        'post_status'  => 'draft',
        'post_type'    => $post->post_type,
        'post_author'  => get_current_user_id(),
    ];

    $new_post_id = wp_insert_post($new_post);

    if (!$new_post_id) {
        wp_die('Ошибка при создании дубликата.');
    }

    // Копируем все кастомные поля (включая ACF)
    $meta = get_post_meta($post_id);
    foreach ($meta as $key => $value) {
        if ($key === '_edit_lock' || $key === '_edit_last') {
            continue; // Пропускаем системные поля
        }
        update_post_meta($new_post_id, $key, maybe_unserialize($value[0]));
    }

    // Перенаправляем обратно в редактор
    wp_redirect(admin_url('post.php?action=edit&post=' . $new_post_id));
    exit;
}

// Добавляем экшен для обработки дублирования
add_action('admin_action_duplicate_post_as_draft', 'duplicate_post_as_draft');

// Добавляем ссылку "Дублировать" в список постов
function add_duplicate_post_link($actions, $post) {
    if (current_user_can('edit_posts')) {
        $url = wp_nonce_url(
            admin_url('admin.php?action=duplicate_post_as_draft&post=' . $post->ID),
            basename(__FILE__)
        );
        $actions['duplicate'] = '<a href="' . esc_url($url) . '" title="Duplicate">Duplicate</a>';
    }
    return $actions;
}

add_filter('post_row_actions', 'add_duplicate_post_link', 10, 2);
add_filter('page_row_actions', 'add_duplicate_post_link', 10, 2);
