<?php

/**
 * Do not edit anything in this file unless you know what you're doing
 */

use Roots\Sage\Config;
use Roots\Sage\Container;

/**
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$sage_error = function ($message, $subtitle = '', $title = '') {
    $title = $title ?: __('Sage &rsaquo; Error', 'sage');
    $footer = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die($message, $title);
};

/**
 * Ensure compatible version of PHP is used
 */
if (version_compare('7.1', phpversion(), '>=')) {
    $sage_error(__('You must be using PHP 7.1 or greater.', 'sage'), __('Invalid PHP version', 'sage'));
}

/**
 * Ensure compatible version of WordPress is used
 */
if (version_compare('4.7.0', get_bloginfo('version'), '>=')) {
    $sage_error(__('You must be using WordPress 4.7.0 or greater.', 'sage'), __('Invalid WordPress version', 'sage'));
}

/**
 * Ensure dependencies are loaded
 */
if (!class_exists('Roots\\Sage\\Container')) {
    if (!file_exists($composer = __DIR__.'/../vendor/autoload.php')) {
        $sage_error(
            __('You must run <code>composer install</code> from the Sage directory.', 'sage'),
            __('Autoloader not found.', 'sage')
        );
    }
    require_once $composer;
}

/**
 * Sage required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map(function ($file) use ($sage_error) {
    $file = "../app/{$file}.php";
    if (!locate_template($file, true, true)) {
        $sage_error(sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file), 'File not found');
    }
}, ['helpers', 'setup', 'filters', 'admin']);

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/sage/resources
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/sage/resources/views
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/sage/resources
 *
 * We do this so that the Template Hierarchy will look in themes/sage/resources/views for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/sage/resources
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/sage/resources
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/sage/resources
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/sage/resources/views
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/sage/resources
 */
array_map(
    'add_filter',
    ['theme_file_path', 'theme_file_uri', 'parent_theme_file_path', 'parent_theme_file_uri'],
    array_fill(0, 4, 'dirname')
);
Container::getInstance()
    ->bindIf('config', function () {
        return new Config([
            'assets' => require dirname(__DIR__).'/config/assets.php',
            'theme' => require dirname(__DIR__).'/config/theme.php',
            'view' => require dirname(__DIR__).'/config/view.php',
        ]);
    }, true);

add_action('after_setup_theme', 'rdp_theme_setup');

function rdp_theme_setup()
{
    add_image_size('xs', 320);
    add_image_size('sm', 540);
    add_image_size('md', 768);
    add_image_size('lg', 1200);
    add_image_size('xl', 1600);
    add_image_size('xxl', 2400);
    add_image_size('xxxl', 3840);

}

function create_srcset($id) {
    $html = 'srcset="';
    $html .= wp_get_attachment_image_src($id, 'md')[0].' 320w,';
    $html .= wp_get_attachment_image_src($id, 'md')[0].' 540w,';
    $html .= wp_get_attachment_image_src($id, 'md')[0].' 768w,';
    $html .= wp_get_attachment_image_src($id, 'lg')[0].' 1200w,';
    $html .= wp_get_attachment_image_src($id, 'xl')[0].'  1400w,';
    $html .= wp_get_attachment_image_src($id, 'xxxl')[0].' 3840w" ';
    $html .= 'sizes="(max-width: 320px) 320px, (max-width: 540px) 540px, (max-width: 768px) 768px, (max-width: 1200px) 1200px, (max-width: 1400px) 1400px, 3840px"';
    return $html;
}

function create_srcset_bg($id, $selector) {
    $html = '<style>';
    $html .= '@media only screen and (min-width: 0px)  { .'.$selector.' { background-image: url('.wp_get_attachment_image_src($id, 'md')[0].') } }';
    $html .= '@media screen and (min-width: 320px)  { .'.$selector.' { background-image: url('.wp_get_attachment_image_src($id, 'md')[0].') } }';
    $html .= '@media screen and (min-width: 540px)  { .'.$selector.' { background-image: url('.wp_get_attachment_image_src($id, 'md')[0].') } }';
    $html .= '@media screen and (min-width: 768px)  { .'.$selector.' { background-image: url('.wp_get_attachment_image_src($id, 'lg')[0].') } }';
    $html .= '@media screen and (min-width: 1200px)  { .'.$selector.' { background-image: url('.wp_get_attachment_image_src($id, 'xl')[0].') } }';
    $html .= '@media screen and (min-width: 1400px)  { .'.$selector.' { background-image: url('.wp_get_attachment_image_src($id, 'xxxl')[0].') } }';
    $html .= '</style>';
    return $html;
}

if( function_exists('acf_add_options_page') ) {

	acf_add_options_page();

}

function social_shorts( $attr ){
	$type = $attr['type'];

	switch($type) :
		case 'facebook' :
			return '<span class="social-shortcode-wrap"><svg width="16px" height="30px" viewBox="0 0 16 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><title>Share on Facebook</title><link rel="stylesheet" href="https://richdysonphotography.com/wp-content/cache/min/1/8f975bc612408f33115d43c781e1e5f4.css" data-minify="1"></link> <desc>Created with Sketch.</desc> <defs></defs> <g id="Desktop" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="logo-fb-simple" fill="#111111" fill-rule="nonzero"> <path d="M4.46218,30 L4.46218,17 L0,17 L0,11 L4.46218,11 L4.46218,6.80998 C4.46218,2.24577 7.35166,0 11.42325,0 C13.37358,0 15.0498,0.1452 15.53829,0.21011 L15.53829,4.97998 L12.71442,4.98126 C10.50007,4.98127 10,6.0335 10,7.57757 L10,11 L16,11 L14,17 L10,17 L10,30 L4.46218,30 Z" id="Shape"></path> </g> </g> </svg></span>';
		break;
		case 'twitter' :
			return '<span class="social-shortcode-wrap"><svg width="32px" height="26px" viewBox="0 0 32 26" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><title>Share on Twitter</title><link rel="stylesheet" href="https://richdysonphotography.com/wp-content/cache/min/1/8f975bc612408f33115d43c781e1e5f4.css" data-minify="1"></link> <desc>Created with Sketch.</desc> <defs></defs> <g id="Desktop" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="logo-twitter" transform="translate(-1.000000, 0.000000)" fill="#111111" fill-rule="nonzero"> <path d="M33,3.1 C31.8,3.6 30.6,4 29.2,4.1 C30.6,3.3 31.6,2 32.1,0.5 C30.8,1.3 29.4,1.8 27.9,2.1 C26.7,0.8 25,0 23.2,0 C19.6,0 16.6,2.9 16.6,6.6 C16.6,7.1 16.7,7.6 16.8,8.1 C11.3,7.8 6.5,5.2 3.2,1.2 C2.6,2.2 2.3,3.3 2.3,4.5 C2.3,6.8 3.5,8.8 5.2,10 C4.1,10 3.1,9.7 2.2,9.2 C2.2,9.2 2.2,9.3 2.2,9.3 C2.2,12.5 4.5,15.1 7.5,15.7 C6.9,15.8 6.4,15.9 5.8,15.9 C5.4,15.9 5,15.9 4.6,15.8 C5.4,18.4 7.9,20.3 10.7,20.4 C8.5,22.2 5.6,23.2 2.5,23.2 C2,23.2 1.4,23.2 0.9,23.1 C3.9,24.9 7.4,26 11.1,26 C23.2,26 29.8,16 29.8,7.3 C29.8,7 29.8,6.7 29.8,6.5 C31,5.5 32.1,4.4 33,3.1 Z" id="Shape"></path> </g> </g> </svg></span>';
		break;
		case 'instagram' :
			return '<span class="social-shortcode-wrap"><svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="instagram" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-instagram fa-w-14 fa-5x"><path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" class=""></path></svg></span>';
		break;
		case 'tumblr' :
			return '<span class="social-shortcode-wrap"><svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="tumblr" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-tumblr fa-w-10 fa-2x"><path fill="currentColor" d="M309.8 480.3c-13.6 14.5-50 31.7-97.4 31.7-120.8 0-147-88.8-147-140.6v-144H17.9c-5.5 0-10-4.5-10-10v-68c0-7.2 4.5-13.6 11.3-16 62-21.8 81.5-76 84.3-117.1.8-11 6.5-16.3 16.1-16.3h70.9c5.5 0 10 4.5 10 10v115.2h83c5.5 0 10 4.4 10 9.9v81.7c0 5.5-4.5 10-10 10h-83.4V360c0 34.2 23.7 53.6 68 35.8 4.8-1.9 9-3.2 12.7-2.2 3.5.9 5.8 3.4 7.4 7.9l22 64.3c1.8 5 3.3 10.6-.4 14.5z" class=""></path></svg></span>';
		break;
		case 'google-plus' :
			return '<span class="social-shortcode-wrap"><svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="google-plus-g" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="svg-inline--fa fa-google-plus-g fa-w-20 fa-2x"><path fill="currentColor" d="M386.061 228.496c1.834 9.692 3.143 19.384 3.143 31.956C389.204 370.205 315.599 448 204.8 448c-106.084 0-192-85.915-192-192s85.916-192 192-192c51.864 0 95.083 18.859 128.611 50.292l-52.126 50.03c-14.145-13.621-39.028-29.599-76.485-29.599-65.484 0-118.92 54.221-118.92 121.277 0 67.056 53.436 121.277 118.92 121.277 75.961 0 104.513-54.745 108.965-82.773H204.8v-66.009h181.261zm185.406 6.437V179.2h-56.001v55.733h-55.733v56.001h55.733v55.733h56.001v-55.733H627.2v-56.001h-55.733z" class=""></path></svg></span>';
		break;
		case 'email' :
			return '<span class="social-shortcode-wrap"><svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-envelope fa-w-16 fa-2x"><path fill="currentColor" d="M464 64H48C21.5 64 0 85.5 0 112v288c0 26.5 21.5 48 48 48h416c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48zM48 96h416c8.8 0 16 7.2 16 16v41.4c-21.9 18.5-53.2 44-150.6 121.3-16.9 13.4-50.2 45.7-73.4 45.3-23.2.4-56.6-31.9-73.4-45.3C85.2 197.4 53.9 171.9 32 153.4V112c0-8.8 7.2-16 16-16zm416 320H48c-8.8 0-16-7.2-16-16V195c22.8 18.7 58.8 47.6 130.7 104.7 20.5 16.4 56.7 52.5 93.3 52.3 36.4.3 72.3-35.5 93.3-52.3 71.9-57.1 107.9-86 130.7-104.7v205c0 8.8-7.2 16-16 16z" class=""></path></svg></span>';
		break;
	endswitch;
	return null;
}
add_shortcode( 'social', 'social_shorts' );
