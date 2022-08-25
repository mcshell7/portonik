<?php

namespace porton\App\Http;

/*
|-----------------------------------------------------------------
| Theme Assets
|-----------------------------------------------------------------
|
| This file is for registering your theme stylesheets and scripts.
| In here you should also deregister all unwanted assets which
| can be shiped with various third-parity plugins.
|
*/

use function porton\App\asset_path;

/**
 * Registers theme stylesheet files.
 *
 * @return void
 */
function register_stylesheets() {
    wp_enqueue_style('app', asset_path('css/app.css'));
    wp_enqueue_style('libs', asset_path('css/libs.css'));
//    wp_enqueue_style('slick', asset_path('css/slick.css'));
//    wp_enqueue_style('animate', asset_path('css/animate.css'));
}
add_action('wp_enqueue_scripts', 'porton\App\Http\register_stylesheets');

/**
 * Registers theme script files.
 *
 * @return void
 */
function register_scripts() {
//    wp_enqueue_script('libs', asset_path('js/libs.js'), null, true);
    wp_enqueue_script('app', asset_path('js/app.js'), ['jquery'], null, true);
}
add_action('wp_enqueue_scripts', 'porton\App\Http\register_scripts');

/**
 * Registers editor stylesheets.
 *
 * @return void
 */
function register_editor_stylesheets() {
    add_editor_style(asset_path('css/app.css'));
}
add_action('admin_init', 'porton\App\Http\register_editor_stylesheets');

/**
 * Moves front-end jQuery script to the footer.
 *
 * @param  \WP_Scripts $wp_scripts
 * @return void
 */
function move_jquery_to_the_footer($wp_scripts) {
    if (! is_admin()) {
        $wp_scripts->add_data('jquery', 'group', 1);
        $wp_scripts->add_data('jquery-core', 'group', 1);
        $wp_scripts->add_data('jquery-migrate', 'group', 1);
    }
}
add_action('wp_default_scripts', 'porton\App\Http\move_jquery_to_the_footer');
