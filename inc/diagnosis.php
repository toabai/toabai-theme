<?php

if (!defined('ABSPATH')) {
  exit;
}

/* =========================
   REPORT AREAS
========================= */

function tm_get_report_area_status($results, $site_facts) {
  $areas = [
    'security' => ['status' => 'good', 'text' => 'Okay'],
    'maintainability' => ['status' => 'good', 'text' => 'Okay'],
    'performance' => ['status' => 'good', 'text' => 'Okay'],
    'seo' => ['status' => 'good', 'text' => 'Okay'],
    'privacy' => ['status' => 'good', 'text' => 'Okay'],
  ];

  foreach ($results as $result) {
    $label = $result['label'] ?? '';
    $status = $result['status'] ?? 'good';
    $category = $result['category'] ?? '';

    if (in_array($label, ['SSL fehlt', 'HSTS fehlt', 'Security Header unvollständig'], true)) {
      $areas['security'] = ['status' => $status === 'bad' ? 'bad' : 'warning', 'text' => $status === 'bad' ? 'Auffällig' : 'Prüfen'];
    }

    if (in_array($label, ['XML-RPC auffällig', 'Login-Bereich sichtbar', 'Plugins öffentlich sichtbar', 'Theme öffentlich erkennbar'], true)) {
      $areas['maintainability'] = ['status' => 'warning', 'text' => 'Prüfen'];
    }

    if (in_array($label, ['Antwortzeit beobachten', 'Langsame erste Antwort'], true)) {
      $areas['performance'] = ['status' => 'warning', 'text' => 'Prüfen'];
    }

    if (in_array($label, ['Indexierung blockiert', 'Meta Description fehlt', 'H1 fehlt', 'Canonical unklar', 'Sitemap unklar', 'robots.txt unklar'], true)) {
      $areas['seo'] = ['status' => $status === 'bad' ? 'bad' : 'warning', 'text' => $status === 'bad' ? 'Auffällig' : 'Prüfen'];
    }

    if ($category === 'DSGVO' || in_array($label, ['Google Fonts extern', 'Externe Dienste erkannt'], true)) {
      $areas['privacy'] = ['status' => 'warning', 'text' => 'Prüfen'];
    }
  }

  if (!empty($site_facts['plugins']) && count($site_facts['plugins']) >= 5) {
    $areas['maintainability'] = ['status' => 'warning', 'text' => 'Auffällig'];
  }

  return $areas;
}

/* =========================
   DIAGNOSIS SIGNALS
========================= */

function tm_get_diagnosis_signals($results, $site_facts) {
  $signals = [
    'special' => [],
    'important' => [],
    'technology' => [],
    'summary' => [],
  ];

  if (!empty($site_facts['theme'])) {
    $signals['technology'][] = ['label' => 'Theme erkannt', 'value' => $site_facts['theme']];
  }

  if (!empty($site_facts['plugins'])) {
    $signals['technology'][] = ['label' => 'Plugins erkannt', 'value' => count($site_facts['plugins']) . ' sichtbar'];
    $signals['summary'][] = 'öffentlich sichtbare Plugins';
  }

  if (!empty($site_facts['external_services'])) {
    $signals['technology'][] = ['label' => 'Externe Dienste', 'value' => implode(', ', $site_facts['external_services'])];
  }

  if (!empty($site_facts['form_count'])) {
    $signals['technology'][] = ['label' => 'Formulare', 'value' => $site_facts['form_count'] . ' erkannt'];
  }

  if (!empty($site_facts['theme'])) {
    $signals['summary'][] = 'erkennbare Theme-Struktur';
  }

  foreach ($results as $result) {
    $label = $result['label'] ?? '';

    if ($label === 'XML-RPC auffällig') {
      $signals['summary'][] = 'erreichbare XML-RPC-Struktur';
    }

    if ($label === 'Langsame erste Antwort') {
      $signals['summary'][] = 'auffällige Antwortzeit';
    }
  }

  return $signals;
}

/**AB hier */

function tm_get_special_findings($site_facts) {
  $findings = [];

  $plugins = $site_facts['plugins'] ?? [];
  $plugin_count = $site_facts['plugin_count'] ?? count($plugins);
  $external_services = $site_facts['external_services'] ?? [];
  $form_count = $site_facts['form_count'] ?? 0;
  $internal_link_count = $site_facts['internal_link_count'] ?? 0;

  $plugin_string = strtolower(implode(' ', $plugins));

  $rules = [
    [
      'needles' => ['woocommerce'],
      'type' => 'warning',
      'accent' => 'orange',
      'icon' => 'shop',
      'label' => 'Shop-System erkannt',
      'text' => 'Die Website nutzt Shop-Funktionen oder verarbeitet Bestellungen.',
      'meaning' => 'Shop-Systeme brauchen laufende Kontrolle, weil Updates Bestellungen, Zahlungen, E-Mails und Kundendaten betreffen können.',
      'priority' => 1,
    ],
    [
      'needles' => ['elementor', 'elementor-pro'],
      'type' => 'warning',
      'accent' => 'cyan',
      'icon' => 'builder',
      'label' => 'Page Builder erkannt',
      'text' => 'Die Website nutzt Elementor oder ein vergleichbares Layout-System.',
      'meaning' => 'Page Builder erhalten regelmäßig Updates. Nach größeren Updates sollten Layouts, mobile Ansichten und Templates geprüft werden.',
      'priority' => 2,
    ],
    [
      'needles' => ['divi', 'js_composer', 'wpbakery', 'oxygen', 'bricks', 'beaver-builder'],
      'type' => 'warning',
      'accent' => 'cyan',
      'icon' => 'builder',
      'label' => 'Visueller Builder erkannt',
      'text' => 'Die Website nutzt ein visuelles Layout-System.',
      'meaning' => 'Solche Systeme erhöhen oft den Kompatibilitätsaufwand, weil Design, Templates und Frontend-Funktionen nach Updates geprüft werden sollten.',
      'priority' => 3,
    ],
    [
      'needles' => ['contact-form-7', 'wpforms', 'gravityforms', 'gravity-forms', 'formidable', 'ninja-forms', 'fluentform', 'fluent-forms'],
      'type' => 'warning',
      'accent' => 'cyan',
      'icon' => 'form',
      'label' => 'Formularsystem erkannt',
      'text' => 'Die Website nutzt offenbar ein Formularsystem.',
      'meaning' => 'Formulare sollten regelmäßig getestet werden, damit Anfragen nicht unbemerkt verloren gehen.',
      'priority' => 4,
    ],
    [
      'needles' => ['wp-rocket', 'w3-total-cache', 'wp-super-cache', 'litespeed-cache', 'autoptimize', 'swift-performance', 'cache-enabler', 'breeze'],
      'type' => 'good',
      'accent' => 'blue',
      'icon' => 'speed',
      'label' => 'Caching erkannt',
      'text' => 'Es wurden Hinweise auf Performance-Optimierung erkannt.',
      'meaning' => 'Caching ist grundsätzlich positiv. Nach Updates sollte aber geprüft werden, ob Darstellung, Formulare und Cache weiterhin sauber funktionieren.',
      'priority' => 5,
    ],
    [
      'needles' => ['wordfence', 'ithemes-security', 'better-wp-security', 'all-in-one-wp-security-and-firewall', 'sucuri-scanner', 'wp-cerber', 'solid-security'],
      'type' => 'good',
      'accent' => 'green',
      'icon' => 'shield',
      'label' => 'Sicherheitsplugin erkannt',
      'text' => 'Die Website nutzt offenbar zusätzliche Sicherheitsfunktionen.',
      'meaning' => 'Das ist ein gutes Signal. Entscheidend bleibt aber, ob Schutz, Benachrichtigungen und Einstellungen regelmäßig kontrolliert werden.',
      'priority' => 6,
    ],
    [
      'needles' => ['wordpress-seo', 'yoast', 'rank-math', 'aioseo', 'seopress'],
      'type' => 'good',
      'accent' => 'purple',
      'icon' => 'chart',
      'label' => 'SEO-System erkannt',
      'text' => 'Die Website nutzt offenbar ein SEO-Plugin.',
      'meaning' => 'SEO-Plugins helfen bei Struktur und Sichtbarkeit. Sitemap, Weiterleitungen, Titel und Indexierung sollten trotzdem regelmäßig geprüft werden.',
      'priority' => 7,
    ],
    [
      'needles' => ['borlabs-cookie', 'complianz', 'cookiebot', 'real-cookie-banner', 'cookie-law-info'],
      'type' => 'good',
      'accent' => 'violet',
      'icon' => 'privacy',
      'label' => 'Consent-Lösung erkannt',
      'text' => 'Es gibt Hinweise auf eine Cookie- oder Consent-Lösung.',
      'meaning' => 'Das ist positiv. Wichtig ist, dass externe Dienste und Tracking tatsächlich korrekt eingebunden sind.',
      'priority' => 8,
    ],
    [
      'needles' => ['wpml', 'polylang', 'translatepress', 'weglot'],
      'type' => 'warning',
      'accent' => 'violet',
      'icon' => 'language',
      'label' => 'Mehrsprachigkeit erkannt',
      'text' => 'Die Website scheint mehrsprachige Funktionen zu nutzen.',
      'meaning' => 'Mehrsprachige Websites brauchen bei Updates zusätzliche Kontrolle, damit Menüs, Übersetzungen und URLs sauber bleiben.',
      'priority' => 9,
    ],
    [
      'needles' => ['updraftplus', 'backwpup', 'duplicator', 'all-in-one-wp-migration', 'wpvivid'],
      'type' => 'good',
      'accent' => 'green',
      'icon' => 'backup',
      'label' => 'Backup-Plugin erkannt',
      'text' => 'Es gibt Hinweise auf eine Backup- oder Migrationslösung.',
      'meaning' => 'Backups sind wichtig. Entscheidend ist aber, ob sie regelmäßig laufen und im Ernstfall wirklich wiederherstellbar sind.',
      'priority' => 10,
    ],
  ];

  foreach ($rules as $rule) {
    foreach ($rule['needles'] as $needle) {
      if (strpos($plugin_string, $needle) !== false) {
        $findings[] = [
          'type' => $rule['type'],
          'accent' => $rule['accent'],
          'icon' => $rule['icon'] ?? 'plugin',
          'label' => $rule['label'],
          'text' => $rule['text'],
          'meaning' => $rule['meaning'],
          'priority' => $rule['priority'],
        ];
        break;
      }
    }
  }

  if ($plugin_count >= 10 && $plugin_count < 20) {
    $findings[] = [
      'type' => 'warning',
      'accent' => 'yellow',
      'icon' => 'plugin',
      'label' => 'Plugins brauchen laufende Kontrolle',
      'text' => $plugin_count . ' Plugins sind öffentlich sichtbar.',
      'meaning' => 'Jedes Plugin kann Updates, Sicherheitslücken oder Konflikte verursachen. Deshalb ist regelmäßige WordPress Wartung hier besonders wichtig.',
      'priority' => 0,
    ];
  }

  if ($plugin_count >= 20) {
    $findings[] = [
      'type' => 'bad',
      'accent' => 'red',
      'icon' => 'plugin',
      'label' => 'Hohe Plugin-Komplexität',
      'text' => $plugin_count . ' Plugins sind öffentlich sichtbar.',
      'meaning' => 'Viele Plugins erhöhen das Risiko für Konflikte, Ausfälle und Performance-Probleme. Das sollte laufend betreut werden.',
      'priority' => 1,
    ];
  }

  if (count($external_services) >= 2) {
    $findings[] = [
      'type' => 'warning',
      'accent' => 'violet',
      'icon' => 'privacy',
      'label' => 'Mehrere externe Dienste',
      'text' => count($external_services) . ' externe Dienste wurden erkannt.',
      'meaning' => 'Externe Dienste beeinflussen Datenschutz, Ladezeit und technische Abhängigkeiten.',
      'priority' => 4,
    ];
  }

  if ($form_count >= 3) {
    $findings[] = [
      'type' => 'warning',
      'accent' => 'cyan',
      'icon' => 'form',
      'label' => 'Mehrere Formulare erkannt',
      'text' => $form_count . ' Formulare wurden erkannt.',
      'meaning' => 'Formulare sollten regelmäßig getestet werden, damit keine Anfragen verloren gehen.',
      'priority' => 5,
    ];
  }

  if ($internal_link_count >= 25) {
    $findings[] = [
      'type' => 'warning',
      'accent' => 'blue',
      'icon' => 'chart',
      'label' => 'Größere Seitenstruktur',
      'text' => $internal_link_count . ' interne Links wurden erkannt.',
      'meaning' => 'Größere Websites brauchen meist mehr Wartung, Strukturpflege und Qualitätskontrolle.',
      'priority' => 6,
    ];
  }

  $has_woocommerce = strpos($plugin_string, 'woocommerce') !== false;
  $has_elementor = strpos($plugin_string, 'elementor') !== false;
  $has_cache = (
    strpos($plugin_string, 'litespeed') !== false ||
    strpos($plugin_string, 'rocket') !== false ||
    strpos($plugin_string, 'cache') !== false
  );

  if ($has_woocommerce && $plugin_count >= 10) {
    $findings[] = [
      'type' => 'bad',
      'accent' => 'red',
      'icon' => 'shop',
      'label' => 'Komplexes Shop-System erkannt',
      'text' => 'WooCommerce und viele Plugins erhöhen die technische Komplexität deutlich.',
      'meaning' => 'Shop-Systeme mit vielen Erweiterungen brauchen laufende Wartung, weil Updates Zahlungen, Bestellungen und Kundenprozesse beeinflussen können.',
      'priority' => 1,
    ];
  }

  if ($has_elementor && $plugin_count >= 12) {
    $findings[] = [
      'type' => 'warning',
      'accent' => 'yellow',
      'icon' => 'builder',
      'label' => 'Komplexe Frontend-Struktur erkannt',
      'text' => 'Page Builder und viele Erweiterungen wurden erkannt.',
      'meaning' => 'Komplexe Frontend-Systeme sollten nach Updates regelmäßig auf Layout-, Mobil- und Darstellungsfehler geprüft werden.',
      'priority' => 2,
    ];
  }

  if ($has_cache && $has_elementor) {
    $findings[] = [
      'type' => 'good',
      'accent' => 'blue',
      'icon' => 'speed',
      'label' => 'Performance-Optimierung aktiv',
      'text' => 'Caching und Frontend-Optimierung wurden erkannt.',
      'meaning' => 'Das kann Ladezeiten verbessern. Nach Updates sollten Cache und Darstellung trotzdem kontrolliert werden.',
      'priority' => 5,
    ];
  }

  usort($findings, function($a, $b) {
    return ($a['priority'] ?? 99) <=> ($b['priority'] ?? 99);
  });

  return $findings;
}

/**Bis hier */

function tm_get_special_icon_svg($icon) {
  $icons = [
    'shop' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 7h12l-1 12H7L6 7Z"/><path d="M9 7a3 3 0 0 1 6 0"/></svg>',
    'builder' => '<svg viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="4" width="16" height="16" rx="3"/><path d="M8 9h8M8 13h5M8 17h7"/></svg>',
    'speed' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 14a8 8 0 1 1 16 0"/><path d="M12 14l4-5"/><path d="M8 18h8"/></svg>',
    'shield' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3l7 3v5c0 5-3 8-7 10-4-2-7-5-7-10V6l7-3Z"/><path d="M9 12l2 2 4-5"/></svg>',
    'chart' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 19h16"/><path d="M7 16v-5"/><path d="M12 16V7"/><path d="M17 16v-8"/></svg>',
    'form' => '<svg viewBox="0 0 24 24" aria-hidden="true"><rect x="5" y="4" width="14" height="16" rx="2"/><path d="M8 9h8M8 13h8M8 17h5"/></svg>',
    'privacy' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 11V8a4 4 0 0 1 8 0v3"/><rect x="5" y="11" width="14" height="9" rx="2"/><path d="M12 15v2"/></svg>',
    'backup' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 12a6 6 0 0 1 10-4l2 2"/><path d="M18 6v4h-4"/><path d="M18 12a6 6 0 0 1-10 4l-2-2"/><path d="M6 18v-4h4"/></svg>',
    'plugin' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 3v4M15 3v4"/><rect x="7" y="7" width="10" height="10" rx="3"/><path d="M12 17v4"/><path d="M8 21h8"/></svg>',
    'language' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 5h9"/><path d="M9 5c-.5 4-2 7-5 9"/><path d="M6 9c1 2 3 4 6 5"/><path d="M14 19l3-7 3 7"/><path d="M15 17h4"/></svg>',
  ];

  return $icons[$icon] ?? $icons['plugin'];
}