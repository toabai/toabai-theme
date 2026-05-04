<?php get_header(); ?>

<main id="content" class="toabai-page website-check-page">

<?php
$website = isset($_GET['website']) ? esc_url($_GET['website']) : '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name    = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
  $email   = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
  $site    = isset($_POST['website']) ? esc_url_raw($_POST['website']) : '';
  $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';

  $to = 'info@toabai.media';
  $subject = 'Neue Website-Prüfung Anfrage';

  $body  = "Name: $name\n";
  $body .= "E-Mail: $email\n";
  $body .= "Website: $site\n\n";
  $body .= "Nachricht:\n$message";

  $headers = ['Content-Type: text/plain; charset=UTF-8'];

  wp_mail($to, $subject, $body, $headers);

  $success = true;
}
?>

<section class="tm-contact-hero">
  <div class="tm-container tm-contact-centered">
    <p class="tm-eyebrow">Kostenlose Erstprüfung</p>
    <h1>Website prüfen lassen</h1>

    <p>
      Du bekommst eine klare Einschätzung: Welche Probleme bestehen,
      wo Risiken liegen und was konkret verbessert werden sollte.
    </p>

    <p class="tm-proof">
      Bereits zahlreiche Websites geprüft. Persönlich, direkt und ohne automatisierte Tools.
    </p>
  </div>
</section>

<section class="tm-check-benefits">
  <div class="tm-container tm-center">
    <h2>Was du von mir bekommst</h2>

    <div class="tm-check-grid">
      <div>
        <strong>Technische Analyse</strong>
        <span>Ich prüfe Updates, Plugins, Sicherheit und grundlegende Struktur.</span>
      </div>

      <div>
        <strong>Konkrete Probleme</strong>
        <span>Du erfährst, wo aktuell Risiken oder Fehler bestehen.</span>
      </div>

      <div>
        <strong>Klare Empfehlung</strong>
        <span>Ich sage dir ehrlich, ob Handlungsbedarf besteht oder alles passt.</span>
      </div>
    </div>
  </div>
</section>

<section class="tm-check-form-section">
  <div class="tm-container">

    <?php if ($success): ?>

      <div class="tm-success-box">
        <h2>Danke!</h2>
        <p>Ich habe deine Anfrage erhalten und melde mich zeitnah bei dir.</p>
      </div>

    <?php else: ?>

      <?php if (!empty($website)) : ?>
        <div class="tm-check-confirm">
          <p>Du möchtest diese Website prüfen lassen:</p>
          <strong><?php echo esc_html($website); ?></strong>
        </div>
      <?php endif; ?>

      <p class="tm-form-intro">
        Trage deine Daten ein und ich melde mich persönlich mit einer Einschätzung bei dir.
      </p>

      <form method="post" class="tm-form">
        <div class="tm-form-row">
          <input type="text" name="name" placeholder="Dein Name" required>
          <input type="email" name="email" placeholder="E-Mail" required>
        </div>

        <div class="tm-form-row">
          <input
            type="url"
            name="website"
            placeholder="https://deine-website.de"
            value="<?php echo esc_attr($website); ?>"
            required
          >
        </div>

        <div class="tm-form-row">
          <textarea name="message" placeholder="Optional: Was soll ich mir besonders anschauen?"></textarea>
        </div>

        <button type="submit" class="tm-btn tm-btn-blue">
          Kostenlose Prüfung starten
        </button>

        <p class="tm-form-trust">
          Kein Spam. Keine Weitergabe deiner Daten.
        </p>

        <p class="tm-form-hint">
          Ich prüfe jede Anfrage persönlich. Antwort in der Regel innerhalb von 24 Stunden.
        </p>
      </form>

    <?php endif; ?>

  </div>
</section>

</main>

<?php get_footer(); ?>