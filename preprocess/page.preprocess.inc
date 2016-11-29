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

}

