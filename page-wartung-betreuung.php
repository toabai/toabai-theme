<?php
/**
 * Template Name: Wartung & Betreuung
 */
get_header();
?>

<main id="content" class="toabai-page wartung-page wartung-page-v2">

  <!-- HERO -->
  <section class="tw-hero">
    <div class="tm-container tw-hero-grid">

      <div class="tw-hero-content">
        <p class="tm-eyebrow">WordPress Wartung & Betreuung</p>

        <h1>Deine Website funktioniert. Und bleibt betreut.</h1>

        <p class="tw-hero-text">
          Ich kümmere mich um Updates, Sicherheit, Backups und laufende Pflege deiner WordPress-Website.
          Damit kleine technische Probleme nicht zu echten Ausfällen werden.
        </p>

        <div class="tm-actions">
          <a class="tm-btn tm-btn-blue" href="<?php echo esc_url(home_url('/kontakt/')); ?>">Website prüfen lassen</a>
          <a class="tm-btn tm-btn-light" href="#paket">Wartung ansehen</a>
        </div>

        <ul class="tw-trust-list">
          <li>Persönliche Betreuung</li>
          <li>Regelmäßige Updates</li>
          <li>Klare Rückmeldung</li>
        </ul>
      </div>

      <div class="tw-status-card">
        <p class="tw-status-label">Wartungsstatus</p>

        <div class="tw-status-main">
          <span></span>
          <strong>Aktiv betreut</strong>
        </div>

        <div class="tw-status-list">
          <div><span>WordPress</span><strong>aktuell</strong></div>
          <div><span>Plugins</span><strong>geprüft</strong></div>
          <div><span>Backups</span><strong>aktiv</strong></div>
          <div><span>Sicherheit</span><strong>überwacht</strong></div>
        </div>

        <p class="tw-status-note">Persönlich betreut durch toabai.media</p>
      </div>

    </div>
  </section>


  <!-- RISIKO -->
  <section class="tw-risk">
    <div class="tm-container">

      <div class="tw-section-head tw-section-head-light">
        <p class="tm-eyebrow">Das Risiko</p>
        <h2>Kleine Fehler. Große Folgen.</h2>
        <p>
          Eine WordPress-Website läuft oft lange unauffällig. Bis ein Update scheitert,
          ein Plugin zur Sicherheitslücke wird oder wichtige Anfragen nicht mehr ankommen.
        </p>
      </div>

<div class="tw-risk-grid">

  <div>
    <div class="tw-risk-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path d="M12 9v4"></path>
        <path d="M12 17h.01"></path>
        <path d="M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0z"></path>
      </svg>
    </div>
    <strong>Website plötzlich offline</strong>
    <p>Nach einem Update, Plugin-Fehler oder Serverproblem.</p>
  </div>

  <div>
    <div class="tw-risk-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path d="M12 2l7 4v6c0 5-3.5 9-7 10-3.5-1-7-5-7-10V6l7-4z"></path>
        <path d="M9.5 12.5 11 14l3.5-4"></path>
      </svg>
    </div>
    <strong>Hackerangriff oder Malware</strong>
    <p>Veraltete Plugins können zur offenen Tür werden.</p>
  </div>

  <div>
    <div class="tw-risk-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path d="M4 4h16v16H4z"></path>
        <path d="m4 7 8 6 8-6"></path>
        <path d="M9 17h6"></path>
      </svg>
    </div>
    <strong>Kontaktformular fällt aus</strong>
    <p>Anfragen gehen verloren, ohne dass du es bemerkst.</p>
  </div>

  <div>
    <div class="tw-risk-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path d="M13 2 4 14h7l-1 8 10-13h-7l1-7z"></path>
      </svg>
    </div>
    <strong>Vertrauen geht verloren</strong>
    <p>Fehler, alte Inhalte oder technische Probleme wirken unprofessionell.</p>
  </div>

</div>

      <div class="tw-center">
        <a class="tm-btn tm-btn-blue" href="<?php echo esc_url(home_url('/kontakt/')); ?>">Website prüfen lassen</a>
      </div>

    </div>
  </section>


  <!-- LÖSUNG -->
  <section id="leistungen" class="tw-solution">
    <div class="tm-container tw-solution-grid">

      <div>
        <p class="tm-eyebrow">Die Lösung</p>

        <h2>Ich kümmere mich um deine Website. Technisch, zuverlässig und langfristig.</h2>

        <p>
          Wartung sorgt dafür, dass deine Website aktuell bleibt, Risiken reduziert werden
          und du bei Problemen nicht alleine dastehst.
        </p>

        <a class="tm-btn tm-btn-blue" href="<?php echo esc_url(home_url('/kontakt/')); ?>">Kostenlose Einschätzung erhalten</a>

        <p class="tw-micro">
          Ich schaue mir deine Website an und sage dir ehrlich, wo du stehst.
        </p>
      </div>

      <div class="tw-feature-panel">
        <div>
          <strong>Updates</strong>
          <span>WordPress, Plugins und Themes werden regelmäßig gepflegt.</span>
        </div>

        <div>
          <strong>Sicherheit</strong>
          <span>Risiken werden früh erkannt und technische Schwachstellen reduziert.</span>
        </div>

        <div>
          <strong>Backups</strong>
          <span>Deine Website ist gesichert und wiederherstellbar.</span>
        </div>

        <div>
          <strong>Inhalte & Pflege</strong>
          <span>Auf Wunsch pflege ich neue Inhalte und kleine Änderungen ein.</span>
        </div>
      </div>

    </div>
  </section>


  <!-- ABLAUF -->
  <section class="tw-process">
    <div class="tm-container">

      <div class="tw-section-head">
        <p class="tm-eyebrow">Ablauf</p>
        <h2>So läuft die Wartung ab</h2>
        <p>Ein klarer Prozess statt technisches Rätselraten.</p>
      </div>

      <div class="tw-process-grid">
        <div>
          <span>01</span>
          <strong>Prüfung</strong>
          <p>Ich schaue mir deine Website und den aktuellen Zustand an.</p>
        </div>

        <div>
          <span>02</span>
          <strong>Absicherung</strong>
          <p>Backups, Updates und Sicherheit werden sauber aufgesetzt.</p>
        </div>

        <div>
          <span>03</span>
          <strong>Betreuung</strong>
          <p>Die laufende Pflege passiert regelmäßig im Hintergrund.</p>
        </div>

        <div>
          <span>04</span>
          <strong>Rückmeldung</strong>
          <p>Du bekommst klare Informationen statt Technik-Blabla.</p>
        </div>
      </div>

    </div>
  </section>


  <!-- ÜBERNAHME -->
  <section class="tw-takeover">
    <div class="tm-container tw-takeover-box">

      <div>
        <p class="tm-eyebrow">Übernahme</p>

        <h2>Ich übernehme auch bestehende WordPress-Websites.</h2>

        <p>
          Egal ob deine Website selbst erstellt wurde, von einer Agentur stammt oder mit einem Page Builder aufgebaut ist.
          Ich prüfe den Zustand und setze die Betreuung sauber auf.
        </p>
      </div>

      <ul class="tm-check-list">
        <li>Bestehende Website analysieren</li>
        <li>Probleme und Risiken erkennen</li>
        <li>Wartung sauber aufsetzen</li>
        <li>Langfristige Betreuung sicherstellen</li>
      </ul>

    </div>
  </section>


  <!-- PAKET -->
  <section id="paket" class="tw-package">
    <div class="tm-container tw-package-grid">

      <div>
        <p class="tm-eyebrow">Wartungsvertrag</p>

        <h2>Wartung ab 29 € im Monat.</h2>

        <p>
          Ein klarer Einstieg für WordPress-Websites, die regelmäßig gepflegt und technisch betreut werden sollen.
        </p>

        <p class="tw-package-note">
          Der genaue Umfang hängt von deiner Website ab. Ich sage dir ehrlich, was sinnvoll ist.
        </p>
      </div>

      <div class="tw-price-card">
        <p class="tw-price-label">Basis-Wartung</p>

        <div class="tw-price">
          <span>ab</span>
          <strong>29 €</strong>
          <em>/ Monat</em>
        </div>

        <ul>
          <li>WordPress Updates</li>
          <li>Plugin-Updates</li>
          <li>Backup-Kontrolle</li>
          <li>Sicherheitsprüfung</li>
          <li>Persönlicher Ansprechpartner</li>
        </ul>

        <a class="tm-btn tm-btn-blue" href="<?php echo esc_url(home_url('/kontakt/')); ?>">Wartung anfragen</a>

        <small>Transparent. Persönlich. Ohne unnötige Komplexität.</small>
      </div>

    </div>
  </section>


  <!-- VERTRAUEN -->
  <section class="tw-trust">
    <div class="tm-container tw-trust-grid">

      <div class="tw-trust-image">
        <img src="/wp-content/uploads/toabai-portrait-optimized.webp" alt="Tobias Öllinger von toabai.media">
        <div>
          <strong>Direkter Ansprechpartner</strong>
          <span>Du sprichst direkt mit mir. Kein Ticketsystem.</span>
        </div>
      </div>

      <div>
        <p class="tm-eyebrow">Warum toabai.media?</p>

        <h2>Wartung ist Vertrauenssache.</h2>

        <p>
          Du gibst die technische Verantwortung ab. Deshalb brauchst du jemanden,
          der zuverlässig arbeitet, mitdenkt und klar kommuniziert.
        </p>

        <div class="tw-mini-list">
          <div>
            <strong>Persönlich</strong>
            <span>Direkter Kontakt statt Support-System.</span>
          </div>

          <div>
            <strong>Strukturiert</strong>
            <span>Klare Prozesse und regelmäßige Pflege.</span>
          </div>

          <div>
            <strong>Langfristig</strong>
            <span>Wartung als laufende Betreuung, nicht als Einzelaufgabe.</span>
          </div>
        </div>
      </div>

    </div>
  </section>


  <!-- FAQ -->
  <section class="tw-faq">
    <div class="tm-container">

      <div class="tw-section-head">
        <p class="tm-eyebrow">Häufige Fragen</p>
        <h2>Fragen zur WordPress Wartung</h2>
      </div>

      <div class="tw-faq-list">
        <details open>
          <summary>Was kostet WordPress Wartung?</summary>
          <p>Die Wartung beginnt ab 29 € pro Monat. Der genaue Preis hängt vom Umfang deiner Website ab.</p>
        </details>

        <details>
          <summary>Was ist in der Wartung enthalten?</summary>
          <p>Regelmäßige Updates, Backup-Kontrolle, Sicherheitsprüfung und persönliche Betreuung.</p>
        </details>

        <details>
          <summary>Übernimmst du bestehende WordPress-Websites?</summary>
          <p>Ja. Ich übernehme auch bestehende Websites und setze die Wartung sauber auf.</p>
        </details>
      </div>

    </div>
  </section>


  <!-- FINAL CTA -->
  <section class="tw-final">
    <div class="tm-container tw-final-box">

      <p class="tm-eyebrow">Kostenlose Ersteinschätzung</p>

      <h2>Finde heraus, wie gut deine Website wirklich gepflegt ist.</h2>

      <p>
        Ich prüfe deine Website und gebe dir eine ehrliche Einschätzung.
      </p>

      <a class="tm-btn tm-btn-blue" href="<?php echo esc_url(home_url('/kontakt/')); ?>">Website prüfen lassen</a>

    </div>
  </section>

</main>

<?php get_footer(); ?>