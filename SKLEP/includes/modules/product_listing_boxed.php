<?php
/*
  $Id: product_listing.php,v 1.44 2003/06/09 22:49:59 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  $listing_split = new splitPageResults($listing_sql, (MAX_DISPLAY_SEARCH_RESULTS*1.5), 'p.products_id');


  $list_box_contents = array();

  for ($col=1, $n=sizeof($column_list); $col<$n-2; $col++) {
    switch ($column_list[$col]) {
      case 'PRODUCT_LIST_MODEL':
        $lc_text = TABLE_HEADING_MODEL;
        $lc_align = '';
        break;
      case 'PRODUCT_LIST_NAME':
        $lc_text = TABLE_HEADING_PRODUCTS;
        $lc_align = '';
        break;
      case 'PRODUCT_LIST_MANUFACTURER':
        $lc_text = TABLE_HEADING_MANUFACTURER;
        $lc_align = '';
        break;
      case 'PRODUCT_LIST_PRICE':
        $lc_text = TABLE_HEADING_PRICE;
        $lc_align = 'right';
        break;
      case 'PRODUCT_LIST_QUANTITY':
        $lc_text = TABLE_HEADING_QUANTITY;
        $lc_align = 'right';
        break;
      case 'PRODUCT_LIST_WEIGHT':
        $lc_text = TABLE_HEADING_WEIGHT;
        $lc_align = 'right';
        break;

      case 'PRODUCT_LIST_BUY_NOW':
        $lc_text = TABLE_HEADING_BUY_NOW;
        $lc_align = 'center';
        break;
    }

    // Products Description Hack begins
    if ($column_list[$col] != 'PRODUCT_LIST_BUY_NOW' &&
        $column_list[$col] != 'PRODUCT_LIST_IMAGE' &&
        $column_list[$col] != 'PRODUCT_LIST_DESCRIPTION')
      $lc_text = tep_create_sort_heading($HTTP_GET_VARS['sort'], $col+1, $lc_text);
	  $sortowanie .= $lc_text.'&nbsp;&nbsp;';
    
  } 
    // Products Description Hack ends

  if ( ($listing_split->number_of_rows > 0) && ( (PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3') ) ) {
?>

<?php
  }
?>

<table cellspacing="0" cellpadding="0" border="0" width="100%">
	<tr>
		<td class="blrC" width="100%"><div class="catSep1"></div></td>
	</tr>
	<tr>
		<td width="100%">
<?php

  if ($listing_split->number_of_rows > 0) {
    $rows = 0;
	$row = 0;
	$col = 0; 
	$num = 0;
	$info_box_contents = array();
    $listing_query = tep_db_query($listing_split->sql_query);
    while ($listing = tep_db_fetch_array($listing_query)) {
		$rows++;
	    $num ++;
	    $listing['products_name'] = tep_get_products_name($listing['products_id']);

//TotalB2B start
    $listing['products_price'] = tep_xppp_getproductprice($listing['products_id']);

	if ($new_price = tep_get_products_special_price($listing['products_id'])) {
		$listing['specials_new_products_price'] = $new_price;
		$query_special_prices_hide = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " WHERE configuration_key = 'SPECIAL_PRICES_HIDE'");
		$query_special_prices_hide_result = tep_db_fetch_array($query_special_prices_hide); 
		if ($query_special_prices_hide_result['configuration_value'] == 'true') {
			$cena = '<span class="list_cena_spec">' . $currencies->display_price_nodiscount($listing['specials_new_products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</span>';
		} else {
			$cena = '<span class="cena_spec"><s>' .  $currencies->display_price($listing['products_id'], $listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s></span><br /><span class="list_cena_spec">' . $currencies->display_price_nodiscount($listing['specials_new_products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</span>';
		}
	} else {
		$cena = '<span class="list_cena">' . $currencies->display_price($listing['products_id'], $listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</span>';
	}
//TotalB2B end

        $info_box_contents[$row][$col] = array('align' => 'left',
                                               'params' => '  class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" width="50%" valign="top" '.($col==0?'style="border-right: 1px solid #DEDEDE;"':''),

                                               'text' => ($row>0?tep_image_t('gfx/sep_box3.gif'):'').'<table border="0" width="100%" cellspacing="0" cellpadding="5" ><tr ><td class="infoBoxContents" colspan="2" align="left"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$listing['products_id']) . '" class="linkP">'.'' . $listing['products_name'] . '</a></td></tr><tr><td style="height:'.(SMALL_IMAGE_HEIGHT+15).'px;" class="infoBoxContents" valign="middle" align="center" width="'.(SMALL_IMAGE_WIDTH+15).'">' . tep_image_mini(DIR_WS_IMAGES.$listing['products_image'], $listing['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT,' vspace="5" hspace="5"') . ' </td><td class="smalltext" align="center" valign="middle"><span class="cenaBig">'.$cena.'</span><br /><br /><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$listing['products_id']) . '" >'.tep_image_button('button_more.gif', $listing['products_name']).'</a> &nbsp; <a href="' . tep_href_link(basename($PHP_SELF), 'products_id=' . $listing['products_id'].'&action=add_wishlist', 'NONSSL') . '">' . tep_image_button('button_wishlist_small.gif', TEXT_BUY . $listing['products_name'] . TEXT_NOW) . '</a><br><a href="' . tep_href_link(basename($PHP_SELF), 'products_id=' . $listing['products_id'].'&action=buy_now', 'NONSSL') . '">' . tep_image_button('button_buy_now.gif', TEXT_BUY . $listing['products_name'] . TEXT_NOW) . '</a></td></tr></table>');
	    $col ++;
	    if ($col >= 2) {
	      $col = 0;
	      $row ++;
	    } 
	  }

    new contentBox($info_box_contents);
  }
?>
        </td>
      </tr>

    </table>
<?php
  if ( ($listing_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3')) ) {
?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
    <td class="smallText"><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></td>
    <td class="smallText" align="right"><?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
  </tr>
</table>
<?php
  }
?>