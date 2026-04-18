<?php
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
      </article>
    <?php endwhile; ?>
  </div>
</main>
<?php
get_footer();
