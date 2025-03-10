<?php

/*

Beach features meta box contains the following boolean values:

* Swim/snorkel
* Rent a chair
* Rent an umbrella
* Buy food
* Restroom available
* Accommodations
* Taxi available
* Parking lot
* Entrance fee

*/

function mvic_plugin_add_beach_features_meta_box() {
  add_meta_box(
    'beach_features_meta_box',
    'Beach Features',
    'mvic_plugin_beach_features_meta_box',
    'beach',
    'side',
    'high'
  );
}

add_action('add_meta_boxes', 'mvic_plugin_add_beach_features_meta_box');

function mvic_plugin_beach_features_meta_box($post) {
  $features = array(
    'swim_snorkel' => 'Swim/snorkel',
    'rent_chair' => 'Rent a chair',
    'rent_umbrella' => 'Rent an umbrella',
    'buy_food' => 'Buy food',
    'restroom_available' => 'Restroom available',
    'accommodations' => 'Accommodations',
    'taxi_available' => 'Taxi available',
    'parking_lot' => 'Parking lot',
    'entrance_fee' => 'Entrance fee'
  );

  ?>
  <p class="meta-options">
    <label for="show_features">
      <input type="checkbox" name="show_features" id="show_features" value="1" <?= checked(get_post_meta($post->ID, '_beach_show_features_meta_key', true), '1'); ?> />
      <b>Show features</b>
    </label>
    <br>
    <?php foreach ($features as $key => $label): ?>
      <?php $value = get_post_meta($post->ID, "_beach_{$key}_meta_key", true); ?>
      <br>
      <label for="<?= $key; ?>">
        <input type="checkbox" id="<?= $key; ?>" name="<?= $key; ?>" value="1" <?= checked($value, 1, false); ?> />
        <?= $label; ?>
      </label>
    <?php endforeach; ?>
  </p>
  <?php
}

function mvic_plugin_save_beach_features_meta_box($post_id) {
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }

  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

  $features = array(
    'show_features',
    'swim_snorkel',
    'rent_chair',
    'rent_umbrella',
    'buy_food',
    'restroom_available',
    'accommodations',
    'taxi_available',
    'parking_lot',
    'entrance_fee'
  );

  foreach ($features as $feature) {
    if (isset($_POST[$feature])) {
      update_post_meta($post_id, "_beach_{$feature}_meta_key", $_POST[$feature]);
    } else {
      update_post_meta($post_id, "_beach_{$feature}_meta_key", 0);
    }
  }
}

add_action('save_post', 'mvic_plugin_save_beach_features_meta_box');