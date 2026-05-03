<?php
/* Template Name: Kontakt */

get_header();
?>

<main id="content" class="toabai-page kontakt-page">

<section class="tm-contact-hero">
  <div class="tm-container tm-contact-centered">

    <p class="tm-eyebrow tm-center">Kontakt</p>

    <h1 class="tm-center">
      Lass uns klären, was deine Website braucht.
    </h1>

    <p class="tm-hero-text tm-center">
      Schreib mir kurz, worum es geht. Ich melde mich persönlich mit einer ehrlichen Einschätzung.
    </p>

    <!-- FORMULAR -->
    <div class="tm-contact-form-wrap">

      <?php echo do_shortcode('[toabai_kontaktformular]'); ?>

      <p class="tm-contact-note">
        Ich melde mich in der Regel innerhalb von 24 Stunden.
      </p>

    </div>

    <!-- TRUST -->
    <ul class="tm-check-list tm-center tm-contact-trust">
      <li>Unkompliziert und direkt</li>
      <li>Keine Verpflichtung</li>
      <li>Ehrliche Einschätzung</li>
    </ul>

  </div>
</section>

  <section class="tm-contact-alt">
    <div class="tm-container">
      <p class="tm-eyebrow tm-center">Direktkontakt</p>
      <h2 class="tm-center">Oder lieber direkt?</h2>

      <div class="tm-contact-alt-grid">

        <div class="tm-mini-card">
          <h3>E-Mail</h3>
          <p>info@toabai.media</p>
        </div>

        <div class="tm-mini-card">
          <h3>Telefon</h3>
          <p>08631 / 185 31 30</p>
        </div>

      </div>

    </div>
  </section>

</main>

<?php get_footer(); ?>