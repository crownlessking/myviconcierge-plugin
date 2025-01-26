<?php
// Add the meta box
function mvic_plugin_beach_profile_add_meta_box() {
  add_meta_box(
    'beach_profile_meta_box', // ID
    'Beach Profile', // Title
    'mvic_plugin_beach_profile_meta_box_callback', // Callback
    'beach', // Post type
    'side', // Context
    'high' // Priority
  );
}
add_action('add_meta_boxes', 'mvic_plugin_beach_profile_add_meta_box');

// Meta box callback function
function mvic_plugin_beach_profile_meta_box_callback($post) {
  // Add a nonce field so we can check for it later.
  wp_nonce_field('mvic_plugin_beach_profile_save_meta_box_data', 'beach_profile_meta_box_nonce');

  // Retrieve existing values from the database
  $phone = get_post_meta($post->ID, '_beach_phone_meta_key', true);
  $website = get_post_meta($post->ID, '_beach_website_meta_key', true);
  $address = get_post_meta($post->ID, '_beach_address_meta_key', true);

  // Display the form fields
  ?>
  <div class="beach-profile-field">
    <label for="beach_show_profile">
      <input type="checkbox" name="beach_show_profile" id="beach_show_profile" value="1" <?= checked(get_post_meta($post->ID, '_beach_show_profile_meta_key', true), '1'); ?> />
      <b>Show profile</b>
    </label>
  </div>
  <br>
  <div class="beach-profile-field">
    <label for="beach_phone" class="meta-box-label">Phone:</label>
    <input type="text" id="beach_phone" name="beach_phone" value="<?php echo esc_attr($phone); ?>" placeholder="Beach phone #" class="beach-phone" />
  </div>
  <div class="beach-profile-field">
    <label for="beach_address" class="meta-box-label align-top">Address:</label>
    <textarea id="beach_address" name="beach_address" placeholder="Beach address" value="<?php echo esc_textarea($address); ?>" class="beach-address"></textarea>
  </div>
  <div class="beach-profile-field">
    <label for="beach_website" class="meta-box-label">Website:</label>
    <input type="text" id="beach_website" name="beach_website" value="<?php echo esc_attr($website); ?>" placeholder="URL" class="beach-website" />
  </div>
  <?php
}

// Save the meta box data
function mvic_plugin_beach_profile_save_meta_box_data($post_id) {
  // Check if our nonce is set.
  if (!isset($_POST['beach_profile_meta_box_nonce'])) {
    return;
  }

  // Verify that the nonce is valid.
  if (!wp_verify_nonce($_POST['beach_profile_meta_box_nonce'], 'mvic_plugin_beach_profile_save_meta_box_data')) {
    return;
  }

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }

  // Check the user's permissions.
  if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
    if (!current_user_can('edit_page', $post_id)) {
      return;
    }
  } else {
    if (!current_user_can('edit_post', $post_id)) {
      return;
    }
  }

  if (isset($_POST['beach_show_profile'])) {
    $show_profile = sanitize_text_field($_POST['beach_show_profile']);
    update_post_meta($post_id, '_beach_show_profile_meta_key', $show_profile);
  } else {
    delete_post_meta($post_id, '_beach_show_profile_meta_key');
  }

  // Sanitize and save the data

  if (isset($_POST['beach_phone'])) {
    $phone = sanitize_text_field($_POST['beach_phone']);
    update_post_meta($post_id, '_beach_phone_meta_key', $phone);
  }

  if (isset($_POST['beach_website'])) {
    $website = sanitize_text_field($_POST['beach_website']);
    update_post_meta($post_id, '_beach_website_meta_key', $website);
  }

  if (isset($_POST['beach_address'])) {
    $address = sanitize_text_field($_POST['beach_address']);
    update_post_meta($post_id, '_beach_address_meta_key', $address);
  }
}
add_action('save_post', 'mvic_plugin_beach_profile_save_meta_box_data');
?>
