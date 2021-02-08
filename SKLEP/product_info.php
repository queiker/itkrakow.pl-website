<?php
/*
  $Id: product_info.php,v 1.97 2003/07/01 14:34:54 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_PRODUCT_INFO);

  $product_check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
  $product_check = tep_db_fetch_array($product_check_query);
?>
<?php
$the_product_info_query = tep_db_query("select pd.language_id, p.products_id, pd.products_name, pd.products_description, p.products_model, p.products_quantity, p.products_image, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pd.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "'" . " and pd.language_id ='" .  (int)$languages_id . "'");
    $the_product_info = tep_db_fetch_array($the_product_info_query);
   $the_product_name = strip_tags ($the_product_info['products_name'], "");
   $the_product_description = strip_tags ($the_product_info['products_description'], "");
   $the_product_model = strip_tags ($the_product_info['products_model'], "");
?>
<?php
$the_manufacturer_query = tep_db_query("select m.manufacturers_id, m.manufacturers_name from " . TABLE_MANUFACTURERS . " m left join " . TABLE_MANUFACTURERS_INFO . " mi on (m.manufacturers_id = mi.manufacturers_id and mi.languages_id = '" . (int)$languages_id . "'), " . TABLE_PRODUCTS . " p  where p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and p.manufacturers_id = m.manufacturers_id");
    $the_manufacturers = tep_db_fetch_array($the_manufacturer_query);
?>

<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<?php 
	require(DIR_WS_INCLUDES . 'meta_tags.php');
?>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_TEMPLATES . $template . $language . '/stylesheet.css';?>">
<link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_TEMPLATES . $template . $language . '/lightbox.css';?>" media="screen">
<link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_TEMPLATES . $template . $language . '/tab/tab.css';?>">

<script src="includes/tabpane.js" type="text/javascript"></script>
<script src="includes/prototype.js" type="text/javascript"></script>
<script src="includes/scriptaculous.js?load=effects" type="text/javascript"></script>
<script src="includes/lightbox.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
function popupWindow(url,id) {
  window.open(url,id,'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=100,height=100,screenX=150,screenY=150,top=150,left=150')
}
//--></script>
</head>
<body>
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<?php include('includes/body.php'); ?>
    <td width="100%" valign="top">
	
	<?php echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action')) . 'action=add_product')); ?><table border="0" width="100%" cellspacing="0" cellpadding="0">
<?php
  if ($product_check['total'] < 1) {
?>
	</form>
      <tr>
        <td><?php
			$info_box_contents = array();
			$info_box_contents[] = array('text' => TEXT_PRODUCT_NOT_FOUND);
			new infoBoxHeading($info_box_contents, true, true);
	  ?></td>
      </tr>
      <tr>
        <td class="buttons" align="right"><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
      </tr>

      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>


      <tr>
        <td><?php include(DIR_WS_MODULES.'advanced_search.php'); ?></td>
      </tr>

<?php
  } else {
    $product_info_query = tep_db_query("select p.products_id, pd.products_name, pd.products_description, p.products_model, p.products_quantity, p.products_image, p.products_image_pop, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id, p.products_last_modified, p.products_date_added from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
    $product_info = tep_db_fetch_array($product_info_query);
	
	$aktualizowany = 0;

    tep_db_query("update " . TABLE_PRODUCTS_DESCRIPTION . " set products_viewed = products_viewed+1 where products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and language_id = '" . (int)$languages_id . "'");

	$darmowa_wysylka = 0; // domyslny status darmowej wysylki

//TotalB2B start
	$product_info['products_price'] = tep_xppp_getproductprice($product_info['products_id']);
//TotalB2B end

    if ($new_price = tep_get_products_special_price($product_info['products_id'])) {
//TotalB2B start
	  $query_special_prices_hide = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " WHERE configuration_key = 'SPECIAL_PRICES_HIDE'");
      $query_special_prices_hide_result = tep_db_fetch_array($query_special_prices_hide); 
      if ($query_special_prices_hide_result['configuration_value'] == 'true') {
	 	$products_price = '<span class="list_cena_spec">' . $currencies->display_price_nodiscount($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span>'; 
	  } else {
	    $products_price = '<span class="cena_spec"><s>' . $currencies->display_price($product_info['products_id'], $product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</s></span><br/><span class="list_cena_spec">' . $currencies->display_price_nodiscount($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span>';
	  }
//TotalB2B end
    } else {
      $products_price = '<span class="list_cena">'.$currencies->display_price($product_info['products_id'], $product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])).'</span>';
    }

    if (tep_not_null($the_manufacturers['manufacturers_name'])) {
      $products_name = '<b>'.$product_info['products_name'].'</b>';
	  $producent = '<a href="'.tep_href_link(FILENAME_DEFAULT, 'manufacturers_id='.$the_manufacturers['manufacturers_id']) . '"><b>'.$the_manufacturers['manufacturers_name'].'</b></a>';
    } else {
      $products_name = '<b>'.$product_info['products_name'] . '</b>';
	  $producent = '---';
    }

// START: Extra Fields Contribution v2.0b - mintpeel display fix
		    list($products_id_clean) = split('{', $products_id);
// budowanie tabelki produktu
                      $extra_fields_query = tep_db_query("
                      SELECT pef.products_extra_fields_status as status, pef.products_extra_fields_name as name, ptf.products_extra_fields_value as value
                      FROM ". TABLE_PRODUCTS_EXTRA_FIELDS ." pef
             LEFT JOIN  ". TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS ." ptf
            ON ptf.products_extra_fields_id=pef.products_extra_fields_id
            WHERE ptf.products_id='".(int)$HTTP_GET_VARS['products_id']."' and ptf.products_extra_fields_value<>'' and (pef.languages_id='0' or pef.languages_id='".(int)$languages_id."')
            ORDER BY products_extra_fields_order");

  if(tep_db_num_rows($extra_fields_query)>0) {
	$opcje_tabelka = '<br /><br /><table border="0"  cellspacing="1" cellpadding="3" width="410" style="background: #FFF;">';
	while ($extra_fields = tep_db_fetch_array($extra_fields_query)) {
        if (! $extra_fields['status'])  // show only enabled extra field
           continue;
        $opcje_tabelka .= '<tr><td align="right" class="smallText" valign="top" style="background: #F0F0F0" width="150"><span style="color: #FF8400; font-weight: bold;">'.$extra_fields['name'].'</span></td><td align="left" class="smallText" valign="top" style="background: #F9F9F9;">' .$extra_fields['value'].'</td></tr>'; 
	}
	$opcje_tabelka.='</table>';
  }

// END: Extra Fields Contribution - mintpeel display fix

	if(tep_session_is_registered('wishlist_id')) {
?>
	  <tr>
		<td class="messageStackSuccess"><?php echo PRODUCT_ADDED_TO_WISHLIST; ?></td>
	  </tr>
<?php
		tep_session_unregister('wishlist_id');
	}
?>

      <tr>
        <td><?php
			$info_box_contents = array();
			$info_box_contents[] = array('text' => PRODUCTS_CART);
			new infoBoxHeading($info_box_contents, true, true);
	  ?></td>
      </tr>
      <tr>
        <td class="blrb">

          <table width="100%" border="0" cellspacing="0" cellpadding="2" align="left">
			<tr>
				<td colspan="2" class="pageHeadingProduct" valign="middle" align="left"><?php echo $products_name; ?></td>
			</tr>
			<tr>
              <td align="center" class="smallText"><DIV style="text-align: left;">

			<?php
			if(!tep_not_null($product_info['products_image'])) $product_info['products_image'] = '_no_.gif';
			?>
				<table border="0" cellspacing="0" cellpadding="2" align="right" width="100%">
					<tr>
						<td align="center" class="smallText">
<?php
	if($product_info['products_image'] != 'pixel_trans.gif') {
	$jest = './' . DIR_WS_IMAGES . $product_info['products_image'];
		if (!file_exists($jest)) {
			echo tep_image_midi(DIR_WS_IMAGES . $product_info['products_image'], addslashes($product_info['products_name']), DISPLAY_IMAGE_WIDTH, DISPLAY_IMAGE_HEIGHT, 'hspace="5" vspace="5"').'<br />';
		} else {
?>
	<a href="<?php echo DIR_WS_IMAGES . $product_info['products_image']; ?>" rel="lightbox[<?php echo $product_info['products_id'];?>]" title="<?php echo str_replace('"','``',$product_info['products_name']); ?>"><?php echo tep_image_midi(DIR_WS_IMAGES . $product_info['products_image'], addslashes($product_info['products_name']), DISPLAY_IMAGE_WIDTH, DISPLAY_IMAGE_HEIGHT, 'hspace="5" vspace="5"').'<br />'.tep_image_t('gfx/icon_enlarge.gif').'</a>';?>
<?php
	}
} else {
?>
	<script type="text/javascript">
	<!--
		document.write('<?php echo '<a href="javascript:popupWindow(\\\'' . tep_href_link(FILENAME_POPUP_IMAGE, 'pID=' . $product_info['products_id']) . '\\\')">' . 	tep_image_midi(DIR_WS_IMAGES . $product_info['products_image'], addslashes($product_info['products_name']), 1, 1, 'hspace="1" vspace="1"').'<br />'.tep_image_t('gfx/icon_enlarge.gif').'</a>'; ?>');
	//-->
	</script>
	<noscript>
		<?php echo '<a href="' . tep_href_link(DIR_WS_IMAGES . $product_info['products_image_pop']) . '" target="_blank">' . tep_image(DIR_WS_IMAGES . $product_info['products_image_pop'], $product_info['products_name'], DISPLAY_IMAGE_WIDTH*1.5, DISPLAY_IMAGE_HEIGHT*1.5, 'hspace="5" vspace="5"') . '<br />'.tep_image_t('gfx/icon_enlarge.gif').'</a>'; ?>
	</noscript>	
<?php
}

?>
<br /><br />

		</td>
		<td class="pageHeadingProduct" valign="middle" align="right">
<?php
#######################
## tabelka produktu BOF

##
## budowa struktury danych BOF
##

## gwarancja 

  $gwarancja_query = tep_db_query("select ptpef.products_id, ptpef.products_extra_fields_value from " . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . " ptpef where ptpef.products_id = '".$product_info['products_id']."' and ptpef.products_extra_fields_id = '29'");
  $gwarancja = tep_db_fetch_array($gwarancja_query);
  if($gwarancja['products_extra_fields_value']) {
	$gwarancja_opis = explode(':', $gwarancja['products_extra_fields_value']);
	if($gwarancja_opis[1]=='p') $gwarancja_opis[1] = 'producenta : ';
	$czas_gwarancji = $gwarancja_opis[1] .$gwarancja_opis[0].(is_numeric($gwarancja_opis[0])?(($gwarancja_opis[0]=='24')?' m-ce':' m-cy'):'');	
  }

## opinia

	$reviews_query = tep_db_query("select count(*) as count from " . TABLE_REVIEWS . " where products_id = '" . (int)$product_info['products_id'] . "'");
	$reviews = tep_db_fetch_array($reviews_query);
	$reviews_query_average = tep_db_query("select (avg(reviews_rating)) as average_rating from " . TABLE_REVIEWS . " where products_id = '" . (int)$product_info['products_id'] . "' AND approved = '1'");
	$reviews_average = tep_db_fetch_array($reviews_query_average);
	$reveiws_stars = $reviews_average['average_rating'];
	$reveiws_rating = number_format($reveiws_stars,0);

##
## budowa struktury danych EOF
##

		$st_lvl = 'low';
		if($product_info['products_quantity'] <= STOCK_LEVEL_NONE) $st_lvl = 'none';
		if($product_info['products_quantity'] >= STOCK_LEVEL_LOW) $st_lvl = 'low';
		if($product_info['products_quantity'] >= STOCK_LEVEL_MEDIUM) $st_lvl = 'medium';
		if($product_info['products_quantity'] >= STOCK_LEVEL_HIGH) $st_lvl = 'high';

?>
			 <table border="0" cellspacing="2" cellpadding="4" width="260" class="smallText" align="right">
				<tr>
					<td class="PId">Cena <?php echo ((DISPLAY_PRICE_WITH_TAX == 'true')? 'brutto':'netto'); ?>:</td>
					<td class="PId" align="right"><span class="cenaBig"><?php echo $products_price; ?></span></td>
				</tr>
				<tr>
					<td class="PIl">Dostêpno¶æ:</td>
					<td class="PIl" align="right"><?php echo tep_image_t('gfx/stock_'.$st_lvl.'.png')?></td>
				</tr>
				<tr>
					<td class="PId">Producent:</td>
					<td class="PId" align="right"><?php echo $producent; ?></td>
				</tr>
<?php
    $products_attributes_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$HTTP_GET_VARS['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "'");
    $products_attributes = tep_db_fetch_array($products_attributes_query);
    if ($products_attributes['total'] > 0) {
?>
<?php
      $products_options_name_query = tep_db_query("select distinct popt.products_options_id, popt.products_options_name from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$HTTP_GET_VARS['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "' order by popt.products_options_name");
      while ($products_options_name = tep_db_fetch_array($products_options_name_query)) {
        $products_options_array = array();
        $products_options_query = tep_db_query("select pov.products_options_values_id, pov.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pa.options_id = '" . (int)$products_options_name['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . (int)$languages_id . "' order by pa.attribute_sort");
        while ($products_options = tep_db_fetch_array($products_options_query)) {
          $products_options_array[] = array('id' => $products_options['products_options_values_id'], 'text' => $products_options['products_options_values_name']);
          if ($products_options['options_values_price'] != '0') {
            $products_options_array[sizeof($products_options_array)-1]['text'] .= ' (' . $products_options['price_prefix'] . $currencies->display_price($product_info['products_id'], $products_options['options_values_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) .') ';
          }
        }

        if (isset($cart->contents[$HTTP_GET_VARS['products_id']]['attributes'][$products_options_name['products_options_id']])) {
          $selected_attribute = $cart->contents[$HTTP_GET_VARS['products_id']]['attributes'][$products_options_name['products_options_id']];
        } else {
          $selected_attribute = false;
        }
?>
				<tr>
					<td class="PIl"><?php echo $products_options_name['products_options_name'] . ':'; ?></td>
					<td class="PIl" align="right"><?php echo tep_draw_pull_down_menu('id[' . $products_options_name['products_options_id'] . ']', $products_options_array, $selected_attribute,'style="width: 110px;"'); ?></td>
				</tr>
<?php
      }
	} else {
?>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
<?php
	}
?>
				<tr>
					<td class="PId">Gwarancja:</td>
					<td class="PId" align="right"><?php echo ($czas_gwarancji)?$czas_gwarancji:'nie dotyczy'; ?></td>
				</tr>
				<tr>
					<td class="PIl">Opinia:</td>
					<td class="PIl" align="right"><?php echo tep_image_t('stars_' . $reveiws_rating . '.gif'); ?></td>
				</tr>
				<tr>
					<td class="PId">Aktualizacja:</td>
					<td class="PId" align="right"><?php echo ($product_info['products_last_modified'])?$product_info['products_last_modified']:$product_info['products_date_added']; ?></td>
				</tr>

				<tr>
					<td class="smallText" align="left"><?php
						echo tep_image_submit('button_wishlist.gif', 'Dodaj do schowka', 'name="wishlist" value="wishlist" style="border: 2px solid #FFF;"');
					?></td>
					<td class="smallText" align="right"><?php echo tep_draw_hidden_field('products_id', $product_info['products_id']) . tep_image_submit('button_in_cart.gif'); ?></td>
				</tr>
			</table></td></tr>

			</table>
		</div></td>
	  </tr>
	 </table>

				</td>
			</tr>
			<tr>
				<td class="smalltext">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="tabelka">

<!-- begin tab pane //-->
<?php
$images_product = tep_db_query("SELECT additional_images_id, products_id, images_description, popup_images FROM " . TABLE_ADDITIONAL_IMAGES . " WHERE products_id = '" . (int)$product_info['products_id'] . "'");
  if (tep_db_num_rows($images_product)) {
	$dodatkowe_zdjecia = '<newtab><tabname>Zdjêcia</tabname><tabpage>includes/modules/additional_images.php</tabpage></newtab>';
  } else {
	$dodatkowe_zdjecia = '';  
  }
// ilosc recenzji

    $reviews_query = tep_db_query("select count(*) as count from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd where r.approved = '1' AND r.products_id = '" . (int)$product_info['products_id'] . "' and r.reviews_id = rd.reviews_id and rd.languages_id = '" . (int)$languages_id . "'");
    $reviews = tep_db_fetch_array($reviews_query);
    if ($reviews['count'] > 0) {
		$opinie ='';
		$opinie = ' <span style="font-weight: normal;">['.$reviews['count'].']</span>';
	}

	if($product_info['products_description']=='') {$product_info['products_description'] = ' ';}

	$opis_zakladka = '<div class="plr">'.$product_info['products_description'].$opcje_tabelka.'</div>';

	$product_description_string = '<newtab><tabname>Opis</tabname><tabtext>'.$opis_zakladka.'</tabtext></newtab>'.
//				'<newtab><tabname>Producent</tabname><tabpage>producent.php</tabpage></newtab>'.
				$dodatkowe_zdjecia . 
				'<newtab><tabname>Opinie'.$opinie.'</tabname><tabpage>recenzje.php</tabpage></newtab>';
//				;
//				$PRT; // promocja razem taniej
//$product_description_string = $product_info['products_description'];
$tab_array = preg_match_all ("|<newtab>(.*)</newtab>|Us", $product_description_string, $matches, PREG_SET_ORDER); // <new_tab>

if ($tab_array){ ?>
<div class="tab-pane" id="tabPane1" style="background-position: top; background-repeat: repeat-x; width: 99.6%;">

<script type="text/javascript">
tp1 = new WebFXTabPane( document.getElementById( "tabPane1" ) );
//tp1.setClassNameTag( "dynamic-tab-pane-control-luna" );
//alert( 0 )
</script>
<?php
for ($i=0, $n=sizeof($matches); $i<$n; $i++) {
	$this_tab_name = preg_match_all ("|<tabname>(.*)</tabname>|Us", $matches[$i][1], $tabname, PREG_SET_ORDER);
	if ($this_tab_name){
		echo '<div class="tab-page" id="tabPage' . $i . '">' .
		'<h2 class="tab">' . $tabname[0][1] . '</h2>' .
		'<script type="text/javascript">tp1.addTabPage(document.getElementById("tabPage' . $i . '"));</script>';
?>
		<table border="0" cellspacing="0" cellpadding="2" width="100%">
		<tr>
		<td width="100%" class="smallText">
<?php
		if (preg_match_all ("|<tabpage>(.*)</tabpage>|Us", $matches[$i][1], $tabpage, PREG_SET_ORDER)){
			require($tabpage[0][1]);
		}elseif (preg_match_all ("|<tabtext>(.*)</tabtext>|Us", $matches[$i][1], $tabtext, PREG_SET_ORDER)){
			echo '<div class="boxTextMain">' . $tabtext[0][1] . '</div><br>';
		}
		echo '</td></tr></table></div>';
	}
}

?>

<table border="0" width="100%">

<?php
    if ($product_info['products_date_available'] > date('Y-m-d H:i:s')) {
?>
      <tr>
        <td class="clear"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td align="center" class="cm" colspan="3"><span class="smallText"><?php echo sprintf(TEXT_DATE_AVAILABLE, tep_date_long($product_info['products_date_available'])); ?></span></td>
      </tr>
<?php
    } else {
	/*

      echo '<tr>
        <td align="center" class="smallText" style="background: #FFF;">&nbsp;</td>
      </tr>';
//sprintf(TEXT_DATE_ADDED, tep_date_long($product_info['products_date_added'])).'
*/
    }
?>

	<tr>
		<td class="buttons" align="left" width="10%"><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO,'products_id='.(int)$product_info['products_id'])?>#top"><?php echo tep_image_button('button_top.gif'); ?></a></td>
		<td class="buttons" align="left" width="50%"><a href="javascript:history.back();"><?php echo tep_image_button('button_back2.gif'); ?></a></td>
        <td class="buttons" align="right" width="20%"><?php
			echo tep_draw_hidden_field('products_id', $product_info['products_id']);
			echo tep_image_submit('button_wishlist.gif', 'Do schowka', 'name="wishlist" value="wishlist"');
		?></td>
		<td class="buttons" align="right" width="20%"><?php echo tep_draw_hidden_field('products_id', $product_info['products_id']) . tep_image_submit('button_in_cart.gif'); ?></td>
	</tr>
</table>

<?php
echo '</div>';
}else{
?>
<!-- End Tab Pane //-->
<p><?php echo stripslashes($product_info['products_description']); ?></p>
<?php
}	
?>
		</td>
      </tr>

      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
			
	  <tr>
		<td class="smalltext" colspan="2" style="padding-top: 10px;"><?php 
			include(DIR_WS_MODULES.'family_products.php');
		?></td>
	  </tr>

<?php

// produkty powiazane
   if ( (USE_CACHE == 'true') && !$SID) {
     include(DIR_WS_MODULES . FILENAME_XSELL_PRODUCTS);
   } else {
	 include(DIR_WS_MODULES . FILENAME_XSELL_PRODUCTS);
   }
//
?>

      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>

      <tr>
        <td>
<?php
    if ((USE_CACHE == 'true') && empty($SID)) {
      echo tep_cache_also_purchased(3600);
    } else {
      include(DIR_WS_MODULES . FILENAME_ALSO_PURCHASED_PRODUCTS);
    }
  }
?>
        </td>
      </tr>

    </table></form></td>

<!-- body_text_eof //-->
<?php include('includes/footer_0.php'); ?>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->

<script type="text/javascript">
//<![CDATA[

setupAllTabs();

//]]>
</script>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>