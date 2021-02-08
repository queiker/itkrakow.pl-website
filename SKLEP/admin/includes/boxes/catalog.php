<?php
/*
  $Id: catalog.php,v 1.20 2002/03/16 00:20:11 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- catalog //-->
          <tr>
            <td>
<?php
  $heading = array();
  $contents = array();

  $heading[] = array('text'  => BOX_HEADING_CATALOG,
                     'link'  => tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('selected_box')) . 'selected_box=catalog'));

  if ($selected_box == 'catalog' || $menu_dhtml == true) {
    $contents[] = array('text'  => tep_admin_files_boxes(FILENAME_CATEGORIES, BOX_CATALOG_CATEGORIES_PRODUCTS) .
								   tep_admin_files_boxes(FILENAME_PRODUCTS_EXTRA_FIELDS, BOX_CATALOG_PRODUCTS_EXTRA_FIELDS) . // Product Extra Fields
								   tep_admin_files_boxes(FILENAME_PRODUCT_UPDATES, BOX_CATALOG_PRODUCTS_UPDATE) .
								   tep_admin_files_boxes(FILENAME_QUICK_UPDATES, BOX_CATALOG_QUICK_UPDATES) .
								   tep_admin_files_boxes(FILENAME_XSELL_PRODUCTS, BOX_CATALOG_XSELL_PRODUCTS) .
                                   tep_admin_files_boxes(FILENAME_SPECIALS, BOX_CATALOG_SPECIALS) .
                                   tep_admin_files_boxes(FILENAME_SPECIALSBYCAT,BOX_CATALOG_SPECIALSBYCAT) .
								   tep_admin_files_boxes(FILENAME_FEATURED, BOX_CATALOG_FEATURED) .                           
								   tep_admin_files_boxes(FILENAME_PRODUCTS_EXPECTED, BOX_CATALOG_PRODUCTS_EXPECTED) .
								   tep_admin_files_boxes(FILENAME_EASYPOPULATE, BOX_CATALOG_EASYPOPULATE) .
								   tep_admin_files_boxes(FILENAME_PRODUCTS_ATTRIBUTES, BOX_CATALOG_CATEGORIES_PRODUCTS_ATTRIBUTES) .
                                   tep_admin_files_boxes(FILENAME_MANUFACTURERS, BOX_CATALOG_MANUFACTURERS) .
                                   tep_admin_files_boxes(FILENAME_REVIEWS, BOX_CATALOG_REVIEWS));
  }

  $box = new box;
  echo $box->menuBox($heading, $contents);
?>
            </td>
          </tr>
<!-- catalog_eof //-->
