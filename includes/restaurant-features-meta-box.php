<?php

/**
 * Restaurant features meta box definition.
 */
function mvic_plugin_add_restaurant_features_meta_box() {
  add_meta_box(
    'restaurant_features_meta_box', // Unique ID
    'Restaurant Features',          // Box title
    'mvic_plugin_restaurant_features_meta_box_html', // Content callback
    'restaurant',                   // Post type
    'side',                         // Context
    'high'                          // Priority
  );
}
add_action('add_meta_boxes', 'mvic_plugin_add_restaurant_features_meta_box');

/**
 * Restaurant features meta box HTML.
 */
function mvic_plugin_restaurant_features_meta_box_html($post) {
  $features = array(
    'takes_reservations' => 'Takes reservations',
    'delivers' => 'Delivers',
    'take_out' => 'Can take out',
    'accepts_credit_cards' => 'Accepts credit cards',
    'accepts_mastercard' => 'Accepts Mastercard',
    'accepts_visa' => 'Accepts Visa',
    'accepts_discover' => 'Accepts Discover',
    'accepts_amex' => 'Accepts American Express',
    'private_parking_lot' => 'Private parking lot',
    'wheelchair_accessible' => 'Wheelchair accessible',
    'kids_friendly' => 'Kids friendly',
    'group_friendly' => 'Group friendly',
    'outdoor_seats' => 'Outdoor seats',
    'has_wifi' => 'Has WIFI',
    'has_tv' => 'Has TV',
    'waiter_service' => 'Waiter service',
    'has_restrooms' => 'Has restrooms'
  );
  ?>
  <p class="meta-options">
    <label for="restaurant_show_features">
      <input type="checkbox" name="restaurant_show_features" id="restaurant_show_features" value="1" <?= checked(get_post_meta($post->ID, '_restaurant_show_features_meta_key', true), '1'); ?> />
      <b>Show features</b>
    </label>
  </p>
  <p class="meta-options">
    <?php
    foreach ($features as $key => $label) :
    ?>
      <?php $value = get_post_meta($post->ID, "_restaurant_{$key}_meta_key", true); ?>
      <label for="restaurant_<?= $key; ?>">
        <input type="checkbox" name="restaurant_<?= $key; ?>" id="restaurant_<?= $key; ?>" value="1" <?= checked($value, '1'); ?> />
        <?= $label; ?>
      </label>
      <br>
    <?php endforeach; ?>
  </p>
  <?php
}

/**
 * Action to save restaurant features data.
 */
function mvic_plugin_save_restaurant_features_meta_box($post_id) {
  if (array_key_exists('restaurant_show_features', $_POST)) {
    update_post_meta(
      $post_id,
      '_restaurant_show_features_meta_key',
      $_POST['restaurant_show_features']
    );
  } else {
    delete_post_meta($post_id, '_restaurant_show_features_meta_key');
  }
  $fields = [
    'restaurant_takes_reservations',
    'restaurant_delivers',
    'restaurant_take_out',
    'restaurant_accepts_credit_cards',
    'restaurant_accepts_mastercard',
    'restaurant_accepts_visa',
    'restaurant_accepts_discover',
    'restaurant_accepts_amex',
    'restaurant_private_parking_lot',
    'restaurant_wheelchair_accessible',
    'restaurant_kids_friendly',
    'restaurant_group_friendly',
    'restaurant_outdoor_seats',
    'restaurant_has_wifi',
    'restaurant_has_tv',
    'restaurant_waiter_service',
    'restaurant_has_restrooms'
  ];

  foreach ($fields as $field) {
    if (array_key_exists($field, $_POST)) {
      update_post_meta($post_id, "_{$field}_meta_key", $_POST[$field]);
    } else {
      delete_post_meta($post_id, "_{$field}_meta_key");
    }
  }
}
add_action('save_post', 'mvic_plugin_save_restaurant_features_meta_box');