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
