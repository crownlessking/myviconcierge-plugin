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
  $takesReservations = get_post_meta($post->ID, '_restaurant_takes_reservations_meta_key', true);
  $delivers = get_post_meta($post->ID, '_restaurant_delivers_meta_key', true);
  $takeOut = get_post_meta($post->ID, '_restaurant_take_out_meta_key', true);
  $acceptsCreditCards = get_post_meta($post->ID, '_restaurant_accepts_credit_cards_meta_key', true);
  $acceptsMastercard = get_post_meta($post->ID, '_restaurant_accepts_mastercard_meta_key', true);
  $acceptsVisa = get_post_meta($post->ID, '_restaurant_accepts_visa_meta_key', true);
  $acceptsDiscover = get_post_meta($post->ID, '_restaurant_accepts_discover_meta_key', true);
  $acceptsAmex = get_post_meta($post->ID, '_restaurant_accepts_amex_meta_key', true); // American Express
  $privateParkingLot = get_post_meta($post->ID, '_restaurant_private_parking_lot_meta_key', true);
  $wheelchairAccessible = get_post_meta($post->ID, '_restaurant_wheelchair_accessible_meta_key', true);
  $kidsFriendly = get_post_meta($post->ID, '_restaurant_kids_friendly_meta_key', true);
  $groupFriendly = get_post_meta($post->ID, '_restaurant_group_friendly_meta_key', true);
  $outdoorSeats = get_post_meta($post->ID, '_restaurant_outdoor_seats_meta_key', true);
  $hasWifi = get_post_meta($post->ID, '_restaurant_has_wifi_meta_key', true);
  $hasTv = get_post_meta($post->ID, '_restaurant_has_tv_meta_key', true);
  $waiterService = get_post_meta($post->ID, '_restaurant_waiter_service_meta_key', true);
  $hasRestrooms = get_post_meta($post->ID, '_restaurant_has_restrooms_meta_key', true);
  ?>
  <p class="meta-options">
    <label for="restaurant_takes_reservations">
      <input type="checkbox" name="restaurant_takes_reservations" id="restaurant_takes_reservations" value="1" <?= checked($takesReservations, '1'); ?> />
      Takes reservations
    </label>
    <br>
    <label for="restaurant_delivers">
      <input type="checkbox" name="restaurant_delivers" id="restaurant_delivers" value="1" <?= checked($delivers, '1'); ?> />
      Delivers
    </label>
    <br>
    <label for="restaurant_take_out">
      <input type="checkbox" name="restaurant_take_out" id="restaurant_take_out" value="1" <?= checked($takeOut, '1'); ?> />
      Can take out
    </label>
    <br>
    <label for="restaurant_accepts_credit_cards">
      <input type="checkbox" name="restaurant_accepts_credit_cards" id="restaurant_accepts_credit_cards" value="1" <?= checked($acceptsCreditCards, '1'); ?> />
      Accepts credit cards
    </label>
    <br>
    <label for="restaurant_accepts_mastercard">
      <input type="checkbox" name="restaurant_accepts_mastercard" id="restaurant_accepts_mastercard" value="1" <?= checked($acceptsMastercard, '1'); ?> />
      Accepts Mastercard
    </label>
    <br>
    <label for="restaurant_accepts_visa">
      <input type="checkbox" name="restaurant_accepts_visa" id="restaurant_accepts_visa" value="1" <?= checked($acceptsVisa, '1'); ?> />
      Accepts Visa
    </label>
    <br>
    <label for="restaurant_accepts_discover">
      <input type="checkbox" name="restaurant_accepts_discover" id="restaurant_accepts_discover" value="1" <?= checked($acceptsDiscover, '1'); ?> />
      Accepts Discover
    </label>
    <br>
    <label for="restaurant_accepts_amex">
      <input type="checkbox" name="restaurant_accepts_amex" id="restaurant_accepts_amex" value="1" <?= checked($acceptsAmex, '1'); ?> />
      Accepts American Express
    </label>
    <br>
    <label for="restaurant_private_parking_lot">
      <input type="checkbox" name="restaurant_private_parking_lot" id="restaurant_private_parking_lot" value="1" <?= checked($privateParkingLot, '1'); ?> />
      Private parking lot
    </label>
    <br>
    <label for="restaurant_wheelchair_accessible">
      <input type="checkbox" name="restaurant_wheelchair_accessible" id="restaurant_wheelchair_accessible" value="1" <?= checked($wheelchairAccessible, '1'); ?> />
      Wheelchair accessible
    </label>
    <br>
    <label for="restaurant_kids_friendly">
      <input type="checkbox" name="restaurant_kids_friendly" id="restaurant_kids_friendly" value="1" <?= checked($kidsFriendly, '1'); ?> />
      Kids friendly
    </label>
    <br>
    <label for="restaurant_group_friendly">
      <input type="checkbox" name="restaurant_group_friendly" id="restaurant_group_friendly" value="1" <?= checked($groupFriendly, '1'); ?> />
      Group friendly
    </label>
    <br>
    <label for="restaurant_outdoor_seats">
      <input type="checkbox" name="restaurant_outdoor_seats" id="restaurant_outdoor_seats" value="1" <?= checked($outdoorSeats, '1'); ?> />
      Outdoor seats
    </label>
    <br>
    <label for="restaurant_has_wifi">
      <input type="checkbox" name="restaurant_has_wifi" id="restaurant_has_wifi" value="1" <?= checked($hasWifi, '1'); ?> />
      Has WIFI
    </label>
    <br>
    <label for="restaurant_has_tv">
      <input type="checkbox" name="restaurant_has_tv" id="restaurant_has_tv" value="1" <?= checked($hasTv, '1'); ?> />
      Has TV
    </label>
    <br>
    <label for="restaurant_waiter_service">
      <input type="checkbox" name="restaurant_waiter_service" id="restaurant_waiter_service" value="1" <?= checked($waiterService, '1'); ?> />
      Waiter service
    </label>
    <br>
    <label for="restaurant_has_restrooms">
      <input type="checkbox" name="restaurant_has_restrooms" id="restaurant_has_restrooms" value="1" <?= checked($hasRestrooms, '1'); ?> />
      Has restrooms
    </label>
  </p>
  <?php
}

/**
 * Action to save restaurant features data.
 */
function mvic_plugin_save_restaurant_features_meta_box($post_id) {
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