<?php
/*
$Id: xsell_products.php, v1  2002/09/11
// adapted for Separate Pricing Per Customer v4 2005/02/24

osCommerce, Open Source E-Commerce Solutions
<http://www.oscommerce.com>

Copyright (c) 2002 osCommerce

Released under the GNU General Public License
*/
require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_XSELL_PRODUCTS);
// do przeniesienia w razie potrzeby do bazy
define('MAX_DISPLAY_PASUJACE_AKCESORIA','6');

// BOF Separate Pricing Per Customer
 if(!tep_session_is_registered('sppc_customer_group_id')) {
	$customer_group_id = '0';
 } else {
	$customer_group_id = $sppc_customer_group_id;
 }

if ((int)tep_db_prepare_input($HTTP_GET_VARS['products_id']) > 0) {

//Cache
$dircache = DIR_FS_CACHE_XSELL . (int)tep_db_prepare_input($HTTP_GET_VARS['products_id']) . '/';
$filename = $dircache  . (int)$languages_id . '-' . (int)$customer_group_id . '.php';
$cache = '<?php 
     $info_box_contents = array();
     $info_box_contents[] = array(\'align\' => \'left\', \'text\' => TEXT_XSELL_PRODUCTS);
     new contentBoxHeading($info_box_contents);
     $info_box_contents = array();';
if (file_exists($filename)) {
	require $filename;
} else {
//Fin cache

if ($customer_group_id != '0') {
	$xsell_query = tep_db_query("select distinct p.products_id, p.products_image, pd.products_name, p.products_tax_class_id, IF(pg.customers_group_price IS NOT NULL, pg.customers_group_price, p.products_price) as products_price from " . TABLE_PRODUCTS_XSELL . " xp, " . TABLE_PRODUCTS . " p LEFT JOIN " . TABLE_PRODUCTS_GROUPS . " pg using(products_id), " . TABLE_PRODUCTS_DESCRIPTION . " pd where xp.products_id = '" . (int)tep_db_prepare_input($HTTP_GET_VARS['products_id']) . "' and xp.xsell_id = p.products_id and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_status = '1' and pg.customers_group_id = '".(int)$customer_group_id."' order by sort_order asc limit " . MAX_DISPLAY_PASUJACE_AKCESORIA);
} else {
	$xsell_query = tep_db_query("select distinct p.products_id, p.products_image, pd.products_name, p.products_tax_class_id, p.products_price from " . TABLE_PRODUCTS_XSELL . " xp, " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where xp.products_id = '" . (int)tep_db_prepare_input($HTTP_GET_VARS['products_id']) . "' and xp.xsell_id = p.products_id and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_status = '1' and p.products_id != '" . (int)tep_db_prepare_input($HTTP_GET_VARS['products_id'])."' order by sort_order asc limit " . MAX_DISPLAY_PASUJACE_AKCESORIA);
}
// EOF Separate Pricing Per Customer

$num_products_xsell = tep_db_num_rows($xsell_query);

if ($num_products_xsell > 0) {
?>
<!-- xsell_products //-->
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
		<tr>
			<td class="smalltext" colspan="2" style="padding-top: 10px;">
<?php
     $info_box_contents = array();
     $info_box_contents[] = array('align' => 'left', 'text' => TEXT_XSELL_PRODUCTS);
     new infoBoxHeading($info_box_contents);

     $row = 0;
     $col = 0;
     $info_box_contents = array();
     while ($xsell = tep_db_fetch_array($xsell_query)) {
 		$rows++;
	    $num ++;
	    $xsell['products_name'] = tep_get_products_name($xsell['products_id']);

//TotalB2B start
    $xsell['products_price'] = tep_xppp_getproductprice($xsell['products_id']);

	$sprzedaz_online = '';
	if($xsell['products_online'] == '0') {
		$sprzedaz_online = '<span style="color #F00;"><b>'.TEXT_NIEDOSTEPNY_ONLINE_PYTAJ.'</b><br />';
		$button_buy = '';
	} else {
		$button_buy = '<a href="' . tep_href_link(basename($PHP_SELF), 'products_id=' . (int)$xsell['products_id'].'&action=buy_now', 'NONSSL') . '">' . tep_image_button('button_buy_now.gif', TEXT_BUY . $xsell['products_name'] . TEXT_NOW) . '</a>';
	}
		

	if ($new_price = tep_get_products_special_price($xsell['products_id'])) {
		$xsell['specials_new_products_price'] = $new_price;

		if(defined('SPECIAL_PRICES_HIDE')) {
			$query_special_prices_hide_result['configuration_value'] = SPECIAL_PRICES_HIDE;
		} else {
			$query_special_prices_hide = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " WHERE configuration_key = 'SPECIAL_PRICES_HIDE'");
			$query_special_prices_hide_result = tep_db_fetch_array($query_special_prices_hide); 	  
		}

		if ($query_special_prices_hide_result['configuration_value'] == 'true') {
			$cena = '<span class="list_cena_spec">' . $currencies->display_price_nodiscount($xsell['specials_new_products_price'], tep_get_tax_rate($xsell['products_tax_class_id'])) . '</span>';
		} else {
			$cena = '<span class="cena_spec"><s>' .  $currencies->display_price($xsell['products_id'], $xsell['products_price'], tep_get_tax_rate($xsell['products_tax_class_id'])) . '</s></span><br><span class="list_cena_spec">' . $currencies->display_price_nodiscount($xsell['specials_new_products_price'], tep_get_tax_rate($xsell['products_tax_class_id'])) . '</span>';
		}
	} else {
		$cena = '<span class="list_cena">' . $currencies->display_price($xsell['products_id'], $xsell['products_price'], tep_get_tax_rate($xsell['products_tax_class_id'])) . '</span>';
	}
//TotalB2B end

/*
        $info_box_contents[$row][$col] = array('align' => 'left',
                                               'params' => '  class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" width="50%" valign="top" '.(($col==0)?'style="border-right: 1px solid #DEDEDE;"':''),

                                               'text' => ($row>0?'<center>'.tep_image_t('gfx/sep_box3.gif').'</center>':'').'<table border="0" width="100%" cellspacing="0" cellpadding="2" ><tr><td style="height:'.(SMALL_IMAGE_HEIGHT+15).'px;" class="infoBoxContents" valign="middle" align="center" width="'.(SMALL_IMAGE_WIDTH+5).'"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$xsell['products_id']) . '" >' . tep_image_mini(DIR_WS_IMAGES.$xsell['products_image'], $xsell['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT,'') . '</a></td></tr><tr ><td class="infoBoxContents" colspan="2" align="center"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$xsell['products_id']) . '" class="linkP">'.'' . $xsell['products_name'] . '</a></td></tr><tr><td class="smalltext" align="center" valign="middle"><span class="cenaBig">'.$cena.'</span><br /><br /><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$xsell['products_id']) . '" >'.tep_image_button('button_more.gif', $xsell['products_name']).'</a> &nbsp; <a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$xsell['products_id'].'&action=add_wishlist') . '" >'.tep_image_button('button_wishlist_small.gif', $xsell['products_name']).'</a><br>'.$button_buy.'&nbsp;</td></tr></table>');
*/

        $info_box_contents[$row][$col] = array('align' => 'left',
                                               'params' => '  class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" width="50%" valign="top" '.($col==0?'style="border-right: 1px solid #DEDEDE;"':''),

                                               'text' => ($row>0?tep_image_t('gfx/sep_box3.gif'):'').'<table border="0" width="100%" cellspacing="0" cellpadding="5" ><tr ><td class="infoBoxContents" colspan="2" align="left"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$xsell['products_id']) . '" class="linkP">'.'' . $xsell['products_name'] . '</a></td></tr><tr><td style="height:'.(SMALL_IMAGE_HEIGHT+15).'px;" class="infoBoxContents" valign="middle" align="center" width="'.(SMALL_IMAGE_WIDTH+15).'">' . tep_image_mini(DIR_WS_IMAGES.$xsell['products_image'], $xsell['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT,' vspace="5" hspace="5"') . ' </td><td class="smalltext" align="center" valign="middle"><span class="cenaBig">'.$cena.'</span><br /><br /><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$xsell['products_id']) . '" >'.tep_image_button('button_more.gif', $xsell['products_name']).'</a> &nbsp; <a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$xsell['products_id'].'&action=add_wishlist', 'NONSSL') . '" >'.tep_image_button('button_wishlist_small.gif', 'Dodaj do przechowalni').'</a><br><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $xsell['products_id'].'&action=buy_now', 'NONSSL') . '">' . tep_image_button('button_buy_now.gif', TEXT_BUY . $xsell['products_name'] . TEXT_NOW) . '</a></td></tr></table>');

	    $col ++;
	    if ($col >= 2) {
	      $col = 0;
	      $row ++;
	    } 
	  }

    new contentBox($info_box_contents);
//Cache
} // end $num_products_xsell > 0
//Fin Cache
     
?>
		</td>
	</tr>
<!-- xsell_products_eof //-->
<?php
   } // end file_exists($filename)
 } // end IF products_id
?>