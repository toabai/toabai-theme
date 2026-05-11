<?php get_header(); ?>

<main id="content" class="toabai-home toabai-home-v2">

  <!-- HERO -->
  <section class="tm-start-hero">
    <div class="tm-container tm-start-hero-grid">

      <div class="tm-start-hero-content">
        <p class="tm-eyebrow">WordPress Wartung & Betreuung</p>

        <h1>Deine Website funktioniert. Bis sie es plötzlich nicht mehr tut.</h1>

        <p class="tm-start-hero-text">
          Der kostenlose Mini-Check prüft öffentlich sichtbare Signale deiner Website und zeigt dir,
          ob Wartungsbedarf besteht. Verständlich, ehrlich und ohne Technik-Blabla.
        </p>

        <ul class="tm-start-trust-list">
          <li>Echter Mini-Check</li>
          <li>Öffentlich sichtbare Risiken</li>
          <li>Klare Wartungsampel</li>
        </ul>
      </div>

      <form class="tm-start-form-card tm-website-check-card tm-check-form" action="<?php echo esc_url(home_url('/website-pruefen/')); ?>" method="get">
        <p class="tm-form-label">Kostenlose Wartungsampel</p>

        <h2>Website prüfen lassen</h2>

        <p>
          Gib deine Website ein. Der Mini-Check prüft erreichbare Signale wie SSL,
          Ladezeit, WordPress-Hinweise, sichtbare Plugins, Sicherheitsheader und SEO-Basics.
        </p>

        <ul class="tm-check-list">
          <li>Erste technische Einschätzung</li>
          <li>Konkrete Hinweise statt Bauchgefühl</li>
          <li>Persönliche Einordnung auf Wunsch</li>
        </ul>

        <div class="tm-website-check-field">
          <input
            type="text"
            name="website"
            placeholder="deine-website.de"
            inputmode="url"
            autocomplete="url"
            required
          >

          <button class="tm-btn tm-btn-blue" type="submit">
            Prüfen lassen
          </button>
        </div>

        <small>
          Der Check prüft öffentlich sichtbare Signale. Backend, Updates und Backups werden anschließend persönlich eingeordnet.
        </small>
      </form>

    </div>
  </section>

  <!-- RISIKO -->
  <section class="tm-start-danger-check">
    <div class="tm-container">

      <div class="tm-danger-simple">
        <p class="tm-eyebrow">Warum Wartung wichtig ist</p>

        <h2>Kleine technische Probleme werden oft erst sichtbar, wenn sie Kunden kosten.</h2>

        <p class="tm-section-text">
          Eine WordPress-Website kann lange unauffällig laufen. Trotzdem können im Hintergrund
          Updates offen sein, Sicherheitsrisiken entstehen oder wichtige Funktionen ausfallen.
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
            <span>Updates, Plugin-Fehler oder Serverprobleme können eine Website lahmlegen.</span>
          </div>

          <div>
            <div class="tm-icon tm-icon-danger">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M12 2l7 4v6c0 5-3.5 9-7 10-3.5-1-7-5-7-10V6l7-4z"></path>
                <path d="M9 12l2 2 4-5"></path>
              </svg>
            </div>
            <strong>Sicherheitsrisiken</strong>
            <span>Veraltete Plugins und offene Standardzugänge können zur Schwachstelle werden.</span>
          </div>

          <div>
            <div class="tm-icon tm-icon-danger">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M21 15a4 4 0 0 1-4 4H7l-4 3V5a2 2 0 0 1 2-2h10a4 4 0 0 1 4 4z"></path>
              </svg>
            </div>
            <strong>Anfragen gehen verloren</strong>
            <span>Kontaktformulare können ausfallen, ohne dass du es sofort bemerkst.</span>
          </div>

          <div>
            <div class="tm-icon tm-icon-danger">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M13 2L3 14h8l-1 8 11-13h-8l1-7z"></path>
              </svg>
            </div>
            <strong>Vertrauen leidet</strong>
            <span>Fehler, langsame Ladezeiten oder Warnmeldungen wirken schnell unprofessionell.</span>
          </div>

        </div>

        <a class="tm-btn tm-btn-blue" href="<?php echo esc_url(home_url('/website-pruefen/')); ?>">
          Wartungsampel starten
        </a>
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
          Wartung sorgt dafür, dass deine Website aktuell, sicher und stabil bleibt.
          Ich prüfe Updates, Sicherheit, Backups und die wichtigsten Funktionen.
          Auf Wunsch übernehme ich auch Inhalte und kleinere Anpassungen.
        </p>

        <div class="tm-cta-block">
          <a class="tm-btn tm-btn-blue" href="<?php echo esc_url(home_url('/website-pruefen/')); ?>">
            Website prüfen lassen
          </a>

          <span class="tm-cta-micro">
            Erst Mini-Check. Danach persönliche Einordnung.
          </span>

          <span class="tm-cta-process">
            Klar, verständlich und ohne unnötige Fachsprache.
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
          Du gibst die technische Verantwortung für deine Website ab.
          Deshalb brauchst du jemanden, der zuverlässig arbeitet,
          mitdenkt und dir klar sagt, was wirklich wichtig ist.
        </p>

        <div class="tm-start-mini-list">

          <div>
            <strong>Persönlich</strong>
            <span>Direkter Kontakt statt anonymem Support-System.</span>
          </div>

          <div>
            <strong>Strukturiert</strong>
            <span>Klare Prozesse, regelmäßige Pflege und verständliche Rückmeldung.</span>
          </div>

          <div>
            <strong>Langfristig</strong>
            <span>Wartung ist Teil der Website-Strategie, nicht nur technische Pflicht.</span>
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
        <h2>Starte mit der Wartungsampel.</h2>
        <p>Der Mini-Check zeigt dir erste öffentlich sichtbare Hinweise und führt dich zur persönlichen Einschätzung.</p>
        <a class="tm-btn tm-btn-blue" href="<?php echo esc_url(home_url('/website-pruefen/')); ?>">
          Website prüfen lassen
        </a>
      </div>
    </div>
  </section>

</main>

<div class="tm-scan-loader" id="tmScanLoader" aria-hidden="true">
  <div class="tm-scan-loader-inner">

    <div class="tm-scan-step">
      Website wird geprüft
    </div>

    <p class="tm-scan-note">
      Bitte kurz warten. Die Wartungsampel wird vorbereitet.
    </p>

    <div class="tm-scan-dots">
      <i></i><i></i><i></i><i></i><i></i>
    </div>

    <div class="tm-scan-brand">
      Mini-Check durch <strong>toabai.media</strong>
    </div>

  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const forms = document.querySelectorAll('.tm-check-form, .tm-website-check-card, form[action*="website-pruefen"]');

  const steps = [
    'Website wird geladen',
    'Weiterleitungen werden verfolgt',
    'Antwortzeit wird gemessen',
    'SSL wird geprüft',
    'WordPress-Signale werden gesucht',
    'Sicherheitsheader werden analysiert',
    'Wartungsampel wird vorbereitet'
  ];

  function normalizeWebsiteInput(value) {
    let url = value.trim();

    url = url.replace(/\s+/g, '');
    url = url.replace(/^https?:\/\//i, '');
    url = url.replace(/\/+$/g, '');

    if (url && !url.includes('.')) {
      url = url + '.de';
    }

    return 'https://' + url;
  }

  forms.forEach(function(form) {
    form.addEventListener('submit', function() {
      const websiteInput = form.querySelector('input[name="website"]');

      if (websiteInput && websiteInput.value.trim() !== '') {
        websiteInput.value = normalizeWebsiteInput(websiteInput.value);
      }

      const loader = document.getElementById('tmScanLoader');
      const stepEl = document.querySelector('.tm-scan-step');

      if (loader) {
        loader.classList.add('is-visible');
        loader.setAttribute('aria-hidden', 'false');
      }

      if (stepEl) {
        let i = 0;
        stepEl.textContent = steps[i];

        setInterval(function () {
          i = (i + 1) % steps.length;
          stepEl.textContent = steps[i];
        }, 750);
      }
    });
  });
});
</script>

<?php get_footer(); ?>