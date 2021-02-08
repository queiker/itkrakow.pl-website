<?php

	define('USE_STOCK_OSC', true);
	$currencies = new currencies();
	if (isset($_GET['products_id']) && USE_STOCK_OSC === true) {
	$orders_query = tep_db_query("select p.products_id, p.products_image, p.products_tax_class_id from " . TABLE_ORDERS_PRODUCTS . " opa, " . TABLE_ORDERS_PRODUCTS . " opb, " . TABLE_ORDERS . " o, " . TABLE_PRODUCTS . " p where opa.products_id = '" . (int)$_GET['products_id'] . "' and opa.orders_id = opb.orders_id and opb.products_id != '" . (int)$_GET['products_id'] . "' and opb.products_id = p.products_id and opb.orders_id = o.orders_id and p.products_status = '1' group by p.products_id order by o.date_purchased desc limit " . MAX_DISPLAY_ALSO_PURCHASED);
    $num_products_ordered = tep_db_num_rows($orders_query);
    if ($num_products_ordered >= MIN_DISPLAY_ALSO_PURCHASED) {
?>
<!-- also_purchased_products //-->
<?php
      $info_box_contents = array();
      $info_box_contents[] = array('text' => TEXT_ALSO_PURCHASED_PRODUCTS);

      new infoBoxHeading($info_box_contents);

      $row = 0;
      $col = 0;
      $info_box_contents = array();
      while ($orders = tep_db_fetch_array($orders_query)) {
        $orders['products_name'] = tep_get_products_name($orders['products_id']);

//TotalB2B start
	    $orders['products_price'] = tep_xppp_getproductprice($orders['products_id']);
	


		if ($new_price = tep_get_products_special_price($orders['products_id'])) {
			$orders['specials_new_products_price'] = $new_price;
			$query_special_prices_hide = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " WHERE configuration_key = 'SPECIAL_PRICES_HIDE'");
			$query_special_prices_hide_result = tep_db_fetch_array($query_special_prices_hide); 
			if ($query_special_prices_hide_result['configuration_value'] == 'true') {
				$cena = '<span class="list_cena_spec">' . $currencies->display_price_nodiscount($orders['specials_new_products_price'], tep_get_tax_rate($orders['products_tax_class_id'])) . '</span>';
			} else {
				$cena = '<span class="cena_spec"><s>' .  $currencies->display_price($orders['products_id'], $orders['products_price'], tep_get_tax_rate($orders['products_tax_class_id'])) . '</s></span><br /><span class="list_cena_spec">' . $currencies->display_price_nodiscount($orders['specials_new_products_price'], tep_get_tax_rate($orders['products_tax_class_id'])) . '</span>';
			}
		} else {
			$cena = '<span class="list_cena">' . $currencies->display_price($orders['products_id'], $orders['products_price'], tep_get_tax_rate($orders['products_tax_class_id'])) . '</span>';
		}
//TotalB2B end
        $info_box_contents[$row][$col] = array('align' => 'left',
                                               'params' => '  class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" width="50%" valign="top" '.($col==0?'style="border-right: 1px solid #DEDEDE;"':''),

                                               'text' => ($row>0?tep_image_t('gfx/sep_box3.gif'):'').'<table border="0" width="100%" cellspacing="0" cellpadding="5" ><tr ><td class="infoBoxContents" colspan="2" align="left"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$orders['products_id']) . '" class="linkP">'.'' . $orders['products_name'] . '</a></td></tr><tr><td style="height:'.(SMALL_IMAGE_HEIGHT+15).'px;" class="infoBoxContents" valign="middle" align="center" width="'.(SMALL_IMAGE_WIDTH+15).'">' . tep_image_mini(DIR_WS_IMAGES.$orders['products_image'], $orders['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT,' vspace="5" hspace="5"') . ' </td><td class="smalltext" align="center" valign="middle"><span class="cenaBig">'.$cena.'</span><br /><br /><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$orders['products_id']) . '" >'.tep_image_button('button_more.gif', $orders['products_name']).'</a> &nbsp; <a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$orders['products_id'].'&action=add_wishlist', 'NONSSL') . '" >'.tep_image_button('button_wishlist_small.gif', 'Dodaj do przechowalni').'</a><br><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $orders['products_id'].'&action=buy_now', 'NONSSL') . '">' . tep_image_button('button_buy_now.gif', TEXT_BUY . $orders['products_name'] . TEXT_NOW) . '</a></td></tr></table>');
/*

                                               'text' => '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $orders['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $orders['products_image'], $orders['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $orders['products_id']) . '">' . $orders['products_name'] . '</a>');
*/
        $col ++;
        if ($col >= 2) {
          $col = 0;
          $row ++;
        }
      }

      new contentBox($info_box_contents);

?>
<!-- also_purchased_products_eof //-->
<?php
    }
  }
  
?>