<?php
/*
  $Id: shopping_cart.php,v 1.18 2003/02/10 22:31:06 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- shopping_cart //-->
          <tr>
            <td class="bgk"><div id="box_koszyk"><?php //BOX_HEADING_SHOPPING_CART

	echo '<div class="headPosW">'.BOX_HEADING_SHOPPING_CART.'</div>';

	$info_box_contents = array();
	$cart_contents_string = '';

	echo '<div id="fkosz">';
	echo TEXT_PRODUKTOW_W_KOSZYKU.'<b>'. $cart->count_contents() .' szt.</b><br />';

	if (((ALLOW_GUEST_TO_SEE_PRICES=='true') && !(tep_session_is_registered('customer_id'))) || ((tep_session_is_registered('customer_id')))) {
		echo TEXT_WARTOSC_ZAKUPOW. '<b>' . $currencies->format($cart->show_total()) . '</b><br />';		
	} else {
		echo TEXT_WARTOSC_ZAKUPOW . PRICES_LOGGED_IN_TEXT;
	}
	echo '</div>';
	
	echo '<div id="bkosz"><a href="' . tep_href_link(FILENAME_SHOPPING_CART) . '">' . tep_image_button('button_see_more.gif') . '</a>';
	echo ' &nbsp; &nbsp; &nbsp; &nbsp; <a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') .'">' . tep_image_button('button_checkout.gif', IMAGE_BUTTON_CHECKOUT) . '</a>';
	echo '</div></div>';
?>
            </td>
          </tr>

<!-- shopping_cart_eof //-->

	<tr><td class="sep"></td></tr>