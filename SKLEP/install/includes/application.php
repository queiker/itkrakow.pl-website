<?php
/*
  $Id: application.php,v 1.5 2003/07/09 01:11:05 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

// Set the level of error reporting
  error_reporting(E_ALL & ~E_NOTICE);

// Check if register_globals is enabled.
// Since this is a temporary measure this message is hardcoded. The requirement will be removed before 2.2 is finalized.
  if (function_exists('ini_get')) {
//    ini_get('register_globals') or exit('FATAL ERROR: register_globals is disabled in php.ini, please enable it!');
  }

  if (PHP_VERSION >= 4.1) {
    $HTTP_GET_VARS =& $_GET;
    $HTTP_POST_VARS =& $_POST;
    $HTTP_COOKIE_VARS =& $_COOKIE;
    $HTTP_SESSION_VARS =& $_SESSION;
    $HTTP_POST_FILES =& $_FILES;
    $HTTP_SERVER_VARS =& $_SERVER;
  } else {
    if (!is_array($HTTP_GET_VARS)) $HTTP_GET_VARS = array();
    if (!is_array($HTTP_POST_VARS)) $HTTP_POST_VARS = array();
    if (!is_array($HTTP_COOKIE_VARS)) $HTTP_COOKIE_VARS = array();
  }

// handle magic_quotes_gpc turned off.
  if (function_exists(get_magic_quotes_gpc())) {
    do_magic_quotes_gpc($HTTP_GET_VARS);
    do_magic_quotes_gpc($HTTP_POST_VARS);
    do_magic_quotes_gpc($HTTP_COOKIE_VARS);
  }

  require('includes/functions/general.php');
  require('includes/functions/database.php');
  require('includes/functions/html_output.php');

?>
