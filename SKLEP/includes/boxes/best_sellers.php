<?php
/*
  $Id: best_sellers.php,v 1.21 2003/06/09 22:07:52 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  if (isset($current_category_id) && ($current_category_id > 0)) {
    $best_sellers_query = tep_db_query("select distinct p.products_id, pd.products_name, p.products_image, p.products_tax_class_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where p.products_status = '1' and p.products_ordered > 0 and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and '" . (int)$current_category_id . "' in (c.categories_id, c.parent_id) order by p.products_ordered desc, pd.products_name limit " . MAX_DISPLAY_BESTSELLERS);
  } else {
    $best_sellers_query = tep_db_query("select distinct p.products_id, pd.products_name, p.products_image, p.products_tax_class_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_ordered > 0 and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by p.products_ordered desc, pd.products_name limit " . MAX_DISPLAY_BESTSELLERS);
  }
	$best_size = tep_db_num_rows($best_sellers_query);
  if ($best_size >= MIN_DISPLAY_BESTSELLERS) {

?>
<!-- best_sellers //-->

          <tr>
            <td class="borB">
<?php
    $info_box_contents = array();
    $info_box_contents[] = array('text' => BOX_HEADING_BESTSELLERS);

    new infoBoxHeading($info_box_contents, false, false);

    $rows = 0;
    $info_box_contents = array();
	
//	$bestsellers_list = '<table border="0" width="100%" cellspacing="0" cellpadding="1">';
    while ($best_sellers = tep_db_fetch_array($best_sellers_query)) {
		$rows++;


//TotalB2B start
    $best_sellers['products_price'] = tep_xppp_getproductprice($best_sellers['products_id']);

	if ($new_price = tep_get_products_special_price($best_sellers['products_id'])) {
		$best_sellers['specials_new_products_price'] = $new_price;
		$query_special_prices_hide = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " WHERE configuration_key = 'SPECIAL_PRICES_HIDE'");
		$query_special_prices_hide_result = tep_db_fetch_array($query_special_prices_hide); 
		if ($query_special_prices_hide_result['configuration_value'] == 'true') {
			$cena = '<span class="list_cena_spec">' . $currencies->display_price_nodiscount($best_sellers['specials_new_products_price'], tep_get_tax_rate($best_sellers['products_tax_class_id'])) . '</span>';
		} else {
			$cena = '<span class="cena_spec"><s>' .  $currencies->display_price($best_sellers['products_id'], $best_sellers['products_price'], tep_get_tax_rate($best_sellers['products_tax_class_id'])) . '</s></span><br /><span class="list_cena_spec">' . $currencies->display_price_nodiscount($best_sellers['specials_new_products_price'], tep_get_tax_rate($best_sellers['products_tax_class_id'])) . '</span>';
		}
	} else {
		$cena = '<span class="list_cena">' . $currencies->display_price($best_sellers['products_id'], $best_sellers['products_price'], tep_get_tax_rate($best_sellers['products_tax_class_id'])) . '</span>';
	}
//TotalB2B end

    $info_box_contents[] = array('align' => 'center',
                                 'text' => '<table border="0" width="100%" cellspacing="0" cellpadding="5" class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" ><tr ><td class="infoBoxContents" colspan="2" align="left"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$best_sellers['products_id']) . '" class="linkP">'.$rows.') ' . $best_sellers['products_name'] . '</a></td></tr><tr><td class="infoBoxContents" valign="top" align="center"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$best_sellers['products_id']) . '">' . tep_image_mini(DIR_WS_IMAGES.$best_sellers['products_image'], $best_sellers['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT,' vspace="5" hspace="5"') . '</a></td><td class="smalltext" align="center" valign="middle"><span class="cenaBig">'.$cena.'</span><br /><br /><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$best_sellers['products_id']) . '" >'.tep_image_button('button_more.gif', $best_sellers['products_name']).'</a> &nbsp; <a href="' . tep_href_link(basename($PHP_SELF), 'products_id=' . (int)$best_sellers['products_id'].'&action=add_wishlist', 'NONSSL') . '" title="Dodaj do schowka">' . tep_image_button('button_wishlist_small.gif',  'Dodaj do schowka '. $best_sellers['products_name'] ) . '</a><br><a href="' . tep_href_link(basename($PHP_SELF), 'products_id=' . $best_sellers['products_id'].'&amp;action=buy_now', 'NONSSL') . '">' . tep_image_button('button_buy_now.gif', TEXT_BUY . $best_sellers['products_name'] . TEXT_NOW) . '</a>&nbsp;</td></tr></table>'.tep_image_t('gfx/sep_box2.gif').($rows==$best_size?'<br /><br />':''));
    }


    new infoBoxC($info_box_contents);

?>
            </td>
          </tr>
<!-- best_sellers_eof //-->
<?php
	echo '<tr><td class="sep"></td></tr>';
  }
?>
