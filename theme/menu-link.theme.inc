<?php
/**
* Returns HTML for a menu link and submenu.
*
* @param $variables
*   An associative array containing:
*   - element: Structured array data for a menu link.
*
* @ingroup themeable
*/
function ofen_menu_link(array $variables) {
    $element = $variables['element'];
    $sub_menu = '';

    if ($element['#below']) {
        $sub_menu = drupal_render($element['#below']);
    }
    $description = '';
    // if it is the main menu we want to print the link description as well
    if (strcmp($element['#theme'], 'menu_link__main_menu') == 0) {
        $element['#localized_options']['html'] = TRUE;
        $description = "<br><span class='main-menu--description'>". $element['#localized_options']['attributes']['title']."</span>";
    }
    $output = l($element['#title'] . $description, $element['#href'], $element['#localized_options']);

    return '<li' . drupal_attributes($element['#attributes']) . '>' . $output .  $sub_menu . "</li>\n";
}
