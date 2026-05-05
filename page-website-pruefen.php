<?php get_header(); ?>

<main id="content" class="toabai-page website-check-page website-check-page-single">

<?php
$website = isset($_GET['website']) ? esc_url_raw($_GET['website']) : '';
$success = false;

$check_results = [];
$visible_results = [];
$hidden_results = [];

$score_points = 0;
$risk_count = 0;
$critical_count = 0;
$warning_count = 0;
$maintenance_percent = 0;
$maintenance_level = 'unklar';
$scan_time = current_time('d.m.Y H:i');

$backend_check_items = [
  'Plugin-Versionen & offene Updates',
  'Theme-Updates & Kompatibilität',
  'WordPress-Core-Version',
  'Backup-Status & Wiederherstellbarkeit',
  'Benutzerrechte & Admin-Zugänge',
  'Sicherheits-Plugins & Konfiguration',
  'Formular-Zustellung per E-Mail',
  'Fehlerprotokolle & PHP-Warnungen',
];

$site_facts = [
  'title' => '',
  'h1' => '',
  'meta_description' => '',
  'internal_links' => [],
  'internal_link_count' => 0,
  'form_count' => 0,
  'external_services' => [],
  'plugins' => [],
  'plugin_count' => 0,
  'theme' => '',
  'final_url' => '',
  'final_host' => '',
  'redirect_detected' => false,
  'redirect_from' => '',
  'redirect_to' => '',
];

function tm_shorten_url_middle($url, $max = 50) {
  if (strlen($url) <= $max) return $url;
  $keep = intval(($max - 3) / 2);
  return substr($url, 0, $keep) . '...' . substr($url, -$keep);
}

function tm_normalize_website_url($url) {
  $url = trim($url);
  if (empty($url)) return '';

  $url = preg_replace('#^https?://#i', '', $url);
  $url = preg_replace('#\s+#', '', $url);
  $url = rtrim($url, '/');

  if ($url && strpos($url, '.') === false) {
    $url .= '.de';
  }

  return esc_url_raw('https://' . $url);
}

function tm_get_host_from_url($url) {
  $host = wp_parse_url($url, PHP_URL_HOST);
  return $host ? preg_replace('#^www\.#', '', $host) : $url;
}

function tm_get_final_response_url($response, $fallback_url) {
  if (is_wp_error($response)) {
    return esc_url_raw($fallback_url);
  }

  if (isset($response['http_response']) && is_object($response['http_response'])) {
    $response_object = $response['http_response']->get_response_object();

    if (!empty($response_object->url)) {
      return esc_url_raw($response_object->url);
    }
  }

  return esc_url_raw($fallback_url);
}

function tm_is_safe_public_url($url) {
  $parts = wp_parse_url($url);
  if (empty($parts['host']) || empty($parts['scheme'])) return false;
  if (!in_array($parts['scheme'], ['http', 'https'], true)) return false;

  $host = $parts['host'];
  if (in_array($host, ['localhost', '127.0.0.1', '::1'], true)) return false;

  $ip = gethostbyname($host);
  if (filter_var($ip, FILTER_VALIDATE_IP)) {
    if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) return false;
  }

  return true;
}

function tm_check_item($label, $status, $text, $category = 'Wartung', $weight = 1, $priority = 5, $metric = '', $meaning = '', $tech = []) {
  return [
    'label' => $label,
    'status' => $status,
    'text' => $text,
    'category' => $category,
    'weight' => $weight,
    'priority' => $priority,
    'metric' => $metric,
    'meaning' => $meaning,
    'tech' => $tech,
  ];
}

function tm_detect_plugins_and_theme($body) {
  $plugins = [];
  $theme = '';

  if (preg_match_all('~/wp-content/plugins/([^/\\?#"\\\']+)~i', $body, $matches)) {
    foreach ($matches[1] as $plugin) {
      $plugin = sanitize_text_field($plugin);
      if (!empty($plugin)) {
        $plugins[] = $plugin;
      }
    }
  }

  $plugins = array_values(array_unique($plugins));

  if (preg_match('~/wp-content/themes/([^/\\?#"\\\']+)~i', $body, $match)) {
    $theme = sanitize_text_field($match[1]);
  }

  return [
    'plugins' => $plugins,
    'plugin_count' => count($plugins),
    'theme' => $theme,
  ];
}

function tm_score_results($results) {
  $points = 0;
  $max = 0;
  $risks = 0;
  $critical = 0;
  $warning = 0;

  foreach ($results as $result) {
    $weight = isset($result['weight']) ? (float) $result['weight'] : 1;
    $max += $weight;

    if ($result['status'] === 'good') {
      $points += $weight;
    } elseif ($result['status'] === 'warning') {
      $points += $weight * 0.5;
      $risks++;
      $warning++;
    } elseif ($result['status'] === 'bad') {
      $risks++;
      $critical++;
    }
  }

  return [
    'score' => $max > 0 ? round(($points / $max) * 10) : 0,
    'risks' => $risks,
    'critical' => $critical,
    'warning' => $warning,
  ];
}

function tm_get_maintenance_level($score, $risks) {
  if ($score >= 8 && $risks <= 3) return 'niedrig bis mittel';
  if ($score >= 6) return 'mittel';
  return 'hoch';
}

function tm_get_maintenance_status($score, $risks) {
  if ($score >= 8 && $risks <= 3) return 'warning';
  if ($score >= 6) return 'warning';
  return 'bad';
}

function tm_get_maintenance_percent($score, $risks) {
  $percent = 100 - ($score * 8);
  $percent += min($risks * 4, 24);
  return max(18, min(88, $percent));
}

function tm_get_report_headline($score, $risks) {
  if ($score >= 8 && $risks <= 3) return 'Deine Website läuft. Aber Wartung bleibt wichtig.';
  if ($score >= 6) return 'Deine Website läuft, zeigt aber Wartungssignale.';
  return 'Deine Website zeigt deutliche Wartungssignale.';
}

function tm_get_maintenance_text($score, $risks) {
  if ($score >= 8 && $risks <= 3) {
    return 'Der erste Eindruck ist solide. Trotzdem gibt es Punkte, die bei WordPress-Websites regelmäßig geprüft werden sollten.';
  }

  if ($score >= 6) {
    return 'Es gibt mehrere Signale, die auf Wartungsbedarf hindeuten. Das heißt nicht automatisch, dass etwas kaputt ist. Es heißt: Die Website sollte regelmäßig betreut werden.';
  }

  return 'Der Mini-Check zeigt deutliche Auffälligkeiten. Hier sollte zeitnah genauer geprüft werden.';
}

function tm_get_form_intro($score, $risks) {
  if ($score >= 8 && $risks <= 3) return 'Ich prüfe, ob hinter dem soliden ersten Eindruck trotzdem Wartungsrisiken im Backend liegen.';
  if ($score >= 6) return 'Ich ordne die Hinweise ein und sage dir, welche Punkte wirklich wichtig sind.';
  return 'Ich schaue mir die auffälligen Punkte genauer an und sage dir, was zuerst erledigt werden sollte.';
}

function tm_get_meaning_text($score, $risks) {
  if ($risks <= 2 && $score >= 8) {
    return 'Deine Website wirkt öffentlich grundsätzlich ordentlich. Ob Plugins aktuell sind, Backups funktionieren und das Backend sauber abgesichert ist, sieht man von außen aber nicht zuverlässig.';
  }

  if ($score >= 6) {
    return 'Deine Website ist erreichbar, zeigt aber mehrere Signale, die bei WordPress-Websites regelmäßig geprüft werden sollten.';
  }

  return 'Der öffentliche Check zeigt mehrere Auffälligkeiten. Das ist ein starkes Signal, dass auch im Backend genauer geprüft werden sollte.';
}

function tm_extract_site_facts($body, $base_url) {
  $detected = tm_detect_plugins_and_theme($body);

  $facts = [
    'title' => '',
    'h1' => '',
    'meta_description' => '',
    'internal_links' => [],
    'internal_link_count' => 0,
    'form_count' => 0,
    'external_services' => [],
    'plugins' => $detected['plugins'],
    'plugin_count' => $detected['plugin_count'],
    'theme' => $detected['theme'],
    'final_url' => '',
    'final_host' => '',
    'redirect_detected' => false,
    'redirect_from' => '',
    'redirect_to' => '',
  ];

  if (preg_match('#<title>(.*?)</title>#is', $body, $match)) {
    $facts['title'] = trim(wp_strip_all_tags($match[1]));
  }

  if (preg_match('#<h1[^>]*>(.*?)</h1>#is', $body, $match)) {
    $facts['h1'] = trim(wp_strip_all_tags($match[1]));
  }

  if (preg_match('#<meta[^>]+name=["\']description["\'][^>]+content=["\']([^"\']+)#i', $body, $match)) {
    $facts['meta_description'] = trim($match[1]);
  }

  preg_match_all('#<form[\s>]#i', $body, $forms);
  $facts['form_count'] = isset($forms[0]) ? count($forms[0]) : 0;

  $base_parts = wp_parse_url($base_url);
  $host = isset($base_parts['host']) ? $base_parts['host'] : '';

  preg_match_all('#<a[^>]+href=["\']([^"\']+)["\']#i', $body, $links);

  $internal = [];

  if (!empty($links[1])) {
    foreach ($links[1] as $link) {
      $link = trim($link);

      if ($link === '' || strpos($link, '#') === 0 || stripos($link, 'mailto:') === 0 || stripos($link, 'tel:') === 0) continue;

      $is_internal = false;

      if (strpos($link, '/') === 0) {
        $is_internal = true;
      } else {
        $link_parts = wp_parse_url($link);
        if (!empty($link_parts['host']) && $link_parts['host'] === $host) $is_internal = true;
      }

      if ($is_internal) {
        $path = $link;

        if (stripos($link, 'http') === 0) {
          $parsed = wp_parse_url($link);
          $path = isset($parsed['path']) ? $parsed['path'] : '/';
        }

        $path = strtok($path, '?');
        $path = strtok($path, '#');

        if ($path === '') $path = '/';

        $internal[] = $path;
      }
    }
  }

  $internal = array_values(array_unique($internal));
  $facts['internal_link_count'] = count($internal);
  $facts['internal_links'] = array_slice($internal, 0, 8);

  $services = [];

  if (stripos($body, 'fonts.googleapis.com') !== false || stripos($body, 'fonts.gstatic.com') !== false) {
    $services[] = 'Google Fonts';
  }

  if (preg_match('#googletagmanager|gtag\(|google-analytics#i', $body)) {
    $services[] = 'Google Analytics / Tag Manager';
  }

  if (preg_match('#facebook\.net|connect\.facebook|doubleclick#i', $body)) {
    $services[] = 'Meta / externe Werbedienste';
  }

  if (preg_match('#matomo|plausible#i', $body)) {
    $services[] = 'Tracking / Analytics';
  }

  $facts['external_services'] = array_values(array_unique($services));

  return $facts;
}

function tm_run_website_check($url, &$site_facts) {
  $results = [];
  $url = tm_normalize_website_url($url);

  if (empty($url) || !tm_is_safe_public_url($url)) {
    $results[] = tm_check_item(
      'URL nicht prüfbar',
      'warning',
      'Die eingegebene URL konnte nicht sicher geprüft werden.',
      'Technik',
      1,
      1,
      'unklar',
      'Ohne sauberen Abruf kann keine belastbare Erstdiagnose erstellt werden.',
      [
        'Geprüfte URL' => $url,
        'Ergebnis' => 'URL wurde nicht abgerufen',
        'Empfehlung' => 'Domain prüfen und erneut eingeben',
      ]
    );
    return $results;
  }

  $parts = wp_parse_url($url);
  $scheme = isset($parts['scheme']) ? $parts['scheme'] : 'https';
  $host = isset($parts['host']) ? $parts['host'] : '';
  $base_url = $scheme . '://' . $host;

  $start = microtime(true);

  $response = wp_remote_get($url, [
    'timeout' => 10,
    'redirection' => 5,
    'user-agent' => 'toabai.media Wartungsampel',
  ]);

  $duration = microtime(true) - $start;

  if (is_wp_error($response)) {
    $results[] = tm_check_item(
      'Website nicht erreichbar',
      'bad',
      'Die Website konnte nicht abgerufen werden.',
      'Technik',
      2,
      1,
      'kritisch',
      'Wenn die Website nicht zuverlässig erreichbar ist, können Besucher und Anfragen verloren gehen.',
      [
        'Geprüfte URL' => $url,
        'Fehler' => $response->get_error_message(),
        'Empfehlung' => 'Domain, SSL und Hosting prüfen',
      ]
    );
    return $results;
  }

  $final_url = tm_get_final_response_url($response, $url);
  $final_host = tm_get_host_from_url($final_url);
  $original_host = tm_get_host_from_url($url);

  if ($final_host !== $original_host) {
    $results[] = tm_check_item(
      'Weiterleitung erkannt',
      'warning',
      'Die eingegebene Domain leitet auf eine andere Website weiter.',
      'Technik',
      1.5,
      2,
      $original_host . ' → ' . $final_host,
      'Das ist nicht automatisch schlecht. Es sollte aber bewusst eingerichtet sein, damit Besucher und Google eindeutig auf der richtigen Website landen.',
      [
        'Eingegeben' => $original_host,
        'Final geprüft' => $final_host,
        'Finale URL' => $final_url,
        'Empfehlung' => 'Weiterleitung bewusst prüfen und eine eindeutige Hauptdomain festlegen',
      ]
    );
  }

  $status_code = wp_remote_retrieve_response_code($response);
  $body = wp_remote_retrieve_body($response);
  $headers = wp_remote_retrieve_headers($response);

  $final_parts = wp_parse_url($final_url);
  $final_scheme = isset($final_parts['scheme']) ? $final_parts['scheme'] : $scheme;
  $final_host_raw = isset($final_parts['host']) ? $final_parts['host'] : $host;
  $base_url = $final_scheme . '://' . $final_host_raw;

  $site_facts = tm_extract_site_facts($body, $base_url);

  $site_facts['final_url'] = $final_url;
  $site_facts['final_host'] = $final_host;

  if ($final_host !== $original_host) {
    $site_facts['redirect_detected'] = true;
    $site_facts['redirect_from'] = $original_host;
    $site_facts['redirect_to'] = $final_host;
  }

  if ($site_facts['plugin_count'] > 0) {
    $results[] = tm_check_item(
      'Plugins öffentlich sichtbar',
      'warning',
      $site_facts['plugin_count'] . ' WordPress-Plugins sind öffentlich erkennbar.',
      'Wartung',
      2,
      2,
      $site_facts['plugin_count'] . ' erkannt',
      'Plugins sind nicht automatisch gefährlich. Aber jedes Plugin ist ein Baustein, der regelmäßig aktualisiert, geprüft und abgesichert werden sollte.',
      [
        'Erkannte Plugins' => implode(', ', $site_facts['plugins']),
        'Hinweis' => 'Es werden nur öffentlich sichtbare Plugins erkannt.',
        'Empfehlung' => 'Plugin-Versionen und Updates im Backend prüfen.',
      ]
    );
  } else {
    $results[] = tm_check_item(
      'Plugins nicht öffentlich sichtbar',
      'good',
      'Es wurden keine öffentlich sichtbaren Plugin-Pfade erkannt.',
      'Wartung',
      1,
      8,
      'nicht sichtbar',
      'Das heißt nicht, dass keine Plugins installiert sind. Viele Plugins sind von außen nicht zuverlässig sichtbar.',
      [
        'Prüfung' => '/wp-content/plugins/',
        'Status' => 'Keine Plugin-Pfade im HTML erkannt.',
      ]
    );
  }

  if (!empty($site_facts['theme'])) {
    $results[] = tm_check_item(
      'Theme öffentlich erkennbar',
      'warning',
      'Das verwendete WordPress-Theme ist öffentlich erkennbar.',
      'Wartung',
      1,
      3,
      $site_facts['theme'],
      'Das Theme ist ein zentraler Bestandteil deiner Website. Auch Themes brauchen Updates und Kompatibilitätsprüfungen.',
      [
        'Erkanntes Theme' => $site_facts['theme'],
        'Hinweis' => 'Erkannt über /wp-content/themes/',
        'Empfehlung' => 'Theme-Updates und Child-Theme-Struktur prüfen.',
      ]
    );
  }

  if ($status_code >= 200 && $status_code < 400) {
    $results[] = tm_check_item(
      'Website erreichbar',
      'good',
      'Die Website antwortet grundsätzlich erreichbar.',
      'Technik',
      2,
      9,
      'HTTP ' . $status_code,
      'Die Basis funktioniert. Entscheidend ist jetzt, ob Updates, Backups und Sicherheit ebenfalls sauber betreut werden.',
      [
        'Finale URL' => $final_url,
        'HTTP Status' => $status_code,
        'Bedeutung' => 'Die Startseite konnte geladen werden',
      ]
    );
  } else {
    $results[] = tm_check_item(
      'Auffälliger HTTP-Status',
      'bad',
      'Die Website antwortet mit einem auffälligen Statuscode.',
      'Technik',
      2,
      1,
      'HTTP ' . $status_code,
      'Auffällige Statuscodes können auf technische Probleme, Weiterleitungen oder Serverfehler hinweisen.',
      [
        'Finale URL' => $final_url,
        'HTTP Status' => $status_code,
        'Empfehlung' => 'Serverantwort prüfen',
      ]
    );
  }

  if (stripos($final_url, 'https://') === 0) {
    $results[] = tm_check_item(
      'SSL aktiv',
      'good',
      'Die Website wird verschlüsselt über HTTPS aufgerufen.',
      'Sicherheit',
      2,
      9,
      'aktiv',
      'SSL ist ein wichtiger Vertrauensfaktor. SSL ersetzt aber keine WordPress-Wartung.',
      [
        'Protokoll' => 'HTTPS',
        'Finale URL' => $final_url,
      ]
    );
  } else {
    $results[] = tm_check_item(
      'SSL fehlt',
      'bad',
      'Die Website nutzt kein HTTPS.',
      'Sicherheit',
      2,
      1,
      'kritisch',
      'Ohne HTTPS wirkt eine Website unsicher und kann Vertrauen kosten.',
      [
        'Protokoll' => 'HTTP',
        'Empfehlung' => 'SSL aktivieren und auf HTTPS weiterleiten',
      ]
    );
  }

  if ($duration < 1.2) {
    $results[] = tm_check_item(
      'Antwortzeit unauffällig',
      'good',
      'Die erste Antwort kam schnell.',
      'Technik',
      1,
      9,
      round($duration, 2) . ' s',
      'Die erste Antwort ist in Ordnung. Für echte Performance müsste zusätzlich im Browser geprüft werden.',
      [
        'Antwortzeit' => round($duration, 2) . ' Sekunden',
        'Messung' => 'Serverantwort beim Abruf',
      ]
    );
  } elseif ($duration < 2.5) {
    $results[] = tm_check_item(
      'Antwortzeit beobachten',
      'warning',
      'Die erste Antwort ist okay, aber nicht besonders schnell.',
      'Technik',
      1,
      5,
      round($duration, 2) . ' s',
      'Das ist noch kein Drama, sollte aber bei Wartung und Hosting im Blick bleiben.',
      [
        'Antwortzeit' => round($duration, 2) . ' Sekunden',
        'Empfehlung' => 'Hosting, Caching und Plugins prüfen',
      ]
    );
  } else {
    $results[] = tm_check_item(
      'Langsame erste Antwort',
      'warning',
      'Die erste Antwort wirkt langsam.',
      'Technik',
      1,
      4,
      round($duration, 2) . ' s',
      'Langsame Antworten können Besucher kosten und sollten technisch eingeordnet werden.',
      [
        'Antwortzeit' => round($duration, 2) . ' Sekunden',
        'Empfehlung' => 'Hosting, Caching, Plugins und Server prüfen',
      ]
    );
  }

  if (preg_match('#wp-content|wp-includes|/wp-json#i', $body)) {
    $results[] = tm_check_item(
      'WordPress erkannt',
      'good',
      'Die Website zeigt öffentlich sichtbare Hinweise auf WordPress.',
      'Wartung',
      2,
      9,
      'erkannt',
      'WordPress braucht regelmäßige Pflege, weil Plugins, Themes und Core-Versionen laufend aktualisiert werden.',
      [
        'Hinweise' => 'wp-content, wp-includes oder wp-json',
        'Empfehlung' => 'Updates, Backups und Sicherheit regelmäßig prüfen',
      ]
    );
  } else {
    $results[] = tm_check_item(
      'WordPress nicht eindeutig erkannt',
      'warning',
      'WordPress konnte von außen nicht eindeutig erkannt werden.',
      'Wartung',
      1,
      6,
      'unklar',
      'Das kann an Caching, Sicherheitsmaßnahmen oder einer anderen Technik liegen.',
      [
        'Hinweis' => 'Keine eindeutigen WordPress-Spuren im HTML',
      ]
    );
  }

  $xmlrpc_response = wp_remote_get(trailingslashit($base_url) . 'xmlrpc.php', [
    'timeout' => 6,
    'redirection' => 3,
    'user-agent' => 'toabai.media Wartungsampel',
  ]);

  if (!is_wp_error($xmlrpc_response)) {
    $xmlrpc_code = wp_remote_retrieve_response_code($xmlrpc_response);

    if ($xmlrpc_code === 200 || $xmlrpc_code === 405) {
      $results[] = tm_check_item(
        'XML-RPC auffällig',
        'warning',
        'xmlrpc.php scheint erreichbar zu sein.',
        'Wartung',
        1.5,
        2,
        'auffällig',
        'Das ist ein klassischer WordPress-Punkt, der geprüft werden sollte. Je nach Website kann XML-RPC unnötige Angriffsfläche bieten.',
        [
          'Geprüfte URL' => trailingslashit($base_url) . 'xmlrpc.php',
          'HTTP Status' => $xmlrpc_code,
          'Empfehlung' => 'Prüfen, ob XML-RPC benötigt wird',
        ]
      );
    } else {
      $results[] = tm_check_item(
        'XML-RPC unauffällig',
        'good',
        'xmlrpc.php wirkt nicht frei erreichbar.',
        'Wartung',
        1.5,
        9,
        'ok',
        'Das ist aus Wartungs- und Sicherheitsblick positiv.',
        [
          'Geprüfte URL' => trailingslashit($base_url) . 'xmlrpc.php',
          'HTTP Status' => $xmlrpc_code,
        ]
      );
    }
  }

  $login_response = wp_remote_get(trailingslashit($base_url) . 'wp-login.php', [
    'timeout' => 6,
    'redirection' => 3,
    'user-agent' => 'toabai.media Wartungsampel',
  ]);

  if (!is_wp_error($login_response)) {
    $login_code = wp_remote_retrieve_response_code($login_response);

    if ($login_code === 200) {
      $results[] = tm_check_item(
        'Login-Bereich sichtbar',
        'warning',
        'Die Standard-Loginseite ist erreichbar.',
        'Wartung',
        1,
        3,
        'öffentlich',
        'Das ist bei WordPress häufig normal. Trotzdem sollte der Login gegen Bots und Brute-Force-Versuche abgesichert sein.',
        [
          'Geprüfte URL' => trailingslashit($base_url) . 'wp-login.php',
          'HTTP Status' => $login_code,
          'Empfehlung' => 'Login-Schutz, starke Passwörter und Zwei-Faktor-Schutz prüfen',
        ]
      );
    } else {
      $results[] = tm_check_item(
        'Login-Bereich geschützt',
        'good',
        'Die Standard-Loginseite ist nicht frei erreichbar.',
        'Wartung',
        1,
        9,
        'geschützt',
        'Das kann ein Hinweis auf zusätzliche Absicherung sein.',
        [
          'Geprüfte URL' => trailingslashit($base_url) . 'wp-login.php',
          'HTTP Status' => $login_code,
        ]
      );
    }
  }

  if ($site_facts['form_count'] > 0) {
    $results[] = tm_check_item(
      'Formular erkannt',
      'good',
      'Auf der Seite wurde mindestens ein Formular gefunden.',
      'Funktion',
      1,
      9,
      $site_facts['form_count'] . ' erkannt',
      'Wichtig ist nicht nur, ob ein Formular sichtbar ist, sondern ob E-Mails zuverlässig zugestellt werden.',
      [
        'Gefundene Formulare' => $site_facts['form_count'],
        'Empfehlung' => 'Formularversand regelmäßig testen',
      ]
    );
  } else {
    $results[] = tm_check_item(
      'Formular nicht erkannt',
      'warning',
      'Auf der Startseite wurde kein Formular erkannt.',
      'Funktion',
      1,
      5,
      'unklar',
      'Falls Kunden dich über die Website kontaktieren sollen, sollte geprüft werden, ob Kontaktwege gut sichtbar und funktional sind.',
      [
        'Gefundene Formulare' => '0',
        'Hinweis' => 'Es wurde nur die geprüfte Seite analysiert',
      ]
    );
  }

  if (!empty($headers['strict-transport-security'])) {
    $results[] = tm_check_item(
      'HSTS vorhanden',
      'good',
      'Ein HSTS-Sicherheitsheader ist vorhanden.',
      'Sicherheit',
      1,
      9,
      'vorhanden',
      'Das ist ein positives Signal für die Sicherheitskonfiguration.',
      [
        'Header' => 'Strict-Transport-Security',
        'Status' => 'vorhanden',
      ]
    );
  } else {
    $results[] = tm_check_item(
      'HSTS fehlt',
      'warning',
      'Ein HSTS-Sicherheitsheader wurde nicht erkannt.',
      'Sicherheit',
      1,
      3,
      'fehlt',
      'Das bedeutet nicht automatisch Gefahr, zeigt aber: Die Sicherheitskonfiguration ist nicht vollständig erkennbar.',
      [
        'Header' => 'Strict-Transport-Security',
        'Status' => 'nicht erkannt',
      ]
    );
  }

  if (!empty($headers['x-frame-options']) || !empty($headers['content-security-policy'])) {
    $results[] = tm_check_item(
      'Security Header teilweise vorhanden',
      'good',
      'Ein grundlegender Schutz gegen bestimmte Einbettungs- oder Script-Risiken ist erkennbar.',
      'Sicherheit',
      1,
      9,
      'teilweise vorhanden',
      'Das ist ein gutes Signal, sollte aber nicht mit vollständiger Sicherheit verwechselt werden.',
      [
        'X-Frame-Options' => !empty($headers['x-frame-options']) ? 'vorhanden' : 'nicht erkannt',
        'Content-Security-Policy' => !empty($headers['content-security-policy']) ? 'vorhanden' : 'nicht erkannt',
      ]
    );
  } else {
    $results[] = tm_check_item(
      'Security Header unvollständig',
      'warning',
      'Wichtige Security Header konnten nicht eindeutig erkannt werden.',
      'Sicherheit',
      1,
      3,
      'unvollständig',
      'Fehlende Header sind oft kein akuter Notfall, aber ein typischer Punkt für technische Pflege.',
      [
        'X-Frame-Options' => 'nicht erkannt',
        'Content-Security-Policy' => 'nicht erkannt',
      ]
    );
  }

  if (in_array('Google Fonts', $site_facts['external_services'], true)) {
    $results[] = tm_check_item(
      'Google Fonts extern',
      'warning',
      'Google Fonts scheinen extern geladen zu werden.',
      'DSGVO',
      1.5,
      2,
      'prüfen',
      'Externe Schriftarten können datenschutzrechtlich relevant sein und sollten sauber eingebunden werden.',
      [
        'Erkannt' => 'fonts.googleapis.com oder fonts.gstatic.com',
        'Empfehlung' => 'Lokale Einbindung prüfen',
      ]
    );
  } else {
    $results[] = tm_check_item(
      'Google Fonts unauffällig',
      'good',
      'Extern geladene Google Fonts wurden auf dieser Seite nicht erkannt.',
      'DSGVO',
      1.5,
      9,
      'ok',
      'Das ist ein positives Signal aus DSGVO-Sicht.',
      [
        'Prüfung' => 'Google Fonts extern',
        'Status' => 'nicht erkannt',
      ]
    );
  }

  if (!empty($site_facts['external_services'])) {
    $results[] = tm_check_item(
      'Externe Dienste erkannt',
      'warning',
      'Externe Dienste wurden erkannt.',
      'DSGVO',
      1.5,
      2,
      count($site_facts['external_services']) . ' erkannt',
      'Tracking, Schriftarten oder externe Dienste sollten rechtlich und technisch sauber eingebunden sein.',
      [
        'Erkannte Dienste' => implode(', ', $site_facts['external_services']),
      ]
    );
  } else {
    $results[] = tm_check_item(
      'Tracking unauffällig',
      'good',
      'Offensichtliche Tracking-Skripte wurden auf dieser Seite nicht erkannt.',
      'DSGVO',
      1.5,
      9,
      'ok',
      'Das reduziert mögliche Datenschutz-Komplexität.',
      [
        'Geprüft' => 'Analytics, Tag Manager, Meta, Matomo, Plausible',
        'Status' => 'nicht erkannt',
      ]
    );
  }

  if (preg_match('#<meta[^>]+name=["\']robots["\'][^>]+content=["\'][^"\']*noindex#i', $body)) {
    $results[] = tm_check_item(
      'Indexierung blockiert',
      'bad',
      'Auf der Seite wurde ein noindex-Hinweis gefunden.',
      'Sichtbarkeit',
      1.5,
      1,
      'kritisch',
      'Die Seite könnte für Google ausgeschlossen sein. Das sollte dringend geprüft werden.',
      [
        'Meta Robots' => 'noindex erkannt',
      ]
    );
  } else {
    $results[] = tm_check_item(
      'Indexierung möglich',
      'good',
      'Kein offensichtlicher noindex-Hinweis erkannt.',
      'Sichtbarkeit',
      1.5,
      9,
      'ok',
      'Die Seite wirkt grundsätzlich indexierbar.',
      [
        'Meta Robots' => 'kein noindex erkannt',
      ]
    );
  }

  if (!empty($site_facts['title'])) {
    $results[] = tm_check_item(
      'Seitentitel vorhanden',
      'good',
      'Ein Seitentitel ist vorhanden.',
      'Sichtbarkeit',
      1,
      9,
      'ok',
      'Der Seitentitel ist ein wichtiges Grundsignal für Google und Nutzer.',
      [
        'Seitentitel' => $site_facts['title'],
      ]
    );
  } else {
    $results[] = tm_check_item(
      'Seitentitel unklar',
      'warning',
      'Ein Seitentitel konnte nicht eindeutig erkannt werden.',
      'Sichtbarkeit',
      1,
      4,
      'prüfen',
      'Ohne klaren Seitentitel wirkt eine Website weniger sauber strukturiert.',
      [
        'Status' => 'kein title-Tag erkannt',
      ]
    );
  }

  if (!empty($site_facts['meta_description'])) {
    $results[] = tm_check_item(
      'Meta Description vorhanden',
      'good',
      'Eine Meta Description ist vorhanden.',
      'Sichtbarkeit',
      1,
      9,
      'ok',
      'Das ist ein gutes Basis-Signal für Suchergebnisse.',
      [
        'Meta Description' => $site_facts['meta_description'],
      ]
    );
  } else {
    $results[] = tm_check_item(
      'Meta Description fehlt',
      'warning',
      'Eine Meta Description wurde nicht eindeutig erkannt.',
      'Sichtbarkeit',
      1,
      4,
      'prüfen',
      'Das ist kein Sicherheitsproblem, aber ein typischer Pflegepunkt.',
      [
        'Status' => 'keine Meta Description erkannt',
      ]
    );
  }

  if (!empty($site_facts['h1'])) {
    $results[] = tm_check_item(
      'H1 erkannt',
      'good',
      'Eine H1-Überschrift wurde erkannt.',
      'Sichtbarkeit',
      1,
      9,
      'ok',
      'Eine klare H1 hilft Struktur und Verständlichkeit.',
      [
        'H1' => $site_facts['h1'],
      ]
    );
  } else {
    $results[] = tm_check_item(
      'H1 fehlt',
      'warning',
      'Keine H1-Überschrift wurde erkannt.',
      'Sichtbarkeit',
      1,
      4,
      'prüfen',
      'Eine fehlende Hauptüberschrift kann auf strukturelle Schwächen hinweisen.',
      [
        'Status' => 'keine H1 erkannt',
      ]
    );
  }

  if (preg_match('#<link[^>]+rel=["\']canonical["\']#i', $body)) {
    $results[] = tm_check_item(
      'Canonical vorhanden',
      'good',
      'Ein Canonical Tag ist vorhanden.',
      'Sichtbarkeit',
      1,
      9,
      'ok',
      'Das ist ein gutes technisches SEO-Signal.',
      [
        'Canonical' => 'erkannt',
      ]
    );
  } else {
    $results[] = tm_check_item(
      'Canonical unklar',
      'warning',
      'Ein Canonical Tag wurde nicht eindeutig erkannt.',
      'Sichtbarkeit',
      1,
      4,
      'prüfen',
      'Das sollte bei SEO- und Wartungschecks mit geprüft werden.',
      [
        'Canonical' => 'nicht erkannt',
      ]
    );
  }

  $robots_response = wp_remote_get(trailingslashit($base_url) . 'robots.txt', [
    'timeout' => 6,
    'redirection' => 3,
    'user-agent' => 'toabai.media Wartungsampel',
  ]);

  if (!is_wp_error($robots_response) && wp_remote_retrieve_response_code($robots_response) === 200) {
    $results[] = tm_check_item(
      'robots.txt vorhanden',
      'good',
      'Eine robots.txt ist vorhanden.',
      'Sichtbarkeit',
      1,
      9,
      'ok',
      'Die robots.txt ist ein technisches Grundsignal.',
      [
        'Geprüfte URL' => trailingslashit($base_url) . 'robots.txt',
        'HTTP Status' => '200',
      ]
    );
  } else {
    $results[] = tm_check_item(
      'robots.txt unklar',
      'warning',
      'robots.txt wurde nicht gefunden oder konnte nicht gelesen werden.',
      'Sichtbarkeit',
      1,
      5,
      'prüfen',
      'Das ist kein Notfall, sollte aber technisch eingeordnet werden.',
      [
        'Geprüfte URL' => trailingslashit($base_url) . 'robots.txt',
      ]
    );
  }

  $sitemap_response = wp_remote_get(trailingslashit($base_url) . 'sitemap.xml', [
    'timeout' => 6,
    'redirection' => 3,
    'user-agent' => 'toabai.media Wartungsampel',
  ]);

  if (!is_wp_error($sitemap_response) && wp_remote_retrieve_response_code($sitemap_response) === 200) {
    $results[] = tm_check_item(
      'Sitemap vorhanden',
      'good',
      'Eine sitemap.xml ist vorhanden.',
      'Sichtbarkeit',
      1,
      9,
      'ok',
      'Eine Sitemap hilft Suchmaschinen, Inhalte besser zu erfassen.',
      [
        'Geprüfte URL' => trailingslashit($base_url) . 'sitemap.xml',
        'HTTP Status' => '200',
      ]
    );
  } else {
    $results[] = tm_check_item(
      'Sitemap unklar',
      'warning',
      'Eine sitemap.xml wurde nicht direkt gefunden.',
      'Sichtbarkeit',
      1,
      5,
      'prüfen',
      'Die Sitemap sollte bei einer sauberen WordPress-Struktur geprüft werden.',
      [
        'Geprüfte URL' => trailingslashit($base_url) . 'sitemap.xml',
      ]
    );
  }

  usort($results, function($a, $b) {
    return $a['priority'] <=> $b['priority'];
  });

  return $results;
}

$website = tm_normalize_website_url($website);
$website_display = !empty($website) ? tm_shorten_url_middle($website, 50) : '';
$website_host = !empty($website) ? tm_get_host_from_url($website) : '';

if (!empty($website)) {
  $check_results = tm_run_website_check($website, $site_facts);
  $score_data = tm_score_results($check_results);

  $score_points = $score_data['score'];
  $risk_count = $score_data['risks'];
  $critical_count = $score_data['critical'];
  $warning_count = $score_data['warning'];

  $maintenance_percent = tm_get_maintenance_percent($score_points, $risk_count);
  $maintenance_level = tm_get_maintenance_level($score_points, $risk_count);

  $top_risks = array_values(array_filter($check_results, function($item) {
    return $item['status'] !== 'good';
  }));

  $visible_results = array_slice($top_risks, 0, 3);

  if (count($visible_results) < 3) {
    $visible_results = array_slice($check_results, 0, 3);
  }

  $hidden_results = array_slice($check_results, count($visible_results));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name  = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
  $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
  $site  = isset($_POST['website']) ? esc_url_raw($_POST['website']) : '';

  $to = 'info@toabai.media';
  $subject = 'Neue Wartungsampel Anfrage';

  $body  = "Name: $name\n";
  $body .= "E-Mail: $email\n";
  $body .= "Website: $site\n";
  $body .= "Wartungsbedarf: $maintenance_percent %\n";
  $body .= "Risiko-Level: $maintenance_level\n";
  $body .= "Hinweise: $risk_count\n";
  $body .= "Analysezeit: $scan_time\n";

  if (!empty($site_facts['redirect_detected'])) {
    $body .= "Weiterleitung: " . $site_facts['redirect_from'] . " → " . $site_facts['redirect_to'] . "\n";
    $body .= "Finale URL: " . $site_facts['final_url'] . "\n";
  }

  if (!empty($site_facts['plugins'])) {
    $body .= "Öffentlich erkannte Plugins: " . implode(', ', $site_facts['plugins']) . "\n";
  }

  if (!empty($site_facts['theme'])) {
    $body .= "Erkanntes Theme: " . $site_facts['theme'] . "\n";
  }

  $headers = ['Content-Type: text/plain; charset=UTF-8'];
  wp_mail($to, $subject, $body, $headers);

  $success = true;
}
?>

<section class="tm-check-single-hero tm-check-signal-hero">
  <div class="tm-container tm-check-single-wrap">

    <p class="tm-eyebrow">Kostenlose Wartungsampel</p>

    <h1>Wartungsampel für deine Website</h1>

    <?php if (!empty($website)) : ?>

      <div class="tm-checked-site-line">
        <span>Geprüft:</span>
        <strong title="<?php echo esc_attr($website); ?>">
          <?php echo esc_html($website_display); ?>
        </strong>
        <em>Analyse durchgeführt am <?php echo esc_html($scan_time); ?></em>
      </div>

      <?php if (!empty($site_facts['redirect_detected'])) : ?>
        <div class="tm-redirect-notice">
          <strong>Weiterleitung erkannt:</strong>
          <span>
            <?php echo esc_html($site_facts['redirect_from']); ?>
            →
            <?php echo esc_html($site_facts['redirect_to']); ?>
          </span>
        </div>
      <?php endif; ?>

      <div class="tm-action-report">

        <div class="tm-action-status tm-action-status-<?php echo esc_attr(tm_get_maintenance_status($score_points, $risk_count)); ?>">
          <div>
            <span>Status</span>
            <strong>Wartung empfohlen</strong>
            <p><?php echo esc_html($maintenance_percent); ?>% Wartungsbedarf · Risiko-Level: <?php echo esc_html($maintenance_level); ?></p>
          </div>

          <div class="tm-action-light">
            <i></i>
            <i></i>
            <i></i>
          </div>
        </div>

        <div class="tm-action-diagnosis">
          <p class="tm-evidence-label">Direkte Diagnose</p>
          <h2><?php echo esc_html(tm_get_report_headline($score_points, $risk_count)); ?></h2>
          <p><?php echo esc_html(tm_get_maintenance_text($score_points, $risk_count)); ?></p>
        </div>

        <div class="tm-action-kpis">
          <div class="tm-kpi-warning">
            <strong><?php echo esc_html($risk_count); ?></strong>
            <span>Hinweise</span>
          </div>

          <div class="tm-kpi-danger">
            <strong><?php echo esc_html($critical_count); ?></strong>
            <span>kritisch</span>
          </div>

          <div>
            <strong><?php echo esc_html(count($hidden_results)); ?></strong>
            <span>weitere Punkte</span>
          </div>
        </div>

        <?php if (!empty($visible_results)) : ?>
          <div class="tm-action-hints">
            <div class="tm-action-hints-head">
              <strong>Das solltest du dir ansehen lassen</strong>
              <span>öffentlich sichtbare Signale</span>
            </div>

            <div class="tm-action-hint-grid">
              <?php foreach ($visible_results as $result) : ?>
                <article class="tm-action-hint tm-action-hint-<?php echo esc_attr($result['status']); ?>">
                  <small><?php echo esc_html($result['category']); ?></small>
                  <h3><?php echo esc_html($result['label']); ?></h3>

                  <?php if (!empty($result['metric'])) : ?>
                    <em><?php echo esc_html($result['metric']); ?></em>
                  <?php endif; ?>

                  <p><?php echo esc_html($result['text']); ?></p>

                  <?php if (!empty($result['meaning'])) : ?>
                    <p class="tm-result-meaning">
                      <?php echo esc_html($result['meaning']); ?>
                    </p>
                  <?php endif; ?>

                  <?php if (!empty($result['tech']) && is_array($result['tech'])) : ?>
                    <details class="tm-tech-details">
                      <summary>Technische Details anzeigen</summary>
                      <div class="tm-tech-box">
                        <?php foreach ($result['tech'] as $tech_label => $tech_value) : ?>
                          <p>
                            <strong><?php echo esc_html($tech_label); ?>:</strong>
                            <span><?php echo esc_html($tech_value); ?></span>
                          </p>
                        <?php endforeach; ?>
                      </div>
                    </details>
                  <?php endif; ?>
                </article>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

        <details class="tm-single-details tm-action-details">
          <summary>Warum ich das so einschätze</summary>

          <div class="tm-single-details-content">

            <div class="tm-meaning-box">
              <p class="tm-evidence-label">Kurz erklärt</p>
              <p><?php echo esc_html(tm_get_meaning_text($score_points, $risk_count)); ?></p>
            </div>

            <div class="tm-site-evidence-box tm-site-evidence-box-v2">
              <p class="tm-evidence-label">Beweise aus deiner Website</p>

              <div class="tm-proof-grid">
                <div>
                  <strong>Eingegebene Domain</strong>
                  <span><?php echo esc_html($website_host); ?></span>
                </div>

                <div>
                  <strong>Final geprüft</strong>
                  <span><?php echo !empty($site_facts['final_host']) ? esc_html($site_facts['final_host']) : esc_html($website_host); ?></span>
                </div>

                <div>
                  <strong>Interne Links</strong>
                  <span><?php echo esc_html($site_facts['internal_link_count']); ?> erkannt</span>
                </div>

                <div>
                  <strong>Formulare</strong>
                  <span><?php echo esc_html($site_facts['form_count']); ?> erkannt</span>
                </div>
              </div>

              <?php if (!empty($site_facts['title'])) : ?>
                <div>
                  <strong>Seitentitel gefunden</strong>
                  <span><?php echo esc_html(tm_shorten_url_middle($site_facts['title'], 95)); ?></span>
                </div>
              <?php endif; ?>

              <?php if (!empty($site_facts['h1'])) : ?>
                <div>
                  <strong>Hauptüberschrift gefunden</strong>
                  <span><?php echo esc_html(tm_shorten_url_middle($site_facts['h1'], 95)); ?></span>
                </div>
              <?php endif; ?>

              <?php if (!empty($site_facts['theme'])) : ?>
                <div>
                  <strong>Erkanntes Theme</strong>
                  <span><?php echo esc_html($site_facts['theme']); ?></span>
                </div>
              <?php endif; ?>

              <?php if (!empty($site_facts['plugins'])) : ?>
                <div class="tm-plugin-box">
                  <strong>Öffentlich erkannte Plugins</strong>

                  <div class="tm-plugin-list">
                    <?php foreach ($site_facts['plugins'] as $plugin) : ?>
                      <span class="tm-plugin-badge"><?php echo esc_html($plugin); ?></span>
                    <?php endforeach; ?>
                  </div>

                  <small>
                    Diese Plugins wurden über öffentlich sichtbare Pfade erkannt. Versionen, Updates und Sicherheitsstatus sind von außen nicht vollständig sichtbar.
                  </small>
                </div>
              <?php endif; ?>

              <?php if (!empty($site_facts['external_services'])) : ?>
                <div>
                  <strong>Externe Dienste erkannt</strong>
                  <span><?php echo esc_html(implode(', ', $site_facts['external_services'])); ?></span>
                </div>
              <?php endif; ?>

              <?php if (!empty($site_facts['internal_links'])) : ?>
                <div class="tm-evidence-paths">
                  <strong>Gefundene Pfade auf der geprüften Website</strong>
                  <ul>
                    <?php foreach ($site_facts['internal_links'] as $path) : ?>
                      <li><?php echo esc_html($path); ?></li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              <?php endif; ?>
            </div>

          </div>
        </details>

      </div>

      <section class="tm-single-form-section">
        <div class="tm-check-hero-form-card tm-single-form-card tm-action-form-card">

          <?php if ($success): ?>

            <div class="tm-success-box">
              <h2>Danke!</h2>
              <p>Ich habe deine Anfrage erhalten und melde mich zeitnah bei dir.</p>
            </div>

          <?php else: ?>

            <p class="tm-form-label">Nächster Schritt</p>
            <h2>Wartungsbedarf persönlich einordnen lassen.</h2>

            <p><?php echo esc_html(tm_get_form_intro($score_points, $risk_count)); ?></p>

            <form method="post" class="tm-form tm-check-form">
              <input type="text" name="name" placeholder="Dein Name" required>
              <input type="email" name="email" placeholder="E-Mail" required>

              <input
                type="text"
                name="website"
                placeholder="deine-website.de"
                inputmode="url"
                autocomplete="url"
                value="<?php echo esc_attr($website); ?>"
                required
              >

              <p class="tm-form-micro">Dauert weniger als 30 Sekunden.</p>

              <button type="submit" class="tm-btn tm-btn-blue">
                Persönliche Einschätzung anfordern
              </button>

              <p class="tm-form-trust">Kein Spam. Keine Weitergabe deiner Daten.</p>
            </form>

          <?php endif; ?>

        </div>
      </section>

    <?php else : ?>

      <div class="tm-check-hero-form-card tm-report-form-card tm-report-form-card-alone">
        <p class="tm-form-label">Website eintragen</p>
        <h2>Wartungsampel starten.</h2>

        <form method="get" class="tm-form tm-check-form">
          <input
            type="text"
            name="website"
            placeholder="deine-website.de"
            inputmode="url"
            autocomplete="url"
            required
          >

          <button type="submit" class="tm-btn tm-btn-blue">
            Wartungsampel anzeigen
          </button>
        </form>
      </div>

    <?php endif; ?>

  </div>
</section>

<?php if (!empty($website)) : ?>
<section class="tm-single-backend-section">
  <div class="tm-container tm-check-single-wrap">
    <div class="tm-backend-limit-box tm-backend-limit-box-v2">
      <p class="tm-evidence-label">Was der Mini-Check nicht sehen kann</p>
      <h2>Die kritischsten Wartungspunkte liegen im Backend.</h2>
      <p>
        Eine Website kann von außen normal wirken, während im Hintergrund Updates offen sind,
        Backups nicht funktionieren oder Benutzerrechte unsauber vergeben sind.
      </p>

      <ul>
        <?php foreach ($backend_check_items as $item) : ?>
          <li><?php echo esc_html($item); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="tm-check-benefits tm-single-benefits">
  <div class="tm-container tm-center">
    <h2>Warum du nicht warten solltest</h2>

    <div class="tm-check-grid">
      <div>
        <strong>Veraltete Plugins</strong>
        <span>Können Sicherheitslücken öffnen, ohne dass du es sofort bemerkst.</span>
      </div>

      <div>
        <strong>Kontaktformulare</strong>
        <span>Können ausfallen, während du denkst, es kommt nur gerade niemand.</span>
      </div>

      <div>
        <strong>Backups & Updates</strong>
        <span>Sind oft erst dann wichtig, wenn die Website plötzlich nicht mehr läuft.</span>
      </div>
    </div>
  </div>
</section>

<section class="tm-check-form-section tm-check-form-section-secondary">
  <div class="tm-container">
    <div class="tm-check-form-head">
      <p class="tm-eyebrow">Wartung statt Rätselraten</p>
      <h2>Die Ampel ist nur der Einstieg.</h2>
      <p>
        Entscheidend ist nicht nur, was von außen sichtbar ist.
        Entscheidend ist, ob deine Website im Hintergrund sauber gepflegt, gesichert und betreut wird.
      </p>
    </div>
  </div>
</section>

</main>

<?php get_footer(); ?>