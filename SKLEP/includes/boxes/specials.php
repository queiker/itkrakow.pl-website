<?php
/*
  $Id: specials.php,v 1.31+ 2003/06/09 22:21:03 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

//TotalB2B start
	if (!isset($customer_id)) $customer_id = 0;
	$customer_group = tep_get_customers_groups_id();

	$q = tep_db_query("SELECT s.products_id, s.specials_new_products_price FROM " . TABLE_SPECIALS . " s LEFT JOIN ".TABLE_PRODUCTS." p on s.products_id = p.products_id WHERE s.status = '1' AND p.products_status = '1' AND ((customers_id = '" . (int)$customer_id . "' and customers_groups_id = '0') or (customers_id = '0' and customers_groups_id = '" . (int)$customer_group . "') or (customers_id = '0' and customers_groups_id = '0')) order by rand() limit ".MAX_RANDOM_SELECT_SPECIALS.""); 
	$best_size = tep_db_num_rows($q);
	
	if($best_size > 0) {

//TotalB2B end

?>

<!-- specials //-->
          <tr>
            <td class="borB">
<?php
    $info_box_contents = array();
    $info_box_contents[] = array('text' => BOX_HEADING_SPECIALS);
    new infoBoxHeading($info_box_contents, false, false, tep_href_link(FILENAME_SPECIALS));
    $info_box_contents = array();

$rows=0;
while($random_specials = tep_db_fetch_array($q)) {
	$rows++;
	$random_product_query = tep_db_query("select p.products_id, pd.products_name, p.products_price, p.products_tax_class_id, p.products_image from " . TABLE_PRODUCTS . " p LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd ON p.products_id = pd.products_id where p.products_status = '1' and p.products_id = '".(int)$random_specials['products_id']."' and pd.language_id = '" . (int)$languages_id . "'  limit 1 ");

	$random_product = tep_db_fetch_array($random_product_query);

//TotalB2B start
	$random_product['products_price'] = tep_xppp_getproductprice($random_product['products_id']);

	if ($new_price = tep_get_products_special_price($random_product['products_id'])) {
		$random_product['specials_new_products_price'] = $new_price;
		$query_special_prices_hide = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " WHERE configuration_key = 'SPECIAL_PRICES_HIDE'");
        $query_special_prices_hide_result = tep_db_fetch_array($query_special_prices_hide); 
        if ($query_special_prices_hide_result['configuration_value'] == 'true') {
			$cena = '<span class="list_cena_spec">' . $currencies->display_price_nodiscount($random_product['specials_new_products_price'], tep_get_tax_rate($random_product['products_tax_class_id'])) . '</span>';
		} else {
			$cena = '<span class="cena_spec"><s>' .  $currencies->display_price($random_product['products_id'], $random_product['products_price'], tep_get_tax_rate($random_product['products_tax_class_id'])) . '</s></span><br /><span class="list_cena_spec">' . $currencies->display_price_nodiscount($random_product['specials_new_products_price'], tep_get_tax_rate($random_product['products_tax_class_id'])) . '</span>';
		}
	} else {
		$cena = '<span class="list_cena">' . $currencies->display_price($random_product['products_id'], $random_product['products_price'], tep_get_tax_rate($random_product['products_tax_class_id'])) . '</span>';
	}

	$random_product['specials_new_products_price'] = tep_get_products_special_price($random_product['products_id']);
    $query_special_prices_hide = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " WHERE configuration_key = 'SPECIAL_PRICES_HIDE'");
    $query_special_prices_hide_result = tep_db_fetch_array($query_special_prices_hide); 
    if ($query_special_prices_hide_result['configuration_value'] == 'true') {
	  $info_box_contents[] = array('align' => 'center',
                                 'text' => '<table border="0" width="100%" cellspacing="0" cellpadding="5" class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" ><tr><td class="infoBoxContents" colspan="2" align="left">'.tep_image_t('gfx/arb2.gif').'<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$random_product['products_id']) . '" class="linkP">&nbsp;' . $random_product['products_name'] . '</a></td></tr><tr><td class="infoBoxContents" valign="top" align="center" width="'.(SMALL_IMAGE_WIDTH+15).'"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$random_product['products_id']) . '">' . tep_image_mini(DIR_WS_IMAGES.$random_product['products_image'], $random_product['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT,' vspace="5" hspace="5"') . '</a></td><td class="smalltext" align="center" valign="middle"><span class="cenaBig">'.$cena.'</span><br /><br /><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $random_product['products_id']) . '">'.tep_image_button('button_more.gif', $random_product['products_name']).'</a> &nbsp; <a href="' . tep_href_link(basename($PHP_SELF), 'products_id=' . (int)$random_product['products_id'].'&action=add_wishlist', 'NONSSL') . '" title="Dodaj do schowka">' . tep_image_button('button_wishlist_small.gif',  'Dodaj do schowka '. $random_product['products_name'] ) . '</a><br><a href="' . tep_href_link(basename($PHP_SELF), 'products_id=' . (int)$random_product['products_id'].'&action=buy_now', 'NONSSL') . '">' . tep_image_button('button_buy_now.gif', TEXT_BUY . $random_product['products_name'] . TEXT_NOW) . '</a></td></tr></table>'.tep_image_t('gfx/sep_box.gif').($rows==$best_size?'<br /><br />':''));
	} else {
	  $info_box_contents[] = array('align' => 'center',
                                 'text' => '<table border="0" width="100%" cellspacing="0" cellpadding="5"  class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)"><tr><td class="infoBoxContents" colspan="2" align="left">'.tep_image_t('gfx/arb2.gif').'<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$random_product['products_id']) . '" class="linkP">&nbsp;' . $random_product['products_name'] . '</a></td></tr><tr><td class="infoBoxContents" valign="top" align="center"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$random_product['products_id']) . '">' . tep_image_mini(DIR_WS_IMAGES.$random_product['products_image'], $random_product['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT,' vspace="5" hspace="5"') . '</a></td><td class="smalltext" align="center" valign="middle"><span class="cenaBig">'.$cena.'</span><br /><br /><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $random_product['products_id']) . '">'.tep_image_button('button_more.gif', $random_product['products_name']).'</a> &nbsp; <a href="' . tep_href_link(basename($PHP_SELF), 'products_id=' . (int)$random_product['products_id'].'&action=add_wishlist', 'NONSSL') . '" title="Dodaj do schowka">' . tep_image_button('button_wishlist_small.gif',  'Dodaj do schowka '. $random_product['products_name'] ) . '</a><br><a href="' . tep_href_link(basename($PHP_SELF), 'products_id=' . (int)$random_product['products_id'].'&action=buy_now', 'NONSSL') . '">' . tep_image_button('button_buy_now.gif', TEXT_BUY . $random_product['products_name'] . TEXT_NOW) . '</a></td></tr></table>'.tep_image_t('gfx/sep_box.gif').($rows==$best_size?'<br /><br />':''));
	}
//TotalB2B end

}
    new infoBoxC($info_box_contents);
?> 
            </td>
          </tr>
<!-- specials_eof //-->

<?php
	echo '<tr><td class="sep"></td></tr>';
  }
?>
