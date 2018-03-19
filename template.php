<?php

/**
 * @file
 * Template overrides as well as (pre-)process and alter hooks for the
 * ofen theme.
 */

/**
 * Search backwards starting from haystack length characters from the end
 */
function ofen_starts_with($haystack, $needle) {
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}

/**
 * hook_form_FORM_ID_alter
 */
function ofen_form_search_block_form_alter(&$form, &$form_state, $form_id) {
  // Alternative (HTML5) placeholder attribute instead of using the javascript
  $form['search_block_form']['#attributes']['placeholder'] = t('Search');
}

/**
 * Returns HTML for a form.
 *
 * @param $variables
 *   An associative array containing:
 *   - element: An associative array containing the properties of the element.
 *     Properties used: #action, #method, #attributes, #children
 *
 * @ingroup themeable
 */
function ofen_form($variables) {
    $element = $variables['element'];
    if (isset($element['#action'])) {
        $element['#attributes']['action'] = drupal_strip_dangerous_protocols($element['#action']);
    }
    element_set_attributes($element, array('method', 'id'));
    if (empty($element['#attributes']['accept-charset'])) {
        $element['#attributes']['accept-charset'] = "UTF-8";
    }
    // CHANGED: Anonymous DIV to satisfy XHTML compliance.
    //    return '<form' . drupal_attributes($element['#attributes']) . '><div>' . $element['#children'] . '</div></form>';
    return '<form' . drupal_attributes($element['#attributes']) . '>' . $element['#children'] . '</form>';
}

/**
 * Returns HTML for a list or nested list of items.
 *
 * CHANGE:
 *   If it is a pager__item whitespaces between li elements are removed
 * @ingroup themeable
 */
function ofen_item_list($variables) {
    $items = $variables['items'];
    $title = $variables['title'];
    $type = $variables['type'];
    $attributes = $variables['attributes'];

    // Only output the list container and title, if there are any list items.
    // Check to see whether the block title exists before adding a header.
    // Empty headers are not semantic and present accessibility challenges.
    $output = '';
    if (isset($title) && $title !== '') {
        $output .= '<h3>' . $title . '</h3>';
    }

    if (!empty($items)) {
        $output .= "<$type" . drupal_attributes($attributes) . '>';
        $i = 0;
        foreach ($items as $item) {
            $attributes = array();
            $children = array();
            $data = '';
            $i++;
            if (is_array($item)) {
                foreach ($item as $key => $value) {
                    if ($key == 'data') {
                        $data = $value;
                    }
                    elseif ($key == 'children') {
                        $children = $value;
                    }
                    else {
                        $attributes[$key] = $value;
                    }
                }
            }
            else {
                $data = $item;
            }
            if (count($children) > 0) {
                // Render nested list.
                $data .= theme_item_list(array(
                  'items' => $children,
                  'title' => NULL,
                  'type' => $type,
                  'attributes' => $attributes,
                ));
            }
            if (in_array('pager__item', $attributes['class'])) {
                $output .= '<li' . drupal_attributes($attributes) . '>' . $data . "</li>";
            } else {
                $output .= '<li' . drupal_attributes($attributes) . '>' . $data . "</li>\n";
            }
        }
        $output .= "</$type>";
    }
    return $output;
}

/**
 * Format date on search result page: 10. Januar 2018
 */
function ofen_preprocess_search_result(&$variables) {
    $date = $variables['result']['date'];
    $variables['info_split']['date'] = format_date($date, 'custom', 'j. F Y');
}


/**
 * Open PDF file in new window
 * See: https://www.drupal.org/node/301234
 */
function ofen_file_link($variables) {
  $file = $variables['file'];
  $icon_directory = drupal_get_path('theme', 'ofen') . '/images/icons';
  $url = file_create_url($file->uri);
  $file_size = format_size($file->filesize);
  $icon = theme('file_icon', array('file' => $file, 'icon_directory' => $icon_directory));

  // Set options as per anchor format described at
  // http://microformats.org/wiki/file-format-examples
  $options = array(
    'attributes' => array(
      'type' => $file->filemime . '; length=' . $file->filesize,
    ),
  );

  // Use the description as the link text if available.
  if (empty($file->description)) {
    $link_text = $file->filename;
  }
  else {
    $link_text = $file->description;
    $options['attributes']['title'] = check_plain($file->filename);
  }

  // Open files of particular mime types in new window
  $new_window_mimetypes = array('application/pdf','text/plain');
  if (in_array($file->filemime, $new_window_mimetypes)) {
    $options['attributes']['target'] = '_blank';
  }

  // File size
  $link_text .= '<br />'. $file_size;
  $options['html'] = TRUE;

  return '<div class="file">'.
				'<div class="file-icon">' . $icon . '</div>'.
				'<div class="file-link">' . l($link_text, $url, $options) .'</div>'.
        '</div>';
}

/**
 * Implements hook_owlcarousel_settings_alter().
 */
function ofen_owlcarousel_settings_alter(&$settings, $instance) {
  switch ($instance) {
    case 'owl-carousel-block':
      break;
    default:
      $settings['navigationText'] = array('<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>');
  }
}