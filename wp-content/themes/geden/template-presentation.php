<?php
/*
Template Name: Présentation (dynamique)
Template Post Type: page
*/

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$presentation_terms = get_terms([
    'taxonomy' => 'presentation_category',
    'hide_empty' => false,
    'orderby' => 'term_id',
    'order' => 'ASC',
]);

$team_members = new WP_Query([
    'post_type' => 'geden_team',
    'posts_per_page' => -1,
    'tax_query' => [[
        'taxonomy' => 'team_category',
        'field' => 'slug',
        'terms' => 'membres-equipe',
    ]],
    'orderby' => ['menu_order' => 'ASC', 'date' => 'ASC'],
]);

?>
<section class="page-hero">
  <div class="container">
    <h1 class="h1"><?php the_title(); ?></h1>
  </div>
</section>

  <main class="container" style="padding:40px 0 64px">
  <?php while (have_posts()) : the_post(); ?>
    <?php if (trim((string) get_the_content()) !== '') : ?>
      <section class="section">
        <?php the_content(); ?>
      </section>
    <?php endif; ?>
  <?php endwhile; ?>

  <?php foreach ($presentation_terms as $term) : ?>
    <?php
    if (!$term instanceof WP_Term) {
        continue;
    }
    $items = new WP_Query([
        'post_type' => 'geden_presentation',
        'posts_per_page' => -1,
        'tax_query' => [[
            'taxonomy' => 'presentation_category',
            'field' => 'slug',
            'terms' => $term->slug,
        ]],
        'orderby' => ['menu_order' => 'ASC', 'date' => 'ASC'],
    ]);
    ?>
    
      <?php
       while ($items->have_posts()) : $items->the_post();
          $post_id = get_the_ID();
          $layout = (string) get_post_meta($post_id, '_geden_presentation_layout', true);
          $label = (string) get_post_meta($post_id, '_geden_presentation_button_label', true);
          if ($layout === '') {
              $layout = 'split-media-left';
          }
      ?>
      <?php if ($label !== '') : ?>
        <p class="presentation-card__label"><?php echo esc_html($label); ?></p>
      <?php endif; ?>
      <section class="section">
        <div class="presentation-card__grid grid-2">
          <?php if (has_post_thumbnail()) : ?>
            <figure class="presentation-card__media">
              <?php the_post_thumbnail('large'); ?>
            </figure>
          <?php endif; ?>
          <div class="presentation-card__content">
            <h2><?php the_title(); ?></h2>
            <?php the_content(); ?>
          </div>
        </div>
      </section>
      <?php endwhile; wp_reset_postdata(); ?>
      <?php endforeach; ?>


      <!-- Equipe -->
  <?php if ($team_members->have_posts()) : ?>
    <section class="section">
      <p class="presentation-card__label"><?php esc_html_e('Notre équipe', 'geden'); ?></p>
      <div class="team-grid">
        <?php while ($team_members->have_posts()) : $team_members->the_post(); ?>
          <?php
          $post_id = get_the_ID();
          $role = (string) get_post_meta($post_id, '_geden_team_role', true);
          if ($role === '' && has_excerpt($post_id)) {
              $role = get_the_excerpt($post_id);
          }
          ?>
          <article class="team-card">
            <?php if (has_post_thumbnail()) : ?>
              <?php the_post_thumbnail('large', ['alt' => get_the_title()]); ?>
            <?php endif; ?>
            <div class="team-content">
              <h3 class="team-name"><?php the_title(); ?></h3>
              <?php if ($role !== '') : ?><p class="role"><?php echo esc_html($role); ?></p><?php endif; ?>
              <button type="button" class="team-more btn btn-outline"><?php esc_html_e('En savoir plus', 'geden'); ?></button>
              <div class="team-full visually-hidden">
                <?php
                $modal_title = (string) get_post_meta($post_id, '_geden_team_modal_title', true);
                if ($modal_title !== '') {
                    echo '<h4>' . esc_html($modal_title) . '</h4>';
                }
                the_content();
                ?>
              </div>
            </div>
          </article>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    </section>
  <?php endif; ?>
</main>

<div class="modal" id="teamModal" aria-hidden="true">
  <div class="modal__backdrop"></div>
  <div class="modal__panel" role="dialog" aria-modal="true" aria-labelledby="teamModalTitle">
    <button type="button" class="modal__close" aria-label="<?php esc_attr_e('Fermer', 'geden'); ?>">&times;</button>
    <div class="modal__header">
      <img class="modal__photo" src="" alt="" />
      <div>
        <h3 class="modal__title" id="teamModalTitle"></h3>
        <p class="modal__role"></p>
      </div>
    </div>
    <div class="modal__content"></div>
  </div>
</div>
<?php
get_footer();
