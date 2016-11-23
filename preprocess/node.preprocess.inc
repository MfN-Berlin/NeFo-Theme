<?php

/**
 * Implements hook_preprocess_node().
 */
function ofen_preprocess_node(&$variables) {
  // You can use preprocess hooks to modify the variables before they are passed
  // to the theme function or template file.

  // Remove blog_usernames_blog
  if($variables['type'] == 'blog') {
    if (isset($variables['content']['links']['blog']['#links']['blog_usernames_blog'])) {
      unset($variables['content']['links']['blog']['#links']['blog_usernames_blog']);
    }
  }
  // Change string Submitted
  $date = format_date($variables['created'] , 'nefo_date_type_din5008');
  $variables['submitted'] = t('Created')  .' '. $date;

}
