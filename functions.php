<?php

require_once('includes/cases.php');
require_once('includes/facts.php');

define('GOOGLE_MAPS_API_KEY', 'AIzaSyBHVW-nW-K5seTUJmg-YoGuhzwTDJLbAmo');

add_theme_support('post-thumbnails');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

function civ_custom_scripts() {
  $cacheVersion = '2.0.28';
  wp_enqueue_style('civ-fonts-fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css');
  wp_enqueue_style('civ-style', get_template_directory_uri() . '/dist/style/style.css', null, $cacheVersion);

  wp_enqueue_script('google-map-js', 'https://maps.googleapis.com/maps/api/js?key=' . GOOGLE_MAPS_API_KEY, null, $cacheVersion);
  wp_enqueue_script('civ-js', get_template_directory_uri() . '/dist/scripts/all.js', array('jquery'), $cacheVersion);
}
add_action('wp_enqueue_scripts', 'civ_custom_scripts');

function register_custom_menus() {
  register_nav_menus(
    array(
      'main-menu' => __('Main Menu')
    )
  );
}
add_action('init', 'register_custom_menus');

if (function_exists('acf_add_options_page')) {

	acf_add_options_page(array(
		'page_title' => 'Map',
		'menu_title' => 'Map',
		'menu_slug' => 'map-settings',
		'capability' => 'edit_posts',
		'redirect' => false,
    'icon_url' => 'dashicons-location-alt',
    'position' => '7.1'
	));

}

function instaItemOutput($imageObject = [], $isFiller = false, $isExtra = false) {
  $content = '';
  if ($isExtra) {
    $content .= '<img src="' . $imageObject['image']['url'] . '">';
  } else {
    if ($isFiller) {
      $instaItemClass = ' item-filler';
    }
    $content .= '<div class="insta-item' . $instaItemClass . '">';
      $content .= '<div class="insta-item-img-wrap">';
        $content .= '<div class="front">';
          if ($isFiller) {
            $content .= '<div class="image-filler"></div>';
          } else {
            $content .= '<img src="' . $imageObject['image']['url'] . '">';
          }
        $content .= '</div>';
        $content.= '<div class="back"></div>';
      $content .= '</div>';
    $content .= '</div>';
  }
  return $content;
}

function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

?>
