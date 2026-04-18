<?php
/*
Template Name: Références (dynamique)
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
    <nav class="pillnav">
      <a href="#passees">Réalisations effectuées</a>
      <a href="#encours">Réalisations en cours</a>
      <a href="#productions">Productions techniques &amp; scientifiques</a>
    </nav>
  </div>
</section>

<main class="container">

  <section id="encours" class="section section-reference" style="margin-top:24px">
    <div class="ribbon">Réalisations en cours</div>
    <?php
    $encours = new WP_Query([
        'post_type' => 'geden_reference',
        'posts_per_page' => -1,
        'tax_query' => [[
            'taxonomy' => 'reference_category',
            'field' => 'slug',
            'terms' => 'realisations-en-cours',
        ]],
        'orderby' => 'menu_order title',
        'order' => 'ASC',
    ]);
    while ($encours->have_posts()) : $encours->the_post();
      $post_id = get_the_ID();
      $client = (string) get_post_meta($post_id, '_geden_reference_client', true);
      $year = (string) get_post_meta($post_id, '_geden_reference_year', true);
      $needs = geden_get_reference_bullets('_geden_reference_needs', $post_id);
      $services = geden_get_reference_bullets('_geden_reference_services', $post_id);
      $sponsors = geden_get_reference_sponsors($post_id);
      ?>
      <article class="ref-card">
        <aside class="ref-meta">
          <?php if ($year !== '') : ?><div class="ref-year"><?php echo esc_html($year); ?></div><?php endif; ?>
          <div class="ref-client">
            <?php if ($client !== '') : ?><h3><?php echo esc_html($client); ?></h3><?php endif; ?>
            <div class="logo-ref">
              <?php foreach ($sponsors as $sponsor) : ?>
                <?php
                $logo = get_the_post_thumbnail($sponsor->ID, 'medium', ['alt' => $sponsor->post_title]);
                $sponsor_url = (string) get_post_meta($sponsor->ID, '_geden_sponsor_website', true);
                ?>
                <?php if (!empty($sponsor_url)) : ?>
                  <a href="<?php echo esc_url($sponsor_url); ?>" target="_blank" rel="noopener"><?php echo $logo; ?></a>
                <?php else : ?>
                  <?php echo $logo; ?>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div>
        </aside>

        <div class="ref-body">
          <h3 class="ref-title"><?php the_title(); ?></h3>
          <div class="ref-grid">
            <div class="ref-text">
              <?php if (!empty($needs)) : ?>
                <h4 class="ref-sub">Problématiques / Besoins :</h4>
                <ul class="bullets tight">
                  <?php foreach ($needs as $item) : ?><li><?php echo esc_html($item); ?></li><?php endforeach; ?>
                </ul>
              <?php endif; ?>

              <?php if (!empty($services)) : ?>
                <h4 class="ref-sub">Prestation :</h4>
                <ul class="bullets tight">
                  <?php foreach ($services as $item) : ?><li><?php echo esc_html($item); ?></li><?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </div>
            <figure class="ref-figure">
              <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large'); ?>
              <?php endif; ?>
            </figure>
          </div>
        </div>
      </article>
    <?php endwhile; wp_reset_postdata(); ?>
  </section>

  <section id="passees" class="section section-reference">
    <div class="ribbon">Réalisations effectuées</div>
    <?php
    $passees = new WP_Query([
        'post_type' => 'geden_reference',
        'posts_per_page' => -1,
        'tax_query' => [[
            'taxonomy' => 'reference_category',
            'field' => 'slug',
            'terms' => 'realisations-effectuees',
        ]],
        'orderby' => 'menu_order title',
        'order' => 'ASC',
    ]);
    while ($passees->have_posts()) : $passees->the_post();
      $post_id = get_the_ID();
      $client = (string) get_post_meta($post_id, '_geden_reference_client', true);
      $year = (string) get_post_meta($post_id, '_geden_reference_year', true);
      $needs = geden_get_reference_bullets('_geden_reference_needs', $post_id);
      $services = geden_get_reference_bullets('_geden_reference_services', $post_id);
      $sponsors = geden_get_reference_sponsors($post_id);
      ?>
      <article class="ref-card">
        <aside class="ref-meta">
          <?php if ($year !== '') : ?><div class="ref-year"><?php echo esc_html($year); ?></div><?php endif; ?>
          <div class="ref-client">
            <?php if ($client !== '') : ?><h3><?php echo esc_html($client); ?></h3><?php endif; ?>
            <div class="logo-ref">
              <?php foreach ($sponsors as $sponsor) : ?>
                <?php
                $logo = get_the_post_thumbnail($sponsor->ID, 'medium', ['alt' => $sponsor->post_title]);
                $sponsor_url = (string) get_post_meta($sponsor->ID, '_geden_sponsor_website', true);
                ?>
                <?php if (!empty($sponsor_url)) : ?>
                  <a href="<?php echo esc_url($sponsor_url); ?>" target="_blank" rel="noopener"><?php echo $logo; ?></a>
                <?php else : ?>
                  <?php echo $logo; ?>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div>
        </aside>

        <div class="ref-body">
          <h3 class="ref-title"><?php the_title(); ?></h3>
          <div class="ref-grid">
            <div class="ref-text">
              <?php if (!empty($needs)) : ?>
                <h4 class="ref-sub">Problématiques / Besoins :</h4>
                <ul class="bullets tight">
                  <?php foreach ($needs as $item) : ?><li><?php echo esc_html($item); ?></li><?php endforeach; ?>
                </ul>
              <?php endif; ?>

              <?php if (!empty($services)) : ?>
                <h4 class="ref-sub">Prestations :</h4>
                <ul class="bullets tight">
                  <?php foreach ($services as $item) : ?><li><?php echo esc_html($item); ?></li><?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </div>
            <figure class="ref-figure">
              <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large'); ?>
              <?php endif; ?>
            </figure>
          </div>
        </div>
      </article>
    <?php endwhile; wp_reset_postdata(); ?>
  </section>

  <img class="fishingIMG" src="<?php echo esc_url(get_template_directory_uri() . '/img/pecheur calme.jpg'); ?>" alt="Pêcheur" loading="lazy">

  <section id="productions" class="section">
    <article class="pubs-hero" style="--img:url('<?php echo esc_url(get_template_directory_uri() . '/img/arbres.jpg'); ?>')">
      <div class="pubs-hero__bg"></div>
      <div class="pubs-hero__inner">
        <span class="pubs-hero__tag">Productions</span>
        <h2 class="pubs-hero__title">Productions techniques et scientifiques</h2>
        <p class="pubs-hero__lede">Publications, rapports et livrables – triés par année.</p>
      </div>
    </article>

    <div class="pubs-acc">
      <?php
      $productions = new WP_Query([
          'post_type' => 'geden_reference',
          'posts_per_page' => -1,
          'tax_query' => [[
              'taxonomy' => 'reference_category',
              'field' => 'slug',
              'terms' => 'productions-techniques-scientifiques',
          ]],
          'orderby' => 'date',
          'order' => 'DESC',
      ]);

      $grouped = [];
      while ($productions->have_posts()) {
          $productions->the_post();
          $year = (string) get_post_meta(get_the_ID(), '_geden_reference_year', true);
          $year = $year !== '' ? $year : 'Non daté';
          if (!isset($grouped[$year])) {
              $grouped[$year] = [];
          }
          $grouped[$year][] = get_post();
      }
      wp_reset_postdata();

      $is_first = true;
      foreach ($grouped as $year => $items) :
        ?>
        <section class="pubs-year <?php echo $is_first ? 'is-open' : ''; ?>">
          <button class="pubs-year__toggle" type="button" aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>">
            <span class="pubs-year__label"><?php echo esc_html($year); ?></span>
            <span class="pubs-year__count">(<?php echo esc_html((string) count($items)); ?>)</span>
            <span class="pubs-year__chev">▾</span>
          </button>
          <div class="pubs-year__panel" style="display:<?php echo $is_first ? 'block' : 'none'; ?>;">
            <ul class="pubs-items">
              <?php foreach ($items as $item) : ?>
                <?php
                $authors = (string) get_post_meta($item->ID, '_geden_reference_authors', true);
                $deliverable = (string) get_post_meta($item->ID, '_geden_reference_deliverable', true);
                ?>
                <li>
                  <?php if ($authors !== '') : ?><span class="pubs-authors"><?php echo esc_html($authors); ?></span><?php endif; ?>
                  <span class="pubs-title"><?php echo esc_html($item->post_title); ?></span>
                  <?php if ($item->post_excerpt !== '') : ?><span class="pubs-title"><?php echo esc_html($item->post_excerpt); ?></span><?php endif; ?>
                  <?php if ($deliverable !== '') : ?><span class="pubs-meta"><?php echo esc_html($deliverable); ?></span><?php endif; ?>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </section>
        <?php
        $is_first = false;
      endforeach;
      ?>
    </div>
  </section>
</main>

<?php
get_footer();
