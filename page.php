<?php

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
template('single');
