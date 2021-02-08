<?php
/*
  $Id: wishlist.php,v 3.0  2005/04/20 Dennis Blake
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Released under the GNU General Public License
*/

/*******************************************************************
****** QUERY THE DATABASE FOR THE CUSTOMERS WISHLIST PRODUCTS ******
*******************************************************************/
  require_once(DIR_WS_LANGUAGES . $language . '/' . FILENAME_WISHLIST);


?>
<!-- wishlist //-->

          <tr>
            <td class="bgw"><div id="box_schowek"><?php //BOX_HEADING_SHOPPING_CART

	echo '<div class="headPosW">'.BOX_HEADING_SCHOWEK.'</div>';

	$info_box_contents = array();
	$cart_contents_string = '';

	echo '<div id="fkosz">';
	echo TEXT_PRODUKTOW_W_SCHOWKU.'<b>'. count($wishList->wishID) .' szt.</b><br />';

	if (((ALLOW_GUEST_TO_SEE_PRICES=='true') && !(tep_session_is_registered('customer_id'))) || ((tep_session_is_registered('customer_id')))) {
		echo TEXT_WARTOSC_SCHOWEK. '<b>' . $currencies->format($wishList->calculate_wishlist()) . '</b><br />';		
	} else {
		echo TEXT_WARTOSC_SCHOWEK . PRICES_LOGGED_IN_TEXT;
	}
	echo '</div>';

	echo '<div id="bkosz"><a href="' . tep_href_link(FILENAME_SHOPPING_CART) . '">' . tep_image_button('button_edit_wishlist.gif') . '</a>';
//	echo ' &nbsp; &nbsp; &nbsp; &nbsp; <a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') .'">' . tep_image_button('button_checkout.gif', IMAGE_BUTTON_CHECKOUT) . '</a>';
	echo '</div></div>';
?>

            </td>
          </tr>

<!-- wishlist_eof //-->

	<tr><td class="sep"></td></tr>
