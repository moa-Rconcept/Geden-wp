<?php
/**
 * Theme functions for GeDEN.
 */

if (!defined('ABSPATH')) {
    exit;
}

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
    if (in_array($post_type, ['geden_reference', 'geden_sponsor'], true)) {
        return false;
    }

    return $use_block_editor;
}
add_filter('use_block_editor_for_post_type', 'geden_disable_block_editor_for_custom_content', 10, 2);

function geden_enqueue_assets(): void
{
    wp_enqueue_style('geden-style', get_template_directory_uri() . '/style.css', [], wp_get_theme()->get('Version'));
    wp_enqueue_script('jquery');
    wp_enqueue_script('geden-main', get_template_directory_uri() . '/main.js', ['jquery'], wp_get_theme()->get('Version'), true);

    if (is_page_template('template-contact.php')) {
        wp_enqueue_script('geden-formulaire', get_template_directory_uri() . '/formulaire.js', ['jquery'], wp_get_theme()->get('Version'), true);
    }

    if (is_page_template('template-references.php')) {
        wp_enqueue_script('geden-references', get_template_directory_uri() . '/references.js', ['jquery'], wp_get_theme()->get('Version'), true);
    }
}
add_action('wp_enqueue_scripts', 'geden_enqueue_assets');

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
    $sponsor_ids = (string) get_post_meta($post->ID, '_geden_reference_sponsor_ids', true);
    $selected_ids = array_filter(array_map('intval', explode(',', $sponsor_ids)));

    $sponsors = get_posts([
        'post_type' => 'geden_sponsor',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
    ]);
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
    <p><label for="geden_reference_sponsor_ids"><strong><?php esc_html_e('Sponsors (logos)', 'geden'); ?></strong></label><br>
      <select id="geden_reference_sponsor_ids" name="geden_reference_sponsor_ids[]" multiple style="width: 100%; min-height: 120px; max-width: 520px;">
        <?php foreach ($sponsors as $sponsor) : ?>
          <option value="<?php echo esc_attr((string) $sponsor->ID); ?>" <?php selected(in_array((int) $sponsor->ID, $selected_ids, true)); ?>><?php echo esc_html($sponsor->post_title); ?></option>
        <?php endforeach; ?>
      </select>
    </p>
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

function geden_save_meta_boxes(int $post_id): void
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['geden_reference_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['geden_reference_nonce'])), 'geden_save_reference_meta')) {
        $sponsor_ids = [];
        if (isset($_POST['geden_reference_sponsor_ids']) && is_array($_POST['geden_reference_sponsor_ids'])) {
            $sponsor_ids = array_filter(array_map('intval', wp_unslash($_POST['geden_reference_sponsor_ids'])));
        }

        update_post_meta($post_id, '_geden_reference_year', sanitize_text_field((string) wp_unslash($_POST['geden_reference_year'] ?? '')));
        update_post_meta($post_id, '_geden_reference_client', sanitize_text_field((string) wp_unslash($_POST['geden_reference_client'] ?? '')));
        update_post_meta($post_id, '_geden_reference_link', esc_url_raw((string) wp_unslash($_POST['geden_reference_link'] ?? '')));
        update_post_meta($post_id, '_geden_reference_needs', sanitize_textarea_field((string) wp_unslash($_POST['geden_reference_needs'] ?? '')));
        update_post_meta($post_id, '_geden_reference_services', sanitize_textarea_field((string) wp_unslash($_POST['geden_reference_services'] ?? '')));
        update_post_meta($post_id, '_geden_reference_authors', sanitize_text_field((string) wp_unslash($_POST['geden_reference_authors'] ?? '')));
        update_post_meta($post_id, '_geden_reference_deliverable', sanitize_text_field((string) wp_unslash($_POST['geden_reference_deliverable'] ?? '')));
        update_post_meta($post_id, '_geden_reference_sponsor_ids', implode(',', $sponsor_ids));
    }

    if (isset($_POST['geden_sponsor_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['geden_sponsor_nonce'])), 'geden_save_sponsor_meta')) {
        $website = isset($_POST['geden_sponsor_website']) ? esc_url_raw(wp_unslash($_POST['geden_sponsor_website'])) : '';
        update_post_meta($post_id, '_geden_sponsor_website', $website);
    }

    if (isset($_POST['geden_references_page_options_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['geden_references_page_options_nonce'])), 'geden_save_references_page_options')) {
        update_post_meta($post_id, '_geden_references_banner_image_id', absint(wp_unslash($_POST['geden_references_banner_image_id'] ?? 0)));
        update_post_meta($post_id, '_geden_references_hero_image_id', absint(wp_unslash($_POST['geden_references_hero_image_id'] ?? 0)));
        update_post_meta($post_id, '_geden_references_hero_title', sanitize_text_field((string) wp_unslash($_POST['geden_references_hero_title'] ?? '')));
        update_post_meta($post_id, '_geden_references_hero_subtitle', sanitize_text_field((string) wp_unslash($_POST['geden_references_hero_subtitle'] ?? '')));
        update_post_meta($post_id, '_geden_references_hero_link_text', sanitize_text_field((string) wp_unslash($_POST['geden_references_hero_link_text'] ?? '')));
        update_post_meta($post_id, '_geden_references_hero_link_url', esc_url_raw((string) wp_unslash($_POST['geden_references_hero_link_url'] ?? '')));
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

function geden_seed_default_terms(): void
{
    $default_terms = [
        'reference_category' => [
            'realisations-effectuees' => 'Réalisations effectuées',
            'realisations-en-cours' => 'Réalisations en cours',
            'productions-techniques-scientifiques' => 'Productions techniques et scientifiques',
        ],
        'presentation_category' => ['blocs-presentation' => 'Blocs présentation'],
        'enjeu_category' => ['blocs-enjeux' => 'Blocs enjeux'],
        'offre_category' => ['blocs-offres' => 'Blocs offres'],
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
    add_submenu_page('edit.php?post_type=geden_reference', 'Réalisations en cours', 'Réalisations en cours', 'edit_posts', 'edit.php?post_type=geden_reference&reference_category=realisations-en-cours');
    add_submenu_page('edit.php?post_type=geden_reference', 'Réalisations effectuées', 'Réalisations effectuées', 'edit_posts', 'edit.php?post_type=geden_reference&reference_category=realisations-effectuees');
    add_submenu_page('edit.php?post_type=geden_reference', 'Productions', 'Productions', 'edit_posts', 'edit.php?post_type=geden_reference&reference_category=productions-techniques-scientifiques');

    add_submenu_page('edit.php?post_type=geden_presentation', 'Blocs Présentation', 'Blocs Présentation', 'edit_posts', 'edit.php?post_type=geden_presentation&presentation_category=blocs-presentation');
    add_submenu_page('edit.php?post_type=geden_enjeu', 'Blocs Enjeux', 'Blocs Enjeux', 'edit_posts', 'edit.php?post_type=geden_enjeu&enjeu_category=blocs-enjeux');
    add_submenu_page('edit.php?post_type=geden_offre', 'Blocs Offres', 'Blocs Offres', 'edit_posts', 'edit.php?post_type=geden_offre&offre_category=blocs-offres');
}
add_action('admin_menu', 'geden_register_admin_shortcuts');
