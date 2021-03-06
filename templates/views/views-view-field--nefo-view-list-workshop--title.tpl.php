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
	$link = count($row->field_field_nefo_workshop_url);
	$workshop_type = ($link) ? '' : '<img alt="" title="application/pdf" src="/'. $path .'/images/icons/application-pdf.png" height="16px" />';
	$output = $workshop_type .' '. $output;
}

print $output;

?>


