<?php
/*
  $Id: performance.php,v 1.6 2004/12/08 21:08:00 admin Exp $
  orig : performance.php,v 1.5 2004/11/21 00:04:53 Chemo Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  if (DISPLAY_PAGE_PARSE_TIME == 'true') {
    $time_start = explode(' ', PAGE_PARSE_START_TIME);
    $time_end = explode(' ', microtime());
    $parse_time = number_format(($time_end[1] + $time_end[0] - ($time_start[1] + $time_start[0])), 3);
    if (DISPLAY_QUERIES_BRIEF == 'true') {
		echo '<div align="center"><span style="font-family: Verdana, Arial, sans-serif; font-size: 10px;">Parse Time: <b>' . $parse_time . ' s</b> | SQL: <b>'.number_format($debug['QUERY_TIME'],4).' s</b> | <b>' . sizeof($debug['QUERIES']) . ' queries</b></span></div>';
	}
    if (DISPLAY_QUERIES == 'true') {
      echo '<b>QUERY DEBUG:</b> ';
      print_array($debug);
      echo '<hr>';
      echo '<b>SESSION:</b> ';
      print_array($_SESSION);
      echo '<hr>';
      echo '<b>COOKIE:</b> ';
      print_array($_COOKIE);
      echo '<b>POST:</b> ';
      print_array($_POST);
      echo '<hr>';
      echo '<b>GET:</b> ';
      print_array($_GET);
    } # END if request
  }
  unset($debug);
?>