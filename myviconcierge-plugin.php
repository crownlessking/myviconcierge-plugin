<?php
/*
  Plugin Name: My VI Concierge Plugin
  Description: Creates the custom post types "restaurant," "beach," and "accommodation".
  Version: 0.1.0
  Author: <a href="https://crownlessking.com" target="_blank">Riviere King</a>
*/

require_once plugin_dir_path(__FILE__) . 'includes/restaurant-profile-meta-box.php';
require_once plugin_dir_path(__FILE__) . 'includes/restaurant-features-meta-box.php';
require_once plugin_dir_path(__FILE__) . 'includes/map-meta-box.php';
require_once plugin_dir_path(__FILE__) . 'includes/restaurant-business-hours-meta-box.php';
require_once plugin_dir_path(__FILE__) . 'includes/beach-profile-meta-box.php';
require_once plugin_dir_path(__FILE__) . 'includes/beach-features-meta-box.php';
require_once plugin_dir_path(__FILE__) . 'includes/accommodation-profile-meta-box.php';

define('SLUG_PREFIX', 'virgin-islands/');
define('TITLE_PREFIX', 'Virgin Islands');

function myviconcierge_plugin_enqueue_styles() {
  wp_enqueue_style('myviconcierge-plugin-styles', plugin_dir_url(__FILE__) . 'myviconcierge-plugin.css');
}
add_action('admin_enqueue_scripts', 'myviconcierge_plugin_enqueue_styles');

function myviconcierge_plugin_enqueue_scripts() {
  wp_enqueue_style('intl-tel-input-css', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css');
  wp_enqueue_script('intl-tel-input-js', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js', ['jquery'], null, true);
  wp_enqueue_script('myviconcierge-plugin-custom-js', plugin_dir_url(__FILE__) . 'myviconcierge-plugin.js', ['jquery', 'intl-tel-input-js'], null, true);
}
add_action('admin_enqueue_scripts', 'myviconcierge_plugin_enqueue_scripts');

/**
 * Creates restaurants, beaches, and accommodations pages.
 */
function mvic_plugin_create_custom_pages() {
  // Retrieve the ID of the homepage
  $pages = [
    'restaurants' => [
      'title' => TITLE_PREFIX . ' Restaurants',
      'template' => 'page-restaurants.php'
    ],
    'beaches' => [
      'title' => TITLE_PREFIX . ' Beaches',
      'template' => 'page-beaches.php'
    ],
    'accommodations' => [
      'title' => TITLE_PREFIX . ' Hotels and Resorts',
      'template' => 'page-accommodations.php'
    ]
  ];

  foreach ($pages as $slug => $data) {
    // Query to check if the page already exists by title
    $query = new WP_Query([
      'post_type' => 'page',
      'title' => $data['title'],
      'post_status' => 'publish',
      'posts_per_page' => 1
    ]);

    if (!$query->have_posts()) {
      // Create the page if it doesn't exist
      $post_id = wp_insert_post([
        'post_title' => $data['title'],
        'post_name' => SLUG_PREFIX . 'hotels-resorts',
        'post_status' => 'publish',
        'post_type' => 'page',
        'meta_input' => [
          '_wp_page_template' => $data['template']
        ],
        // 'post_parent' => get_option('page_on_front')
      ]);

      // Check for errors
      if (is_wp_error($post_id)) {
        error_log('Error creating page: ' . $slug . ' - ' . $post_id->get_error_message());
      }
    }
  }
}
add_action('init', 'mvic_plugin_create_custom_pages');

/**
 * Creates "restaurant", "beach", and "accommodation" custom posts.
 */
function mvic_plugin_create_custom_post_types() {
  // Register Restaurant Post Type
  register_post_type('restaurant', [
    'labels' => [
      'name' => __('Restaurants'),
      'singular_name' => __('Restaurant'),
      'add_new_item' => __('Add New Restaurant'),
      'edit_item' => __('Edit Restaurant'),
      'new_item' => __('New Restaurant'),
      'view_item' => __('View Restaurant'),
      'search_items' => __('Search Restaurants'),
      'not_found' => __('No restaurants found'),
      'not_found_in_trash' => __('No restaurants found in Trash'),
    ],
    'public' => true,
    'has_archive' => true,
    'hierarchical' => true, // Enable parent page option
    'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'comments', 'page-attributes'],
    'menu_icon' => 'dashicons-food', // Icon for restaurant
    'rewrite' => ['slug' => SLUG_PREFIX . 'restaurants']
  ]);

  // Register Beach Post Type
  register_post_type('beach', [
    'labels' => [
      'name' => __('Beaches'),
      'singular_name' => __('Beach'),
      'add_new_item' => __('Add New Beach'),
      'edit_item' => __('Edit Beach'),
      'new_item' => __('New Beach'),
      'view_item' => __('View Beach'),
      'search_items' => __('Search Beaches'),
      'not_found' => __('No beaches found'),
      'not_found_in_trash' => __('No beaches found in Trash'),
    ],
    'public' => true,
    'has_archive' => true,
    'hierarchical' => true, // Enable parent page option
    'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'comments', 'page-attributes'],
    'menu_icon' => 'dashicons-palmtree', // Icon for beach
    'rewrite' => ['slug' => SLUG_PREFIX . 'beaches']
  ]);

  // Register Accommodation Post Type
  register_post_type('accommodation', [
    'labels' => [
      'name' => __('Accommodations'),
      'singular_name' => __('Accommodation'),
      'add_new_item' => __('Add New Accommodation'),
      'edit_item' => __('Edit Accommodation'),
      'new_item' => __('New Accommodation'),
      'view_item' => __('View Accommodation'),
      'search_items' => __('Search Accommodations'),
      'not_found' => __('No accommodations found'),
      'not_found_in_trash' => __('No accommodations found in Trash'),
    ],
    'public' => true,
    'has_archive' => true,
    'hierarchical' => true, // Enable parent page option
    'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'comments', 'page-attributes'],
    'menu_icon' => 'dashicons-building', // Icon for accommodation
    'rewrite' => ['slug' => SLUG_PREFIX . 'accommodations'],
  ]);
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
