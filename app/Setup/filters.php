<?php

namespace porton\App\Setup;

/*
|-----------------------------------------------------------
| Theme Filters
|-----------------------------------------------------------
|
| This file purpose is to include your theme various
| filters hooks, which changes output or behaviour
| of different parts of WordPress functions.
|
*/

/**
 * Hides sidebar on index template on specific views.
 *
 * @see apply_filters('theme/index/sidebar/visibility')
 * @see apply_filters('theme/single/sidebar/visibility')
 */
function show_index_sidebar($status)
{
    if (is_404() || is_page()) {
        return false;
    }

    return $status;
}
add_filter('theme/index/sidebar/visibility', 'porton\App\Setup\show_index_sidebar');
add_filter('theme/single/sidebar/visibility', 'porton\App\Setup\show_index_sidebar');

/**
 * Shortens posts excerpts to 60 words.
 *
 * @return integer
 */
function modify_excerpt_length()
{
    return 60;
}
add_filter('excerpt_length', 'porton\App\Setup\modify_excerpt_length');

use \Walker_Nav_Menu;
// свой класс построения меню:
class My_Walker_Nav_Menu extends Walker_Nav_Menu {

    // add classes to ul sub-menus
    function start_lvl( &$output, $depth = 0, $args = NULL ) {
        // depth dependent classes
        $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
        $display_depth = ( $depth + 1); // because it counts the first submenu as 0
        $classes = array(
            'sub-menu',
            ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
            ( $display_depth >=2 ? 'sub-sub-menu' : '' ),
            'menu-depth-' . $display_depth
        );
        $class_names = implode( ' ', $classes );

        // build html
        $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
    }

    // add main/sub classes to li's and links
    function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
        global $wp_query;

        // Restores the more descriptive, specific name for use within this method.
        $item = $data_object;

        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

        // depth dependent classes
        $depth_classes = array(
            ( $depth == 0 ? 'menu__list-item' : 'sub-menu-item' ),
            ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
            ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
            'menu-item-depth-' . $depth
        );
        $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

        // passed classes
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

        // build html
        $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

        // link attributes
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

        $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
            $args->before,
            $attributes,
            $args->link_before,
            apply_filters( 'the_title', $item->title, $item->ID ),
            $args->link_after,
            $args->after
        );

        // build html
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

}
function my_nav_menu( $args ) {

    $args = array_merge( [
        'location_them'   => 'primary',
        'container'       => 'nav',
        'container_id'    => 'menu',
        'container_class' => 'menu',
        'menu_class'      => 'menu__list menu-depth-0 menu-even',
        'echo'            => false,
        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'link_before'     => '<span>',
        'link_after'      => '</span>',
        'depth'           => 10,
        'walker'          => new My_Walker_Nav_Menu()
    ], $args );
    echo wp_nav_menu( $args );
}


function portonik_site_logo( $args = array(), $display = true ) {
    $logo       = get_custom_logo();
    $site_title = get_bloginfo( 'name' );
    $contents   = '';
    $classname  = '';

    $defaults = array(
        'logo'        => '%1$s<span class="screen-reader-text">%2$s</span>',
        'logo_class'  => 'logo',
        'title'       => '<a href="%1$s">%2$s</a>',
        'title_class' => 'site-title',
        'home_wrap'   => '<h1 class="%1$s">%2$s</h1>',
        'single_wrap' => '<div class="%1$s faux-heading">%2$s</div>',
        'condition'   => ( is_front_page() || is_home() ) && ! is_page(),
    );

    $args = wp_parse_args( $args, $defaults );

    /**
     * Filters the arguments for `portonik_site_logo()`.
     *
     * @since Portonik 1.0
     *
     * @param array $args     Parsed arguments.
     * @param array $defaults Function's default arguments.
     */
    $args = apply_filters( 'portonik_site_logo', $args, $defaults );

    if ( has_custom_logo() ) {
        $contents  = sprintf( $args['logo'], $logo, esc_html( $site_title ) );
        $classname = $args['logo_class'];
    } else {
        $contents  = sprintf( $args['title'], esc_url( get_home_url( null, '/' ) ), esc_html( $site_title ) );
        $classname = $args['title_class'];
    }

    $wrap = $args['condition'] ? 'home_wrap' : 'single_wrap';

    $html = sprintf( $args[ $wrap ], $classname, $contents );

    /**
     * Filters the arguments for `portonik_site_logo()`.
     *
     * @since Portonik 1.0
     *
     * @param string $html      Compiled HTML based on our arguments.
     * @param array  $args      Parsed arguments.
     * @param string $classname Class name based on current view, home or single.
     * @param string $contents  HTML for site title or logo.
     */
    $html = apply_filters( 'portonik_site_logo', $html, $args, $classname, $contents );

    if ( ! $display ) {
        return $html;
    }

    echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

}

function portonik_date_shortcode(){
    $date = date('Y-m-d H:i:s');
    return "- ".$date;
}
add_shortcode( 'portonik_date_shortcode', 'portonik_date_shortcode' );
