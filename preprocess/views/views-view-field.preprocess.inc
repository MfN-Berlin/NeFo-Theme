<?php

/**
 * Implements hook_preprocess_views_view_field().
 */
function ofen_preprocess_views_view_field(&$variables) {
  $view = $variables['view'];

  /**
   * View: NeFo-Übersichtstabelle Produkte per Begriff
   */
  if ($view->name == 'nefo_view_list_products_by_term') {
    if ($variables['field']->options['id'] == 'type_1') {
      $tid = intval($variables['row']->taxonomy_term_data_field_data_field_nefo_taxonomy_document_t);
      $node_type = $variables['row']->node_type;
      $variables['output'] = _ofen_get_product_document_icon($node_type, $tid);
    }
  }

  /**
   * View: NeFo-Block Current Products
   * Aktuelle Produkte: Stellungnahmen, Faktenblätter, Berichte, Studien, NeFo-Artikel
   */
  if ($view->name == 'nefo_block_current_products') {
    // Image
    if ($variables['field']->options['id'] == 'field_nefo_slide_product_img') {
      if (empty($variables['row']->field_field_nefo_article_img) && empty($variables['row']->field_field_nefo_slide_product_img)) {
        $tid = intval($variables['row']->taxonomy_term_data_field_data_field_nefo_taxonomy_document_t);
        $nid = $variables['row']->nid;
        $node_type = $variables['row']->node_type;
        $image = _ofen_get_product_frontpage_image($node_type, $tid);
        $variables['output'] = l($image, "node/$nid", array('html' => TRUE));
      }
    }
    // Link
    if ($variables['field']->options['id'] == 'type') {
      $tid = intval($variables['row']->taxonomy_term_data_field_data_field_nefo_taxonomy_document_t);
      $node_type = $variables['row']->node_type;
      $variables['output'] = _ofen_get_product_display_link($node_type, $tid);
    }
  }

}


function _ofen_get_product_document_icon($node_type, $tid) {
  $path = drupal_get_path('theme', 'ofen');
  $type = _ofen_get_nefo_product_type($node_type, $tid);
  switch ($type) {
		case 'nefo_product_article':
			$icon = '<img class="nefo-product-icon" alt="Artikel" title="Artikel" src="/'. $path .'/images/icons/products/Artikel.png">';
			break;
		case 'nefo_product_report':
			$icon = '<img class="nefo-product-icon" alt="Bericht" title="Bericht" src="/'. $path .'/images/icons/products/Bericht.png">';
			break;
		case 'nefo_product_factsheet':
			$icon = '<img class="nefo-product-icon" alt="Faktenblatt" title="Faktenblatt" src="/'. $path .'/images/icons/products/Faktenblatt.png">';
			break;
		case 'nefo_product_interview':
			$icon = '<img class="nefo-product-icon" alt="Interview" title="Interview" src="/'. $path .'/images/icons/products/Interview.png">';
			break;
		case 'nefo_product_opinion':
			$icon = '<img class="nefo-product-icon" alt="Stellungnahme" title="Stellungnahme" src="/'. $path .'/images/icons/products/Stellungnahme.png">';
			break;
		case 'nefo_product_study':
			$icon = '<img class="nefo-product-icon" alt="Studie" title="Studie" src="/'. $path .'/images/icons/products/Bericht.png">';
			break;
		case 'nefo_product_workshop':
			$icon = '<img class="nefo-product-icon" alt="Workshop" title="Workshop" src="/'. $path .'/images/icons/products/Bericht.png">';
			break;
        case 'nefo_news':
			$icon = '<img class="nefo-product-icon" alt="News" title="Workshop" src="/'. $path .'/images/icons/products/Pressemitteilung.png">';
			break;
		case 'nefo_event':
			$icon = '<img class="nefo-product-icon" alt="Event" title="Workshop" src="/'. $path .'/images/icons/products/Artikel.png">';
			break;
		default:
			$icon = '';
  }

  return $icon;
}


function _ofen_get_product_frontpage_image($node_type, $tid) {
  $path = drupal_get_path('theme', 'ofen');
  $type = _ofen_get_nefo_product_type($node_type, $tid);
  switch ($type) {
		case 'nefo_product_report':
			$image = '<img class="nefo-product-icon" alt="Bericht" title="Bericht" src="/'. $path .'/images/icons/current-products/Bericht.png">';
			break;
		case 'nefo_product_factsheet':
			$image = '<img class="nefo-product-icon" alt="Faktenblatt" title="Faktenblatt" src="/'. $path .'/images/icons/current-products/Faktenblatt.png">';
			break;
		case 'nefo_product_opinion':
			$image = '<img class="nefo-product-icon" alt="Stellungnahme" title="Stellungnahme" src="/'. $path .'/images/icons/current-products/Stellungnahme.png">';
			break;
		case 'nefo_product_study':
			$image = '<img class="nefo-product-icon" alt="Studie" title="Studie" src="/'. $path .'/images/icons/current-products/Studie.png">';
			break;
		default:
			$image = '';
  }

  return $image;
}


function _ofen_get_product_display_link($node_type, $tid) {
  $products = array(
      'nefo_product_report'     => array('alle Berichte', '/produkte/berichte'),
      'nefo_product_factsheet'  => array('alle Faktenblätter', '/produkte/faktenblaetter'),
      'nefo_product_opinion'    => array('alle Stellungnahmen', '/produkte/stellungnahmen'),
      'nefo_product_study'      => array('alle Studien', '/produkte/studien'),
      'nefo_product_article'      => array('alle Artikel', '/schnittstellen/produkte/artikel'),
  );

  $type = _ofen_get_nefo_product_type($node_type, $tid);
  $display_link = (!empty($products[$type])) ? l($products[$type][0], $products[$type][1]) : '';

  return $display_link;
}


function _ofen_get_nefo_product_type($node_type, $tid) {
  $type = '';
  // Taxonomy: NeFo-Dokument
  switch ($tid) {
      case 79:
        $type = 'nefo_product_report';
        break;
      case 76:
        $type = 'nefo_product_factsheet';
        break;
      case 77:
        $type = 'nefo_product_opinion';
        break;
      case 78:
        $type = 'nefo_product_study';
        break;
      default:
        $type = $node_type;
  }

  return $type;
}


