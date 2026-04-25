<?php
/*
Template Name: Offres & Services (dynamique)
Template Post Type: page
*/

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$page_id = get_queried_object_id();
$subtitle = has_excerpt($page_id) ? get_the_excerpt($page_id) : '';
$terms = get_terms([
    'taxonomy' => 'offre_category',
    'hide_empty' => false,
    'orderby' => 'name',
    'order' => 'ASC',
]);

$section_classes = [
    'blocs-offres' => 'section section-services-hero',
    'frequentation' => 'section section-service-block',
    'enquetes' => 'section section-service-block',
    'entretiens' => 'section section-service-block',
    'outils-analytiques' => 'section section-service-tools',
];
?>
<section class="page-hero">
  <div class="container">
    <h1 class="h1"><?php the_title(); ?></h1>
    <?php if ($subtitle !== '') : ?>
      <p class="subtitle"><?php echo esc_html($subtitle); ?></p>
    <?php endif; ?>
  </div>
</section>

<main class="container">
  <?php while (have_posts()) : the_post(); ?>
    <?php if (trim((string) get_the_content()) !== '') : ?>
      <section class="section">
        <?php the_content(); ?>
      </section>
    <?php endif; ?>
  <?php endwhile; ?>

  <?php foreach ($terms as $term) : ?>
    <?php
    if (!$term instanceof WP_Term) {
        continue;
    }

    $tag   = trim((string) get_term_meta($term->term_id, '_geden_offre_category_tag', true));
    $title = trim((string) get_term_meta($term->term_id, '_geden_offre_category_title', true));
    $text  = trim((string) get_term_meta($term->term_id, '_geden_offre_category_subtitle', true));

    $category_description = trim((string) term_description($term->term_id, 'offre_category'));

   $image_url = '';

    $image_id = (int) get_term_meta($term->term_id, '_geden_offre_category_image_id', true);

    if ($image_id > 0) {
        $image_url = (string) wp_get_attachment_image_url($image_id, 'full');
    }

    if ($image_url === '') {
        $image_meta = trim((string) get_term_meta($term->term_id, '_geden_offre_category_image', true));

        if ($image_meta !== '') {
            $image_url = esc_url($image_meta);
        }
    }

    if ($title === '') {
        $title = $term->name;
    }
    $items = new WP_Query([
      'post_type' => 'geden_offre',
      'posts_per_page' => -1,
      'tax_query' => [[
          'taxonomy' => 'offre_category',
          'field' => 'slug',
          'terms' => $term->slug,
      ]],
      'orderby' => ['menu_order' => 'ASC', 'date' => 'ASC'],
    ]);

    $section_class = $section_classes[$term->slug] ?? 'section section-service-block';
    ?>
    <section class="<?php echo esc_attr($section_class); ?>">
      <article class="services-hero<?php echo $term->slug === 'blocs-offres' ? '' : ' services-hero--small'; ?>"<?php echo $image_url !== '' ? " style=\"background-image:url('" . esc_url($image_url) . "')\"" : ''; ?>>
        <div class="services-hero__bg"></div>
        <div class="services-hero__inner">
        <?php if ($tag !== '') : ?>
          <span class="services-hero__tag"><?php echo esc_html($tag); ?></span>
        <?php endif; ?>
          <h2 class="services-hero__title"><?php echo esc_html($title); ?></h2>
          <?php if ($text !== '') : ?>
            <p class="services-hero__lede"><?php echo esc_html($text); ?></p>
          <?php endif; ?>
        </div>
      </article>

      <?php if ($term->slug === 'blocs-offres') : ?>
        <div class="services-cards">
      <?php elseif ($term->slug === 'outils-analytiques') : ?>
        <div class="tools">
      <?php else : ?>
        <div class="service-content">
      <?php endif; ?>

      <?php if (!$items->have_posts()) : ?>
        <?php if ($category_description !== '' && $term->slug !== 'blocs-offres' && $term->slug !== 'outils-analytiques') : ?>
          <article class="service-content">
            <?php echo wp_kses_post(wpautop($category_description)); ?>
          </article>
        <?php else : ?>
          <p class="ref-empty">Aucun bloc trouvé pour la catégorie <code><?php echo esc_html($term->slug); ?></code>.</p>
        <?php endif; ?>
      <?php endif; ?>

      <?php
      while ($items->have_posts()) : $items->the_post();
        $post_id = get_the_ID();
      ?>
        <?php if ($term->slug === 'blocs-offres') : ?>
          <article class="services-card">
            <?php
            $badge = (string) get_post_meta($post_id, '_geden_offre_badge', true);
            $badge = $badge !== '' ? $badge : 'badge-blue';
            $icon = (string) get_post_meta($post_id, '_geden_offre_icon', true);
            $short_text = (string) get_post_meta($post_id, '_geden_offre_text', true);
            $lines = geden_get_offre_lines($post_id);
            ?>
            <div class="services-card__head">
              <span class="services-icon icon-badge <?php echo esc_attr($badge); ?>" aria-hidden="true">
                <span class="svg"><?php echo wp_kses(geden_get_enjeu_icon_svg($icon), ['svg' => ['viewBox' => true, 'fill' => true], 'path' => ['d' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true], 'circle' => ['cx' => true, 'cy' => true, 'r' => true], 'rect' => ['x' => true, 'y' => true, 'width' => true, 'height' => true, 'rx' => true]]); ?></span>
              </span>
              <h3><?php the_title(); ?></h3>
            </div>
            <?php if (!empty($lines)) : ?>
              <ul class="en-list">
                <?php foreach ($lines as $line) : ?><li><?php echo esc_html($line); ?></li><?php endforeach; ?>
              </ul>
            <?php elseif ($short_text !== '') : ?>
              <p><?php echo esc_html($short_text); ?></p>
            <?php elseif (has_excerpt()) : ?>
              <p><?php echo esc_html(get_the_excerpt()); ?></p>
            <?php else : ?>
              <?php the_content(); ?>
            <?php endif; ?>
          </article>
        <?php elseif ($term->slug === 'outils-analytiques') : ?>
          <article class="tool">
            <h3 class="tool__title"><?php the_title(); ?></h3>
            <?php the_content(); ?>
          </article>
        <?php else : ?>
          <article class="service-content">
            <?php the_content(); ?>
          </article>
        <?php endif; ?>
      <?php endwhile; wp_reset_postdata(); ?>
      </div>
    </section>
  <?php endforeach; ?>
</main>
<?php
get_footer();