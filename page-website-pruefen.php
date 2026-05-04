<?php get_header(); ?>

<main id="content" class="toabai-page">

<?php
// URL aus GET übernehmen
$website = isset($_GET['website']) ? esc_url($_GET['website']) : '';

// Formular verarbeitet?
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $name    = sanitize_text_field($_POST['name']);
  $email   = sanitize_email($_POST['email']);
  $site    = esc_url_raw($_POST['website']);
  $message = sanitize_textarea_field($_POST['message']);

  $to = info@toabai.media // später anpassen!
  $subject = 'Neue Website-Prüfung Anfrage';

  $body = "Name: $name\n";
  $body .= "E-Mail: $email\n";
  $body .= "Website: $site\n\n";
  $body .= "Nachricht:\n$message";

  $headers = ['Content-Type: text/plain; charset=UTF-8'];

  wp_mail($to, $subject, $body, $headers);

  $success = true;
}
?>

<!-- HERO -->
<section class="tm-contact-hero">
  <div class="tm-container tm-contact-centered">

    <p class="tm-eyebrow">Kostenlose Erstprüfung</p>

    <h1>Website prüfen lassen</h1>

    <p>
      Ich schaue mir deine WordPress-Website technisch an und gebe dir eine ehrliche Einschätzung.
    </p>

  </div>
</section>

<!-- FORM -->
<section>
  <div class="tm-container">

<?php if ($success): ?>

  <div class="tm-success-box">
    <h2>Danke! 🙌</h2>
    <p>Ich habe deine Anfrage erhalten und melde mich zeitnah bei dir.</p>
  </div>

<?php else: ?>

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
      Website prüfen lassen
    </button>

  </form>

<?php endif; ?>

  </div>
</section>

</main>

<?php get_footer(); ?>