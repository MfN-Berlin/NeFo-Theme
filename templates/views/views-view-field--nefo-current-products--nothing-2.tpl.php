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
  $products = array(
      'nefo_product_report'  => array('alle Berichte', '/schnittstellen/produkte/berichte'),
      'nefo_product_factsheet'  => array('alle Faktenblätter', '/schnittstellen/produkte/faktenblaetter'),
      'nefo_product_opinion'  => array('alle Stellungnahmen', '/schnittstellen/produkte/stellungnahmen'),
      'nefo_product_workshop'  => array('alle Workshops', '/schnittstellen/produkte/workshops'),
      'nefo_product_study'  => array('alle Studien', '/schnittstellen/produkte/studien'),
      'blog'  => array('alle Blogs', '/blogs'),
  );

  $type = $row->node_field_data_field_nefo_slide_product_refer_type;
  $output = (!empty($products[$type])) ? '<span class="nefo-view-block-current-products-link-all">'.
                                            l($products[$type][0], $products[$type][1]) .'</span>'
                                       : '';
}

print $output;


?>
