<?php
/**
 * Theme functions for GeDEN.
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once get_template_directory() . '/inc/taxonomies/reference.php';
require_once get_template_directory() . '/inc/taxonomies/presentation.php';
require_once get_template_directory() . '/inc/taxonomies/team.php';
require_once get_template_directory() . '/inc/taxonomies/enjeu.php';
require_once get_template_directory() . '/inc/taxonomies/offre.php';

function geden_theme_setup(): void
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);

    register_nav_menus([
        'primary' => __('Menu principal', 'geden'),
        'footer'  => __('Menu pied de page', 'geden'),
        'menu_presentation' => __('Menu page Présentation', 'geden'),
        'menu_enjeux' => __('Menu page Problématiques et Enjeux', 'geden'),
        'menu_offres' => __('Menu page Offres & Services', 'geden'),
        'menu_references' => __('Menu page Références', 'geden'),
        'menu_contact' => __('Menu page Contact', 'geden'),
    ]);
}
add_action('after_setup_theme', 'geden_theme_setup');

function geden_disable_block_editor_for_custom_content(bool $use_block_editor, string $post_type): bool
{
    if (in_array($post_type, ['geden_reference', 'geden_sponsor', 'geden_enjeu', 'geden_offre', 'geden_team'], true)) {
              return false;
    }

    return $use_block_editor;
}
add_filter('use_block_editor_for_post_type', 'geden_disable_block_editor_for_custom_content', 10, 2);

function geden_enqueue_assets(): void
{
    wp_enqueue_style('geden-style', get_template_directory_uri() . '/style.css', [], wp_get_theme()->get('Version'));
    wp_deregister_script('jquery');
    wp_register_script(
        'jquery',
        'https://code.jquery.com/jquery-3.7.1.min.js',
        [],
        '3.7.1',
        true
    );
    wp_enqueue_script('jquery');    wp_enqueue_script('geden-main', get_template_directory_uri() . '/main.js', ['jquery'], wp_get_theme()->get('Version'), true);

    if (is_page_template('template-contact.php')) {
        wp_enqueue_script('geden-formulaire', get_template_directory_uri() . '/formulaire.js', ['jquery'], wp_get_theme()->get('Version'), true);
    }

    if (is_page_template('template-references.php')) {
        wp_enqueue_script('geden-references', get_template_directory_uri() . '/references.js', ['jquery'], wp_get_theme()->get('Version'), true);
    }
}
add_action('wp_enqueue_scripts', 'geden_enqueue_assets');

function geden_admin_enqueue_media_for_references(string $hook): void
{
    $screen = get_current_screen();
    if (!$screen) {
        return;
    }

     if (in_array($hook, ['post.php', 'post-new.php'], true) && $screen->post_type === 'geden_reference') {
        wp_enqueue_media('jquery');
        return;
    }

    if (in_array($hook, ['edit-tags.php', 'term.php'], true) && in_array($screen->taxonomy, ['enjeu_category', 'offre_category'], true)) {
        wp_enqueue_media('jquery');
    }
}
add_action('admin_enqueue_scripts', 'geden_admin_enqueue_media_for_references');

function geden_register_content_types(): void
{
    register_post_type('geden_reference', [
        'labels' => [
            'name' => __('Références', 'geden'),
            'singular_name' => __('Référence', 'geden'),
            'add_new_item' => __('Ajouter une référence', 'geden'),
        ],
        'public' => true,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'],
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'reference'],
    ]);

    register_post_type('geden_sponsor', [
        'labels' => [
            'name' => __('Sponsors', 'geden'),
            'singular_name' => __('Sponsor', 'geden'),
            'add_new_item' => __('Ajouter un sponsor', 'geden'),
        ],
        'public' => true,
        'menu_icon' => 'dashicons-groups',
        'supports' => ['title', 'thumbnail'],
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'sponsor'],
    ]);

    register_post_type('geden_presentation', [
        'labels' => [
            'name' => __('Présentation', 'geden'),
            'singular_name' => __('Élément Présentation', 'geden'),
            'add_new_item' => __('Ajouter un élément Présentation', 'geden'),
        ],
        'public' => true,
        'menu_icon' => 'dashicons-id-alt',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'],
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'presentation-item'],
    ]);

     register_post_type('geden_team', [
        'labels' => [
            'name' => __('Équipe', 'geden'),
            'singular_name' => __('Membre d\'équipe', 'geden'),
            'add_new_item' => __('Ajouter un membre', 'geden'),
        ],
        'public' => true,
        'menu_icon' => 'dashicons-groups',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'],
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'equipe-item'],
    ]);

    register_post_type('geden_enjeu', [
        'labels' => [
            'name' => __('Enjeux', 'geden'),
            'singular_name' => __('Élément Enjeux', 'geden'),
            'add_new_item' => __('Ajouter un élément Enjeux', 'geden'),
        ],
        'public' => true,
        'menu_icon' => 'dashicons-chart-line',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'],
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'enjeu-item'],
    ]);

    register_post_type('geden_offre', [
        'labels' => [
            'name' => __('Offres', 'geden'),
            'singular_name' => __('Élément Offres', 'geden'),
            'add_new_item' => __('Ajouter un élément Offres', 'geden'),
        ],
        'public' => true,
        'menu_icon' => 'dashicons-admin-tools',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'],
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'offre-item'],
    ]);

    register_taxonomy('reference_category', ['geden_reference'], [
        'labels' => [
            'name' => __('Catégories de référence', 'geden'),
            'singular_name' => __('Catégorie de référence', 'geden'),
        ],
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
    ]);

    register_taxonomy('presentation_category', ['geden_presentation'], [
        'labels' => ['name' => __('Catégories Présentation', 'geden')],
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
    ]);

     register_taxonomy('team_category', ['geden_team'], [
        'labels' => ['name' => __('Catégories Équipe', 'geden')],
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
    ]);

    register_taxonomy('enjeu_category', ['geden_enjeu'], [
        'labels' => ['name' => __('Catégories Enjeux', 'geden')],
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
    ]);

    register_taxonomy('offre_category', ['geden_offre'], [
        'labels' => ['name' => __('Catégories Offres', 'geden')],
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
    ]);
}
add_action('init', 'geden_register_content_types');

function geden_register_meta_boxes(): void
{
    add_meta_box('geden_reference_infos', __('Bloc Référence (format identique)', 'geden'), 'geden_reference_meta_box', 'geden_reference', 'normal', 'high');
    add_meta_box('geden_sponsor_infos', __('Infos sponsor', 'geden'), 'geden_sponsor_meta_box', 'geden_sponsor', 'normal', 'default');
    add_meta_box('geden_presentation_infos', __('Bloc Présentation', 'geden'), 'geden_presentation_meta_box', 'geden_presentation', 'normal', 'high');
    add_meta_box('geden_team_infos', __('Membre équipe', 'geden'), 'geden_team_meta_box', 'geden_team', 'normal', 'high');
    add_meta_box('geden_enjeu_infos', __('Bloc Enjeu / Problématique', 'geden'), 'geden_enjeu_meta_box', 'geden_enjeu', 'normal', 'high');
    add_meta_box('geden_offre_infos', __('Bloc Offre / Service', 'geden'), 'geden_offre_meta_box', 'geden_offre', 'normal', 'high');
    add_meta_box('geden_references_page_options', __('Options page Références', 'geden'), 'geden_references_page_options_meta_box', 'page', 'normal', 'high');
}
add_action('add_meta_boxes', 'geden_register_meta_boxes');

function geden_reference_meta_box(WP_Post $post): void
{
    wp_nonce_field('geden_save_reference_meta', 'geden_reference_nonce');

    $year = (string) get_post_meta($post->ID, '_geden_reference_year', true);
    $client = (string) get_post_meta($post->ID, '_geden_reference_client', true);
    $project_link = (string) get_post_meta($post->ID, '_geden_reference_link', true);
    $needs = (string) get_post_meta($post->ID, '_geden_reference_needs', true);
    $services = (string) get_post_meta($post->ID, '_geden_reference_services', true);
    $authors = (string) get_post_meta($post->ID, '_geden_reference_authors', true);
    $deliverable = (string) get_post_meta($post->ID, '_geden_reference_deliverable', true);
   $saved_logos = geden_get_reference_sponsor_logos($post->ID);
    if (empty($saved_logos)) {
        $saved_logos = [['name' => '', 'url' => '', 'image_id' => 0]];
    }
    ?>
    <p>
      <strong><?php esc_html_e('Astuce catégorie', 'geden'); ?></strong>:
      <code>realisations-effectuees</code>, <code>realisations-en-cours</code> <?php esc_html_e('ou', 'geden'); ?> <code>productions-techniques-scientifiques</code>
    </p>
    <p><label for="geden_reference_year"><strong><?php esc_html_e('Année / période', 'geden'); ?></strong></label><br>
      <input type="text" id="geden_reference_year" name="geden_reference_year" value="<?php echo esc_attr($year); ?>" style="width: 240px;" />
    </p>
    <p><label for="geden_reference_client"><strong><?php esc_html_e('Client', 'geden'); ?></strong></label><br>
      <input type="text" id="geden_reference_client" name="geden_reference_client" value="<?php echo esc_attr($client); ?>" style="width: 100%;" />
    </p>
    <p><label for="geden_reference_link"><strong><?php esc_html_e('Lien du projet', 'geden'); ?></strong></label><br>
      <input type="url" id="geden_reference_link" name="geden_reference_link" value="<?php echo esc_url($project_link); ?>" style="width: 100%;" />
    </p>
    <p><label for="geden_reference_needs"><strong><?php esc_html_e('Besoins (1 ligne = 1 puce)', 'geden'); ?></strong></label><br>
      <textarea id="geden_reference_needs" name="geden_reference_needs" rows="4" style="width: 100%;"><?php echo esc_textarea($needs); ?></textarea>
    </p>
    <p><label for="geden_reference_services"><strong><?php esc_html_e('Prestations (1 ligne = 1 puce)', 'geden'); ?></strong></label><br>
      <textarea id="geden_reference_services" name="geden_reference_services" rows="4" style="width: 100%;"><?php echo esc_textarea($services); ?></textarea>
    </p>
    <p><label for="geden_reference_authors"><strong><?php esc_html_e('Auteurs (productions)', 'geden'); ?></strong></label><br>
      <input type="text" id="geden_reference_authors" name="geden_reference_authors" value="<?php echo esc_attr($authors); ?>" style="width: 100%;" />
    </p>
    <p><label for="geden_reference_deliverable"><strong><?php esc_html_e('Livrable (productions)', 'geden'); ?></strong></label><br>
      <input type="text" id="geden_reference_deliverable" name="geden_reference_deliverable" value="<?php echo esc_attr($deliverable); ?>" style="width: 100%;" />
    </p>
    <div>
      <label><strong><?php esc_html_e('Sponsors (logos)', 'geden'); ?></strong></label>
      <p style="margin-top:6px;"><?php esc_html_e('Ajoutez un nom (title), un lien et une image pour chaque logo.', 'geden'); ?></p>
      <div id="geden-sponsor-rows">
        <?php foreach ($saved_logos as $logo) : ?>
          <div class="geden-sponsor-row" style="display:grid;grid-template-columns:1fr 1fr auto auto;gap:8px;align-items:center;margin-bottom:8px;">
            <input type="text" name="geden_reference_sponsors_name[]" value="<?php echo esc_attr((string) ($logo['name'] ?? '')); ?>" placeholder="<?php esc_attr_e('Nom du sponsor', 'geden'); ?>" />
            <input type="url" name="geden_reference_sponsors_url[]" value="<?php echo esc_url((string) ($logo['url'] ?? '')); ?>" placeholder="<?php esc_attr_e('https://...', 'geden'); ?>" />
            <input type="hidden" class="geden-sponsor-image-id" name="geden_reference_sponsors_image_id[]" value="<?php echo esc_attr((string) ((int) ($logo['image_id'] ?? 0))); ?>" />
            <button type="button" class="button geden-pick-image"><?php esc_html_e('Choisir image', 'geden'); ?></button>
            <button type="button" class="button-link-delete geden-remove-row"><?php esc_html_e('Supprimer', 'geden'); ?></button>
          </div>
          <?php endforeach; ?>
          </div>
      <button type="button" class="button" id="geden-add-sponsor-row"><?php esc_html_e('Ajouter un logo', 'geden'); ?></button>
    </div>
    <script>
      (function($){
        const rows = $('#geden-sponsor-rows');
        $('#geden-add-sponsor-row').on('click', function(){
          rows.append('<div class="geden-sponsor-row" style="display:grid;grid-template-columns:1fr 1fr auto auto;gap:8px;align-items:center;margin-bottom:8px;"><input type="text" name="geden_reference_sponsors_name[]" placeholder="<?php echo esc_js(__('Nom du sponsor', 'geden')); ?>" /><input type="url" name="geden_reference_sponsors_url[]" placeholder="https://..." /><input type="hidden" class="geden-sponsor-image-id" name="geden_reference_sponsors_image_id[]" value="0" /><button type="button" class="button geden-pick-image"><?php echo esc_js(__('Choisir image', 'geden')); ?></button><button type="button" class="button-link-delete geden-remove-row"><?php echo esc_js(__('Supprimer', 'geden')); ?></button></div>');
        });
        rows.on('click', '.geden-remove-row', function(){
          $(this).closest('.geden-sponsor-row').remove();
        });
        rows.on('click', '.geden-pick-image', function(){
          const button = $(this);
          const target = button.closest('.geden-sponsor-row').find('.geden-sponsor-image-id');
          const frame = wp.media({ title: '<?php echo esc_js(__('Choisir un logo', 'geden')); ?>', multiple: false, library: { type: 'image' } });
          frame.on('select', function(){
            const image = frame.state().get('selection').first().toJSON();
            target.val(image.id || 0);
            button.text(image.filename ? image.filename : '<?php echo esc_js(__('Image sélectionnée', 'geden')); ?>');
          });
          frame.open();
        });
      })(jQuery);
    </script>
    <?php
}

function geden_sponsor_meta_box(WP_Post $post): void
{
    wp_nonce_field('geden_save_sponsor_meta', 'geden_sponsor_nonce');
    $website = (string) get_post_meta($post->ID, '_geden_sponsor_website', true);
    ?>
    <p><label for="geden_sponsor_website"><strong><?php esc_html_e('Lien site sponsor', 'geden'); ?></strong></label><br>
      <input type="url" id="geden_sponsor_website" name="geden_sponsor_website" value="<?php echo esc_url($website); ?>" style="width: 100%;" />
    </p>
    <?php
}

function geden_references_page_options_meta_box(WP_Post $post): void
{
    $template = (string) get_page_template_slug($post->ID);
    if ($template !== 'template-references.php') {
        echo '<p>' . esc_html__('Ce bloc est utilisé uniquement sur la page avec le template "Références (dynamique)".', 'geden') . '</p>';
        return;
    }

    wp_nonce_field('geden_save_references_page_options', 'geden_references_page_options_nonce');

    $banner_image_id = (int) get_post_meta($post->ID, '_geden_references_banner_image_id', true);
    $hero_image_id = (int) get_post_meta($post->ID, '_geden_references_hero_image_id', true);
    $hero_title = (string) get_post_meta($post->ID, '_geden_references_hero_title', true);
    $hero_subtitle = (string) get_post_meta($post->ID, '_geden_references_hero_subtitle', true);
    $hero_link_text = (string) get_post_meta($post->ID, '_geden_references_hero_link_text', true);
    $hero_link_url = (string) get_post_meta($post->ID, '_geden_references_hero_link_url', true);
    ?>
    <p><label for="geden_references_banner_image_id"><strong><?php esc_html_e('Image bandeau avant productions', 'geden'); ?></strong></label><br>
      <input type="number" id="geden_references_banner_image_id" name="geden_references_banner_image_id" value="<?php echo esc_attr((string) $banner_image_id); ?>" min="0" style="width: 180px;" />
      <small style="display:block;"><?php esc_html_e('Saisissez un ID de média WordPress.', 'geden'); ?></small>
    </p>
    <p><label for="geden_references_hero_image_id"><strong><?php esc_html_e('Image hero productions', 'geden'); ?></strong></label><br>
      <input type="number" id="geden_references_hero_image_id" name="geden_references_hero_image_id" value="<?php echo esc_attr((string) $hero_image_id); ?>" min="0" style="width: 180px;" />
    </p>
    <p><label for="geden_references_hero_title"><strong><?php esc_html_e('Titre productions', 'geden'); ?></strong></label><br>
      <input type="text" id="geden_references_hero_title" name="geden_references_hero_title" value="<?php echo esc_attr($hero_title); ?>" style="width: 100%;" />
    </p>
    <p><label for="geden_references_hero_subtitle"><strong><?php esc_html_e('Sous-titre productions', 'geden'); ?></strong></label><br>
      <input type="text" id="geden_references_hero_subtitle" name="geden_references_hero_subtitle" value="<?php echo esc_attr($hero_subtitle); ?>" style="width: 100%;" />
    </p>
    <p><label for="geden_references_hero_link_text"><strong><?php esc_html_e('Texte du lien (optionnel)', 'geden'); ?></strong></label><br>
      <input type="text" id="geden_references_hero_link_text" name="geden_references_hero_link_text" value="<?php echo esc_attr($hero_link_text); ?>" style="width: 100%;" />
    </p>
    <p><label for="geden_references_hero_link_url"><strong><?php esc_html_e('URL du lien (optionnel)', 'geden'); ?></strong></label><br>
      <input type="url" id="geden_references_hero_link_url" name="geden_references_hero_link_url" value="<?php echo esc_url($hero_link_url); ?>" style="width: 100%;" />
    </p>
    <?php
}

function geden_enjeu_meta_box(WP_Post $post): void
{
    wp_nonce_field('geden_save_enjeu_meta', 'geden_enjeu_nonce');

    $badge = (string) get_post_meta($post->ID, '_geden_enjeu_badge', true);
    $icon = (string) get_post_meta($post->ID, '_geden_enjeu_icon', true);
    $lines = (string) get_post_meta($post->ID, '_geden_enjeu_lines', true);
    $text = (string) get_post_meta($post->ID, '_geden_enjeu_text', true);
    ?>
    <p><strong><?php esc_html_e('Astuce catégorie', 'geden'); ?></strong>: <code>blocs-enjeux</code>, <code>blocs-permet</code>, <code>blocs-problematiques</code></p>
    <p>
      <label for="geden_enjeu_badge"><strong><?php esc_html_e('Couleur du picto', 'geden'); ?></strong></label><br>
      <select id="geden_enjeu_badge" name="geden_enjeu_badge">
        <?php
        $badges = [
            'badge-blue' => __('Bleu', 'geden'),
            'badge-orange' => __('Orange', 'geden'),
            'badge-green' => __('Vert', 'geden'),
            'badge-navy' => __('Bleu nuit', 'geden'),
            'badge-purple' => __('Violet', 'geden'),
            'badge-teal' => __('Turquoise', 'geden'),
            'badge-amber' => __('Ambre', 'geden'),
        ];
        foreach ($badges as $value => $label) :
          ?>
          <option value="<?php echo esc_attr($value); ?>" <?php selected($badge, $value); ?>><?php echo esc_html($label); ?></option>
        <?php endforeach; ?>
      </select>
    </p>
    <p>
      <label for="geden_enjeu_icon"><strong><?php esc_html_e('Icône', 'geden'); ?></strong></label><br>
      <select id="geden_enjeu_icon" name="geden_enjeu_icon">
        <?php
        $icons = [
            'chart' => __('Graphique', 'geden'),
            'clock' => __('Horloge', 'geden'),
            'leaf' => __('Feuille', 'geden'),
            'ruler' => __('Mesure', 'geden'),
            'shuffle' => __('Flux', 'geden'),
            'cross' => __('Croisement', 'geden'),
            'megaphone' => __('Communication', 'geden'),
            'people' => __('Usagers', 'geden'),
            'bubble' => __('Perceptions', 'geden'),
            'check' => __('Réglementation', 'geden'),
        ];
        foreach ($icons as $value => $label) :
          ?>
          <option value="<?php echo esc_attr($value); ?>" <?php selected($icon, $value); ?>><?php echo esc_html($label); ?></option>
        <?php endforeach; ?>
      </select>
    </p>
    <p><label for="geden_enjeu_text"><strong><?php esc_html_e('Texte court (optionnel)', 'geden'); ?></strong></label><br>
      <input type="text" id="geden_enjeu_text" name="geden_enjeu_text" value="<?php echo esc_attr($text); ?>" style="width: 100%;" />
    </p>
    <p><label for="geden_enjeu_lines"><strong><?php esc_html_e('Liste (1 ligne = 1 puce)', 'geden'); ?></strong></label><br>
      <textarea id="geden_enjeu_lines" name="geden_enjeu_lines" rows="5" style="width: 100%;"><?php echo esc_textarea($lines); ?></textarea>
    </p>
    <?php
}

function geden_offre_meta_box(WP_Post $post): void
{
    wp_nonce_field('geden_save_offre_meta', 'geden_offre_nonce');
    $badge = (string) get_post_meta($post->ID, '_geden_offre_badge', true);
    $icon = (string) get_post_meta($post->ID, '_geden_offre_icon', true);
    $text = (string) get_post_meta($post->ID, '_geden_offre_text', true);
    $lines = (string) get_post_meta($post->ID, '_geden_offre_lines', true);
    if ($badge === '') {
        $badge = 'badge-blue';
    }
    if ($icon === '') {
        $icon = 'chart';
    }
    ?>
    <p><strong><?php esc_html_e('Astuce catégorie', 'geden'); ?></strong>: <code>blocs-offres</code>, <code>frequentation</code>, <code>enquetes</code>, <code>entretiens</code>, <code>outils-analytiques</code></p>
    <p>
      <label for="geden_offre_badge"><strong><?php esc_html_e('Couleur du picto', 'geden'); ?></strong></label><br>
      <select id="geden_offre_badge" name="geden_offre_badge">
        <?php
        $badges = [
            'badge-blue' => __('Bleu', 'geden'),
            'badge-green' => __('Vert', 'geden'),
            'badge-orange' => __('Orange', 'geden'),
            'badge-navy' => __('Marine', 'geden'),
            'badge-teal' => __('Turquoise', 'geden'),
            'badge-amber' => __('Ambre', 'geden'),
        ];
        foreach ($badges as $value => $label) :
          ?>
          <option value="<?php echo esc_attr($value); ?>" <?php selected($badge, $value); ?>><?php echo esc_html($label); ?></option>
        <?php endforeach; ?>
      </select>
    </p>
    <p>
      <label for="geden_offre_icon"><strong><?php esc_html_e('Icône', 'geden'); ?></strong></label><br>
      <select id="geden_offre_icon" name="geden_offre_icon">
        <?php
        $icons = [
            'chart' => __('Graphique', 'geden'),
            'clock' => __('Horloge', 'geden'),
            'leaf' => __('Feuille', 'geden'),
            'ruler' => __('Mesure', 'geden'),
            'shuffle' => __('Flux', 'geden'),
            'cross' => __('Croisement', 'geden'),
            'megaphone' => __('Communication', 'geden'),
            'people' => __('Usagers', 'geden'),
            'bubble' => __('Perceptions', 'geden'),
            'check' => __('Réglementation', 'geden'),
        ];
        foreach ($icons as $value => $label) :
          ?>
          <option value="<?php echo esc_attr($value); ?>" <?php selected($icon, $value); ?>><?php echo esc_html($label); ?></option>
        <?php endforeach; ?>
      </select>
    </p>
        <p><label for="geden_offre_text"><strong><?php esc_html_e('Texte court (optionnel)', 'geden'); ?></strong></label><br>
      <input type="text" id="geden_offre_text" name="geden_offre_text" value="<?php echo esc_attr($text); ?>" style="width: 100%;" />
    </p>
    <p><label for="geden_offre_lines"><strong><?php esc_html_e('Liste (1 ligne = 1 puce)', 'geden'); ?></strong></label><br>
      <textarea id="geden_offre_lines" name="geden_offre_lines" rows="5" style="width: 100%;"><?php echo esc_textarea($lines); ?></textarea>
    </p>
    <?php
}

function geden_presentation_meta_box(WP_Post $post): void
{
    wp_nonce_field('geden_save_presentation_meta', 'geden_presentation_nonce');
    $layout = (string) get_post_meta($post->ID, '_geden_presentation_layout', true);
    $button_label = (string) get_post_meta($post->ID, '_geden_presentation_button_label', true);
    if ($layout === '') {
        $layout = 'split-media-left';
    }
    ?>
    <p><strong><?php esc_html_e('Astuce catégorie', 'geden'); ?></strong>: <code>blocs-presentation</code>, <code>blocs-valeurs</code></p>
    <p>
      <label for="geden_presentation_layout"><strong><?php esc_html_e('Type de bloc', 'geden'); ?></strong></label><br>
      <select id="geden_presentation_layout" name="geden_presentation_layout">
        <?php
        $layouts = [
            'split-media-left' => __('Texte + image (image à gauche)', 'geden'),
            'split-media-right' => __('Texte + image (image à droite)', 'geden'),
            'text-only' => __('Texte seul', 'geden'),
            'quote' => __('Citation / mise en avant', 'geden'),
        ];
        foreach ($layouts as $value => $label) :
        ?>
          <option value="<?php echo esc_attr($value); ?>" <?php selected($layout, $value); ?>><?php echo esc_html($label); ?></option>
        <?php endforeach; ?>
      </select>
    </p>
    <p>
      <label for="geden_presentation_button_label"><strong><?php esc_html_e('Label de pastille (optionnel)', 'geden'); ?></strong></label><br>
      <input type="text" id="geden_presentation_button_label" name="geden_presentation_button_label" value="<?php echo esc_attr($button_label); ?>" style="width: 100%;" placeholder="<?php esc_attr_e('Ex: Nos valeurs', 'geden'); ?>" />
    </p>
    <?php
}

function geden_team_meta_box(WP_Post $post): void
{
    wp_nonce_field('geden_save_team_meta', 'geden_team_nonce');
    $role = (string) get_post_meta($post->ID, '_geden_team_role', true);
    $modal_title = (string) get_post_meta($post->ID, '_geden_team_modal_title', true);
    ?>
    <p><strong><?php esc_html_e('Astuce catégorie', 'geden'); ?></strong>: <code>membres-equipe</code></p>
    <p>
      <label for="geden_team_role"><strong><?php esc_html_e('Rôle affiché sur la carte', 'geden'); ?></strong></label><br>
      <input type="text" id="geden_team_role" name="geden_team_role" value="<?php echo esc_attr($role); ?>" style="width: 100%;" />
    </p>
    <p>
      <label for="geden_team_modal_title"><strong><?php esc_html_e('Titre secondaire modal (optionnel)', 'geden'); ?></strong></label><br>
      <input type="text" id="geden_team_modal_title" name="geden_team_modal_title" value="<?php echo esc_attr($modal_title); ?>" style="width: 100%;" placeholder="<?php esc_attr_e('Ex: Expertise / Spécialité', 'geden'); ?>" />
    </p>
    <p><?php esc_html_e('Le contenu principal de la modale est le contenu de l’éditeur du membre.', 'geden'); ?></p>
    <?php
}

function geden_enjeu_category_add_form_fields(): void
{
    ?>
    <div class="form-field">
      <label for="geden_enjeu_category_tag"><?php esc_html_e('Tag affiché sur le bloc', 'geden'); ?></label>
      <input type="text" name="geden_enjeu_category_tag" id="geden_enjeu_category_tag" />
    </div>
    <div class="form-field">
      <label for="geden_enjeu_category_title"><?php esc_html_e('Titre du bloc', 'geden'); ?></label>
      <input type="text" name="geden_enjeu_category_title" id="geden_enjeu_category_title" />
    </div>
    <div class="form-field">
      <label for="geden_enjeu_category_subtitle"><?php esc_html_e('Sous-titre du bloc', 'geden'); ?></label>
      <textarea name="geden_enjeu_category_subtitle" id="geden_enjeu_category_subtitle" rows="4"></textarea>
    </div>
    <div class="form-field">
      <label for="geden_enjeu_category_image_id"><?php esc_html_e('Image du bloc', 'geden'); ?></label>
      <input type="hidden" name="geden_enjeu_category_image_id" id="geden_enjeu_category_image_id" value="0" />
      <input type="text" id="geden_enjeu_category_image_url" value="" placeholder="<?php esc_attr_e('Aucune image sélectionnée', 'geden'); ?>" readonly />
      <button type="button" class="button" id="geden_pick_enjeu_category_image"><?php esc_html_e('Choisir image', 'geden'); ?></button>
      <button type="button" class="button-link-delete" id="geden_clear_enjeu_category_image"><?php esc_html_e('Supprimer', 'geden'); ?></button>
      <p><?php esc_html_e('Utilisez la médiathèque WordPress.', 'geden'); ?></p>
    </div>
    <script>
      (function($){
        const idField = $('#geden_enjeu_category_image_id');
        const urlField = $('#geden_enjeu_category_image_url');
        $('#geden_pick_enjeu_category_image').on('click', function(e){
          e.preventDefault();
          const frame = wp.media({ title: '<?php echo esc_js(__('Choisir une image', 'geden')); ?>', multiple: false, library: { type: 'image' } });
          frame.on('select', function(){
            const image = frame.state().get('selection').first().toJSON();
            idField.val(image.id || 0);
            urlField.val(image.url || '');
          });
          frame.open();
        });
        $('#geden_clear_enjeu_category_image').on('click', function(e){
          e.preventDefault();
          idField.val(0);
          urlField.val('');
        });
      })(jQuery);
    </script>
    <?php
}
add_action('enjeu_category_add_form_fields', 'geden_enjeu_category_add_form_fields');

function geden_enjeu_category_edit_form_fields(WP_Term $term): void
{
    $tag = (string) get_term_meta($term->term_id, '_geden_enjeu_category_tag', true);
    $title = (string) get_term_meta($term->term_id, '_geden_enjeu_category_title', true);
    $subtitle = (string) get_term_meta($term->term_id, '_geden_enjeu_category_subtitle', true);
    $image_id = (int) get_term_meta($term->term_id, '_geden_enjeu_category_image_id', true);
    $image_url = $image_id > 0 ? (string) wp_get_attachment_image_url($image_id, 'full') : (string) get_term_meta($term->term_id, '_geden_enjeu_category_image_url', true);
    ?>
    <tr class="form-field">
      <th scope="row"><label for="geden_enjeu_category_tag"><?php esc_html_e('Tag affiché sur le bloc', 'geden'); ?></label></th>
      <td><input type="text" name="geden_enjeu_category_tag" id="geden_enjeu_category_tag" value="<?php echo esc_attr($tag); ?>" /></td>
    </tr>
    <tr class="form-field">
      <th scope="row"><label for="geden_enjeu_category_title"><?php esc_html_e('Titre du bloc', 'geden'); ?></label></th>
      <td><input type="text" name="geden_enjeu_category_title" id="geden_enjeu_category_title" value="<?php echo esc_attr($title); ?>" /></td>
    </tr>
    <tr class="form-field">
      <th scope="row"><label for="geden_enjeu_category_subtitle"><?php esc_html_e('Sous-titre du bloc', 'geden'); ?></label></th>
      <td><textarea name="geden_enjeu_category_subtitle" id="geden_enjeu_category_subtitle" rows="4"><?php echo esc_textarea($subtitle); ?></textarea></td>
    </tr>
    <tr class="form-field">
      <th scope="row"><label for="geden_enjeu_category_image_id"><?php esc_html_e('Image du bloc', 'geden'); ?></label></th>
      <td>
        <input type="hidden" name="geden_enjeu_category_image_id" id="geden_enjeu_category_image_id" value="<?php echo esc_attr((string) $image_id); ?>" />
        <input type="text" id="geden_enjeu_category_image_url" value="<?php echo esc_url($image_url); ?>" placeholder="<?php esc_attr_e('Aucune image sélectionnée', 'geden'); ?>" readonly style="min-width:360px;" />
        <button type="button" class="button" id="geden_pick_enjeu_category_image"><?php esc_html_e('Choisir image', 'geden'); ?></button>
        <button type="button" class="button-link-delete" id="geden_clear_enjeu_category_image"><?php esc_html_e('Supprimer', 'geden'); ?></button>
        <p class="description"><?php esc_html_e('Utilisez la médiathèque WordPress.', 'geden'); ?></p>
      </td>
    </tr>
    <script>
      (function($){
        const idField = $('#geden_enjeu_category_image_id');
        const urlField = $('#geden_enjeu_category_image_url');
        $('#geden_pick_enjeu_category_image').on('click', function(e){
          e.preventDefault();
          const frame = wp.media({ title: '<?php echo esc_js(__('Choisir une image', 'geden')); ?>', multiple: false, library: { type: 'image' } });
          frame.on('select', function(){
            const image = frame.state().get('selection').first().toJSON();
            idField.val(image.id || 0);
            urlField.val(image.url || '');
          });
          frame.open();
        });
        $('#geden_clear_enjeu_category_image').on('click', function(e){
          e.preventDefault();
          idField.val(0);
          urlField.val('');
        });
      })(jQuery);
    </script>
    <?php
}
add_action('enjeu_category_edit_form_fields', 'geden_enjeu_category_edit_form_fields');

function geden_save_enjeu_category_meta(int $term_id): void
{
    update_term_meta($term_id, '_geden_enjeu_category_tag', sanitize_text_field((string) wp_unslash($_POST['geden_enjeu_category_tag'] ?? '')));
    update_term_meta($term_id, '_geden_enjeu_category_title', sanitize_text_field((string) wp_unslash($_POST['geden_enjeu_category_title'] ?? '')));
    update_term_meta($term_id, '_geden_enjeu_category_subtitle', sanitize_textarea_field((string) wp_unslash($_POST['geden_enjeu_category_subtitle'] ?? '')));
    update_term_meta($term_id, '_geden_enjeu_category_image_id', absint($_POST['geden_enjeu_category_image_id'] ?? 0));
}
add_action('created_enjeu_category', 'geden_save_enjeu_category_meta');
add_action('edited_enjeu_category', 'geden_save_enjeu_category_meta');

function geden_offre_category_add_form_fields(): void
{
    ?>
    <div class="form-field">
      <label for="geden_offre_category_tag"><?php esc_html_e('Tag affiché sur le bloc', 'geden'); ?></label>
      <input type="text" name="geden_offre_category_tag" id="geden_offre_category_tag" />
    </div>
    <div class="form-field">
      <label for="geden_offre_category_title"><?php esc_html_e('Titre du bloc', 'geden'); ?></label>
      <input type="text" name="geden_offre_category_title" id="geden_offre_category_title" />
    </div>
    <div class="form-field">
      <label for="geden_offre_category_subtitle"><?php esc_html_e('Sous-titre du bloc', 'geden'); ?></label>
      <textarea name="geden_offre_category_subtitle" id="geden_offre_category_subtitle" rows="4"></textarea>
    </div>
    <div class="form-field">
      <label for="geden_offre_category_image_id"><?php esc_html_e('Image du bloc', 'geden'); ?></label>
      <input type="hidden" name="geden_offre_category_image_id" id="geden_offre_category_image_id" value="0" />
      <input type="text" id="geden_offre_category_image_url" value="" placeholder="<?php esc_attr_e('Aucune image sélectionnée', 'geden'); ?>" readonly />
      <button type="button" class="button" id="geden_pick_offre_category_image"><?php esc_html_e('Choisir image', 'geden'); ?></button>
      <button type="button" class="button-link-delete" id="geden_clear_offre_category_image"><?php esc_html_e('Supprimer', 'geden'); ?></button>
      <p><?php esc_html_e('Utilisez la médiathèque WordPress.', 'geden'); ?></p>
    </div>
    <script>
      (function($){
        const idField = $('#geden_offre_category_image_id');
        const urlField = $('#geden_offre_category_image_url');
        $('#geden_pick_offre_category_image').on('click', function(e){
          e.preventDefault();
          const frame = wp.media({ title: '<?php echo esc_js(__('Choisir une image', 'geden')); ?>', multiple: false, library: { type: 'image' } });
          frame.on('select', function(){
            const image = frame.state().get('selection').first().toJSON();
            idField.val(image.id || 0);
            urlField.val(image.url || '');
          });
          frame.open();
        });
        $('#geden_clear_offre_category_image').on('click', function(e){
          e.preventDefault();
          idField.val(0);
          urlField.val('');
        });
      })(jQuery);
    </script>
    <?php
}
add_action('offre_category_add_form_fields', 'geden_offre_category_add_form_fields');

function geden_offre_category_edit_form_fields(WP_Term $term): void
{
    $tag = (string) get_term_meta($term->term_id, '_geden_offre_category_tag', true);
    $title = (string) get_term_meta($term->term_id, '_geden_offre_category_title', true);
    $subtitle = (string) get_term_meta($term->term_id, '_geden_offre_category_subtitle', true);
    $image_id = (int) get_term_meta($term->term_id, '_geden_offre_category_image_id', true);
    $image_url = $image_id > 0 ? (string) wp_get_attachment_image_url($image_id, 'full') : '';
    ?>
    <tr class="form-field">
      <th scope="row"><label for="geden_offre_category_tag"><?php esc_html_e('Tag affiché sur le bloc', 'geden'); ?></label></th>
      <td><input type="text" name="geden_offre_category_tag" id="geden_offre_category_tag" value="<?php echo esc_attr($tag); ?>" /></td>
    </tr>
    <tr class="form-field">
      <th scope="row"><label for="geden_offre_category_title"><?php esc_html_e('Titre du bloc', 'geden'); ?></label></th>
      <td><input type="text" name="geden_offre_category_title" id="geden_offre_category_title" value="<?php echo esc_attr($title); ?>" /></td>
    </tr>
    <tr class="form-field">
      <th scope="row"><label for="geden_offre_category_subtitle"><?php esc_html_e('Sous-titre du bloc', 'geden'); ?></label></th>
      <td><textarea name="geden_offre_category_subtitle" id="geden_offre_category_subtitle" rows="4"><?php echo esc_textarea($subtitle); ?></textarea></td>
    </tr>
    <tr class="form-field">
      <th scope="row"><label for="geden_offre_category_image_id"><?php esc_html_e('Image du bloc', 'geden'); ?></label></th>
      <td>
        <input type="hidden" name="geden_offre_category_image_id" id="geden_offre_category_image_id" value="<?php echo esc_attr((string) $image_id); ?>" />
        <input type="text" id="geden_offre_category_image_url" value="<?php echo esc_url($image_url); ?>" placeholder="<?php esc_attr_e('Aucune image sélectionnée', 'geden'); ?>" readonly style="min-width:360px;" />
        <button type="button" class="button" id="geden_pick_offre_category_image"><?php esc_html_e('Choisir image', 'geden'); ?></button>
        <button type="button" class="button-link-delete" id="geden_clear_offre_category_image"><?php esc_html_e('Supprimer', 'geden'); ?></button>
      </td>
    </tr>
    <script>
      (function($){
        const idField = $('#geden_offre_category_image_id');
        const urlField = $('#geden_offre_category_image_url');
        $('#geden_pick_offre_category_image').on('click', function(e){
          e.preventDefault();
          const frame = wp.media({ title: '<?php echo esc_js(__('Choisir une image', 'geden')); ?>', multiple: false, library: { type: 'image' } });
          frame.on('select', function(){
            const image = frame.state().get('selection').first().toJSON();
            idField.val(image.id || 0);
            urlField.val(image.url || '');
          });
          frame.open();
        });
        $('#geden_clear_offre_category_image').on('click', function(e){
          e.preventDefault();
          idField.val(0);
          urlField.val('');
        });
      })(jQuery);
    </script>
    <?php
}
add_action('offre_category_edit_form_fields', 'geden_offre_category_edit_form_fields');

function geden_save_offre_category_meta(int $term_id): void
{
    update_term_meta($term_id, '_geden_offre_category_tag', sanitize_text_field((string) wp_unslash($_POST['geden_offre_category_tag'] ?? '')));
    update_term_meta($term_id, '_geden_offre_category_title', sanitize_text_field((string) wp_unslash($_POST['geden_offre_category_title'] ?? '')));
    update_term_meta($term_id, '_geden_offre_category_subtitle', sanitize_textarea_field((string) wp_unslash($_POST['geden_offre_category_subtitle'] ?? '')));
    update_term_meta($term_id, '_geden_offre_category_image_id', absint($_POST['geden_offre_category_image_id'] ?? 0));
}
add_action('created_offre_category', 'geden_save_offre_category_meta');
add_action('edited_offre_category', 'geden_save_offre_category_meta');

function geden_save_meta_boxes(int $post_id): void
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['geden_reference_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['geden_reference_nonce'])), 'geden_save_reference_meta')) {
        update_post_meta($post_id, '_geden_reference_year', sanitize_text_field((string) wp_unslash($_POST['geden_reference_year'] ?? '')));
        update_post_meta($post_id, '_geden_reference_client', sanitize_text_field((string) wp_unslash($_POST['geden_reference_client'] ?? '')));
        update_post_meta($post_id, '_geden_reference_link', esc_url_raw((string) wp_unslash($_POST['geden_reference_link'] ?? '')));
        update_post_meta($post_id, '_geden_reference_needs', sanitize_textarea_field((string) wp_unslash($_POST['geden_reference_needs'] ?? '')));
        update_post_meta($post_id, '_geden_reference_services', sanitize_textarea_field((string) wp_unslash($_POST['geden_reference_services'] ?? '')));
        update_post_meta($post_id, '_geden_reference_authors', sanitize_text_field((string) wp_unslash($_POST['geden_reference_authors'] ?? '')));
        update_post_meta($post_id, '_geden_reference_deliverable', sanitize_text_field((string) wp_unslash($_POST['geden_reference_deliverable'] ?? '')));
        $logo_names = isset($_POST['geden_reference_sponsors_name']) ? (array) wp_unslash($_POST['geden_reference_sponsors_name']) : [];
        $logo_urls = isset($_POST['geden_reference_sponsors_url']) ? (array) wp_unslash($_POST['geden_reference_sponsors_url']) : [];
        $logo_image_ids = isset($_POST['geden_reference_sponsors_image_id']) ? (array) wp_unslash($_POST['geden_reference_sponsors_image_id']) : [];
        $max = max(count($logo_names), count($logo_urls), count($logo_image_ids));
        $logos = [];
        for ($i = 0; $i < $max; $i++) {
            $name = sanitize_text_field((string) ($logo_names[$i] ?? ''));
            $url = esc_url_raw((string) ($logo_urls[$i] ?? ''));
            $image_id = absint($logo_image_ids[$i] ?? 0);
            if ($name === '' && $url === '' && $image_id === 0) {
                continue;
            }
            $logos[] = ['name' => $name, 'url' => $url, 'image_id' => $image_id];
        }
        update_post_meta($post_id, '_geden_reference_sponsor_logos', wp_json_encode($logos));    }

    if (isset($_POST['geden_sponsor_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['geden_sponsor_nonce'])), 'geden_save_sponsor_meta')) {
        $website = isset($_POST['geden_sponsor_website']) ? esc_url_raw(wp_unslash($_POST['geden_sponsor_website'])) : '';
        update_post_meta($post_id, '_geden_sponsor_website', $website);
    }

    if (isset($_POST['geden_presentation_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['geden_presentation_nonce'])), 'geden_save_presentation_meta')) {
        update_post_meta($post_id, '_geden_presentation_layout', sanitize_text_field((string) wp_unslash($_POST['geden_presentation_layout'] ?? 'split-media-left')));
        update_post_meta($post_id, '_geden_presentation_button_label', sanitize_text_field((string) wp_unslash($_POST['geden_presentation_button_label'] ?? '')));
    }

    if (isset($_POST['geden_team_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['geden_team_nonce'])), 'geden_save_team_meta')) {
        update_post_meta($post_id, '_geden_team_role', sanitize_text_field((string) wp_unslash($_POST['geden_team_role'] ?? '')));
        update_post_meta($post_id, '_geden_team_modal_title', sanitize_text_field((string) wp_unslash($_POST['geden_team_modal_title'] ?? '')));
    }

    if (isset($_POST['geden_references_page_options_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['geden_references_page_options_nonce'])), 'geden_save_references_page_options')) {
        update_post_meta($post_id, '_geden_references_banner_image_id', absint(wp_unslash($_POST['geden_references_banner_image_id'] ?? 0)));
        update_post_meta($post_id, '_geden_references_hero_image_id', absint(wp_unslash($_POST['geden_references_hero_image_id'] ?? 0)));
        update_post_meta($post_id, '_geden_references_hero_title', sanitize_text_field((string) wp_unslash($_POST['geden_references_hero_title'] ?? '')));
        update_post_meta($post_id, '_geden_references_hero_subtitle', sanitize_text_field((string) wp_unslash($_POST['geden_references_hero_subtitle'] ?? '')));
        update_post_meta($post_id, '_geden_references_hero_link_text', sanitize_text_field((string) wp_unslash($_POST['geden_references_hero_link_text'] ?? '')));
        update_post_meta($post_id, '_geden_references_hero_link_url', esc_url_raw((string) wp_unslash($_POST['geden_references_hero_link_url'] ?? '')));
    }

    if (isset($_POST['geden_enjeu_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['geden_enjeu_nonce'])), 'geden_save_enjeu_meta')) {
        update_post_meta($post_id, '_geden_enjeu_badge', sanitize_text_field((string) wp_unslash($_POST['geden_enjeu_badge'] ?? 'badge-blue')));
        update_post_meta($post_id, '_geden_enjeu_icon', sanitize_text_field((string) wp_unslash($_POST['geden_enjeu_icon'] ?? 'chart')));
        update_post_meta($post_id, '_geden_enjeu_text', sanitize_text_field((string) wp_unslash($_POST['geden_enjeu_text'] ?? '')));
        update_post_meta($post_id, '_geden_enjeu_lines', sanitize_textarea_field((string) wp_unslash($_POST['geden_enjeu_lines'] ?? '')));
    }

    if (isset($_POST['geden_offre_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['geden_offre_nonce'])), 'geden_save_offre_meta')) {
        update_post_meta($post_id, '_geden_offre_badge', sanitize_text_field((string) wp_unslash($_POST['geden_offre_badge'] ?? 'badge-blue')));
        update_post_meta($post_id, '_geden_offre_icon', sanitize_text_field((string) wp_unslash($_POST['geden_offre_icon'] ?? 'chart')));
        update_post_meta($post_id, '_geden_offre_text', sanitize_text_field((string) wp_unslash($_POST['geden_offre_text'] ?? '')));
        update_post_meta($post_id, '_geden_offre_lines', sanitize_textarea_field((string) wp_unslash($_POST['geden_offre_lines'] ?? '')));
    }

}
add_action('save_post', 'geden_save_meta_boxes');

function geden_get_reference_bullets(string $meta_key, int $post_id): array
{
    $raw = (string) get_post_meta($post_id, $meta_key, true);
    if ($raw === '') {
        return [];
    }
    $lines = preg_split('/\r\n|\r|\n/', $raw) ?: [];
    return array_values(array_filter(array_map('trim', $lines)));
}

function geden_get_enjeu_lines(int $post_id): array
{
    $raw = (string) get_post_meta($post_id, '_geden_enjeu_lines', true);
    if ($raw === '') {
        return [];
    }
    $lines = preg_split('/\r\n|\r|\n/', $raw) ?: [];
    return array_values(array_filter(array_map('trim', $lines)));
}

function geden_get_offre_lines(int $post_id): array
{
    $raw = (string) get_post_meta($post_id, '_geden_offre_lines', true);
    if ($raw === '') {
        return [];
    }
    $lines = preg_split('/\r\n|\r|\n/', $raw) ?: [];
    return array_values(array_filter(array_map('trim', $lines)));
}

function geden_get_enjeu_icon_svg(string $icon): string
{
    $map = [
        'chart' => '<svg viewBox="0 0 24 24" fill="none"><path d="M4 18h16M6 15l4-4 3 3 5-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'clock' => '<svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="2"/><path d="M12 8v5l3 2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
        'leaf' => '<svg viewBox="0 0 24 24" fill="none"><path d="M6 13c0-5 4-8 12-9-1 8-4 12-9 12-2 0-3-1-3-3Z" stroke="currentColor" stroke-width="2"/><path d="M10 14l5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
        'ruler' => '<svg viewBox="0 0 24 24" fill="none"><path d="M4 16h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M8 13v6M12 11v8M16 13v6" stroke="currentColor" stroke-width="2"/></svg>',
        'shuffle' => '<svg viewBox="0 0 24 24" fill="none"><path d="M4 7h4l8 10h4M20 17l-2-2m2 2-2 2M4 17h4l2-2M14 9l2-2h4m0 0-2-2m2 2-2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'cross' => '<svg viewBox="0 0 24 24" fill="none"><path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
        'megaphone' => '<svg viewBox="0 0 24 24" fill="none"><path d="M4 13v-2l11-4v10L4 13Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M8 14v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
        'people' => '<svg viewBox="0 0 24 24" fill="none"><circle cx="9" cy="8" r="3" stroke="currentColor" stroke-width="2"/><path d="M3 18c1.5-3 3.5-4 6-4s4.5 1 6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M16 10c1.7.2 3 1.2 4 3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
        'bubble' => '<svg viewBox="0 0 24 24" fill="none"><path d="M6 17l-2 3v-3a7 7 0 1 1 2 0Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>',
        'check' => '<svg viewBox="0 0 24 24" fill="none"><path d="M7 12l3 3 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><rect x="4" y="4" width="16" height="16" rx="2" stroke="currentColor" stroke-width="2"/></svg>',
    ];
    return $map[$icon] ?? $map['chart'];
}

function geden_get_reference_sponsors(int $post_id): array
{
    $ids_csv = (string) get_post_meta($post_id, '_geden_reference_sponsor_ids', true);
    $ids = array_filter(array_map('intval', explode(',', $ids_csv)));
    if (empty($ids)) {
        return [];
    }
    return get_posts([
        'post_type' => 'geden_sponsor',
        'post_status' => 'publish',
        'post__in' => $ids,
        'orderby' => 'post__in',
        'numberposts' => -1,
    ]);
}

function geden_get_reference_sponsor_logos(int $post_id): array
{
    $raw = (string) get_post_meta($post_id, '_geden_reference_sponsor_logos', true);
    $decoded = $raw !== '' ? json_decode($raw, true) : [];
    if (is_array($decoded) && !empty($decoded)) {
        return array_values(array_filter(array_map(static function ($row) {
            if (!is_array($row)) {
                return null;
            }
            $name = sanitize_text_field((string) ($row['name'] ?? ''));
            $url = esc_url_raw((string) ($row['url'] ?? ''));
            $image_id = absint($row['image_id'] ?? 0);
            if ($name === '' && $url === '' && $image_id === 0) {
                return null;
            }
            return ['name' => $name, 'url' => $url, 'image_id' => $image_id];
        }, $decoded)));
    }

    $legacy = geden_get_reference_sponsors($post_id);
    if (empty($legacy)) {
        return [];
    }

    return array_map(static function (WP_Post $sponsor) {
        return [
            'name' => $sponsor->post_title,
            'url' => (string) get_post_meta($sponsor->ID, '_geden_sponsor_website', true),
            'image_id' => get_post_thumbnail_id($sponsor->ID),
        ];
    }, $legacy);
}


function geden_seed_default_terms(): void
{
    $default_terms = [
        'reference_category' => geden_reference_default_terms(),
        'presentation_category' => geden_presentation_default_terms(),
        'team_category' => geden_team_default_terms(),
        'enjeu_category' => geden_enjeu_default_terms(),
        'offre_category' => geden_offre_default_terms(),
    ];

    foreach ($default_terms as $taxonomy => $terms) {
        foreach ($terms as $slug => $name) {
            if (!term_exists($slug, $taxonomy)) {
                wp_insert_term($name, $taxonomy, ['slug' => $slug]);
            }
        }
    }
}
add_action('init', 'geden_seed_default_terms', 20);

function geden_register_admin_shortcuts(): void
{
    foreach (geden_reference_admin_shortcuts() as [$page_title, $menu_title, $slug]) {
        add_submenu_page('edit.php?post_type=geden_reference', $page_title, $menu_title, 'edit_posts', $slug);
    }

    foreach (geden_presentation_admin_shortcuts() as [$page_title, $menu_title, $slug]) {
        add_submenu_page('edit.php?post_type=geden_presentation', $page_title, $menu_title, 'edit_posts', $slug);
    }

     foreach (geden_team_admin_shortcuts() as [$page_title, $menu_title, $slug]) {
        add_submenu_page('edit.php?post_type=geden_team', $page_title, $menu_title, 'edit_posts', $slug);
    }

    foreach (geden_enjeu_admin_shortcuts() as [$page_title, $menu_title, $slug]) {
        add_submenu_page('edit.php?post_type=geden_enjeu', $page_title, $menu_title, 'edit_posts', $slug);
    }

    foreach (geden_offre_admin_shortcuts() as [$page_title, $menu_title, $slug]) {
        add_submenu_page('edit.php?post_type=geden_offre', $page_title, $menu_title, 'edit_posts', $slug);
    }
}
add_action('admin_menu', 'geden_register_admin_shortcuts');