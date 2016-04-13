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

function ofen_theme_registry_alter(&$theme_registry) {
//    dpm("theme registry");
//    $theme_registry['views_view__view_researcher_profile']['preprocess functions'][] = 'ofen_preprocess_addjs';
//    krumo($theme_registry);
}

/**
 * @param $vars
 */
function ofen_preprocess_html(&$vars) {
  drupal_add_css("https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css",
    array('type' => 'external')
  );
}

function ofen_preprocess_addjs(&$vars) {
//    dpm("preprocess_addjs");
//    krumo($vars);
//    if ($view->name == 'view_researcher_profile') {
//        krumo(drupal_get_path('theme', 'ofen') . '/js/ofen_researcher.behaviors.js');
//        drupal_add_js(drupal_get_path('theme', 'ofen') . '/js/ofen_researcher.behavior.js', array(
//          'type' => 'file',
//          'group' => JS_THEME,
//        ));
//        $my_variables = array('var1' => 'test1', 'var2' => 'test2'); // and so on
//        drupal_add_js(array('ofenResearcher' => $my_variables), 'setting'); //
//    }
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

