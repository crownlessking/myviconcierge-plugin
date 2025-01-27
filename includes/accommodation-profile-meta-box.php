<?php

function accommodation_profile_meta_box($post) {
  $types = array('Hotel', 'Resort', 'Ownership');
  $ambiences = array('Beach', 'Town view', 'Town');
  $type = get_post_meta($post->ID, '_accommodation_type', true);
  $phone = get_post_meta($post->ID, '_accommodation_phone', true);
  $website = get_post_meta($post->ID, '_accommodation_website', true);
  $address = get_post_meta($post->ID, '_accommodation_address', true);
  $ambience = get_post_meta($post->ID, '_accommodation_ambience', true);
  $room_total = get_post_meta($post->ID, '_accommodation_room_total', true);
  ?>
  <div class="accommodation-profile-field">
    <label for="accommodation_show_profile">
      <input type="checkbox" name="accommodation_show_profile" id="accommodation_show_profile" value="1" <?= checked(get_post_meta($post->ID, '_accommodation_show_profile', true), '1'); ?> />
      <b>Show profile</b>
    </label>
  </div>
  <br>
  <div class="accommodation-profile-field">
    <label for="accommodation_type">Type:</label>
    <select name="accommodation_type" id="accommodation_type" class="meta-box-select">
      <option class="not-set" value="">Select type</option>
      <?php foreach ($types as $option) : ?>
        <option value="<?php echo esc_attr($option); ?>" <?php selected($type, $option); ?>>
          <?php echo esc_html($option); ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="accommodation-profile-field">
    <label for="accommodation_phone">Phone: &nbsp;</label>
    <input type="text" name="accommodation_phone" id="accommodation_phone" class="accommodation-phone" value="<?php echo esc_attr($phone); ?>" />
  </div>
  <div class="accommodation-profile-field">
    <label for="accommodation_website">Website:</label>
    <input type="text" name="accommodation_website" id="accommodation_website" class="accommodation-website" value="<?php echo esc_attr($website); ?>" />
  </div>
  <div class="accommodation-profile-field">
    <label for="accommodation_address" class="meta-box-label align-top">Address:</label>
    <textarea name="accommodation_address" id="accommodation_address" class="meta-box-input accommodation-address" value="<?php echo esc_attr($address); ?>"></textarea>
  </div>
  <div class="accommodation-profile-field">
    <label for="accommodation_ambience">Ambience:</label>
    <select name="accommodation_ambience" id="accommodation_ambience" class="meta-box-select">
      <option class="not-set" value="">Select ambience</option>
      <?php foreach ($ambiences as $option) : ?>
        <option value="<?php echo esc_attr($option); ?>" <?php selected($ambience, $option); ?>>
          <?php echo esc_html($option); ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="accommodation-profile-field">
    <label for="accommodation_room_total">Room Total:</label>
    <input type="number" name="accommodation_room_total" id="accommodation_room_total" value="<?php echo esc_attr($room_total); ?>" />
  </div>
  <?php
}

function save_accommodation_profile_meta_box($post_id) {
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if (isset($_POST['accommodation_show_profile'])) {
    update_post_meta($post_id, '_accommodation_show_profile', '1');
  } else {
    update_post_meta($post_id, '_accommodation_show_profile', '0');
  }
  if (!isset($_POST['accommodation_type']) || !isset($_POST['accommodation_phone']) || !isset($_POST['accommodation_website']) || !isset($_POST['accommodation_address']) || !isset($_POST['accommodation_ambience']) || !isset($_POST['accommodation_room_total'])) return;
  update_post_meta($post_id, '_accommodation_type', sanitize_text_field($_POST['accommodation_type']));
  update_post_meta($post_id, '_accommodation_phone', sanitize_text_field($_POST['accommodation_phone']));
  update_post_meta($post_id, '_accommodation_website', sanitize_text_field($_POST['accommodation_website']));
  update_post_meta($post_id, '_accommodation_address', sanitize_text_field($_POST['accommodation_address']));
  update_post_meta($post_id, '_accommodation_ambience', sanitize_text_field($_POST['accommodation_ambience']));
  update_post_meta($post_id, '_accommodation_room_total', intval($_POST['accommodation_room_total']));
}

function add_accommodation_profile_meta_box() {
  add_meta_box(
    'accommodation_profile_meta_box',
    'Accommodation Profile',
    'accommodation_profile_meta_box',
    'accommodation',
    'side',
    'high'
  );
}

add_action('add_meta_boxes', 'add_accommodation_profile_meta_box');
add_action('save_post', 'save_accommodation_profile_meta_box');