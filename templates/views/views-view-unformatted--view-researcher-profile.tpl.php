<?php

/**
 * @file
 * Template to display a list of rows.
 */
?>
<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<?php foreach ($rows as $delta => $row): ?>
  <?php if ($delta % 2 == 0): ?>
    <div class="row">
  <?php endif; ?>
  <div class="cell <?php print $classes_array[$delta]; ?>">
    <?php print $row; ?>
  </div>
  <?php if ($delta % 2 == 1): ?>
    </div>
  <?php endif; ?>
<?php endforeach; ?>
<?php //If the total number of researchers is odd the div.row is not closed in the foreach loop ?>
<?php if (count($rows) % 2 == 1): ?>
 </div>
<?php endif; ?>