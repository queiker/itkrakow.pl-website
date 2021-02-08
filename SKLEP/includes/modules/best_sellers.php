<?php
/*
  Id: best_sellers.php,v 1.0 2002/11/22

  Written by Tony Alanis tmalanis@swbell.net

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- best_sellers //-->
<?php
  $info_box_contents = array();
  $info_box_contents[] = array('align' => 'left', 'text' => sprintf(TABLE_HEADING_BEST_SELLERS, strftime('%B')));
  new contentBoxHeading($info_box_contents);

  if ($cPath) {
    $best_sellers_query = tep_db_query("select distinct p.products_id, pd.products_name, p.products_image, p.products_price, p.products_ordered, p.products_quantity from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where p.products_status = '1' and p.products_ordered > 0 and p.products_id = pd.products_id and pd.language_id = '" . $languages_id . "' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and (c.categories_id = '" . $current_category_id . "' OR c.parent_id = '" . $current_category_id . "') order by p.products_ordered DESC, pd.products_name limit " . MAX_DISPLAY_BESTSELLERS);
  } else {
    $best_sellers_query = tep_db_query("select p.products_id, pd.products_name, p.products_image, p.products_price, p.products_ordered, p.products_quantity from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_ordered > 0 and p.products_id = pd.products_id and pd.language_id = '" . $languages_id . "' order by p.products_ordered DESC, pd.products_name limit " . MAX_DISPLAY_BESTSELLERS);
  }
  
  $info_box_contents = array();
  $row = 0;
  $col = 0;
  while ($best_sellers = tep_db_fetch_array($best_sellers_query)) {
    $best_sellers['products_name'] = tep_get_products_name($best_sellers['products_id']);
    $info_box_contents[$row][$col] = array('align' => 'center',
                                           'params' => 'class="main" width="33%" valign="top"',
                                           'text' => '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $best_sellers['products_id']) . '">' . tep_image_mini(DIR_WS_IMAGES . $best_sellers['products_image'], $best_sellers['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $best_sellers['products_id']) . '">' . $best_sellers['products_name'] . '</a><br><b>' . $currencies->display_price($best_sellers['products_price'], tep_get_tax_rate($best_sellers['products_tax_class_id'] . '</b>')));
    $col ++;
    if ($col > 2) {
      $col = 0;
      $row ++;
    }
  }
  new contentBox($info_box_contents);
?>
<!-- best_sellers_eof //-->