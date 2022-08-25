<?php


/*
Template Name: Home page template
*/


namespace porton\Page;

/*
|------------------------------------------------------------------
| Page Controller
|------------------------------------------------------------------
|
| Think about theme template files as some sort of controllers
| from MVC design pattern. They should link application
| logic with your theme view templates files.
|
*/

use function porton\App\template;

/**
 * Renders single page.
 *
 * @see resources/templates/single.tpl.php
 */
use Carbon_Fields\Helper\Color;

$header_communities = carbon_get_post_meta(get_option('page_on_front'), 'crb_home_slider');

template('home');
