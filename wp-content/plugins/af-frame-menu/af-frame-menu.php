<?php
/**
 * Plugin Name: A-Frame Menu
 * Description: Displays an animated A-Frame house menu via the [af_frame_menu] shortcode.
 * Version: 1.0.0
 * Author: AF Menu
 * Text Domain: af-frame-menu
 */

if (!defined('ABSPATH')) {
    exit;
}

define('AF_FRAME_MENU_VERSION', '1.0.0');
define('AF_FRAME_MENU_FILE', __FILE__);
define('AF_FRAME_MENU_DIR', plugin_dir_path(__FILE__));
define('AF_FRAME_MENU_URL', plugin_dir_url(__FILE__));

function af_frame_menu_default_items() {
    return array(
        array(
            'text' => 'О Нас',
            'url'  => '#about',
        ),
        array(
            'text' => 'Наши работы',
            'url'  => '#works',
        ),
        array(
            'text' => 'Проекты',
            'url'  => '#projects',
        ),
        array(
            'text' => 'Цены',
            'url'  => '#prices',
        ),
    );
}

function af_frame_menu_get_items() {
    $items = get_option('af_frame_menu_items', af_frame_menu_default_items());

    if (!is_array($items) || empty($items)) {
        return af_frame_menu_default_items();
    }

    return $items;
}

function af_frame_menu_sanitize_items($items) {
    if (!is_array($items)) {
        return af_frame_menu_default_items();
    }

    $sanitized_items = array();

    foreach ($items as $item) {
        if (!is_array($item)) {
            continue;
        }

        $text = isset($item['text']) ? sanitize_text_field(wp_unslash($item['text'])) : '';
        $url  = isset($item['url']) ? esc_url_raw(wp_unslash($item['url'])) : '';

        if ('' === $text && '' === $url) {
            continue;
        }

        $sanitized_items[] = array(
            'text' => $text,
            'url'  => $url,
        );
    }

    if (empty($sanitized_items)) {
        return af_frame_menu_default_items();
    }

    return $sanitized_items;
}

function af_frame_menu_register_settings() {
    register_setting(
        'af_frame_menu_settings',
        'af_frame_menu_items',
        array(
            'type'              => 'array',
            'sanitize_callback' => 'af_frame_menu_sanitize_items',
            'default'           => af_frame_menu_default_items(),
        )
    );
}
add_action('admin_init', 'af_frame_menu_register_settings');

require_once AF_FRAME_MENU_DIR . 'includes/admin-page.php';
require_once AF_FRAME_MENU_DIR . 'includes/frontend.php';
