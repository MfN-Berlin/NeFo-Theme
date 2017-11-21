<?php

/**
 * @file
 * Template overrides as well as (pre-)process and alter hooks for the
 * ofen theme.
 */
function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}

/**
 * hook_form_FORM_ID_alter
 */
function ofen_form_search_block_form_alter(&$form, &$form_state, $form_id) {
//    $form['search_block_form']['#title'] = t('Search'); // Change the text on the label element
//    $form['search_block_form']['#title_display'] = 'invisible'; // Toggle label visibilty
//    $form['search_block_form']['#size'] = 40;  // define size of the textfield
//    $form['search_block_form']['#default_value'] = t('Search'); // Set a default value for the textfield
//    $form['actions']['submit']['#value'] = t('GO!'); // Change the text on the submit button
//    $form['actions']['submit'] = array('#type' => 'image_button', '#src' => base_path() . path_to_theme() . '/images/search-button-16x16.png');
//
//    // Add extra attributes to the text box
//    $form['search_block_form']['#attributes']['onblur'] = "if (this.value == '') {this.value = 'Search';}";
//    $form['search_block_form']['#attributes']['onfocus'] = "if (this.value == 'Search') {this.value = '';}";
//    // Prevent user from searching the default text
//    $form['#attributes']['onsubmit'] = "if(this.search_block_form.value=='Search'){ alert('Please enter a search'); return false; }";
//
//    // Alternative (HTML5) placeholder attribute instead of using the javascript
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

//function ofen_views_exposed_form($form) {
//    $form['submit']['#value'] = t('Search');
//    $output = drupal_render($form);
//    return $output;
//}

/**
 * Theme function to allow any menu tree to be themed as a Superfish menu.
 */
function ofen_superfish($variables) {
    global $user, $language;

    $id = $variables['id'];
    $menu_name = $variables['menu_name'];
    $mlid = $variables['mlid'];
    $sfsettings = $variables['sfsettings'];

    $menu = menu_tree_all_data($menu_name);

    if (function_exists('i18n_menu_localize_tree')) {
        $menu = i18n_menu_localize_tree($menu);
    }

    // For custom $menus and menus built all the way from the top-level we
    // don't need to "create" the specific sub-menu and we need to get the title
    // from the $menu_name since there is no "parent item" array.
    // Create the specific menu if we have a mlid.
    if (!empty($mlid)) {
        // Load the parent menu item.
        $item = menu_link_load($mlid);
        $title = check_plain($item['title']);
        $parent_depth = $item['depth'];
        // Narrow down the full menu to the specific sub-tree we need.
        for ($p = 1; $p < 10; $p++) {
            if ($sub_mlid = $item["p$p"]) {
                $subitem = menu_link_load($sub_mlid);
                $key = (50000 + $subitem['weight']) . ' ' . $subitem['title'] . ' ' . $subitem['mlid'];
                $menu = (isset($menu[$key]['below'])) ? $menu[$key]['below'] : $menu;
            }
        }
    }
    else {
        $result = db_query("SELECT title FROM {menu_custom} WHERE menu_name = :a", array(':a' => $menu_name))->fetchField();
        $title = check_plain($result);
    }

    $output['content'] = '';
    $output['subject'] = '<i class="fa fa-bars"></i> ' . $title;
    if ($menu) {
        // Set the total menu depth counting from this parent if we need it.
        $depth = $sfsettings['depth'];
        $depth = ($sfsettings['depth'] > 0 && isset($parent_depth)) ? $parent_depth + $depth : $depth;

        $var = array(
          'id' => $id,
          'menu' => $menu,
          'depth' => $depth,
          'trail' => superfish_build_page_trail(menu_tree_page_data($menu_name)),
          'clone_parent' => FALSE,
          'sfsettings' => $sfsettings,
        );
        if ($menu_tree = theme('superfish_build', $var)) {
            if ($menu_tree['content']) {
                // Add custom HTML codes around the main menu.
                if ($sfsettings['wrapmul'] && strpos($sfsettings['wrapmul'], ',') !== FALSE) {
                    $wmul = explode(',', $sfsettings['wrapmul']);
                    // In case you just wanted to add something after the element.
                    if (drupal_substr($sfsettings['wrapmul'], 0) == ',') {
                        array_unshift($wmul, '');
                    }
                }
                else {
                    $wmul = array();
                }
                $output['content'] = isset($wmul[0]) ? $wmul[0] : '';
                $output['content'] .= '<ul id="superfish-' . $id . '"';
                $output['content'] .= ' class="menu sf-menu sf-' . $menu_name . ' sf-' . $sfsettings['type'] . ' sf-style-' . $sfsettings['style'];
                $output['content'] .= ($sfsettings['itemcounter']) ? ' sf-total-items-' . $menu_tree['total_children'] : '';
                $output['content'] .= ($sfsettings['itemcounter']) ? ' sf-parent-items-' . $menu_tree['parent_children'] : '';
                $output['content'] .= ($sfsettings['itemcounter']) ? ' sf-single-items-' . $menu_tree['single_children'] : '';
                $output['content'] .= ($sfsettings['ulclass']) ? ' ' . $sfsettings['ulclass'] : '';
                $output['content'] .= ($language->direction == 1) ? ' rtl' : '';
                $output['content'] .= '">' . $menu_tree['content'] . '</ul>';
                $output['content'] .= isset($wmul[1]) ? $wmul[1] : '';
            }
        }
    }
    return $output;
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


function ofen_preprocess_search_result(&$vars) {
    $date = $vars['result']['date'];
    $vars['info_split']['date'] = format_date($date, 'custom', 'j. F Y');
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




