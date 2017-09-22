<?php

/**
 * Implements hook_preprocess_page().
 */
function ofen_preprocess_page(&$variables) {
  // You can use preprocess hooks to modify the variables before they are passed
  // to the theme function or template file.

  // If interview content type, add custom class to title
  if ((isset($variables['node']->type)) && ($variables['node']->type == 'nefo_product_interview')) {
    $variables['title_attributes_array']['class'][] = 'nefo-product-interview-page-title';
  }

  // If nefo_news content type, add custom variable
  if ((isset($variables['node']->type)) && ($variables['node']->type == 'nefo_news')) {
    $node = node_load($variables['node']->nid);
    $output = field_view_field('node', $node, 'field_nefo_news_category', array('label' => 'hidden'));
    $variables['nefo_news_category'] = $output;
  }

  // Change title of Presse page (view "NeFo-Übersichtstabelle News per Begriff")
  if (empty($variables['node'])) {
    $current_path = drupal_get_path_alias();
    if($current_path == 'presse') {
      drupal_set_title('Presse');
    }
  }

}

