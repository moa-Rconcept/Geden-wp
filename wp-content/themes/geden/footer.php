<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<footer>
  <div class="container foot">
    <p>© <?php echo esc_html(wp_date('Y')); ?> <?php bloginfo('name'); ?>. Tous droits réservés.</p>
    <p>
      <?php
      wp_nav_menu([
          'theme_location' => 'footer',
          'container' => false,
          'items_wrap' => '%3$s',
          'fallback_cb' => false,
      ]);
      ?>
    </p>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
