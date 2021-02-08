<?php
/*
  -- Changed 11/10/03 for v 2.2 MS2 - Randy Pertiet

  $Id: product_listing_col.php,v 1.00 2002/05/06 20:28:07 icw_ Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- product_listing_col //-->
<?php

  $producenci = array();
  DEFINE('PRODUCT_LIST_COL_NUM',1);
  $liczba_kolumn = PRODUCT_LIST_COL_NUM;

  $listing_split = new splitPageResults($listing_sql, 5, 'p.products_id');

  if ($listing_split->number_of_rows > 0) {
?>
	  <tr>
		<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
	  </tr>
	  <tr>
		<td class="borA">
<?php

	new infoBoxHeading($info_box_contents, true, true);
	$row = 0;
	$col = 0;

    $listing = tep_db_query($listing_split->sql_query);
    while ($listing_values = tep_db_fetch_array($listing)) {
	  if(tep_not_null($listing_values['customers_id']) && $listing_values['customers_id']!='0') {
		  if(tep_session_is_registered('customer_id') && (int)$customer_id == (int)$listing_values['customers_id']) {
		  // poka¿ produkt wlasciwemu klientowi
		  } else {
			continue;
		  }
	  }
      $listing_values['products_name'] = '&nbsp;&nbsp;'.tep_get_products_name($listing_values['products_id']);

	  $lc_text = '<div>';

	  $lc_text .= '<div class="catSep"></div>';  
	  $lc_text .= '<div align="left"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $listing_values['products_id']) . '" class="linkP">' . $listing_values['products_name'] . '</a></div>';

	  $lc_text .= '<table border="0" cellspacing="0" cellpadding="0" class="boxText" width="100%"><tr><td align="center" valign="middle" width="'.(SMALL_IMAGE_WIDTH+20).'">';

      $lc_text .= tep_draw_separator('pixel_trans.gif',15,5).'<div style="width:'.(SMALL_IMAGE_WIDTH+30).'px; "><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $listing_values['products_id']) . '">' . tep_image_mini(DIR_WS_IMAGES . $listing_values['products_image'], $listing_values['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT,'vspace="5" hspace="5"') . '</a></div></td><td valign="top" align="center" >';
	  
	  $listing_values['products_available'] = 1;
	  $listing_values['products_genre']= 1;

	  if($listing_values['products_available']=='1'){
		if($listing_values['products_genre']=='1'){

//TotalB2B start
		    $listing_values['products_price'] = tep_xppp_getproductprice($listing_values['products_id']);

		    if ($new_price = tep_get_products_special_price($listing_values['products_id'])) {
              $listing_values['specials_new_products_price'] = $new_price;
			  $query_special_prices_hide = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " WHERE configuration_key = 'SPECIAL_PRICES_HIDE'");
              $query_special_prices_hide_result = tep_db_fetch_array($query_special_prices_hide); 
              if ($query_special_prices_hide_result['configuration_value'] == 'true') {
			    $cena = '<span class="list_cena_spec">' . $currencies->display_price_nodiscount($listing_values['specials_new_products_price'], tep_get_tax_rate($listing_values['products_tax_class_id'])) . '</span>';
	          } else {
			    $cena = '<span class="cena_spec"><s>' .  $currencies->display_price($listing_values['products_id'], $listing_values['products_price'], tep_get_tax_rate($listing_values['products_tax_class_id'])) . '</s></span><br /><span class="list_cena_spec">' . $currencies->display_price_nodiscount($listing_values['specials_new_products_price'], tep_get_tax_rate($listing_values['products_tax_class_id'])) . '</span>';
	          }
//TotalB2B end
            } else {
              $cena = '<span class="list_cena">' . $currencies->display_price($listing_values['products_id'], $listing_values['products_price'], tep_get_tax_rate($listing_values['products_tax_class_id'])) . '</span>';
            }
		} else {
			$lc_text .= '<span class="list_cena"><a href="'.tep_href_link(FILENAME_ZAPYTAJ,'pID='.$listing_values['products_id']).'" class="at_ask">' . TEXT_ASK_FOR_PRICE . '</a></span>';	
		}
	  } else {
		  $lc_text .= '<br /><span class="list_br">TOWAR SPRZEDANY</span>';
	  }

//		$opis = tep_get_products_desc($listing_values['products_id']);
//		$opis = osc_trunc_string(strip_tags($opis, '<a><em><i><s><sub><sup><u>'), 250);
		$opis = '';

//$lc_text .= '&nbsp;</td></tr>';
      if (PRODUCT_LIST_BUY_NOW) {

		$lc_text .= '<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width="100%" align="left" valign="top" colspan="3" class="opis">';

		$lc_text .= '<tr><td width="150" valign="middle" align="left" style="border-top: 5px solid #FFF; line-height: 1.8em" NOWRAP class="smallText">';
		$lc_text .= '&raquo; <a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $listing_values['products_id']) . '" ><b>Dok³adny opis produktu</b></a><br />';

		$st_lvl = 'low';
		if($listing_values['products_quantity'] <= STOCK_LEVEL_NONE) $st_lvl = 'none';
		if($listing_values['products_quantity'] >= STOCK_LEVEL_LOW) $st_lvl = 'low';
		if($listing_values['products_quantity'] >= STOCK_LEVEL_MEDIUM) $st_lvl = 'medium';
		if($listing_values['products_quantity'] >= STOCK_LEVEL_HIGH) $st_lvl = 'high';

		$lc_text .= '&raquo; Dostêpno¶æ: '.tep_image_t('gfx/stock_'.$st_lvl.'.png').'<br />';

		if(tep_not_null($listing_values['manufacturers_id'])) {
			$p['nazwa'] = '';
			if(!array_key_exists((int)$listing_values['manufacturers_id'],$producenci)) {
				$q = tep_db_query("SELECT manufacturers_id as id, manufacturers_name as nazwa FROM ".TABLE_MANUFACTURERS." WHERE manufacturers_id = '".(int)$listing_values['manufacturers_id']."'");
				$p = tep_db_fetch_array($q);
				$producenci[$p['id']] = $p['nazwa'];
			}
			if(tep_not_null($producenci[(int)$listing_values['manufacturers_id']])) {
				$lc_text .= '&raquo; <a href="'.tep_href_link(FILENAME_DEFAULT,'manufacturers_id='.(int)$listing_values['manufacturers_id']).'"><b>'.$producenci[(int)$listing_values['manufacturers_id']].'</b></a><br />';
			}
		}
		$lc_text .= '</td>';

		$lc_text .= '<td align="center" width="150" valign="middle" style="border-top: 5px solid #FFF;" NOWRAP><div class="cenaBig">'.$cena.'</div>
			<div class="btn"><a href="' . tep_href_link(basename($PHP_SELF), 'products_id=' . (int)$listing_values['products_id'].'&action=add_wishlist', 'NONSSL') . '" title="Dodaj do schowka">' . tep_image_button('button_wishlist.gif',  'Dodaj do schowka '. $listing_values['products_name'] ) . '</a></div><div class="btn">
			<a href="' . tep_href_link(basename($PHP_SELF), 'products_id=' . $listing_values['products_id'].'&action=buy_now', 'NONSSL') . '">' . tep_image_button('button_in_cart.gif', TEXT_BUY . $listing_values['products_name'] . TEXT_NOW,' style="vertical-align: middle;"') . '</a></div></td></tr></table>';
      }

$lc_text .= '</table></div><br />';
      $info_box_contents[$row][$col] = array('align' => 'center', 'params' => 'class="smallText" width="100%" valign="middle"',
                                           'text' => $lc_text);

      $col ++;
      if ($col > $liczba_kolumn-1) {
        $col = 0;
        $row ++;
      }
    }

    new contentBox($info_box_contents);

?>
		</td>
	  </tr>
<?php
  }
?>

