<?php
/*
  $Id: checkout_success.php,v 1.49 2003/06/09 23:03:53 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

// if the customer is not logged on, redirect them to the shopping cart page
  if (!tep_session_is_registered('customer_id')) {
    tep_redirect(tep_href_link(FILENAME_DEFAULT));
  }

  if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'update')) {
    $notify_string = 'action=notify&';
    $notify = $HTTP_POST_VARS['notify'];

    if (!is_array($notify)) $notify = array($notify);
    for ($i=0, $n=sizeof($notify); $i<$n; $i++) {
      $notify_string .= 'notify[]=' . $notify[$i] . '&';
    }
    if (strlen($notify_string) > 0) $notify_string = substr($notify_string, 0, -1);

//    tep_redirect(tep_href_link(FILENAME_DEFAULT, $notify_string));
// Added a check for a Guest checkout and cleared the session - 030411 
	if (tep_session_is_registered('noaccount')) { 
		tep_session_destroy(); 
		tep_redirect(tep_href_link(FILENAME_DEFAULT, '', 'NONSSL')); 
	} else { 
//		tep_redirect(tep_href_link(FILENAME_DEFAULT, $notify_string, 'SSL')); 
		tep_redirect(tep_href_link(FILENAME_DEFAULT, '', 'SSL')); 
	}
}

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CHECKOUT_SUCCESS);


  $breadcrumb->add(NAVBAR_TITLE_1);
//  $breadcrumb->add(NAVBAR_TITLE_2); // PWA

  $global_query = tep_db_query("select global_product_notifications from " . TABLE_CUSTOMERS_INFO . " where customers_info_id = '" . (int)$customer_id . "'");
  $global = tep_db_fetch_array($global_query);

  if ($global['global_product_notifications'] != '1') {
    $orders_query = tep_db_query("select orders_id from " . TABLE_ORDERS . " where customers_id = '" . (int)$customer_id . "' order by date_purchased desc limit 1");
    $orders = tep_db_fetch_array($orders_query);

    $products_array = array();
    $products_query = tep_db_query("select products_id, products_name from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . (int)$orders['orders_id'] . "' order by products_name");
    while ($products = tep_db_fetch_array($products_query)) {
      $products_array[] = array('id' => $products['products_id'],
                                'text' => $products['products_name']);
    }
  }
// PWA:  Added a check for a Guest checkout and cleared the session - 030411 v0.71
  if (tep_session_is_registered('noaccount')) {
	$order_update = array('purchased_without_account' => '1');
	tep_db_perform(TABLE_ORDERS, $order_update, 'update', "orders_id = '" . (int)$orders['orders_id'] . "'");
//  tep_db_query("insert into " . TABLE_ORDERS . " (purchased_without_account) values ('1') where orders_id = '" . (int)$orders['orders_id'] . "'");
	tep_db_query("delete from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)tep_db_input($customer_id) . "'");
	tep_db_query("delete from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)tep_db_input($customer_id) . "'");
	tep_db_query("delete from " . TABLE_CUSTOMERS_INFO . " where customers_info_id = '" . (int)tep_db_input($customer_id) . "'");
	tep_db_query("delete from " . TABLE_CUSTOMERS_BASKET . " where customers_id = '" . (int)tep_db_input($customer_id) . "'");
	tep_db_query("delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " where customers_id = '" . (int)tep_db_input($customer_id) . "'");
	tep_db_query("delete from " . TABLE_WHOS_ONLINE . " where customer_id = '" . (int)tep_db_input($customer_id) . "'");
	tep_session_destroy();
  }
?>
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_TEMPLATES . $template . $language . '/stylesheet.css';?>">
</head>
<body>
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<?php include('includes/body.php'); ?>
    <td width="100%" valign="top"><?php echo tep_draw_form('order', tep_href_link(FILENAME_CHECKOUT_SUCCESS, 'action=update', 'SSL')); ?>

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
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="checkout_bar"><?php echo tep_image_t('gfx/checkout_ok.png'); ?></td>
            <td class="checkout_bar"><?php echo tep_image_t('gfx/checkout_ok.png'); ?></td>
            <td class="checkout_bar"><?php echo tep_image_t('gfx/checkout_ok.png'); ?></td>
            <td class="checkout_bar"><?php echo tep_image_t('gfx/checkout_finish.png'); ?></td>
          </tr>
          <tr>
            <td align="center" width="25%" class="checkoutBarTo"><?php echo CHECKOUT_BAR_DELIVERY; ?></td>
            <td align="center" width="25%" class="checkoutBarTo"><?php echo CHECKOUT_BAR_PAYMENT; ?></td>
            <td align="center" width="25%" class="checkoutBarTo"><?php echo CHECKOUT_BAR_CONFIRMATION; ?></td>
            <td align="center" width="25%" class="checkoutBarCurrent"><?php echo CHECKOUT_BAR_FINISHED; ?></td>
          </tr>
        </table></td>
      </tr>
	  <tr>
        <td><table border="0" width="100%" cellspacing="4" cellpadding="2">
          <tr>
            <td valign="top" align="center" class="main"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?>
				<?php
			    echo '<br>' . TEXT_CONTACT_STORE_OWNER;
				?>
	            <h3><?php echo TEXT_THANKS_FOR_SHOPPING; ?></h3>
            </td>
		</tr>
		<tr>
			<td colspan="2" class="main" align="center"><h3><?php echo TEXT_ORDER_ID . (int)$last_order . '/' . substr(date("Y"),2,4); ?></h3></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td align="right" class="main"><?php echo tep_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="checkout_bar"><?php echo tep_image_t('gfx/checkout_ok.png'); ?></td>
            <td class="checkout_bar"><?php echo tep_image_t('gfx/checkout_ok.png'); ?></td>
            <td class="checkout_bar"><?php echo tep_image_t('gfx/checkout_ok.png'); ?></td>
            <td class="checkout_bar"><?php echo tep_image_t('gfx/checkout_finish.png'); ?></td>
          </tr>
          <tr>
            <td align="center" width="25%" class="checkoutBarTo"><?php echo CHECKOUT_BAR_DELIVERY; ?></td>
            <td align="center" width="25%" class="checkoutBarTo"><?php echo CHECKOUT_BAR_PAYMENT; ?></td>
            <td align="center" width="25%" class="checkoutBarTo"><?php echo CHECKOUT_BAR_CONFIRMATION; ?></td>
            <td align="center" width="25%" class="checkoutBarCurrent"><?php echo CHECKOUT_BAR_FINISHED; ?></td>
          </tr>
        </table></td>
      </tr>
<?php if (DOWNLOAD_ENABLED == 'true') include(DIR_WS_MODULES . 'downloads.php'); ?>
    </table></form></td>
<!-- body_text_eof //-->
<?php include('includes/footer_0.php'); ?>
<!-- body_eof //-->

<!-- footer //-->
<?php
	tep_session_unregister('last_order');
	require(DIR_WS_INCLUDES . 'footer.php');
?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>