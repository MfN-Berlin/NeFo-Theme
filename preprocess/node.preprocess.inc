<?php

/**
 * Implements hook_preprocess_node().
 */
function ofen_preprocess_node(&$variables) {
  // You can use preprocess hooks to modify the variables before they are passed
  // to the theme function or template file.

  // Content type blog
  if($variables['type'] == 'blog') {
    // Custom field blog_author
    $variables['nefo_blog_author_data'] = array();
    if (!empty($variables['field_blog_author'])) {
      $author_profile = $variables['field_blog_author']['0']['entity'];
      $name = $author_profile->field_researcher_name[LANGUAGE_NONE][0]['value'];
      $link = $author_profile->field_researcher_personal_www[LANGUAGE_NONE][0]['url'];
      $institution = $author_profile->field_researcher_institutio_name[LANGUAGE_NONE][0]['value'];
      $variables['nefo_blog_author_data']['author'] = empty($link) ? $name : l($name, $link);
      $variables['nefo_blog_author_data']['institution'] = !empty($institution) ? $institution : '';
      $picture = array();
      if (!empty($author_profile->field_researcher_picture[LANGUAGE_NONE][0]['uri'])) {
        $picture['credit'] = !empty($author_profile->field_researcher_picture[LANGUAGE_NONE][0]['field_file_image_credit_text'][LANGUAGE_NONE][0]['value']) ?
          $author_profile->field_researcher_picture[LANGUAGE_NONE][0]['field_file_image_credit_text'][LANGUAGE_NONE][0]['value'] : '';
        $picture['caption'] = !empty($author_profile->field_researcher_picture[LANGUAGE_NONE][0]['field_image_caption_text'][LANGUAGE_NONE][0]['value']) ?
          $author_profile->field_researcher_picture[LANGUAGE_NONE][0]['field_image_caption_text'][LANGUAGE_NONE][0]['value'] : '';
        $picture['image'] = array(
          '#theme' => 'image_style',
          '#path' => $author_profile->field_researcher_picture[LANGUAGE_NONE][0]['uri'],
          '#style_name' => 'thumbnail',
          '#alt' => $variables['nefo_blog_author_data']['author'],
          '#title' => $picture['caption'] ."\n". $picture['credit'],
        );
      }
      $variables['nefo_blog_author_data']['picture'] = $picture;
      unset($variables['content']['field_blog_author']);
    }
    if (isset($variables['content']['links']['blog']['#links']['blog_usernames_blog'])) {
      unset($variables['content']['links']['blog']['#links']['blog_usernames_blog']);
    }
  } // if(blog)

  // Change string Submitted
  $date = format_date($variables['created'] , 'nefo_date_type_din5008');
  $variables['submitted'] = t('Created')  .' '. $date;

}
