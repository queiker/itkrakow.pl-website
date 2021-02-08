<?php
/*
 $ID family_products.php - JOHNSON - 05/07/2003 matti@suomedia.com
 
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce
  
  Family Products  - JOHNSON - 05/07/2003 matti@suomedia.com
 
  Copyright (c) 2003 Suomedia - Dynamic Content Management

  Released under the GNU General Public License
*/

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_FAMILY_PRODUCTS);
  
  $kolumn = 1; // liczba kolumn z produktami

  $family_query = tep_db_query("select products_podobne from " . TABLE_PRODUCTS . " where products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "'");
  $thisquery = tep_db_fetch_array($family_query);

if ($thisquery['products_podobne'] != '' && tep_db_num_rows($family_query) > 0) {
	
	echo '<div id="produkty_podobne">&nbsp; &nbsp; &nbsp; &nbsp; '.TEXT_ZOBACZ_TAKZE.'</div>';

    $define_list = array('PRODUCT_LIST_MODEL' => PRODUCT_LIST_MODEL,
                         'PRODUCT_LIST_NAME' => PRODUCT_LIST_NAME,
                         'PRODUCT_LIST_MANUFACTURER' => PRODUCT_LIST_MANUFACTURER,
                         'PRODUCT_LIST_PRICE' => PRODUCT_LIST_PRICE,
                         'PRODUCT_LIST_QUANTITY' => PRODUCT_LIST_QUANTITY,
                         'PRODUCT_LIST_WEIGHT' => PRODUCT_LIST_WEIGHT,
                         'PRODUCT_LIST_IMAGE' => PRODUCT_LIST_IMAGE,
                         'PRODUCT_LIST_BUY_NOW' => PRODUCT_LIST_BUY_NOW);

    asort($define_list);

    $column_list = array();
    reset($define_list);
    while (list($key, $value) = each($define_list)) {
      if ($value > 0) $column_list[] = $key;
    }

      $family_sql = "select distinct p.products_id,  p.manufacturers_id, p.products_model, p.products_image, p.products_tax_class_id, pd.products_name, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, s.status, p.products_price, p.products_podobne, m.manufacturers_name from ". TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id !=" . (int)$HTTP_GET_VARS['products_id'] . " and p.products_id = p2c.products_id and p.products_id = pd.products_id and p.products_podobne = '" . tep_db_prepare_input(tep_db_input($thisquery['products_podobne'])) . "' and p.products_status = '1' and pd.language_id = '" . (int)$languages_id . "'";


	$family_sql .= ' order by ';
	$family_sql .= "pd.products_name";
//	$family_sql .= " LIMIT 1 ";

	$q = tep_db_query($family_sql);
	echo '<table width="100%" cellspacing="4" cellpadding="4" align="right" border="0" class="podobne_bg"><tr><td width="'.(int)(100/$kolumn).'%">';
	
	$podzial = tep_db_num_rows($q);
	$row = 0;
	while($r = tep_db_fetch_array($q)) {
		$row++;

//TotalB2B start
	$products_price = '';
	$r['products_price'] = tep_xppp_getproductprice($r['products_id']);
//TotalB2B end

    if ($new_price = tep_get_products_special_price($r['products_id'])) {
//TotalB2B start
	  if(defined('SPECIAL_PRICES_HIDE')) {
		$query_special_prices_hide_result['configuration_value'] = SPECIAL_PRICES_HIDE;
	  } else {
		  $query_special_prices_hide = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " WHERE configuration_key = 'SPECIAL_PRICES_HIDE'");
	      $query_special_prices_hide_result = tep_db_fetch_array($query_special_prices_hide); 	  
	  }

      if ($query_special_prices_hide_result['configuration_value'] == 'true') {
	 	$products_price = '<span style="color: #F10294;">' . $currencies->display_price_nodiscount($new_price, tep_get_tax_rate($r['products_tax_class_id'])) . '</span>'; 
	  } else {
	    $products_price = '<span class="cena_spec2"><s>' . $currencies->display_price($r['products_id'], $r['products_price'], tep_get_tax_rate($r['products_tax_class_id'])) . '</s></span><br/><span style="color: #F10294;">' . $currencies->display_price_nodiscount($new_price, tep_get_tax_rate($r['products_tax_class_id'])) . '</span>';
	  }
//TotalB2B end
    } else {
      $products_price = '<span style="color: #F10294;"><b>'.$currencies->display_price($r['products_id'], $r['products_price'], tep_get_tax_rate($r['products_tax_class_id'])).'</b></span>';
    }

		echo tep_image_t('gfx/ar_podobne.png').'<a href="'.tep_href_link(FILENAME_PRODUCT_INFO,'products_id='.$r['products_id']).'" style="color: #777;">'.$r['products_name'].'</a><br />';
		
		if($row == $podzial / $kolumn) {
			echo '</td><td width="'.(int)(100/$kolumn).'%">';
		}

	}
	echo '</tr></table>';
}
?>