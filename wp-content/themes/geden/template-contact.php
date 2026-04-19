<?php
/*
Template Name: Contact
*/

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>



  <!-- Titre -->
  <section class="page-hero">
    <div class="container">
      <h1 class="h1">Nous contacter</h1>
      <p class="subtitle">Parlez-nous de votre besoin, on vous répond vite.</p>
    </div>
  </section>

  <main class="container" style="padding:40px 0 64px">
    <!-- Cartes de contact -->
    <section class="section">
      <div class="contact-cards">
        <article class="contact-card">
          <div class="contact-card__icon" aria-hidden="true">📍</div>
          <h3>Adresse</h3>
          <p>10 place de la Résistance<br>66130 Ille-sur-Têt — FRANCE</p>
        </article>

        <article class="contact-card">
          <div class="contact-card__icon" aria-hidden="true">✉️</div>
          <h3>Email</h3>
          <p><a href="mailto:contact@geden.fr">contact@geden.fr</a></p>
        </article>

        <article class="contact-card">
          <div class="contact-card__icon" aria-hidden="true">☎️</div>
          <h3>Téléphone</h3>
          <p><a href="tel:+33778645482">+33 7 77 86 45 82</a></p>
        </article>
      </div>
    </section>

    <!-- Formulaire -->
    <section class="section" style="margin-top:24px">
      <div class="ribbon">Formulaire de contact</div>

      <!-- Remplace action par ton endpoint (Formspree, backend, etc.) -->
      <form class="form" id="contactForm" method="post" action="" data-endpoint="" data-recipient="contact@geden.fr" data-logo-url="https://geden.fr/logo.png" enctype="multipart/form-data" novalidate>        <div class="visually-hidden">
          <label>Ne pas remplir si vous êtes humain
            <input name="company" type="text" tabindex="-1" autocomplete="off">
          </label>
        </div>

        <div class="form-grid">
          <div class="form-field">
            <label for="lastname">Nom <span class="req">*</span></label>
            <input id="lastname" name="lastname" type="text" required autocomplete="family-name">
          </div>

          <div class="form-field">
            <label for="firstname">Prénom</label>
            <input id="firstname" name="firstname" type="text" autocomplete="given-name">
          </div>

          <div class="form-field">
            <label for="email">Email <span class="req">*</span></label>
            <input id="email" name="email" type="email" required autocomplete="email">
          </div>

          <div class="form-field">
            <label for="phone">Téléphone</label>
            <input id="phone" name="phone" type="tel" autocomplete="tel">
          </div>

          <div class="form-field">
            <label for="subject">Objet <span class="req">*</span></label>
            <select id="subject" name="subject" required>
              <option value="" selected disabled>Choisir…</option>
              <option>Demande d’information</option>
              <option>Devis / cahier des charges</option>
              <option>Partenariat / expertise</option>
              <option>Autre</option>
            </select>
          </div>

          <div class="form-field form-field--full">
            <label for="message">Message <span class="req">*</span></label>
            <textarea id="message" name="message" rows="6" required></textarea>
          </div>

          <div class="form-field form-field--full">
            <label for="file">Pièce jointe (facultatif)</label>
            <input id="file" name="file" type="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg">
            <small class="hint">Max. 10&nbsp;Mo — évitez les caractères spéciaux dans le nom du fichier.</small>
          </div>

          <div class="form-field form-field--full">
            <label class="check">
              <input type="checkbox" required name="rgpd">
              <span>Je consens à ce que mes données soient utilisées pour répondre à ma demande. (Aucune cession à des tiers.)</span>
            </label>
          </div>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Envoyer</button>
          <p class="form-note">* Champs obligatoires</p>
        </div>

        <div class="form-success" id="formSuccess" aria-live="polite" hidden>
          Merci, votre message a bien été envoyé. Nous revenons vers vous rapidement.
        </div>
      </form>
    </section>

    <!-- Carte -->
    <section class="section" style="margin-top:24px">
      <div class="ribbon">Où nous trouver</div>
      <div class="map-wrap">
        <!-- Option 1 : iframe Google Maps -->
        <iframe
          title="Localisation GeDEN"
          loading="lazy" referrerpolicy="no-referrer-when-downgrade"
          src="https://www.google.com/maps?q=10+place+de+la+R%C3%A9sistance,+66130+Ille-sur-T%C3%AAt,+France&output=embed">
        </iframe>

        <!-- Option 2 (à la place de l'iframe) : image statique locale
        <img src="img/map-ille-sur-tet.jpg" alt="Plan d’accès GeDEN">
        -->
      </div>
    </section>

    <!-- Bande CTA -->
    <!-- <section class="band" style="margin-top:24px">
      <div class="band__row container">
        <h2 style="color: #fff;">Un projet à lancer&nbsp;?</h2>
        <a href="mailto:contact@geden.fr" class="btn btn-white">contact@geden.fr</a>
      </div>
    </section> -->
  </main>

<!-- <main class="white">
  <div class="container">
    <?php while (have_posts()) : the_post(); ?>
      <article <?php post_class(); ?>>
        <h1><?php the_title(); ?></h1>
        <?php the_content(); ?>
      </article>
    <?php endwhile; ?>
  </div>
</main> -->
<?php
get_footer();
