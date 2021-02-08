<?php
/*
  $Id: checkout_success.php,v 1.49 2003/06/09 23:03:53 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

  //michal.bajer@horyzont.net
  //2006-01-02,03
*/
  
  $u=$_SERVER['QUERY_STRING'];
  eregi('osCsid=(.*)',$u,$wynik);
  eregi('orders_id=(.*)\&',$u,$wynik1);
  eregi('languages_code=(.*)\?osCsid',$u,$wynik2);
  
  $_GET['orders_id']=$wynik1[1];
  $_GET['language_code']=$wynik2[1];
  $_GET['osCsid']=$wynik[1];
  
  
  
  require('includes/application_top.php');
  
  

// if the customer is not logged on, redirect them to the shopping cart page
  if (!tep_session_is_registered('customer_id')) {
    tep_redirect(tep_href_link(FILENAME_SHOPPING_CART));
  }


// load selected payment module
  require(DIR_WS_CLASSES . 'payment.php');
  $payment_modules = new payment($payment);

// load the selected shipping module
  require(DIR_WS_CLASSES . 'shipping.php');
  $shipping_modules = new shipping($shipping);

  require(DIR_WS_CLASSES . 'order.php');
  $order = new order;

  require(DIR_WS_CLASSES . 'order_total.php');
  $order_total_modules = new order_total;

  $order_totals = $order_total_modules->process();

  require(DIR_WS_LANGUAGES . $language . '/' . 'checkout_przelewy24.php');

  $languages_code=isset($HTTP_GET_VARS['languages_code'])&&strlen($HTTP_GET_VARS['languages_code'])>0?$HTTP_GET_VARS['languages_code']:'pl';
  

      $my_currency = 'PLN';

      $session_id=session_id();
      
      //print($order->info['total']."<br>");
      //print($currencies->get_value($my_currency));
      //exit;
//print(number_format(($order->info['total'] * $currencies->get_value($my_currency)), 2, ".", "")*100);
             $process_button_string = tep_draw_hidden_field('p24_session_id', $session_id) .
             tep_draw_hidden_field('p24_id_sprzedawcy', MODULE_PAYMENT_PRZELEWY24_ID) .
             tep_draw_hidden_field('p24_kwota', number_format(($order->info['total'] * $currencies->get_value($my_currency)), 2, ".", "")*100) .
             tep_draw_hidden_field('p24_opis', 'Zamowienie nr '.$HTTP_GET_VARS['orders_id'].', ' . $order->customer['firstname'] . ' ' . $order->customer['lastname'].', ' . date('Ymdhi').', '. STORE_NAME) .
             //tep_draw_hidden_field('p24_opis', 'TEST_ERR') .
             tep_draw_hidden_field('p24_return_url_ok', tep_href_link('przelewy24.php', '', 'SSL')) .
             tep_draw_hidden_field('p24_language', $languages_code) .
             tep_draw_hidden_field('p24_email', $order->customer['email_address']) .
             tep_draw_hidden_field('p24_klient', $order->delivery['firstname'] . ' ' . $order->delivery['lastname']) .
             tep_draw_hidden_field('p24_adres', $order->delivery['street_address']) .
             tep_draw_hidden_field('p24_miasto', $order->delivery['city']) .
             tep_draw_hidden_field('p24_kod', $order->delivery['postcode']) .
             tep_draw_hidden_field('p24_kraj', $order->delivery['country']['iso_code_2']) .
             tep_draw_hidden_field('p24_return_url_error', tep_href_link('przelewy24_error.php', '', 'SSL'))
             ;

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_TEMPLATES . $template . $language . '/stylesheet.css';?>">
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="3" cellpadding="3">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="0" cellpadding="2">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><?php echo tep_draw_form('order', 'https://secure.przelewy24.pl/index.php'); ?>

	<table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php
			$info_box_contents = array();
			$info_box_contents[] = array('text' => HEADING_TITLE);
			new infoBoxHeading($info_box_contents, true, true);
	  ?></td>
      </tr>
	</table>

	<table border="0" width="100%" cellspacing="0" cellpadding="0" class="blrb">
      <tr>
        <td><table border="0" width="100%" cellspacing="4" cellpadding="2">
          <tr>
            <td valign="top"><?php echo tep_image(DIR_WS_IMAGES . 'przelewy24_logo.gif', HEADING_TITLE); ?></td>
            <td valign="top" class="main"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?><br><?php echo TEXT_SUCCESS; ?><br><br>
            <h3><?php echo TEXT_THANKS_FOR_SHOPPING.TEXT_CONTINUE; ?></h3></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td align="right" class="main"><?php echo $process_button_string.tep_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td width="25%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="50%" align="right"><?php echo tep_draw_separator('pixel_silver.gif', '1', '5'); ?></td>
                <td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
              </tr>
            </table></td>
            <td width="25%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
            <td width="25%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
            <td width="25%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
                <td width="50%"><?php echo tep_image(DIR_WS_IMAGES . 'checkout_bullet.gif'); ?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="center" width="25%" class="checkoutBarFrom"><?php echo CHECKOUT_BAR_DELIVERY; ?></td>
            <td align="center" width="25%" class="checkoutBarFrom"><?php echo CHECKOUT_BAR_PAYMENT; ?></td>
            <td align="center" width="25%" class="checkoutBarFrom"><?php echo CHECKOUT_BAR_CONFIRMATION; ?></td>
            <td align="center" width="25%" class="checkoutBarCurrent"><?php echo CHECKOUT_BAR_FINISHED; ?></td>
          </tr>
        </table></td>
      </tr>
    </table></form></td>
<!-- body_text_eof //-->
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="0" cellpadding="2">
<!-- right_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_right.php'); ?>
<!-- right_navigation_eof //-->
    </table></td>
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
