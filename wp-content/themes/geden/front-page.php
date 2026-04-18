<?php
if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<section class="hero">
  <div class="hero__bg"></div>
  <div class="hero__veil"></div>
  <div class="container hero__inner">
    <h1><?php bloginfo('name'); ?></h1>
    <p><?php bloginfo('description'); ?></p>
    <div class="cta">
      <a href="<?php echo esc_url(home_url('/offres-et-services')); ?>" class="btn btn-primary">Découvrir nos offres</a>
      <a href="<?php echo esc_url(home_url('/references')); ?>" class="btn btn-ghost">Voir nos références</a>
    </div>
  </div>
</section>

<section class="white">
  <div class="container">
    <?php
    while (have_posts()) :
        the_post();
        the_content();
    endwhile;
    ?>
  </div>
</section>

<section class="white section-trust">
  <div class="container">
    <div class="section-head">
      <h2>Ils nous ont fait confiance</h2>
      <p class="lead">Collectivités, offices, parcs naturels, universités et partenaires techniques mobilisés sur nos missions.</p>
    </div>
    <div class="trust-logos">
      <img src="<?php echo esc_url(get_template_directory_uri() . '/img/copie-de-logo-ofb.webp'); ?>" alt="Office français de la biodiversité" loading="lazy">
      <img src="<?php echo esc_url(get_template_directory_uri() . '/img/parc-naturel-marin-du-golfe-du-lion.png'); ?>" alt="Parc naturel marin du golfe du Lion" loading="lazy">
      <img src="<?php echo esc_url(get_template_directory_uri() . '/img/hd_bassindarcachon-vect_v2.png'); ?>" alt="Parc naturel marin du Bassin d’Arcachon" loading="lazy">
      <img src="<?php echo esc_url(get_template_directory_uri() . '/img/logo-province-sud-nc-01.jpg'); ?>" alt="Province Sud Nouvelle-Calédonie" loading="lazy">
      <img src="<?php echo esc_url(get_template_directory_uri() . '/img/logo-sepanso-2021_resize-2.png'); ?>" alt="SEPANSO" loading="lazy">
      <img src="<?php echo esc_url(get_template_directory_uri() . '/img/rnf_logo.jpg'); ?>" alt="Réserves naturelles de France" loading="lazy">
    </div>
  </div>
</section>

<section class="band">
  <div class="container band__row">
    <h2 style="color: #fff;">Parlons de votre territoire et de vos objectifs</h2>
    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-white">Prendre contact</a>
  </div>
</section>

<?php
get_footer();
