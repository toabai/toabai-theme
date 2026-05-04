<?php get_header(); ?>

<main id="content" class="toabai-home toabai-home-v2">

  <!-- HERO -->
  <section class="tm-start-hero">
    <div class="tm-container tm-start-hero-grid">

      <div class="tm-start-hero-content">
        <p class="tm-eyebrow">WordPress Wartung & Betreuung</p>

        <h1>Deine Website funktioniert. Bis sie es plötzlich nicht mehr tut.</h1>

        <p class="tm-start-hero-text">
          Updates, Sicherheit und Backups werden oft erst dann wichtig, wenn etwas nicht mehr funktioniert. Ich kümmere mich darum, bevor aus kleinen Problemen echte Risiken werden.
        </p>

        <ul class="tm-start-trust-list">
          <li>Persönliche Betreuung</li>
          <li>Regelmäßige Wartung</li>
          <li>Klare Rückmeldung</li>
        </ul>
      </div>

      <form class="tm-start-form-card tm-website-check-card" action="<?php echo esc_url(home_url('/kontakt/')); ?>" method="get">
  <p class="tm-form-label">Kostenlose Erstprüfung</p>

  <h2>Website prüfen lassen</h2>

  <p>
    Gib deine Website ein. Ich schaue sie mir an und gebe dir eine ehrliche Einschätzung.
  </p>

  <div class="tm-website-check-field">
    <input
      type="url"
      name="website"
      placeholder="https://deine-website.de"
      required
    >
    <button class="tm-btn tm-btn-blue" type="submit">
      Prüfen lassen
    </button>
  </div>

  <small>Keine automatische Fantasie-Auswertung. Du bekommst eine echte persönliche Einschätzung.</small>
</form>

    </div>
  </section>

<!-- DANGER -->
<section class="tm-start-danger-check">
  <div class="tm-container">

    <div class="tm-danger-simple">
      <p class="tm-eyebrow">Das Risiko</p>

      <h2>Kleine Fehler. Große Folgen.</h2>

      <p class="tm-section-text">
        Eine WordPress-Website läuft oft lange unauffällig. Bis ein Update scheitert,
        ein Plugin zur Sicherheitslücke wird oder wichtige Anfragen nicht mehr ankommen.
      </p>

      <div class="tm-danger-grid">

        <div>
          <div class="tm-icon tm-icon-danger">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M6 18L18 6"></path>
              <path d="M6 6l12 12"></path>
            </svg>
          </div>
          <strong>Website plötzlich offline</strong>
          <span>Nach einem Update, Plugin-Fehler oder Serverproblem.</span>
        </div>

        <div>
          <div class="tm-icon tm-icon-danger">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M12 2l7 4v6c0 5-3.5 9-7 10-3.5-1-7-5-7-10V6l7-4z"></path>
              <path d="M9 12l2 2 4-5"></path>
            </svg>
          </div>
          <strong>Hackerangriff oder Malware</strong>
          <span>Veraltete Plugins können zur offenen Tür werden.</span>
        </div>

        <div>
          <div class="tm-icon tm-icon-danger">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M21 15a4 4 0 0 1-4 4H7l-4 3V5a2 2 0 0 1 2-2h10a4 4 0 0 1 4 4z"></path>
            </svg>
          </div>
          <strong>Kontaktformular fällt aus</strong>
          <span>Anfragen gehen verloren, ohne dass du es bemerkst.</span>
        </div>

        <div>
          <div class="tm-icon tm-icon-danger">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M13 2L3 14h8l-1 8 11-13h-8l1-7z"></path>
            </svg>
          </div>
          <strong>Website macht keinen guten Eindruck</strong>
          <span>Fehler, alte Inhalte oder kleine Probleme wirken unprofessionell.</span>
        </div>

      </div>

      <a class="tm-btn tm-btn-blue"  href="<?php echo esc_url(home_url('/kontakt/')); ?>">Website jetzt prüfen lassen</a>
    </div>

  </div>
</section>


  <!-- PROBLEM -->
  <section class="tm-start-problem">
    <div class="tm-container">

      <div class="tm-start-section-head">
        <p class="tm-eyebrow tm-center">Warum Wartung wichtig ist</p>

        <h2 class="tm-center">
          Deine Website braucht Aufmerksamkeit.
          Auch wenn sie gerade funktioniert.
        </h2>

        <p class="tm-section-text">
          WordPress, Plugins, Themes und Sicherheitsstandards verändern sich ständig.
          Ohne regelmäßige Pflege steigt das Risiko mit jedem Monat.
        </p>
      </div>

      <div class="tm-start-card-grid tm-start-card-grid-3">

        <article class="tm-start-card">
          <div class="tm-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M21 12a9 9 0 1 1-3-6.7"></path>
              <path d="M21 3v6h-6"></path>
            </svg>
          </div>
          <h3>Updates bleiben liegen</h3>
          <p>Veraltete Plugins führen zu Fehlern, Sicherheitslücken und Kompatibilitätsproblemen.</p>
        </article>

        <article class="tm-start-card">
          <div class="tm-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M12 2l7 4v6c0 5-3.5 9-7 10-3.5-1-7-5-7-10V6l7-4z"></path>
              <path d="M9 12l2 2 4-5"></path>
            </svg>
          </div>
          <h3>Sicherheitsrisiken entstehen</h3>
          <p>Angriffe, Spam und Schadcode werden wahrscheinlicher, wenn niemand regelmäßig hinschaut.</p>
        </article>

        <article class="tm-start-card">
          <div class="tm-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M13 2L3 14h8l-1 8 11-13h-8l1-7z"></path>
            </svg>
          </div>
          <h3>Vertrauen geht verloren</h3>
          <p>Technische Fehler, veraltete Inhalte und Ausfälle wirken unprofessionell.</p>
        </article>

      </div>

    </div>
  </section>


  <!-- LÖSUNG -->
  <section class="tm-start-maintenance">
    <div class="tm-container tm-start-maintenance-grid">

      <div>
        <p class="tm-eyebrow">Die Lösung</p>

        <h2>
          Ich kümmere mich um deine Website.
          Technisch, zuverlässig und langfristig.
        </h2>

        <p>
          Wartung ist kein Extra. Sie sorgt dafür, dass deine Website sicher, aktuell und stabil bleibt.
          Auf Wunsch übernehme ich auch regelmäßige Inhalte und kleine Änderungen.
        </p>

<div class="tm-cta-block">

  <a class="tm-btn tm-btn-blue" href="<?php echo esc_url(home_url('/kontakt/')); ?>">
    Website prüfen lassen
  </a>

  <span class="tm-cta-micro">
    Ich schaue mir deine Website an und sage dir ehrlich, wo du stehst.
  </span>

  <span class="tm-cta-process">
    Kurze Einschätzung. Kein Technik-Blabla.
  </span>

</div>
      </div>

      <div class="tm-start-maintenance-panel">

  <div>
    <div class="tm-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path d="M21 12a9 9 0 1 1-3-6.7"></path>
        <path d="M21 3v6h-6"></path>
      </svg>
    </div>
    <strong>Updates</strong>
    <span>WordPress, Plugins und Themes werden regelmäßig gepflegt.</span>
  </div>

  <div>
    <div class="tm-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path d="M12 2l7 4v6c0 5-3.5 9-7 10-3.5-1-7-5-7-10V6l7-4z"></path>
        <path d="M9 12l2 2 4-5"></path>
      </svg>
    </div>
    <strong>Sicherheit</strong>
    <span>Risiken werden früh erkannt und technische Schwachstellen reduziert.</span>
  </div>

  <div>
    <div class="tm-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <ellipse cx="12" cy="6" rx="8" ry="3"></ellipse>
        <path d="M4 6v6c0 1.7 3.6 3 8 3s8-1.3 8-3V6"></path>
        <path d="M4 12v6c0 1.7 3.6 3 8 3s8-1.3 8-3v-6"></path>
      </svg>
    </div>
    <strong>Backups</strong>
    <span>Deine Website ist gesichert und bei Problemen wiederherstellbar.</span>
  </div>
<!--
  <div>
    <div class="tm-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path d="M13 2L3 14h8l-1 8 11-13h-8l1-7z"></path>
      </svg>
    </div>
    <strong>Performance</strong>
    <span>Technische Pflege für schnelle Ladezeiten und stabile Nutzung.</span>
  </div>
-->
  <div>
    <div class="tm-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path d="M4 19.5V5a2 2 0 0 1 2-2h9l5 5v11.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 4 19.5z"></path>
        <path d="M14 3v6h6"></path>
        <path d="M8 13h8"></path>
        <path d="M8 17h6"></path>
      </svg>
    </div>
    <strong>Inhalte & Pflege</strong>
    <span>Auf Wunsch pflege ich neue Inhalte, kleine Änderungen und regelmäßige Aktualisierungen ein.</span>
  </div>

</div>

    </div>
  </section>

	<!-- WARUM / PERSON -->
<section class="tm-start-why">
  <div class="tm-container tm-start-image-grid">

    <div class="tm-start-image-wrap">
      <img src="/wp-content/uploads/toabai-portrait-optimized.webp" alt="Tobias Öllinger – toabai.media">

      <div class="tm-start-image-badge">
        <strong>Direkter Ansprechpartner</strong>
        <span>Du sprichst direkt mit mir. Kein Ticketsystem.</span>
      </div>
    </div>

    <div class="tm-start-text-block">
      <p class="tm-eyebrow">Warum toabai.media?</p>

      <h2>Wartung ist Vertrauenssache.</h2>

      <p>
        Du gibst die technische Verantwortung ab.
        Deshalb brauchst du jemanden, der zuverlässig arbeitet,
        mitdenkt und sich kümmert.
      </p>

      <div class="tm-start-mini-list">

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
          <span>Wartung ist Teil der Strategie, nicht nur Technik.</span>
        </div>

      </div>

    </div>

  </div>
</section>

  <!-- CTA -->
  <section class="tm-start-final">
    <div class="tm-container">
      <div class="tm-start-final-box">
        <p class="tm-eyebrow">Bereit?</p>
        <h2>Finde heraus, wie gut deine Website wirklich gepflegt ist.</h2>
        <p>Ich prüfe deine Website und gebe dir eine ehrliche Einschätzung.</p>
        <a class="tm-btn tm-btn-blue" href="<?php echo esc_url(home_url('/kontakt/')); ?>">Website prüfen lassen</a>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>