<?php
/**
 * Utility functions
 */
function is_element_empty($element) {
  $element = trim($element);
  return !empty($element);
}

// Tell WordPress to use searchform.php from the templates/ directory
function roots_get_search_form($form) {
  $form = '';
  locate_template('/searchform.php', true, false);
  return $form;
}
add_filter('get_search_form', 'roots_get_search_form');

// Device detection
function device_detect($device) {
  $detect = new Mobile_Detect;
  $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
  return ($device == $deviceType) ? true : false;
}