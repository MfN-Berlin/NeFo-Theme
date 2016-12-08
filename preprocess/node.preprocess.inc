<?php

/**
 * Implements hook_preprocess_node().
 */
function ofen_preprocess_node(&$variables) {
  // You can use preprocess hooks to modify the variables before they are passed
  // to the theme function or template file.

  // Content type blog
  if($variables['type'] == 'blog') {
    $author_profile = profile2_load_by_user($variables['uid'], 'researcher');
    $variables['nefo_blog_author_data'] = array();
    if (!empty($author_profile)) {
      $variables['nefo_blog_author_data']['author'] = t('from') .' '. (empty($author_profile->field_researcher_personal_www[LANGUAGE_NONE][0]['url']) ?
          $author_profile->field_researcher_name[LANGUAGE_NONE][0]['value'] :
          l($author_profile->field_researcher_name[LANGUAGE_NONE][0]['value'], $author_profile->field_researcher_personal_www[LANGUAGE_NONE][0]['url']));
      $variables['nefo_blog_author_data']['author'] .= (!empty($author_profile->field_researcher_institutio_name[LANGUAGE_NONE][0]['value'])) ?
          ', '. $author_profile->field_researcher_institutio_name[LANGUAGE_NONE][0]['value'] : '';
      $picture = array();
      if (!empty($author_profile->field_researcher_picture[LANGUAGE_NONE][0]['uri'])) {
        $caption = !empty($author_profile->field_researcher_picture[LANGUAGE_NONE][0]['field_image_caption_text'][LANGUAGE_NONE][0]['value']) ?
          $author_profile->field_researcher_picture[LANGUAGE_NONE][0]['field_image_caption_text'][LANGUAGE_NONE][0]['value'] : '';
        $credit = !empty($author_profile->field_researcher_picture[LANGUAGE_NONE][0]['field_file_image_credit_text'][LANGUAGE_NONE][0]['value']) ?
          $author_profile->field_researcher_picture[LANGUAGE_NONE][0]['field_file_image_credit_text'][LANGUAGE_NONE][0]['value'] : '';
        $picture['caption'] = $caption . ((!empty($caption) && !empty($credit)) ? ', ' : '') . $credit;
        $picture['image'] = array(
          '#theme' => 'image_style',
          '#path' => $author_profile->field_researcher_picture[LANGUAGE_NONE][0]['uri'],
          '#style_name' => 'thumbnail',
          '#alt' => $variables['nefo_blog_author_data']['author'],
          '#title' => $caption ."\n". $credit,
        );
      }
      $variables['nefo_blog_author_data']['picture'] = $picture;
    }
    if (isset($variables['content']['links']['blog']['#links']['blog_usernames_blog'])) {
      unset($variables['content']['links']['blog']['#links']['blog_usernames_blog']);
    }
  } // if(blog)

  // Change string Submitted
  $date = format_date($variables['created'] , 'nefo_date_type_din5008');
  $variables['submitted'] = t('Created')  .' '. $date;

}
