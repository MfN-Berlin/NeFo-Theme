<?php

/**
 * Theme a menu item link.
 *
 * @param array $variables
 *   An array of variables containing:
 *    - menu_item: The menu item array.
 *    - link_options: An array of link options.
 *
 * @ingroup themeable
 */
function ofen_superfish_menu_item_link(array $variables) {
    $menu_item = $variables['menu_item'];
    $link_options = $variables['link_options'];
    $link_options['html'] = TRUE;
    $description = '';
    if (array_key_exists('title', $link_options['attributes']) ) {
        //$description = '<br><span class="main-menu--description">'. $link_options['attributes']['title'] . '</span>';
    }

    return l($menu_item['link']['title'] . $description, $menu_item['link']['href'], $link_options);
}