<?php

/**
 * Implements hook_preprocess_file_entity().
 *
 * Move styles from image to <DIV id="file-<ID>">
 */
function ofen_preprocess_file_entity(&$variables) {
  $elements = $variables['elements'];
  if (($elements['#bundle'] == 'image') && (!empty($elements['file']['#view_mode'])) && ($elements['file']['#view_mode'] == 'default')) {
    if (isset($elements['file']['#attributes']['style'])) {
      // Add all styles but height to <DIV id="file-<ID>">
      $variables['attributes_array']['style'] = preg_replace('|height: ?.+?\;|', '', $elements['file']['#attributes']['style']);
    }
    if (isset($elements['#attributes'])) {
      if (is_array($elements['#attributes']['class'])) {
        $class = $elements['#attributes']['class'];
      }
      else if (is_string($elements['#attributes']['class'])) {
        $class = explode(' ', $elements['#attributes']['class']);
      }
      else {
        $class = array();
      }
      // Add classes to <DIV id="file-<ID>">
      $variables['classes_array'] = array_merge($variables['classes_array'], $class);
    }
  }
}



