<?php

// Hook to add meta box
add_action('add_meta_boxes', 'mvic_add_map_meta_box');

// Hook to save meta box data
add_action('save_post', 'mvic_save_map_meta_box_data');

// Function to add meta box
function mvic_add_map_meta_box() {
  $post_types = array('restaurant', 'beach', 'accommodation'); // Add your custom post types here

  foreach ($post_types as $post_type) {
    add_meta_box(
      'mvic_map_meta_box', // ID of the meta box
      'Map Info', // Title of the meta box
      'mvic_map_meta_box_callback', // Callback function
      $post_type, // Post type where the meta box will be displayed
      'normal', // Context
      'high' // Priority
    );
  }
}

// Callback function to display the meta box
function mvic_map_meta_box_callback($post) {
  // Add a nonce field for security
  wp_nonce_field('mvic_save_map_meta_box_data', 'mvic_map_meta_box_nonce');

  // Get the current value of the meta field
  $icon_url = get_post_meta($post->ID, '_mvic_icon_url', true);
  $latitude  = get_post_meta($post->ID, '_mvic_latitude', true);
  $longitude = get_post_meta($post->ID, '_mvic_longitude', true);

  // Get the current value of the location field
  $location = get_post_meta($post->ID, '_mvic_location', true);

  $location_values = [
    'st-thomas' => 'St. Thomas',
    'st-john' => 'St. John',
    'st-croix' => 'St. Croix'
  ];

  // Display the form field
  ?>
  <div class="meta-box-map-field">
    <label for="mvic_show_map">
      <input type="checkbox" id="mvic_show_map" name="mvic_show_map" value="1" <?php checked(get_post_meta($post->ID, '_mvic_show_map', true), '1'); ?> />
      <b>Show map</b>
    </label>
  </div>
  <br>
  <div class="meta-box-map-field">
    <label for="mvic_location">Location: </label>
    <select id="mvic_location" name="mvic_location">
      <?php foreach ($location_values as $key => $label) : ?>
        <option value="<?= esc_attr($key); ?>" <?php selected($location, $key); ?>><?= esc_html($label); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="meta-box-map-field">
    <label for="mvic_latitude">Latitude: &nbsp;&nbsp;</label>
    <input type="text" id="mvic_latitude" name="mvic_latitude" value="<?= esc_attr($latitude); ?>" size="16" />
  </div>
  <div class="meta-box-map-field">
    <label for="mvic_longitude">Longitude: </label>
    <input type="text" id="mvic_longitude" name="mvic_longitude" value="<?= esc_attr($longitude); ?>" size="16" />
  </div>
  <div class="meta-box-map-field flex items-center">
    <label for="mvic_icon_url" class="mr-[10px]">Map Icon URL:</label>
    <input type="text" id="mvic_icon_url" name="mvic_icon_url" value="<?= esc_attr($icon_url); ?>" class="flex-1" />
  </div>
  <?php
}

// Function to save the meta box data
function mvic_save_map_meta_box_data($post_id) {
  // Check if nonce is set
  if (!isset($_POST['mvic_map_meta_box_nonce'])) {
    return;
  }

  // Check if the user has permission to save the data
  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

  // Check if the meta fields are set
  if (!isset($_POST['mvic_icon_url'])
    || !isset($_POST['mvic_latitude'])
    || !isset($_POST['mvic_longitude'])
    || !isset($_POST['mvic_location'])) 
  {
    return;
  }

  $location = sanitize_text_field($_POST['mvic_location']);
  update_post_meta($post_id, '_mvic_location', $location);

  // Sanitize and save the data
  $icon_url = sanitize_text_field($_POST['mvic_icon_url']);
  $latitude = sanitize_text_field($_POST['mvic_latitude']);
  $longitude = sanitize_text_field($_POST['mvic_longitude']);
  $show_map = sanitize_text_field($_POST['mvic_show_map']);
  $show_map = isset($_POST['mvic_show_map']) ? '1' : '0';
  update_post_meta($post_id, '_mvic_icon_url', $icon_url);
  update_post_meta($post_id, '_mvic_latitude', $latitude);
  update_post_meta($post_id, '_mvic_longitude', $longitude);
  update_post_meta($post_id, '_mvic_show_map', $show_map);
}
?>