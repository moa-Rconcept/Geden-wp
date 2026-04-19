<?php
/*
Template Name: Enjeux dynamique
Template Post Type: page
*/

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$page_id = get_queried_object_id();
$subtitle = has_excerpt($page_id) ? get_the_excerpt($page_id) : '';

$terms = get_terms([
    'taxonomy' => 'enjeu_category',
    'hide_empty' => false,
    'orderby' => 'name',
    'order' => 'ASC',
]);

$hero_classes = [
    'blocs-enjeux' => [
        'section_class' => 'enjeux',
        'hero_class' => 'enjeux-hero',
        'bg_class' => 'enjeux-hero__bg',
        'inner_class' => 'enjeux-hero__inner',
        'tag_class' => 'enjeux-hero__tag',
        'title_class' => 'enjeux-hero__title',
        'text_class' => 'enjeux-hero__lede',
    ],
    'blocs-permet' => [
        'section_class' => 'permet',
        'hero_class' => 'services-hero services-hero--small',
        'bg_class' => 'services-hero__bg',
        'inner_class' => 'services-hero__inner',
        'tag_class' => 'services-hero__tag',
        'title_class' => 'services-hero__title',
        'text_class' => 'services-hero__lede',
    ],
    'blocs-problematiques' => [
        'section_class' => 'problematiques',
        'hero_class' => 'pr-hero',
        'bg_class' => 'pr-hero__bg',
        'inner_class' => 'pr-hero__inner',
        'tag_class' => 'pr-hero__tag',
        'title_class' => 'pr-hero__title',
        'text_class' => 'pr-hero__lede',
    ],
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
  <?php foreach ($terms as $term) : ?>
    <?php
    if (!$term instanceof WP_Term) {
        continue;
    }
    $style = $hero_classes[$term->slug] ?? $hero_classes['blocs-enjeux'];
    $tag = (string) get_term_meta($term->term_id, '_geden_enjeu_category_tag', true);
    $title = (string) get_term_meta($term->term_id, '_geden_enjeu_category_title', true);
    $text = (string) get_term_meta($term->term_id, '_geden_enjeu_category_subtitle', true);
    $image_id = (int) get_term_meta($term->term_id, '_geden_enjeu_category_image_id', true);
    $image_url = $image_id > 0 ? (string) wp_get_attachment_image_url($image_id, 'full') : '';
    if ($image_url === '') {
        // Compatibilité ancienne saisie URL manuelle.
        $image_url = (string) get_term_meta($term->term_id, '_geden_enjeu_category_image_url', true);
    }
    $tag = $tag !== '' ? $tag : $term->name;
    $title = $title !== '' ? $title : $term->name;

    $items = new WP_Query([
        'post_type' => 'geden_enjeu',
        'posts_per_page' => -1,
        'tax_query' => [[
            'taxonomy' => 'enjeu_category',
            'field' => 'slug',
            'terms' => $term->slug,
        ]],
        'orderby' => ['menu_order' => 'ASC', 'date' => 'ASC'],
    ]);

    $grid_class = $term->slug === 'blocs-permet' ? 'en-grid services-cards' : 'en-grid enjeux-cards';
    ?>
    <section class="section <?php echo esc_attr($style['section_class']); ?>">
      <article class="<?php echo esc_attr($style['hero_class']); ?>"<?php echo $image_url !== '' ? " style=\"background-image:url('" . esc_url($image_url) . "')\"" : ''; ?>>
        <div class="<?php echo esc_attr($style['bg_class']); ?>"></div>
        <div class="<?php echo esc_attr($style['inner_class']); ?>">
          <span class="<?php echo esc_attr($style['tag_class']); ?>"><?php echo esc_html($tag); ?></span>
          <h2 class="<?php echo esc_attr($style['title_class']); ?>"><?php echo esc_html($title); ?></h2>
          <?php if ($text !== '') : ?><p class="<?php echo esc_attr($style['text_class']); ?>"><?php echo esc_html($text); ?></p><?php endif; ?>
        </div>
      </article>

      <div class="<?php echo esc_attr($grid_class); ?>">
        <?php if (!$items->have_posts()) : ?>
          <p class="ref-empty">Aucun bloc trouvé pour la catégorie <code><?php echo esc_html($term->slug); ?></code>.</p>
        <?php endif; ?>

        <?php while ($items->have_posts()) : $items->the_post(); ?>
          <?php
          $post_id = get_the_ID();
          $badge = (string) get_post_meta($post_id, '_geden_enjeu_badge', true);
          $badge = $badge !== '' ? $badge : 'badge-blue';
          $icon = (string) get_post_meta($post_id, '_geden_enjeu_icon', true);
          $short_text = (string) get_post_meta($post_id, '_geden_enjeu_text', true);
          $lines = geden_get_enjeu_lines($post_id);
          ?>
          <article class="en-item <?php echo $term->slug === 'blocs-permet' ? 'services-card' : ''; ?>">
            <span class="icon-badge <?php echo esc_attr($badge); ?>" aria-hidden="true">
              <span class="svg"><?php echo wp_kses(geden_get_enjeu_icon_svg($icon), ['svg' => ['viewBox' => true, 'fill' => true], 'path' => ['d' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true], 'circle' => ['cx' => true, 'cy' => true, 'r' => true], 'rect' => ['x' => true, 'y' => true, 'width' => true, 'height' => true, 'rx' => true]]); ?></span>
            </span>
            <div class="en-body">
              <h3 class="en-title"><?php the_title(); ?></h3>
              <?php if (!empty($lines)) : ?>
                <ul class="en-list">
                  <?php foreach ($lines as $line) : ?><li><?php echo esc_html($line); ?></li><?php endforeach; ?>
                </ul>
              <?php elseif ($short_text !== '') : ?>
                <p class="en-text"><?php echo esc_html($short_text); ?></p>
              <?php elseif (has_excerpt()) : ?>
                <p class="en-text"><?php echo esc_html(get_the_excerpt()); ?></p>
              <?php else : ?>
                <p class="en-text"><?php echo esc_html(wp_strip_all_tags(get_the_content())); ?></p>
              <?php endif; ?>
            </div>
          </article>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    </section>
  <?php endforeach; ?>
</main>

<?php
get_footer();