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
}
add_action('wp_enqueue_scripts', 'toabai_enqueue_assets');

function toabai_mobile_menu_script() {
    ?>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const btn = document.querySelector('.tm-menu-toggle');
        const menu = document.querySelector('.tm-mobile-menu');
        const closeBtn = document.querySelector('.tm-menu-close');

        if (btn && menu) {
          function closeMenu() {
            menu.classList.remove('active');
            btn.classList.remove('active');
            document.body.classList.remove('tm-menu-open');
            btn.setAttribute('aria-expanded', 'false');
            menu.setAttribute('aria-hidden', 'true');
          }

          function openMenu() {
            menu.classList.add('active');
            btn.classList.add('active');
            document.body.classList.add('tm-menu-open');
            btn.setAttribute('aria-expanded', 'true');
            menu.setAttribute('aria-hidden', 'false');
          }

          btn.addEventListener('click', function() {
            if (menu.classList.contains('active')) {
              closeMenu();
            } else {
              openMenu();
            }
          });

          if (closeBtn) {
            closeBtn.addEventListener('click', closeMenu);
          }

          const links = menu.querySelectorAll('a');

          links.forEach(function(link) {
            link.addEventListener('click', closeMenu);
          });

          document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
              closeMenu();
            }
          });
        }
      });
    </script>
    <?php
}
add_action('wp_footer', 'toabai_mobile_menu_script');