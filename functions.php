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
    $theme_version = wp_get_theme()->get('Version');

    wp_enqueue_style(
        'toabai-style',
        get_stylesheet_uri(),
        [],
        filemtime(get_stylesheet_directory() . '/style.css')
    );

    wp_enqueue_script(
        'toabai-menu',
        get_template_directory_uri() . '/assets/js/menu.js',
        [],
        $theme_version,
        true
    );
    wp_script_add_data('toabai-menu', 'strategy', 'defer');

    wp_enqueue_script(
        'toabai-reveal',
        get_template_directory_uri() . '/assets/js/reveal.js',
        [],
        $theme_version,
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

function toabai_is_website_pruefen_request() {
    $path = isset($_SERVER['REQUEST_URI'])
        ? wp_parse_url(wp_unslash($_SERVER['REQUEST_URI']), PHP_URL_PATH)
        : '';

    return trim((string) $path, '/') === 'website-pruefen';
}

add_filter('redirect_canonical', function($redirect_url) {
    if (
        toabai_is_website_pruefen_request()
        && isset($_SERVER['REQUEST_METHOD'])
        && strtoupper($_SERVER['REQUEST_METHOD']) === 'POST'
    ) {
        return false;
    }

    return $redirect_url;
});

add_action('template_redirect', function() {
    if (!toabai_is_website_pruefen_request()) {
        return;
    }

    global $wp_query;

    if ($wp_query) {
        $wp_query->is_404 = false;
        $wp_query->is_page = true;
    }

    status_header(200);
});

add_filter('template_include', function($template) {
    if (!toabai_is_website_pruefen_request()) {
        return $template;
    }

    $website_check_template = get_template_directory() . '/page-website-pruefen.php';

    return file_exists($website_check_template) ? $website_check_template : $template;
});

require_once get_template_directory() . '/inc/diagnosis.php';