<?php
/*
  $Id: taxes.php,v 1.16 2002/03/16 00:20:11 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- taxes //-->
          <tr>
            <td>
<?php
  $heading = array();
  $contents = array();

  $heading[] = array('text'  => BOX_HEADING_LOCATION_AND_TAXES,
                     'link'  => tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('selected_box')) . 'selected_box=taxes'));

  if ($selected_box == 'taxes' || $menu_dhtml == true) {
    $contents[] = array('text'  => tep_admin_files_boxes(FILENAME_COUNTRIES, BOX_TAXES_COUNTRIES) .
                                   tep_admin_files_boxes(FILENAME_ZONES, BOX_TAXES_ZONES) .
                                   tep_admin_files_boxes(FILENAME_GEO_ZONES, BOX_TAXES_GEO_ZONES) .
                                   tep_admin_files_boxes(FILENAME_TAX_CLASSES, BOX_TAXES_TAX_CLASSES) .
                                   tep_admin_files_boxes(FILENAME_TAX_RATES, BOX_TAXES_TAX_RATES));
  }

  $box = new box;
  echo $box->menuBox($heading, $contents);
?>
            </td>
          </tr>
<!-- taxes_eof //-->
