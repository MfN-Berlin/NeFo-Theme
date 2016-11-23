<?php

/**
 * Implements hook_preprocess_page().
 */
function ofen_preprocess_page(&$variables) {
  // You can use preprocess hooks to modify the variables before they are passed
  // to the theme function or template file.

  // Overwrite title with value of field "field_nefo_interview_thema"
  if ((isset($variables['node']->type)) && ($variables['node']->type == 'nefo_product_interview')) {
    $items = field_get_items('node', $variables['node'], 'field_nefo_interview_thema');
    if (!empty($items)) {
      $field_output = field_view_value('node', $variables['node'], 'field_nefo_interview_thema', $items[0]);
      drupal_set_title($field_output['#markup']);
    }
  }

}

