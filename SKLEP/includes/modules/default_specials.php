<?php
/*
  $Id: default_specials.php,v 2.0 2003/06/13

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_NEW_PRODUCTS);
?>
<!-- default_specials //-->

<?php
  $info_box_contents = array();
  $info_box_contents[] = array('align' => 'left', 'text' => sprintf(TABLE_HEADING_DEFAULT_SPECIALS, strftime('%B')));


   if ( (!isset($new_products_category_id)) || ($new_products_category_id == '0') ) {
     $listing_sql = "select p.products_id, pd.products_name, p.products_price, p.products_tax_class_id, p.products_image, p.manufacturers_id, s.specials_new_products_price, p.products_quantity from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s where p.products_status = '1' and s.products_id = p.products_id and p.products_id = pd.products_id and pd.language_id = '" . $languages_id . "' and s.status = '1' order by s.specials_date_added DESC ";
   } else {
	 $listing_sql = "select distinct p.products_id, p.products_image, p.products_tax_class_id, p.products_price, p.manufacturers_id, s.specials_new_products_price, p.products_quantity from " . TABLE_PRODUCTS . " p, " . TABLE_SPECIALS . " s, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and c.parent_id = '" . (int)$new_products_category_id . "' and p.products_status = '1' and s.status = '1' and s.products_id = p.products_id order by s.specials_date_added DESC ";
   }

//	new infoBoxHeading($info_box_contents, true, true, tep_href_link(FILENAME_SPECIALS));   $info_box_contents = array();
    include(DIR_WS_MODULES . FILENAME_PRODUCT_LISTING_NOWOSCI);
?>
<!-- default_specials_eof //-->