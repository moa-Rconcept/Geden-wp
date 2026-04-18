<?php
/*
Template Name: Sections dynamiques
*/

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main class="white">
  <div class="container">
    <?php while (have_posts()) : the_post(); ?>
      <article <?php post_class(); ?>>
        <h1><?php the_title(); ?></h1>
        <?php the_content(); ?>
        <?php $page_slug = get_post_field('post_name', get_the_ID()); ?>
        <?php echo do_shortcode('[geden_sections page="' . esc_attr($page_slug) . '"]'); ?>
      </article>
    <?php endwhile; ?>
  </div>
</main>
<?php
get_footer();
