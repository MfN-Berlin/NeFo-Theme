<?php

/**
 * Implements hook_preprocess_node().
 */
function ofen_preprocess_node(&$variables) {
  // You can use preprocess hooks to modify the variables before they are passed
  // to the theme function or template file.

  // Change string Submitted
  $date = format_date($variables['created'] , 'nefo_date_type_din5008');
  $variables['submitted'] = t('Created')  .' '. $date;

  // Content type "blog"
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


  // Content type "nefo_news"
  if($variables['type'] == 'nefo_news' && $variables['page']) {
    // Don't show category on page
    hide($variables['content']['field_nefo_news_category']);
    // Change link "all News" if taxonomy term is "NeFo-Produkt Pressemitteilung"
    if (!empty($variables['field_nefo_news_category'][0]['tid'])) {
      if ($variables['field_nefo_news_category'][0]['tid'] == 75) {
        $variables['nefo_link_back_to_list'] = l('alle Pressemitteilungen', 'presse');
      }
      else {
        $variables['nefo_link_back_to_list'] = l('alle News', 'news');
      }
    }
  } // if(nefo_news)

  // Content type "nefo_product_document"
  if($variables['type'] == 'nefo_product_document' && $variables['page']) {
    // Don't show category on page
    hide($variables['content']['field_nefo_product_field_type']);
    // Create link to taxonomy term page
    $taxonomy_term = field_get_items('node', $variables['node'], 'field_nefo_taxonomy_document');
    $tid = intval($taxonomy_term[0]['tid']);
    switch ($tid) {
      case 76:
         $variables['nefo_link_back_to_list'] = l('alle Berichte', 'produkte/berichte');
        break;
      case 77:
         $variables['nefo_link_back_to_list'] = l('alle Faktenblätter', 'produkte/faktenblaetter');
        break;
      case 78:
         $variables['nefo_link_back_to_list'] = l('alle Stellungnahmen', 'produkte/stellungnahmen');
        break;
      case 79:
         $variables['nefo_link_back_to_list'] = l('alle Studien', 'produkte/studien');
        break;
    }
  } // if(nefo_product_document)

}


