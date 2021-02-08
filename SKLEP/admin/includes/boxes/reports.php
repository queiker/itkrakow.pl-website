<?php
/*
  $Id: reports.php,v 1.4 2002/03/16 00:20:11 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- reports //-->
          <tr>
            <td>
<?php
  $heading = array();
  $contents = array();

  $heading[] = array('text'  => BOX_HEADING_REPORTS,
                     'link'  => tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('selected_box')) . 'selected_box=reports'));

  if ($selected_box == 'reports' || $menu_dhtml == true) {
    $contents[] = array('text'  => tep_admin_files_boxes(FILENAME_STATS_PRODUCTS_VIEWED, BOX_REPORTS_PRODUCTS_VIEWED) .
                                   tep_admin_files_boxes(FILENAME_STATS_PRODUCTS_PURCHASED, BOX_REPORTS_PRODUCTS_PURCHASED) .
                                   tep_admin_files_boxes(FILENAME_STATS_CUSTOMERS, BOX_REPORTS_ORDERS_TOTAL) .
                                   tep_admin_files_boxes(FILENAME_CUSTOMER_STATS, BOX_REPORTS_CUSTOMER_STATS) .
                                   tep_admin_files_boxes(FILENAME_STATS_ORDERS_TRACKING_ZONES, BOX_REPORTS_ORDERS_TRACKING_ZONES) .
                                   tep_admin_files_boxes(FILENAME_STATS_ORDERS_TRACKING, BOX_REPORTS_ORDERS_TRACKING) .
                                   tep_admin_files_boxes(FILENAME_STATS_LOW_STOCK, BOX_REPORTS_STOCK_LEVEL).
                                   tep_admin_files_boxes(FILENAME_STATS_WISHLISTS, BOX_REPORTS_WISHLISTS));
  }

  $box = new box;
  echo $box->menuBox($heading, $contents);
?>
            </td>
          </tr>
<!-- reports_eof //-->