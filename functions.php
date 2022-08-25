
<?php



use Carbon_Fields\Container;
use Carbon_Fields\Field;

/*
 |------------------------------------------------------------------
 | Bootstraping a Theme
 |------------------------------------------------------------------
 |
 | This file is responsible for bootstrapping your theme. Autoloads
 | composer packages, checks compatibility and loads theme files.
 | Most likely, you don't need to change anything in this file.
 | Your theme custom logic should be distributed across a
 | separated components in the `/app` directory.
 |
 */

// Require Composer's autoloading file
// if it's present in theme directory.
if (file_exists($composer = __DIR__ . '/vendor/autoload.php')) {
    require $composer;
}

// Before running we need to check if everything is in place.
// If something went wrong, we will display friendly alert.
$ok = require_once __DIR__ . '/bootstrap/compatibility.php';

if ($ok) {
    // Now, we can bootstrap our theme.
    $theme = require_once __DIR__ . '/bootstrap/theme.php';

    // Autoload theme. Uses localize_template() and
    // supports child theme overriding. However,
    // they must be under the same dir path.
    (new Tonik\Gin\Foundation\Autoloader($theme->get('config')))->register();
}

//add theme support
add_action('after_setup_theme', 'add_theme_support_func');
function add_theme_support_func()
{
    add_theme_support('widgets');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'comment-list',
        'comment-form',
        'search-form',
        'gallery',
        'caption',
        'script',
        'style',
    ));
    add_theme_support('title-tag');

    add_theme_support('customize-selective-refresh-widgets');

    register_nav_menu('primary', 'Primary Menu');
    register_nav_menu('footer', 'Footer Menu');

//    load_theme_textdomain('carbonportonik', get_template_directory() . '/languages');
}







// Custom fields
//
add_action('carbon_fields_register_fields', function () {
    // Theme options
    Container::make('theme_options', __('Theme Options', 'carbonportonik'))
        // Main

        ->add_tab(__('Home', 'carbonportonik'), array(
            Field::make('image', 'crb_logo', __('Logo', 'carbonportonik'))
                ->set_width(25),
            Field::make('image', 'crb_logo_w', __('White Logo', 'carbonportonik'))
                ->set_width(25),
            Field::make('image', 'crb_logo_footer', __('Footer Logo', 'carbonportonik'))
                ->set_width(25),
            Field::make('image', 'crb_logo_2', __('Second Logo', 'carbonportonik'))
                ->set_width(25),
            Field::make('text', 'crb_cta_button_text', __('Call to action button text', 'carbonportonik'))
                ->set_width(50),
            Field::make('text', 'crb_cta_button_link', __('Call to action button link', 'carbonportonik'))
                ->set_width(50),
            Field::make('text', 'crb_copyright', __('Copyright', 'carbonportonik')),
            Field::make('text', 'crb_terms', __('Terms link', 'carbonportonik'))
                ->set_width(50),
            Field::make('text', 'crb_privacy', __('Privacy link', 'carbonportonik'))
                ->set_width(50),
            Field::make('rich_text', 'crb_zelle_text', __('Zelle Text', 'carbonportonik')),
        ))
        // Socials
        ->add_tab(__('Socials', 'carbonportonik'), array(
            Field::make('complex', 'crb_socials', __('Socials', 'carbonportonik'))
                ->add_fields(array(
                    Field::make('text', 'title', __('Title', 'carbonportonik'))
                        ->set_width(33),
                    Field::make('text', 'url', __('URL', 'carbonportonik'))
                        ->set_width(33),
                )),
        ))
        // Communities
        ->add_tab(__('Communities', 'carbonportonik'), array(
            Field::make('complex', 'crb_header_communities', __('Header communities', 'carbonportonik'))
                ->add_fields(array(
                    Field::make('text', 'title', __('Title', 'carbonportonik'))
                        ->set_width(33),
                    Field::make('text', 'url', __('URL', 'carbonportonik'))
                        ->set_width(33),
                    Field::make('image', 'logo', __('Logo', 'carbonportonik'))
                        ->set_width(33),
                )),
        ));
    // Front page
    Container::make('post_meta', __('Page sections', 'carbonportonik'))
        ->where('post_id', '=', get_option('page_on_front'))
        ->add_tab(__('Slider', 'carbonportonik'), array(
            Field::make('complex', 'crb_home_slider', __('Home Sides', 'carbonportonik'))
                ->add_fields(array(
                    Field::make('text', 'suptitle', __('Suptitle', 'carbonportonik'))
                        ->set_required(true),
                    Field::make('text', 'title', __('Title', 'carbonportonik'))
                        ->set_required(true),
                    Field::make('text', 'suptext', __('Suptext', 'carbonportonik'))
                        ->set_required(true),
                    Field::make('text', 'text', __('Text', 'carbonportonik'))
                        ->set_required(true),
                    Field::make('image', 'img_bg', __('Image background', 'carbonportonik'))
                        ->set_type( array( 'image' ) )
                        ->set_value_type( 'url' )
                        ->set_width(33),
                )),
        ))
        ->add_tab(__('Our Mission', 'carbonportonik'), array(
            Field::make('text', 'crb_our_mission_top_title', __('Top Title', 'carbonportonik')),
            Field::make('text', 'crb_our_mission_title', __('Title', 'carbonportonik')),
            Field::make('text', 'crb_our_mission_text', __('Text', 'carbonportonik')),
            Field::make('complex', 'crb_our_mission_images', __('Images', 'carbonportonik'))
                ->set_layout('tabbed-horizontal')
                ->add_fields(array(
                    Field::make('image', 'img', __('Image', 'carbonportonik')),
                )),
        ))
        ->add_tab(__('Mission Slider', 'carbonportonik'), array(
            Field::make('complex', 'crb_home_mission_slider', __('Mission Slides', 'carbonportonik'))
                ->set_layout('tabbed-horizontal')
                ->add_fields(array(
                    Field::make('text', 'title', __('Title', 'carbonportonik'))
                        ->set_width(100),
                    Field::make('image', 'img', __('Image', 'carbonportonik'))
                        ->set_width(33),
                    Field::make('color', 'bg_color', __('Background color', 'carbonportonik'))
                        ->set_width(33),
                    Field::make('color', 'color', __('Text color', 'carbonportonik'))
                        ->set_width(33),
                    Field::make('text', 'letter', __('Letter', 'carbonportonik'))
                        ->set_width(1),
                )),
        ))
        ->add_tab(__('For who', 'carbonportonik'), array(
            Field::make('text', 'crb_for_who_top_title', __('Top Title', 'carbonportonik')),
            Field::make('text', 'crb_for_who_title', __('Title', 'carbonportonik')),
            Field::make('text', 'crb_for_who_text', __('Text', 'carbonportonik')),
            Field::make('complex', 'crb_for_who_videos', __('Videos', 'carbonportonik'))
                ->set_layout('tabbed-horizontal')
                ->add_fields(array(
                    Field::make('image', 'crb_for_who_video_image', __('Video Image', 'carbonportonik'))
                        ->set_width(50),
                    Field::make('file', 'crb_for_who_video', __('Video', 'carbonportonik'))
                        ->set_type(array('video'))
                        ->set_value_type('url')
                        ->set_width(50),
                )),
            Field::make('complex', 'crb_for_who_images', __('Images', 'carbonportonik'))
                ->set_layout('tabbed-horizontal')
                ->add_fields(array(
                    Field::make('image', 'img', __('Image', 'carbonportonik')),
                )),
        ))
        ->add_tab(__('How to donate?', 'carbonportonik'), array(
            Field::make('text', 'crb_donate_title', __('Title', 'carbonportonik')),
            Field::make('text', 'crb_donate_text', __('Text', 'carbonportonik')),
            Field::make('image', 'crb_donate_image_1', __('Image 1', 'carbonportonik'))
                ->set_width(50),
            Field::make('text', 'crb_donate_link_1', __('Link 1', 'carbonportonik'))
                ->set_width(50),
            Field::make('image', 'crb_donate_image_2', __('Image 2', 'carbonportonik'))
                ->set_width(50),
            Field::make('text', 'crb_donate_link_2', __('Link 2', 'carbonportonik'))
                ->set_width(50),
        ))
        ->add_tab(__('Events', 'carbonportonik'), array(
            Field::make('text', 'crb_events_top_title', __('Top Title', 'carbonportonik')),
            Field::make('text', 'crb_events_title', __('Title', 'carbonportonik')),
            Field::make('text', 'crb_events_text', __('Text', 'carbonportonik')),
        ))
        ->add_tab(__('App', 'carbonportonik'), array(
            Field::make('text', 'crb_app_title', __('Title', 'carbonportonik')),
            Field::make('text', 'crb_app_text', __('Text', 'carbonportonik')),
            Field::make('image', 'crb_app_image_1', __('Image 1', 'carbonportonik'))
                ->set_value_type('url')
                ->set_width(50),
            Field::make('image', 'crb_app_image_2', __('Image 2', 'carbonportonik'))
                ->set_value_type('url')
                ->set_width(50),
            Field::make('text', 'crb_app_link_text_1', __('Text link 1', 'carbonportonik'))
                ->set_width(50),
            Field::make('text', 'crb_app_link_1', __('link 1', 'carbonportonik'))
                ->set_width(50),
            Field::make('text', 'crb_app_link_text_2', __('Text link 2', 'carbonportonik'))
                ->set_width(50),
            Field::make('text', 'crb_app_link_2', __('link 2', 'carbonportonik'))
                ->set_width(50),
        ))
        ->add_tab(__('App2', 'carbonportonik'), array(
            Field::make('text', 'crb_app2_title', __('Title', 'carbonportonik')),
            Field::make('text', 'crb_app2_text', __('Text', 'carbonportonik')),
            Field::make('image', 'crb_app2_image_1', __('Image 1', 'carbonportonik'))
                ->set_value_type('url')
                ->set_width(50),
            Field::make('image', 'crb_app2_image_2', __('Image 2', 'carbonportonik'))
                ->set_value_type('url')
                ->set_width(50),
            Field::make('text', 'crb_app2_link_text_1', __('Text link 1', 'carbonportonik'))
                ->set_width(50),
            Field::make('text', 'crb_app2_link_1', __('link 1', 'carbonportonik'))
                ->set_width(50),
            Field::make('text', 'crb_app2_link_text_2', __('Text link 2', 'carbonportonik'))
                ->set_width(50),
            Field::make('text', 'crb_app2_link_2', __('link 2', 'carbonportonik'))
                ->set_width(50),
        ));
    // Event page
    Container::make('post_meta', __('Page sections', 'carbonportonik'))
        ->where('post_type', '=', 'event')
        ->add_fields(array(
            Field::make('text', 'crb_event_time', __('Time', 'carbonportonik'))
                ->set_width(33),
            Field::make('text', 'crb_event_time_2', __('Time 2', 'carbonportonik'))
                ->set_width(33),
            Field::make('text', 'crb_event_agenda', __('Agenda', 'carbonportonik'))
                ->set_width(33),
        ));
    // Service page
    Container::make('post_meta', __('Page sections', 'carbonportonik'))
        ->where('post_type', '=', 'service')
        ->add_fields(array(
            Field::make('text', 'crb_service_time', __('Time', 'carbonportonik'))
                ->set_width(33),
            Field::make('text', 'crb_service_time_2', __('Time 2', 'carbonportonik'))
                ->set_width(33),
            Field::make('text', 'crb_service_agenda', __('Agenda', 'carbonportonik'))
                ->set_width(33),
        ));
    // Donations page
    Container::make('post_meta', __('Page sections', 'carbonportonik'))
        ->where('post_template', '=', 'donations-page.php')
        ->add_tab(__('First section', 'carbonportonik'), array(
            Field::make('text', 'crb_donations_title', __('Title', 'carbonportonik')),
            Field::make('text', 'crb_donations_text', __('Text', 'carbonportonik')),
            Field::make('text', 'crb_donations_total', __('Total sum', 'carbonportonik')),
            Field::make('text', 'crb_donations_right_title', __('Right title', 'carbonportonik')),
            Field::make('complex', 'crb_donations_targets', __('Targets', 'carbonportonik'))
                ->add_fields(array(
                    Field::make('image', 'img', __('Image', 'carbonportonik'))
                        ->set_width(33),
                    Field::make('text', 'title', __('Title', 'carbonportonik'))
                        ->set_required(true)
                        ->set_width(33),
                    Field::make('text', 'link', __('Link', 'carbonportonik'))
                        ->set_required(true)
                        ->set_default_value('#')
                        ->set_width(33),
                )),
        ))
        ->add_tab(__('Second section', 'carbonportonik'), array(
                Field::make('text', 'crb_donations_second_subtitle', __('Subtitle', 'carbonportonik')),
                Field::make('text', 'crb_donations_second_title', __('Title', 'carbonportonik')),
                Field::make('textarea', 'crb_donations_second_text', __('Text', 'carbonportonik'))->set_rows(3),
                Field::make('complex', 'crb_donations_second_lots', __('Lots', 'carbonportonik'))
                    ->add_fields(array(
                        Field::make('image', 'img', __('Image', 'carbonportonik'))
                            ->set_width(20),
                        Field::make('text', 'title', __('Title', 'carbonportonik'))
                            ->set_required(true)
                            ->set_width(20),
                        Field::make('textarea', 'description', __('Description', 'carbonportonik'))
                            ->set_required(true)
                            ->set_rows(6)
                            ->set_width(20),
                        Field::make('text', 'donation_now', __('Donation now', 'carbonportonik'))
                            ->set_required(true)
                            ->set_width(20),
                        Field::make('text', 'donation_target', __('Donation target', 'carbonportonik'))
                            ->set_required(true)
                            ->set_width(20),
                    )),
            )
        )
        ->add_tab(__('Third section', 'carbonportonik'), array(
                Field::make('text', 'crb_donations_third_subtitle', __('Subtitle', 'carbonportonik')),
                Field::make('text', 'crb_donations_third_title', __('Title', 'carbonportonik')),
                Field::make('textarea', 'crb_donations_third_text', __('Text', 'carbonportonik'))->set_rows(3),
                Field::make('complex', 'crb_donations_third_slides', __('Slides', 'carbonportonik'))
                    ->add_fields(array(
                        Field::make('image', 'img', __('Image', 'carbonportonik'))
                    )),
            )
        );

    // Team page
    Container::make('post_meta', __('Page sections', 'carbonportonik'))
        ->where('post_template', '=', 'team-page.php')

        ->add_tab(__('Our Founders', 'carbonportonik'), array(
            Field::make('text', 'crb_team_our_founders_title', __('Title', 'carbonportonik')),
            Field::make('textarea', 'crb_team_our_founders_text', __('Text', 'carbonportonik'))->set_rows(3),
            Field::make('complex', 'crb_team_our_founders', __('Targets', 'carbonportonik'))
                ->add_fields(array(
                    Field::make('image', 'img', __('Image', 'carbonportonik'))
                        ->set_required(true)
                        ->set_width(33),
//                    Field::make('text', 'name', __('Name', 'carbonportonik')) // пока не используется
//                        ->set_required(true)
//                        ->set_width(33),
                    Field::make('text', 'text', __('Text', 'carbonportonik'))
                        ->set_required(true)
                        ->set_width(33),
                )),
        ))
        ->add_tab(__('Our Leaderships', 'carbonportonik'), array(
            Field::make('text', 'crb_team_our_leaderships_title', __('Title', 'carbonportonik')),
            Field::make('textarea', 'crb_team_our_leaderships_text', __('Text', 'carbonportonik'))->set_rows(3),
            Field::make('complex', 'crb_team_our_leaderships', __('Targets', 'carbonportonik'))
                ->add_fields(array(
                    Field::make('image', 'img', __('Image', 'carbonportonik'))
                        ->set_required(true)
                        ->set_width(33),
                    Field::make('text', 'name', __('Name', 'carbonportonik'))
                        ->set_required(true)
                        ->set_width(33),
                    Field::make('text', 'text', __('Text', 'carbonportonik'))
                        ->set_required(true)
                        ->set_width(33),
                )),
        ))
        ->add_tab(__('Our Team', 'carbonportonik'), array(
            Field::make('text', 'crb_team_our_team_title', __('Title', 'carbonportonik')),
            Field::make('complex', 'crb_team_our_team', __('Targets', 'carbonportonik'))
                ->add_fields(array(
                    Field::make('image', 'img', __('Image', 'carbonportonik'))
                        ->set_required(true)
                        ->set_width(33),
                    Field::make('text', 'name', __('Name', 'carbonportonik'))
                        ->set_required(true)
                        ->set_width(33),
                    Field::make('text', 'position', __('Position', 'carbonportonik'))
                        ->set_required(true)
                        ->set_width(33),
                )),
        ));
});
