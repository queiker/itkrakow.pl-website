<?php
/*
  $Id: column_left.php,v 1.15 2002/01/11 05:03:25 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License

  ===========================================================
  PLEASE MAKE GROUPS PERMISSION by YOURSELF
  Don't ask me about this!
  
  5 = Top Administrator or Owner
  4 = ...
  3 = ...
  2 = ...
  1 = ...
  0 = accessable for every groups
  
  Enjoy :)
  zaenal
  ===========================================================

*/

 /* if (tep_admin_check_boxes('administrator.php') == true) {
    include(DIR_WS_BOXES . 'administrator.php');
  } */ 
  if (tep_admin_check_boxes('configuration.php') == true) {
    include(DIR_WS_BOXES . 'configuration.php');
  } 
  if (tep_admin_check_boxes('catalog.php') == true) {
    include(DIR_WS_BOXES . 'catalog.php');
  } 
  if (tep_admin_check_boxes('modules.php') == true) {
    include(DIR_WS_BOXES . 'modules.php');
  } 
  if (tep_admin_check_boxes('customers.php') == true) {
    include(DIR_WS_BOXES . 'customers.php');
  } 
  if (tep_admin_check_boxes('taxes.php') == true) {
    include(DIR_WS_BOXES . 'taxes.php');
  } 
  if (tep_admin_check_boxes('localization.php') == true) {
    include(DIR_WS_BOXES . 'localization.php');
  } 
  if (tep_admin_check_boxes('reports.php') == true) {
    include(DIR_WS_BOXES . 'reports.php');
  } 
  if (tep_admin_check_boxes('tools.php') == true) {
    include(DIR_WS_BOXES . 'tools.php');
  }
  if (tep_admin_check_boxes('information.php') == true) {
    include(DIR_WS_BOXES . 'information.php');
  }

?>