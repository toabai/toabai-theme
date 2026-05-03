<footer class="site-footer">
  <div class="tm-container tm-footer-inner">

    <div class="tm-footer-brand">
      <a class="tm-logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="toabai.media Startseite">
        <span class="tm-logo-main">toabai</span><span class="tm-logo-dot">.</span><span class="tm-logo-sub">media</span>
      </a>

      <p>
        WordPress Wartung, Betreuung und Websites, die langfristig funktionieren.
      </p>

      <a class="tm-footer-cta" href="/kontakt/">Website prüfen lassen</a>
    </div>

    <div class="tm-footer-grid">

      <div>
        <strong>Leistungen</strong>
        <ul>
          <li><a href="/wartung-betreuung/">Wartung & Betreuung</a></li>
          <li><a href="/website-erstellen/">Website erstellen lassen</a></li>
        </ul>
      </div>

      <div>
        <strong>Wissen</strong>
        <ul>
          <li><a href="/wissen/">Wissen & Ratgeber</a></li>
          <li><a href="/wissen/wordpress-wartung-kosten/">WordPress Wartung Kosten</a></li>
          <li><a href="/wissen/wordpress-updates/">WordPress Updates</a></li>
          <li><a href="/wissen/website-gehackt/">Website gehackt?</a></li>
        </ul>
      </div>

      <div>
        <strong>toabai.media</strong>
        <ul>
          <li><a href="/referenzen/">Referenzen</a></li>
          <li><a href="/ueber-mich/">Über mich</a></li>
          <li><a href="/kontakt/">Kontakt</a></li>
		  <li><a href="https://cloud.toabai.media">Cloud</a></li>	
        </ul>
      </div>

      <div>
        <strong>Rechtliches</strong>
        <ul>
          <li><a href="/impressum/">Impressum</a></li>
          <li><a href="/datenschutz/">Datenschutz</a></li>
		  <li><a href="/datenschutz/">AGB</a></li>
        </ul>
      </div>

    </div>

    <div class="tm-footer-bottom">
      <span>© <?php echo date('Y'); ?> toabai.media</span>
    </div>

  </div>
</footer>


<?php if (is_front_page()) : ?>

<!-- =========================
     Schema.org (SEO + KI)
========================= -->

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ProfessionalService",
  "name": "toabai.media",
  "url": "https://toabai.media",
  "description": "WordPress Wartung, Betreuung und Website Erstellung.",
  "areaServed": {
    "@type": "Country",
    "name": "Deutschland"
  },
  "serviceType": [
    "WordPress Wartung",
    "WordPress Betreuung",
    "Website Erstellung"
  ],
  "offers": {
    "@type": "Offer",
    "price": "29",
    "priceCurrency": "EUR"
  }
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "Was kostet WordPress Wartung?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Die WordPress Wartung beginnt ab 29 Euro pro Monat."
      }
    },
    {
      "@type": "Question",
      "name": "Was ist in der Wartung enthalten?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Updates, Backups, Sicherheitsüberwachung und technische Betreuung."
      }
    }
  ]
}
</script>

<?php endif; ?>


<?php wp_footer(); ?>

<script id="reveal-animation">
document.addEventListener("DOMContentLoaded", function () {

  const items = document.querySelectorAll('.tm-reveal');

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
      }
    });
  }, {
    threshold: 0.15
  });

  items.forEach(item => observer.observe(item));

});
</script>
</body>
</html>