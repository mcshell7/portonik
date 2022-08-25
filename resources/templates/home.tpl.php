
<!-- Здесь html/php код шаблона -->
<?php get_header(); ?>

<?php
/**
 * Functions hooked into `theme/home/render_home_frontscreen` action.
 *
 * @hooked porton\App\Structure\render_home_page - 10
 */
do_action('theme/home/frontscreen');
?>

<?php get_footer(); ?>
