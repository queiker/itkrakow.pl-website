<?php
/*
  $Id: new_products.php,v 1.35+ 2002/04/26 20:28:07 dgw_ Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2005 osCommerce

  Released under the GNU General Public License
*/
require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_NEW_PRODUCTS);
?>
<!-- new_products //-->
<?php
  $info_box_contents = array();
  $info_box_contents[] = array('text' => sprintf(TABLE_HEADING_NEW_PRODUCTS, strftime('%B')));

//TotalB2B start
  if ( (!isset($new_products_category_id)) || ($new_products_category_id == '0') ) {
    $listing_sql = "select p.products_id, p.products_image, p.products_tax_class_id, p.products_price, p.manufacturers_id, p.products_quantity from " . TABLE_PRODUCTS . " p where products_status = '1' order by p.products_date_added desc";
  } else {
    $listing_sql = "select distinct p.products_id, p.products_image, p.products_tax_class_id, p.products_price as products_price, p.manufacturers_id, p.products_quantity from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and c.parent_id = '" . (int)$new_products_category_id . "' and p.products_status = '1' order by p.products_date_added desc";
  }
//TotalB2B end

	$info_box_contents = array();	
	$info_box_contents[] = array('text' => sprintf(TABLE_HEADING_NEW_PRODUCTS, strftime('%B')));

//	new infoBoxHeading($info_box_contents, true, true, tep_href_link(FILENAME_PRODUCTS_NEW));
    include(DIR_WS_MODULES . FILENAME_PRODUCT_LISTING_NOWOSCI);

?>
<!-- new_products_eof //-->