<?php

function accommodation_profile_meta_box($post) {
  $types = array(
    'hotel' => 'Hotel',
    'resort' => 'Resort',
    'ownership' => 'Ownership'
  );
  $ambiences = array(
    'beach' => 'Beach',
    'town_view' => 'Town view',
    'town' => 'Town'
  );
  $type = get_post_meta($post->ID, '_accommodation_type_meta_key', true);
  $phone = get_post_meta($post->ID, '_accommodation_phone_meta_key', true);
  $website = get_post_meta($post->ID, '_accommodation_website_meta_key', true);
  $address = get_post_meta($post->ID, '_accommodation_address_meta_key', true);
  $ambience = get_post_meta($post->ID, '_accommodation_ambience_meta_key', true);
  $room_total = get_post_meta($post->ID, '_accommodation_room_total_meta_key', true);
  ?>
  <div class="accommodation-profile-field">
    <label for="accommodation_show_profile">
      <input type="checkbox" name="accommodation_show_profile" id="accommodation_show_profile" value="1" <?= checked(get_post_meta($post->ID, '_accommodation_show_profile_meta_key', true), '1'); ?> />
      <b>Show profile</b>
    </label>
  </div>
  <br>
  <div class="accommodation-profile-field">
    <label for="accommodation_type">Type:</label>
    <select name="accommodation_type" id="accommodation_type" class="meta-box-select">
      <option class="not-set" value="">Select type</option>
      <?php foreach ($types as $key => $label) : ?>
        <option value="<?= esc_attr($key); ?>" <?= selected($type, $key); ?>>
          <?= esc_html($label); ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="accommodation-profile-field">
    <label for="accommodation_phone">Phone: &nbsp;</label>
    <input type="text" name="accommodation_phone" id="accommodation_phone" class="accommodation-phone" value="<?= esc_attr($phone); ?>" />
  </div>
  <div class="accommodation-profile-field">
    <label for="accommodation_website">Website:</label>
    <input type="text" name="accommodation_website" id="accommodation_website" class="accommodation-website" value="<?= esc_attr($website); ?>" />
  </div>
  <div class="accommodation-profile-field">
    <label for="accommodation_address" class="meta-box-label align-top">Address:</label>
    <textarea name="accommodation_address" id="accommodation_address" class="meta-box-input accommodation-address"><?= esc_textarea($address); ?></textarea>
  </div>
  <div class="accommodation-profile-field">
    <label for="accommodation_ambience">Ambience:</label>
    <select name="accommodation_ambience" id="accommodation_ambience" class="meta-box-select">
      <option class="not-set" value="">Select ambience</option>
      <?php foreach ($ambiences as $key => $label) : ?>
        <option value="<?= esc_attr($key); ?>" <?= selected($ambience, $key); ?>>
          <?= esc_html($label); ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="accommodation-profile-field">
    <label for="accommodation_room_total">Room Total:</label>
    <input type="number" name="accommodation_room_total" id="accommodation_room_total" value="<?= esc_attr($room_total); ?>" />
  </div>
  <?php
}

function save_accommodation_profile_meta_box($post_id) {
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if (isset($_POST['accommodation_show_profile'])) {
    update_post_meta($post_id, '_accommodation_show_profile_meta_key', sanitize_text_field($_POST['accommodation_show_profile']));
  } else {
    delete_post_meta($post_id, '_accommodation_show_profile_meta_key');
  }
  if (!isset($_POST['accommodation_type'])
    || !isset($_POST['accommodation_phone'])
    || !isset($_POST['accommodation_website'])
    || !isset($_POST['accommodation_address'])
    || !isset($_POST['accommodation_ambience'])
    || !isset($_POST['accommodation_room_total'])
  ) return;
  update_post_meta($post_id, '_accommodation_type_meta_key', sanitize_text_field($_POST['accommodation_type']));
  update_post_meta($post_id, '_accommodation_phone_meta_key', sanitize_text_field($_POST['accommodation_phone']));
  update_post_meta($post_id, '_accommodation_website_meta_key', sanitize_text_field($_POST['accommodation_website']));
  update_post_meta($post_id, '_accommodation_address_meta_key', sanitize_text_field($_POST['accommodation_address']));
  update_post_meta($post_id, '_accommodation_ambience_meta_key', sanitize_text_field($_POST['accommodation_ambience']));
  update_post_meta($post_id, '_accommodation_room_total_meta_key', intval($_POST['accommodation_room_total']));
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