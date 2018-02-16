<?php

/**
 * @file
 * Template to display a list of rows.
 */

if (!empty($title)) {
  print '<div class="nefo-block-team-col">';
  // View: NeFo-Block Team
  $pos = strpos($title, 'Helmholtz-Zentrum');
  if ($pos === false) {
    $block = block_load('nefo_blocks_builder', 'nefo_sponsor_mfn');
  }
  else {
    $block = block_load('nefo_blocks_builder', 'nefo_sponsor_ufz');
  }
  $block_content = _block_render_blocks(array($block));
  $block_build = _block_get_renderable_array($block_content);
  print drupal_render($block_build);

  foreach ($rows as $delta => $row) {
    print '<div'. $row_attributes[$delta] .'>';
    print $row;
    print '</div>';
  }
  print '</div>'; //nefo-block-team-col
}

?>
