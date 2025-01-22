<?php

/**
 * Restaurant business hours meta box definition.
 */
function mvic_plugin_add_business_hours_meta_box() {
  add_meta_box(
    'restaurant_business_hours_meta_box', // Unique ID
    'Restaurant Business Hours',          // Box title
    'mvic_plugin_business_hours_meta_box_html', // Content callback
    'restaurant',                         // Post type
    'normal',                             // Context
    'high'                                // Priority
  );
}
add_action('add_meta_boxes', 'mvic_plugin_add_business_hours_meta_box');

/**
 * Restaurant business hours meta box HTML.
 */
function mvic_plugin_business_hours_meta_box_html($post) {
  $business_hours = get_post_meta($post->ID, '_restaurant_business_hours_meta_key', true);
  ?>
  <div id="business-hours-container">
    <?php if (!empty($business_hours)) : ?>
      <?php foreach ($business_hours as $index => $hours) : ?>
        <div class="business-hours-row">
          <select name="restaurant_business_hours[<?= $index; ?>][day]">
            <option value="monday" <?= selected($hours['day'], 'monday'); ?>>Monday</option>
            <option value="tuesday" <?= selected($hours['day'], 'tuesday'); ?>>Tuesday</option>
            <option value="wednesday" <?= selected($hours['day'], 'wednesday'); ?>>Wednesday</option>
            <option value="thursday" <?= selected($hours['day'], 'thursday'); ?>>Thursday</option>
            <option value="friday" <?= selected($hours['day'], 'friday'); ?>>Friday</option>
            <option value="saturday" <?= selected($hours['day'], 'saturday'); ?>>Saturday</option>
            <option value="sunday" <?= selected($hours['day'], 'sunday'); ?>>Sunday</option>
          </select>
          <input type="time" name="restaurant_business_hours[<?= $index; ?>][open]" value="<?= esc_attr($hours['open']); ?>" />
          <input type="time" name="restaurant_business_hours[<?= $index; ?>][close]" value="<?= esc_attr($hours['close']); ?>" />
          <select class="business-hours-meal" name="restaurant_business_hours[<?= $index; ?>][meal]">
            <option class="not-set" value="" <?= selected($hours['meal'], ''); ?>>Select Meal</option>
            <option value="breakfast" <?= selected($hours['meal'], 'breakfast'); ?>>Breakfast</option>
            <option value="lunch" <?= selected($hours['meal'], 'lunch'); ?>>Lunch</option>
            <option value="dinner" <?= selected($hours['meal'], 'dinner'); ?>>Dinner</option>
            <option value="brunch" <?= selected($hours['meal'], 'brunch'); ?>>Brunch</option>
          </select>
          <button type="button" class="remove-business-hours-row">-</button>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
  <button type="button" id="add-business-hours-row" class="add-business-hours-row">+</button>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('add-business-hours-row').addEventListener('click', function() {
        var container = document.getElementById('business-hours-container');
        var index = container.children.length;
        var row = document.createElement('div');
        row.className = 'business-hours-row';
        row.innerHTML = `
          <select name="restaurant_business_hours[${index}][day]">
            <option value="monday">Monday</option>
            <option value="tuesday">Tuesday</option>
            <option value="wednesday">Wednesday</option>
            <option value="thursday">Thursday</option>
            <option value="friday">Friday</option>
            <option value="saturday">Saturday</option>
            <option value="sunday">Sunday</option>
          </select>
          <input type="time" name="restaurant_business_hours[${index}][open]" />
          <input type="time" name="restaurant_business_hours[${index}][close]" />
          <select class="business-hours-meal" name="restaurant_business_hours[${index}][meal]">
            <option class="not-set" value="">Select Meal</option>
            <option value="breakfast">Breakfast</option>
            <option value="lunch">Lunch</option>
            <option value="dinner">Dinner</option>
            <option value="brunch">Brunch</option>
          </select>
          <button type="button" class="remove-business-hours-row">-</button>
        `;
        container.appendChild(row);
      });

      document.getElementById('business-hours-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-business-hours-row')) {
          e.target.parentElement.remove();
        }
      });
    });
  </script>
  <?php
}

/**
 * Action to save restaurant business hours data.
 */
function mvic_plugin_save_business_hours_meta_box($post_id) {
  if (array_key_exists('restaurant_business_hours', $_POST)) {
    update_post_meta(
      $post_id,
      '_restaurant_business_hours_meta_key',
      $_POST['restaurant_business_hours']
    );
  }
}
add_action('save_post', 'mvic_plugin_save_business_hours_meta_box');