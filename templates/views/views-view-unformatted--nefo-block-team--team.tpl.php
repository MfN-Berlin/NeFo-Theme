<?php

/**
 * @file
 * Template to display a list of rows.
 */

if (!empty($title)) {
  print '<div class="nefo-block-team-col">';
  //print '<h3>' . $title .'</h3>';
  foreach ($rows as $delta => $row) {
    print '<div'. $row_attributes[$delta] .'>';
    print $row;
    print '</div>';
  }
  print '</div>';
}

?>
