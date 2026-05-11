<?php
if (!defined('ABSPATH')) {
    exit;
}

function toabai_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('align-wide');

    register_nav_menus([
        'primary' => __('Hauptmenü', 'toabai'),
        'footer'  => __('Footer-Menü', 'toabai'),
    ]);
}
add_action('after_setup_theme', 'toabai_theme_setup');

function toabai_enqueue_assets() {
    wp_enqueue_style(
        'toabai-style',
        get_stylesheet_uri(),
        [],
        wp_get_theme()->get('Version')
    );

    $version = wp_get_theme()->get('Version');

    wp_enqueue_script(
        'toabai-menu',
        get_template_directory_uri() . '/assets/js/menu.js',
        [],
        $version,
        true
    );
    wp_script_add_data('toabai-menu', 'strategy', 'defer');

    wp_enqueue_script(
        'toabai-reveal',
        get_template_directory_uri() . '/assets/js/reveal.js',
        [],
        $version,
        true
    );
    wp_script_add_data('toabai-reveal', 'strategy', 'defer');
}
add_action('wp_enqueue_scripts', 'toabai_enqueue_assets');

add_filter('body_class', function($classes) {

    if (is_page('ueber-mich')) {
        $classes[] = 'page-about';
    }

    if (is_page('wartung-betreuung')) {
        $classes[] = 'page-wartung';
    }

    if (is_page('website-erstellen-lassen')) {
        $classes[] = 'page-website';
    }

    if (is_page('referenzen')) {
        $classes[] = 'page-references';
    }

    return $classes;
});

require_once get_template_directory() . '/inc/diagnosis.php';