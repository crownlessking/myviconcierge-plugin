<?php
/*
  Plugin Name: My VI Concierge Plugin
  Description: Register the custom post types "restaurant," "beach," and "accommodation".
  Version: 0.1.0
  Author: <a href="https://crownlessking.com" target="_blank">Riviere King</a>
*/

require_once plugin_dir_path(__FILE__) . 'includes/restaurant-profile-meta-box.php';
require_once plugin_dir_path(__FILE__) . 'includes/restaurant-feature-meta-box.php';
require_once plugin_dir_path(__FILE__) . 'includes/icon-url-meta-box.php';
require_once plugin_dir_path(__FILE__) . 'includes/restaurant-business-hours-meta-box.php';

function myviconcierge_plugin_enqueue_styles() {
  wp_enqueue_style('myviconcierge-plugin-styles', plugin_dir_url(__FILE__) . 'myviconcierge-plugin.css');
}
add_action('admin_enqueue_scripts', 'myviconcierge_plugin_enqueue_styles');

function myviconcierge_plugin_enqueue_scripts() {
    wp_enqueue_style('intl-tel-input-css', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css');
    wp_enqueue_script('intl-tel-input-js', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js', array('jquery'), null, true);
    wp_enqueue_script('myviconcierge-plugin-custom-js', plugin_dir_url(__FILE__) . 'myviconcierge-plugin.js', array('jquery', 'intl-tel-input-js'), null, true);
}
add_action('admin_enqueue_scripts', 'myviconcierge_plugin_enqueue_scripts');

/**
 * Creates "restaurant", "beach", and "accommodation" custom posts.
 */
function mvic_plugin_create_custom_post_types() {
  // Register Restaurant Post Type
  register_post_type('restaurant', array(
    'labels' => array(
      'name' => __('Restaurants'),
      'singular_name'      => __('Restaurant'),
      'add_new_item'       => __('Add New Restaurant'),
      'edit_item'          => __('Edit Restaurant'),
      'new_item'           => __('New Restaurant'),
      'view_item'          => __('View Restaurant'),
      'search_items'       => __('Search Restaurants'),
      'not_found'          => __('No restaurants found'),
      'not_found_in_trash' => __('No restaurants found in Trash'),
    ),
    'public' => true,
    'has_archive' => true,
    'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
    'menu_icon'   => 'dashicons-food', // Icon for restaurant
    'rewrite' => array('slug' => 'restaurants'),
  ));

  // Register Beach Post Type
  register_post_type('beach', array(
    'labels' => array(
      'name' => __('Beaches'),
      'singular_name'      => __('Beach'),
      'add_new_item'       => __('Add New Beach'),
      'edit_item'          => __('Edit Beach'),
      'new_item'           => __('New Beach'),
      'view_item'          => __('View Beach'),
      'search_items'       => __('Search Beaches'),
      'not_found'          => __('No beaches found'),
      'not_found_in_trash' => __('No beaches found in Trash'),
    ),
    'public' => true,
    'has_archive' => true,
    'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
    'menu_icon'   => 'dashicons-palmtree', // Icon for beach
    'rewrite' => array('slug' => 'beaches')
  ));

  // Register Accommodation Post Type
  register_post_type('accommodation', array(
    'labels' => array(
      'name' => __('Accommodations'),
      'singular_name' => __('Accommodation'),
      'add_new_item'       => __('Add New Accommodation'),
      'edit_item'          => __('Edit Accommodation'),
      'new_item'           => __('New Accommodation'),
      'view_item'          => __('View Accommodation'),
      'search_items'       => __('Search Accommodations'),
      'not_found'          => __('No accommodations found'),
      'not_found_in_trash' => __('No accommodations found in Trash'),
    ),
    'public' => true,
    'has_archive' => true,
    'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
    'menu_icon'   => 'dashicons-building', // Icon for accommodation
    'rewrite' => array('slug' => 'accommodations'),
  ));
}
add_action('init', 'mvic_plugin_create_custom_post_types');

/**
 * Change the title placeholder for the "restaurant", "beach", "accommodation"
 * custom post types.
 */
function mvic_plugin_change_title_placeholder_text($title) {
  $screen = get_current_screen();
  if ($screen->post_type == 'restaurant') {
    $title = 'Restaurant Name';
  } else if ($screen->post_type == 'beach') {
    $title = 'Beach Name';
  } else if ($screen->post_type == 'accommodation') {
    $title = 'Hotel or Resort Name';
  }
  return $title;
}
add_filter('enter_title_here', 'mvic_plugin_change_title_placeholder_text');
