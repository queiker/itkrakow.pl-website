<?php
/*
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
  
  Featured Products V1.1
  Displays a list of featured products, selected from admin
  For use as an Infobox instead of the "New Products" Infobox  
*/
?>
<!-- featured_products //-->
<?php
 if(FEATURED_PRODUCTS_DISPLAY == 'true')
 {
  $featured_products_category_id = $new_products_category_id;
  $cat_name_query = tep_db_query("select categories_name from categories_description where categories_id = '" . $featured_products_category_id . "' limit 1");
  $cat_name_fetch = tep_db_fetch_array($cat_name_query);
  $cat_name = $cat_name_fetch['categories_name'];
  $info_box_contents = array();

  if ( (!isset($featured_products_category_id)) || ($featured_products_category_id == '0') ) {
    $info_box_contents[] = array('align' => 'left', 'text' => TABLE_HEADING_FEATURED_PRODUCTS);

  list($usec, $sec) = explode(' ', microtime());
  srand( (float) $sec + ((float) $usec * 100000) );
  $mtm= rand();

   $listing_sql = "select p.products_id, p.products_image, p.products_tax_class_id, p.products_price, p.manufacturers_id, p.products_quantity from " . TABLE_PRODUCTS . " p left join " . TABLE_FEATURED . " f on p.products_id = f.products_id where p.products_status = '1' and f.status = '1' order by rand($mtm) DESC ";
  } else {
    $info_box_contents[] = array('align' => 'left', 'text' => TABLE_HEADING_FEATURED_PRODUCTS);
    $listing_sql = "select distinct p.products_id, p.products_image, p.products_tax_class_id, p.products_price, p.manufacturers_id, p.products_quantity from " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c, " . TABLE_PRODUCTS . " p left join " . TABLE_FEATURED . " f on p.products_id = f.products_id where p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and c.parent_id = '" . $featured_products_category_id . "' and p.products_status = '1' and f.status = '1' order by rand() DESC ";
  }

    include(DIR_WS_MODULES . FILENAME_PRODUCT_LISTING_NOWOSCI);
  
 }
?>
<!-- featured_products_eof //-->
