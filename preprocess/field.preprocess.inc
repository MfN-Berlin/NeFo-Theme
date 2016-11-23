<?php

/**
 * Implements hook_preprocess_node().
 */
function ofen_preprocess_field(&$variables) {
  // Change value of field "field_nefo_interview_thema"
  if($variables['element']['#field_name'] == 'field_nefo_interview_thema') {
    $variables['items'][0]['#markup'] = $variables['element']['#object']->title;
  }
}
