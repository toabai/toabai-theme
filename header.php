<?php
/**
 * Header Template
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#content">Zum Inhalt springen</a>

<header class="site-header">
  <div class="tm-container tm-header-inner">

    <div class="site-branding">
      <a class="tm-logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="toabai.media Startseite">
        <span class="tm-logo-main">toabai</span><span class="tm-logo-dot">.</span><span class="tm-logo-sub">media</span>
      </a>
    </div>

    <?php
    if (has_nav_menu('primary')) {
      wp_nav_menu([
        'theme_location'       => 'primary',
        'container'            => 'nav',
        'container_class'      => 'main-navigation',
        'container_aria_label' => 'Hauptnavigation',
        'menu_class'           => 'tm-main-menu',
        'depth'                => 2,
        'fallback_cb'          => false,
      ]);
    }
    ?>

    <a class="tm-header-cta" href="/kontakt/">Wartung starten</a>

    <button class="tm-menu-toggle" type="button" aria-label="Menü öffnen" aria-expanded="false">
      <span></span>
      <span></span>
      <span></span>
    </button>

  </div>
</header>

<div class="tm-mobile-menu" aria-hidden="true">

  <div class="tm-mobile-header">
    <a class="tm-mobile-brand tm-logo" href="<?php echo esc_url(home_url('/')); ?>">
      <span class="tm-logo-main">toabai</span><span class="tm-logo-dot">.</span><span class="tm-logo-sub">media</span>
    </a>

    <button class="tm-menu-close" type="button" aria-label="Menü schließen">
      <span></span>
      <span></span>
    </button>
  </div>

  <?php
  if (has_nav_menu('primary')) {
    wp_nav_menu([
      'theme_location' => 'primary',
      'menu_class'     => 'tm-mobile-nav',
      'container'      => false,
      'depth'          => 1,
      'fallback_cb'    => false,
    ]);
  }
  ?>

  <a class="tm-mobile-cta" href="/kontakt/">Wartung starten</a>

</div>