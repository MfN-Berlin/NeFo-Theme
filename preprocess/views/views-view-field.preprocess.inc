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
   * View: NeFo-Block Aktuelle Produkte
   */
  if ($view->name == 'nefo_current_products') {
    // Field:Wrapper 2
    if ($variables['field']->options['id'] == 'nothing_1') {
      $tid = intval($variables['row']->taxonomy_term_data_field_data_field_nefo_taxonomy_document_t);
      $node_type = $variables['row']->node_field_data_field_nefo_slide_product_refer_type;
      $variables['output'] = _ofen_get_product_display_name($node_type, $tid);
    }
    // Field:Wrapper 3
    if ($variables['field']->options['id'] == 'nothing_2') {
      $tid = intval($variables['row']->taxonomy_term_data_field_data_field_nefo_taxonomy_document_t);
      $node_type = $variables['row']->node_field_data_field_nefo_slide_product_refer_type;
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


function _ofen_get_product_display_name($node_type, $tid) {
  $products = array(
      'nefo_product_report'     => 'Berichte',
      'nefo_product_factsheet'  => 'Faktenblätter',
      'nefo_product_opinion'    => 'Stellungnahmen',
      'nefo_product_workshop'   => 'Workshops',
      'nefo_product_study'      => 'Studien',
      'blog'                    => 'Blogs',
  );

  $type = _ofen_get_nefo_product_type($node_type, $tid);
  $display_name = (!empty($products[$type])) ? $products[$type] : '';

  return $display_name;
}


function _ofen_get_product_display_link($node_type, $tid) {
  $products = array(
      'nefo_product_report'     => array('alle Berichte', '/produkte/berichte'),
      'nefo_product_factsheet'  => array('alle Faktenblätter', '/produkte/faktenblaetter'),
      'nefo_product_opinion'    => array('alle Stellungnahmen', '/produkte/stellungnahmen'),
      'nefo_product_study'      => array('alle Studien', '/produkte/studien'),
      'nefo_product_workshop'   => array('alle Workshops', '/schnittstellen/produkte/workshops'),
      'blog'                    => array('alle Blogs', '/blogs'),
  );

  $type = _ofen_get_nefo_product_type($node_type, $tid);
  $display_link = (!empty($products[$type])) ? '<span class="nefo-view-block-current-products-link-all">'.
                                            l($products[$type][0], $products[$type][1]) .'</span>'
                                       : '';

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


