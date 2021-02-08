<?php
/*
  $Id: customers.php,v 1.15 2002/03/16 00:20:11 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- customers //-->
          <tr>
            <td>
<?php
  $heading = array();
  $contents = array();

  $heading[] = array('text'  => BOX_HEADING_CUSTOMERS,
                     'link'  => tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('selected_box')) . 'selected_box=customers'));

  if ($selected_box == 'customers' || $menu_dhtml == true) {
    $contents[] = array('text'  => tep_admin_files_boxes(FILENAME_CUSTOMERS, BOX_CUSTOMERS_CUSTOMERS) .
                                   tep_admin_files_boxes(FILENAME_CUSTOMERS_ADVANCED, BOX_CUSTOMERS_ADVANCED) .
                                   tep_admin_files_boxes('create_account.php', 'Klienci - utwórz konto') .
                                   tep_admin_files_boxes(FILENAME_ORDERS, BOX_CUSTOMERS_ORDERS) .
                                   tep_admin_files_boxes('create_order.php', 'Zamówienia - utwórz zamówienie') .
                                   tep_admin_files_boxes('customers_groups.php', BOX_CUSTOMERS_GROUPS) .
                                   tep_admin_files_boxes('manudiscount.php', BOX_MANUDISCOUNT));
  }

  $box = new box;
  echo $box->menuBox($heading, $contents);
?>
            </td>
          </tr>
<!-- customers_eof //-->