<?php
if (!defined('ABSPATH')) {
    exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="<?php echo esc_attr(get_bloginfo('description')); ?>" />
  <link rel="icon" type="image/png" href="<?php echo esc_url(get_template_directory_uri() . '/favicon.png'); ?>">
  <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri() . '/style.css'); ?>">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
$menu_location = 'primary';
if (is_page()) {
    $slug = get_post_field('post_name', get_queried_object_id());
    $map = [
        'presentation' => 'menu_presentation',
        'problematiques-et-enjeux' => 'menu_enjeux',
        'offres-et-services' => 'menu_offres',
        'references' => 'menu_references',
        'contact' => 'menu_contact',
    ];
    if (isset($map[$slug])) {
        $menu_location = $map[$slug];
    }
}
?>

<header class="header">
  <div class="container nav">
    <a class="brand" href="<?php echo esc_url(home_url('/')); ?>">
      <img src="<?php echo esc_url(get_template_directory_uri() . '/logo.png'); ?>" alt="Logo GeDEN" height="80">
      <div class="brand__title">
        <div class="brand__tag">Gestion durable des espaces naturels</div>
      </div>
    </a>

    <nav class="menu" id="menu">
      <?php if (has_nav_menu($menu_location)) : ?>
        <?php
        wp_nav_menu([
            'theme_location' => $menu_location,
            'container' => false,
            'items_wrap' => '%3$s',
        ]);
        ?>
      <?php elseif (has_nav_menu('primary')) : ?>
        <?php
        wp_nav_menu([
            'theme_location' => 'primary',
            'container' => false,
            'items_wrap' => '%3$s',
        ]);
        ?>
      <?php else : ?>
        <?php
        $pages = get_pages(['sort_column' => 'menu_order']);
        foreach ($pages as $page) :
        ?>
          <a href="<?php echo esc_url(get_permalink($page)); ?>"><?php echo esc_html($page->post_title); ?></a>
        <?php endforeach; ?>
      <?php endif; ?>
    </nav>
    <button class="menu-toggle" id="menuToggle" aria-expanded="false" aria-controls="menu">Menu</button>
  </div>
</header>
