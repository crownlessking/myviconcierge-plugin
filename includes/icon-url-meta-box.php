<?php
// Hook to add meta box
add_action('add_meta_boxes', 'mvic_add_icon_url_meta_box');

// Hook to save meta box data
add_action('save_post', 'mvic_save_icon_url_meta_box_data');

// Function to add meta box
function mvic_add_icon_url_meta_box() {
  $post_types = array('restaurant', 'beach', 'accommodation'); // Add your custom post types here

  foreach ($post_types as $post_type) {
    add_meta_box(
      'mvic_icon_url_meta_box', // ID of the meta box
      'Icon URL', // Title of the meta box
      'mvic_icon_url_meta_box_callback', // Callback function
      $post_type, // Post type where the meta box will be displayed
      'normal', // Context
      'high' // Priority
    );
  }
}

// Callback function to display the meta box
function mvic_icon_url_meta_box_callback($post) {
  // Add a nonce field for security
  wp_nonce_field('mvic_save_icon_url_meta_box_data', 'mvic_icon_url_meta_box_nonce');

  // Get the current value of the meta field
  $value = get_post_meta($post->ID, '_mvic_icon_url', true);

  // Display the form field
  echo '<label for="mvic_icon_url">Enter the URL of the icon image: </label>';
  echo '<input type="text" id="mvic_icon_url" name="mvic_icon_url" value="' . esc_attr($value) . '" size="25" />';
}

// Function to save the meta box data
function mvic_save_icon_url_meta_box_data($post_id) {
  // Check if nonce is set
  if (!isset($_POST['mvic_icon_url_meta_box_nonce'])) {
    return;
  }

  // Verify the nonce
  if (!wp_verify_nonce($_POST['mvic_icon_url_meta_box_nonce'], 'mvic_save_icon_url_meta_box_data')) {
    return;
  }

  // Check if the user has permission to save the data
  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

  // Check if the meta field is set
  if (!isset($_POST['mvic_icon_url'])) {
    return;
  }

  // Sanitize and save the data
  $icon_url = sanitize_text_field($_POST['mvic_icon_url']);
  update_post_meta($post_id, '_mvic_icon_url', $icon_url);
}
?>