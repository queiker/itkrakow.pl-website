<?php
/*
  $Id: invoice.php,v 1.4 2003/02/16 15:42:33 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
  }

  if (!isset($HTTP_GET_VARS['oID']) || (isset($HTTP_GET_VARS['oID']) && !is_numeric($HTTP_GET_VARS['oID']))) {
    tep_redirect(tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
  }
  
  $customer_info_query = tep_db_query("select customers_id from " . TABLE_ORDERS . " where orders_id = '". (int)$HTTP_GET_VARS['oID'] . "'");
  $customer_info = tep_db_fetch_array($customer_info_query);
  if ($customer_info['customers_id'] != $customer_id) {
    tep_redirect(tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
  }

  require('includes/languages/polish/invoice.php');

//  require(DIR_WS_CLASSES . 'currencies.php');
//  $currencies = new currencies();

  $oID = tep_db_prepare_input($HTTP_GET_VARS['oID']);
  $orders_query = tep_db_query("select orders_id from " . TABLE_ORDERS . " where orders_id = '" . tep_db_input($oID) . "'");
  $czas = date("Y-m-d");
  $aNow = localtime();
  $godzina =  $aNow[2];
  $minuta = $aNow[1];
  $sekunda = $aNow[0];
  $data = $czas." ".$godzina.":".$minuta.":".$sekunda;
  $czas = $godzina.":".$minuta.":".$sekunda;

  include(DIR_WS_CLASSES . 'order.php');
  $order = new order($oID);
?>
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title>Zamówienie z³o¿one</title>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<link rel="stylesheet" type="text/css" href="stylesheet_faktura.css">
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">

<!-- body_text //-->
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
    <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td class="pageHeading">&nbsp;</td>
        <td class="pageHeading" align="right"><?php echo MODULE_PAYMENT_BANKTRANSFER_ACCNAM . '<br />' .MODULE_PAYMENT_BANKTRANSFER_BANKNAM . '<br />' .MODULE_PAYMENT_BANKTRANSFER_ACCNUM; ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td colspan="2"><?php echo tep_draw_separator(); ?></td>
      </tr>
	  <tr>
<td class="main" align="center"><b>Data wystawienia: </b><?php echo strftime(DATE_FORMAT_LONG).' ';//.$czas; ?></td> 
<td class="main" align="center"><b>Data sprzeda¿y: </b><?php echo strftime(DATE_FORMAT_LONG).' ';//.$czas; ?></td>
	  </tr>
          <tr>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '30'); ?></td>
          </tr>
<tr> 
<td class="pageHeading" colspan="2" align="center"><b>Zamówienie nr  </b> <?php echo tep_db_input($oID).'/' . substr(date("Y"),2,4); ?><br /><br /></td>
</tr> 
      <tr>
        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
		    <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '5'); ?>
            <td class="main"><b><?php echo'SPRZEDAWCA:'; ?></b></td>
          </tr>
          <tr>
		    <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '5'); ?>
            <td class="main"><?php echo nl2br(STORE_NAME_ADDRESS); ?></td>
          </tr>
        </table></td>
        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
		  	 <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '5'); ?>
            <td class="main"><b><?php echo 'NABYWCA';//ENTRY_SOLD_TO; ?></b></td>
          </tr>
          <tr>
		  	<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '5'); ?>
            <td class="main"><?php echo tep_address_format($order->customer['format_id'], $order->customer, 1, '&nbsp;', '<br>'); ?></td>
          </tr>
          <tr>
			<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '5'); ?>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '5'); ?></td>
          </tr>
          <tr>
		  	<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '5'); ?>
            <td class="main"><?php echo $order->customer['telephone']; ?></td>
          </tr>
          <tr>
		  	<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '5'); ?>
            <td class="main"><?php echo '<a href="mailto:' . $order->customer['email_address'] . '"><u>' . $order->customer['email_address'] . '</u></a>'; ?></td>
          </tr>
        </table></td>
<!--        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><b><?php echo ENTRY_SHIP_TO; ?></b></td>
          </tr>
          <tr>
            <td class="main"><?php echo tep_address_format($order->delivery['format_id'], $order->delivery, 1, '&nbsp;', '<br>'); ?></td>
          </tr>
        </table></td>
//-->
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
  </tr>
  <tr>
    <td><table border="0" cellspacing="0" cellpadding="2">
	<?php 
// BOF: WebMakers.com Added: Show Order Info 
?> 

 
<?php 
// EOF: WebMakers.com Added: Show Order Info 
?> 
      <tr>
        <td class="main"><b><span style="font-family: verdana;"><?php echo 'Termin p³atno¶ci:'; ?></span></b></td>
        <td class="main"><?php echo '7 dni'; ?></td>
      </tr>
	  <tr>
        <td class="main"><b><?php echo 'Forma p³atno¶ci:'; ?></b></td>
        <td class="main"><?php echo $order->info['payment_method']; ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
  </tr>
  <tr>
    <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr class="dataTableHeadingRow">
        <td class="dataTableHeadingContent" colspan="2"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
        <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS_MODEL; ?></td>
        <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TAX; ?></td>
        <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRICE_EXCLUDING_TAX; ?></td>
        <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRICE_INCLUDING_TAX; ?></td>
        <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TOTAL_EXCLUDING_TAX; ?></td>
        <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TOTAL_INCLUDING_TAX; ?></td>
      </tr>
<?php
    for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {
      echo '      <tr class="dataTableRow">' . "\n" .
           '        <td class="dataTableContent" valign="top" align="right">' . $order->products[$i]['qty'] . '&nbsp;x</td>' . "\n" .
           '        <td class="dataTableContent" valign="top">' . $order->products[$i]['name'];

      if (($k = sizeof($order->products[$i]['attributes']) > 0)) {
        for ($j = 0; $j < $k; $j++) {
          echo '<br><nobr><small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'];
          if ($order->products[$i]['attributes'][$j]['price'] != '0') echo ' (' . $order->products[$i]['attributes'][$j]['prefix'] . $currencies->format($order->products[$i]['attributes'][$j]['price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . ')';
          echo '</i></small></nobr>';
        }
      }

      echo '        </td>' . "\n" .
           '        <td class="dataTableContent" valign="top">' . $order->products[$i]['model'] . '</td>' . "\n";
      echo '        <td class="dataTableContent" align="right" valign="top">' . tep_display_tax_value($order->products[$i]['tax']) . '%</td>' . "\n" .
           '        <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format($order->products[$i]['final_price'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n" .
           '        <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format(tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n" .
           '        <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format($order->products[$i]['final_price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n" .
           '        <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format(tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']) * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n";
      echo '      </tr>' . "\n";
    }
?>
      <tr>
        <td align="right" colspan="8"><table border="0" cellspacing="0" cellpadding="2">
<?php
  for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++) {
    echo '          <tr>' . "\n" .
         '            <td align="right" class="smallText">' . $order->totals[$i]['title'] . '</td>' . "\n" .
         '            <td align="right" class="smallText">' . $order->totals[$i]['text'] . '</td>' . "\n" .
         '          </tr>' . "\n";
  }
?><br><br>
        </table></td>
      </tr>

    </table><br /><br /><br /><br /><br /><br /></td>
  </tr>
	  <tr>
	          <td class="boxText" align="right"><br><br><a href="#" onclick="window.print();return false"><span style="color:#0000CC" class ="main">Wydrukuj dane zamówienia</span></a></td>
	  </tr>
</table>
<!-- body_text_eof //-->

</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>