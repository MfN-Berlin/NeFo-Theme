<?php
function ofen_process_block(&$variables) {
    if (strrpos($variables['attributes'], 'nefo-footer-menu')) {
        $variables['classes_array'][] = "block--footer";
    }
}