<?php

/**
 * Restaurant profile meta box definition.
 */
function mvic_plugin_add_restaurant_profile_meta_box() {
  add_meta_box(
    'restaurant_profile_meta_box', // Unique ID
    'Restaurant Profile',        // Box title
    'mvic_plugin_restaurant_profile_meta_box_html', // Content callback
    'restaurant',                // Post type
    'side',                      // Context
    'high'                       // Priority
  );
}
add_action('add_meta_boxes', 'mvic_plugin_add_restaurant_profile_meta_box');

/**
 * Restaurant profile meta box HTML.
 */
function mvic_plugin_restaurant_profile_meta_box_html($post) {
  $phone = get_post_meta($post->ID, '_restaurant_phone_meta_key', true);
  $address = get_post_meta($post->ID, '_restaurant_address_meta_key', true);
  $website = get_post_meta($post->ID, '_restaurant_website_meta_key', true);
  $cuisine = get_post_meta($post->ID, '_restaurant_cuisine_meta_key', true);
  $costLow = get_post_meta($post->ID, '_restaurant_cost_low_meta_key', true);
  $costHigh = get_post_meta($post->ID, '_restaurant_cost_high_meta_key', true);
  $ambience = get_post_meta($post->ID, '_restaurant_ambience_meta_key', true);
  $suitableFor = get_post_meta($post->ID, '_restaurant_suitable_for_meta_key', true);
  $attire = get_post_meta($post->ID, '_restaurant_attire_meta_key', true);
  $noiseLevel = get_post_meta($post->ID, '_restaurant_noise_level_meta_key', true);
  $alcohol = get_post_meta($post->ID, '_restaurant_alcohol_meta_key', true);
  ?>
    <div class="restaurant-profile-field">
      <label for="restaurant_show_profile">
        <input type="checkbox" name="restaurant_show_profile" id="restaurant_show_profile" value="1" <?= checked(get_post_meta($post->ID, '_restaurant_show_profile_meta_key', true), '1'); ?> />
        <b>Show Profile</b>
      </label>
    </div>  
    <div class="restaurant-profile-field">
      <label for="restaurant_phone" class="meta-box-label">Phone:</label>
      <input type="text" name="restaurant_phone" id="restaurant_phone" value="<?= esc_attr($phone); ?>" placeholder="Phone #" class="meta-box-input restaurant-phone" />
    </div>
    <div class="restaurant-profile-field">
      <label for="restaurant_address" class="meta-box-label align-top">Address:</label>
      <textarea name="restaurant_address" id="restaurant_address" placeholder="Restaurant address" class="meta-box-input restaurant-address"><?= esc_textarea($address); ?></textarea>
    </div>
    <div class="restaurant-profile-field">
      <label for="restaurant_website" class="meta-box-label">Website:</label>
      <input type="text" name="restaurant_website" id="restaurant_website" value="<?= esc_attr($website); ?>" placeholder="Restaurant website" class="meta-box-input restaurant-website" />
    </div>
    <div class="restaurant-profile-field">
      <label for="restaurant_cuisine" class="meta-box-label">Cuisine:</label>
      <input type="text" name="restaurant_cuisine" id="restaurant_cuisine" value="<?= esc_attr($cuisine); ?>" placeholder="Restaurant cuisine" class="meta-box-input restaurant-cuisine" />
    </div>
    <div class="restaurant-profile-field">
      <label for="restaurant_cost_low" class="meta-box-label">Cost Low:</label>
      <input type="number" name="restaurant_cost_low" id="restaurant_cost_low" value="<?= esc_attr($costLow); ?>" placeholder="Lowest cost" class="meta-box-input restaurant-cost-low" />
    </div>
    <div class="restaurant-profile-field">
      <label for="restaurant_cost_high" class="meta-box-label">Cost High:</label>
      <input type="number" name="restaurant_cost_high" id="restaurant_cost_high" value="<?= esc_attr($costHigh); ?>" placeholder="Highest cost" class="meta-box-input restaurant-cost-high" />
    </div>
    <div class="restaurant-profile-field">
      <label for="restaurant_ambience">Ambience:</label>
      <select name="restaurant_ambience" id="restaurant_ambience" class="meta-box-select">
        <option class="not-set" value="" <?= selected($ambience, ''); ?>>Select Ambience</option>
        <option value="indoors" <?= selected($ambience, 'indoors'); ?>>Indoors</option>
        <option value="cultural" <?= selected($ambience, 'cultural'); ?>>Cultural</option>
        <option value="bistro/pub" <?= selected($ambience, 'bistro/pub'); ?>>Bistro/pub</option>
        <option value="historical" <?= selected($ambience, 'historical'); ?>>Historical</option>
        <option value="oceanside" <?= selected($ambience, 'oceanside'); ?>>Oceanside</option>
        <option value="outdoors" <?= selected($ambience, 'outdoors'); ?>>Outdoors</option>
        <option value="beachside" <?= selected($ambience, 'beachside'); ?>>Beachside</option>
        <option value="sport_bar" <?= selected($ambience, 'sport_bar'); ?>>Sport bar</option>
        <option value="dockside" <?= selected($ambience, 'dockside'); ?>>Dockside</option>
        <option value="food_truck" <?= selected($ambience, 'food_truck'); ?>>Food truck</option>
        <option value="great_view" <?= selected($ambience, 'great_view'); ?>>Great view</option>
        <option value="beach" <?= selected($ambience, 'beach'); ?>>Beach</option>
        <option value="town_view" <?= selected($ambience, 'town_view'); ?>>Town view</option>
        <option value="town" <?= selected($ambience, 'town'); ?>>Town</option>
      </select>
    </div>
    <div class="restaurant-profile-field">
      <label for="restaurant_suitable_for">Suitable For:</label>
      <select name="restaurant_suitable_for" id="restaurant_suitable_for" class="meta-box-select">
        <option class="not-set" value="" <?= selected($suitableFor, ''); ?>>Select Suitable For</option>
        <option value="all" <?= selected($suitableFor, 'all'); ?>>All</option>
        <option value="hanging_out" <?= selected($suitableFor, 'hanging_out'); ?>>Hanging out</option>
        <option value="romance" <?= selected($suitableFor, 'romance'); ?>>Romance</option>
        <option value="quick_stops" <?= selected($suitableFor, 'quick_stops'); ?>>Quick stops</option>
      </select>
    </div>
    <div class="restaurant-profile-field">
      <label for="restaurant_attire">Attire:</label>
      <select name="restaurant_attire" id="restaurant_attire" class="meta-box-select">
        <option class="not-set" value="" <?= selected($attire, ''); ?>>Select Attire</option>
        <option value="casual" <?= selected($attire, 'casual'); ?>>Casual</option>
        <option value="casual_elegant" <?= selected($attire, 'casual_elegant'); ?>>Casual elegant</option>
      </select>
    </div>
    <div class="restaurant-profile-field">
      <label for="restaurant_noise_level">Noise level:</label>
      <select name="restaurant_noise_level" id="restaurant_noise_level" class="meta-box-select">
        <option class="not-set" value="" <?= selected($noiseLevel, ''); ?>>Select Noise Level</option>
        <option value="average" <?= selected($noiseLevel, 'average'); ?>>Average</option>
        <option value="quiet" <?= selected($noiseLevel, 'quiet'); ?>>Quiet</option>
        <option value="loud" <?= selected($noiseLevel, 'loud'); ?>>Loud</option>
      </select>
    </div>
    <div class="restaurant-profile-field">
      <label for="restaurant_alcohol">Alcohol:</label>
      <select name="restaurant_alcohol" id="restaurant_alcohol" class="meta-box-select">
        <option class="not-set" value="" <?= selected($alcohol, ''); ?>>Select Alcohol</option>
        <option value="full_bar" <?= selected($alcohol, 'full_bar'); ?>>Full bar</option>
        <option value="menu_selection" <?= selected($alcohol, 'menu_selection'); ?>>Menu selection</option>
        <option value="limited" <?= selected($alcohol, 'limited'); ?>>Limited</option>
      </select>
    </div>
  <?php
}

/**
 * Action to save the restaurant profile data.
 */
function mvic_plugin_save_restaurant_profile_meta_box($post_id) {
  if (array_key_exists('restaurant_show_profile', $_POST)) {
    update_post_meta(
      $post_id,
      '_restaurant_show_profile_meta_key',
      $_POST['restaurant_show_profile']
    );
  } else {
    delete_post_meta($post_id, '_restaurant_show_profile_meta_key');
  }
  if (array_key_exists('restaurant_phone', $_POST)) {
    update_post_meta(
      $post_id,
      '_restaurant_phone_meta_key',
      $_POST['restaurant_phone']
    );
  }
  if (array_key_exists('restaurant_address', $_POST)) {
    update_post_meta(
      $post_id,
      '_restaurant_address_meta_key',
      $_POST['restaurant_address']
    );
  }
  if (array_key_exists('restaurant_website', $_POST)) {
    update_post_meta(
      $post_id,
      '_restaurant_website_meta_key',
      $_POST['restaurant_website']
    );
  }
  if (array_key_exists('restaurant_cuisine', $_POST)) {
    update_post_meta(
      $post_id,
      '_restaurant_cuisine_meta_key',
      $_POST['restaurant_cuisine']
    );
  }
  if (array_key_exists('restaurant_cost_low', $_POST)) {
    update_post_meta(
      $post_id,
      '_restaurant_cost_low_meta_key',
      $_POST['restaurant_cost_low']
    );
  }
  if (array_key_exists('restaurant_cost_high', $_POST)) {
    update_post_meta(
      $post_id,
      '_restaurant_cost_high_meta_key',
      $_POST['restaurant_cost_high']
    );
  }
  if (array_key_exists('restaurant_ambience', $_POST)) {
    update_post_meta(
      $post_id,
      '_restaurant_ambience_meta_key',
      $_POST['restaurant_ambience']
    );
  }
  if (array_key_exists('restaurant_suitable_for', $_POST)) {
    update_post_meta(
      $post_id,
      '_restaurant_suitable_for_meta_key',
      $_POST['restaurant_suitable_for']
    );
  }
  if (array_key_exists('restaurant_attire', $_POST)) {
    update_post_meta(
      $post_id,
      '_restaurant_attire_meta_key',
      $_POST['restaurant_attire']
    );
  }
  if (array_key_exists('restaurant_noise_level', $_POST)) {
    update_post_meta(
      $post_id,
      '_restaurant_noise_level_meta_key',
      $_POST['restaurant_noise_level']
    );
  }
  if (array_key_exists('restaurant_alcohol', $_POST)) {
    update_post_meta(
      $post_id,
      '_restaurant_alcohol_meta_key',
      $_POST['restaurant_alcohol']
    );
  }
}

add_action('save_post', 'mvic_plugin_save_restaurant_profile_meta_box');