<?php
/*
Template Name: Présentation (dynamique)
Template Post Type: page
*/

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>
<section class="page-hero">
  <div class="container">
    <h1 class="h1"><?php the_title(); ?></h1>
  </div>
</section>

<main class="container">
  <section class="section">
    <?php while (have_posts()) : the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; ?>
  </section>

  <section class="section">
    <div class="cards" style="grid-template-columns:repeat(auto-fit,minmax(280px,1fr));">
      <?php
      $items = new WP_Query([
          'post_type' => 'geden_presentation',
          'posts_per_page' => -1,
          'orderby' => ['menu_order' => 'ASC', 'date' => 'ASC'],
      ]);
      while ($items->have_posts()) : $items->the_post();
      ?>
        <article class="card">
          <?php if (has_post_thumbnail()) : the_post_thumbnail('medium_large'); endif; ?>
          <h3><?php the_title(); ?></h3>
          <?php the_content(); ?>
        </article>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </section>
</main>
<?php
get_footer();
