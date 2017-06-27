<?php

/**
 * @file
 * This template is used to print a single field in a view.
 *
 * It is not actually used in default Views, as this is registered as a theme
 * function which has better performance. For single overrides, the template is
 * perfectly okay.
 *
 * Variables available:
 * - $view: The view object
 * - $field: The field handler object that can process the input
 * - $row: The raw SQL result that can be used
 * - $output: The processed output that will normally be used.
 *
 * When fetching output from the $row, this construct should be used:
 * $data = $row->{$field->field_alias}
 *
 * The above will guarantee that you'll always get the correct data,
 * regardless of any changes in the aliasing that might happen if
 * the view is modified.
 */

if (!empty($row)) {
	$path = drupal_get_path('theme', 'ofen');
	switch ($row->node_type) {
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
		case 'nefo_product_press_release':
			$icon = '<img class="nefo-product-icon" alt="Pressemitteilung" title="Pressemitteilung" src="/'. $path .'/images/icons/products/Pressemitteilung.png">';
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
	$output = $icon;
}

print $output;

?>


