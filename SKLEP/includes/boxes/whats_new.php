<?php
/*
  $Id: whats_new.php,v 1.31 2003/02/10 22:31:09 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  if ($random_product = tep_random_select("select products_id, products_image, products_tax_class_id, products_price from " . TABLE_PRODUCTS . " where products_status = '1' order by products_date_added desc limit 1")) {
?>
<!-- whats_new //-->
          <tr>
            <td class="borB">
<?php
    $random_product['products_name'] = tep_get_products_name($random_product['products_id']);
    $random_product['specials_new_products_price'] = tep_get_products_special_price($random_product['products_id']);

    $info_box_contents = array();
    $info_box_contents[] = array('text' => BOX_HEADING_WHATS_NEW);

    new infoBoxHeading($info_box_contents, false, false, tep_href_link(FILENAME_PRODUCTS_NEW));

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
//TotalB2B end

    $info_box_contents = array();
    $info_box_contents[] = array('align' => 'center',
                                 'text' => '<table border="0" width="100%" cellspacing="0" cellpadding="1"><tr><td class="infoBoxContents" colspan="2" align="left"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$random_product['products_id']) . '" class="linkP">' . $random_product['products_name'] . '</a></td></tr><tr><td class="infoBoxContents" valign="top" align="center"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$random_product['products_id']) . '" >' . tep_image(DIR_WS_IMAGES.$random_product['products_image'], $random_product['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT,' vspace="5" hspace="5"') . '</a></td><td class="smalltext" align="center" valign="middle"><span class="cenaBig">'.$cena.'</span><br /><br /><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$random_product['products_id']) . '" >'.tep_image_button('button_more.gif', $random_product['products_name']).'</a> &nbsp; <a href="' . tep_href_link(basename($PHP_SELF), 'products_id=' . (int)$random_product['products_id'].'&action=add_wishlist', 'NONSSL') . '" title="Dodaj do schowka">' . tep_image_button('button_wishlist_small.gif',  'Dodaj do schowka '. $random_product['products_name'] ) . '</a><br><a href="' . tep_href_link(basename($PHP_SELF), 'products_id=' . $random_product['products_id'].'&amp;action=buy_now', 'NONSSL') . '">' . tep_image_button('button_buy_now.gif', TEXT_BUY . $random_product['products_name'] . TEXT_NOW) . '</a>&nbsp;</td></tr><tr><td colspan="2" align="center">'.tep_image(DIR_WS_IMAGES.'gfx/sep_best.gif').'</td></tr></table>');

    new infoBox($info_box_contents);
?>
            </td>
          </tr>
<!-- whats_new_eof //-->

<?php
	echo '<tr><td class="sep"></td></tr>';
  }
?>
