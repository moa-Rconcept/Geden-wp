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
$subtitle = (string) get_post_meta($page_id, '_geden_enjeux_subtitle', true);

$sections = [
    'enjeux' => [
        'taxonomy_slug' => 'blocs-enjeux',
        'class' => 'enjeux',
        'hero_class' => 'enjeux-hero',
        'img_meta' => '_geden_enjeux_hero_image_id',
        'tag_meta' => '_geden_enjeux_hero_tag',
        'title_meta' => '_geden_enjeux_hero_title',
        'text_meta' => '_geden_enjeux_hero_text',
        'default_img' => get_template_directory_uri() . '/img/arbres.jpg',
        'default_tag' => 'Enjeux',
        'default_title' => 'Comprendre, quantifier et anticiper les usages',
        'default_text' => 'Les activités humaines dans les espaces naturels sont nombreuses, diversifiées et en augmentation.',
    ],
    'permet' => [
        'taxonomy_slug' => 'blocs-permet',
        'class' => 'permet',
        'hero_class' => 'services-hero services-hero--small',
        'img_meta' => '_geden_permet_hero_image_id',
        'tag_meta' => '_geden_permet_hero_tag',
        'title_meta' => '_geden_permet_hero_title',
        'text_meta' => '_geden_permet_hero_text',
        'default_img' => get_template_directory_uri() . '/img/water-7902554_1280.jpg',
        'default_tag' => 'Ce que cela permet',
        'default_title' => 'Intérêt pour la gestion de vos sites',
        'default_text' => "Faire appel à Geden, c'est vous permettre de mieux :",
    ],
    'problematiques' => [
        'taxonomy_slug' => 'blocs-problematiques',
        'class' => 'problematiques',
        'hero_class' => 'pr-hero',
        'img_meta' => '_geden_problematiques_hero_image_id',
        'tag_meta' => '_geden_problematiques_hero_tag',
        'title_meta' => '_geden_problematiques_hero_title',
        'text_meta' => '_geden_problematiques_hero_text',
        'default_img' => get_template_directory_uri() . '/img/reef-7886750_1280.jpg',
        'default_tag' => 'Problématiques',
        'default_title' => 'Les questions à éclairer pour agir',
        'default_text' => "Répondre à ces questions, c'est permettre d’aborder de manière efficace de nombreux enjeux concrets.",
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
  <?php foreach ($sections as $section_key => $section) : ?>
    <?php
    $image_id = (int) get_post_meta($page_id, $section['img_meta'], true);
    $image_url = $image_id > 0 ? wp_get_attachment_image_url($image_id, 'full') : '';
    $image_url = $image_url !== '' ? $image_url : $section['default_img'];

    $tag = (string) get_post_meta($page_id, $section['tag_meta'], true);
    $title = (string) get_post_meta($page_id, $section['title_meta'], true);
    $text = (string) get_post_meta($page_id, $section['text_meta'], true);
    $tag = $tag !== '' ? $tag : $section['default_tag'];
    $title = $title !== '' ? $title : $section['default_title'];
    $text = $text !== '' ? $text : $section['default_text'];

    $items = new WP_Query([
        'post_type' => 'geden_enjeu',
        'posts_per_page' => -1,
        'tax_query' => [[
            'taxonomy' => 'enjeu_category',
            'field' => 'slug',
            'terms' => $section['taxonomy_slug'],
        ]],
        'orderby' => ['menu_order' => 'ASC', 'date' => 'ASC'],
    ]);

    $grid_class = $section_key === 'permet' ? 'en-grid services-cards' : 'en-grid enjeux-cards';
    ?>
    <section class="section <?php echo esc_attr($section['class']); ?>">
      <article class="<?php echo esc_attr($section['hero_class']); ?>" style="--img:url('<?php echo esc_url($image_url); ?>')">
        <div class="<?php echo $section_key === 'permet' ? 'services-hero__bg' : ($section_key === 'problematiques' ? 'pr-hero__bg' : 'enjeux-hero__bg'); ?>" style="<?php echo $section_key !== 'permet' ? "background-image: linear-gradient(180deg, rgba(11, 18, 32, 0.55), rgba(11, 18, 32, 0.55)), url('" . esc_url($image_url) . "');" : ''; ?>"></div>
        <div class="<?php echo $section_key === 'permet' ? 'services-hero__inner' : ($section_key === 'problematiques' ? 'pr-hero__inner' : 'enjeux-hero__inner'); ?>">
          <span class="<?php echo $section_key === 'permet' ? 'services-hero__tag' : ($section_key === 'problematiques' ? 'pr-hero__tag' : 'enjeux-hero__tag'); ?>"><?php echo esc_html($tag); ?></span>
          <h2 class="<?php echo $section_key === 'permet' ? 'services-hero__title' : ($section_key === 'problematiques' ? 'pr-hero__title' : 'enjeux-hero__title'); ?>"><?php echo esc_html($title); ?></h2>
          <p class="<?php echo $section_key === 'permet' ? 'services-hero__lede' : ($section_key === 'problematiques' ? 'pr-hero__lede' : 'enjeux-hero__lede'); ?>"><?php echo esc_html($text); ?></p>
        </div>
      </article>

      <div class="<?php echo esc_attr($grid_class); ?>">
        <?php if (!$items->have_posts()) : ?>
          <p class="ref-empty">Aucun bloc trouvé pour la catégorie <code><?php echo esc_html($section['taxonomy_slug']); ?></code>.</p>
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
          <article class="en-item <?php echo $section_key === 'permet' ? 'services-card' : ''; ?>">
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
