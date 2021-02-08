<?php
/*
  $Id: Ship2Pay, v1.5 2005/01/07 00:00:00 gjw Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 Edwin Bekaert (edwin@ednique.com)

  Released under the GNU General Public License

  http://forums.oscommerce.com/viewtopic.php?t=36112
  
  http://www.oscommerce.com/community/contributions,1042
*/

  require('includes/application_top.php');
  require(DIR_WS_CLASSES . 'shipping.php');
  $cShip = new shipping2p;

  include('order_editor/shipping.php');
  $shipping_modules = new shipping;

  require(DIR_WS_CLASSES . 'payment.php');
  $cPay = new payment;
  if ($HTTP_GET_VARS['action']) {
    switch ($HTTP_GET_VARS['action']) {
      case 'insert':
        $shp_id = tep_db_prepare_input($HTTP_POST_VARS['shp_id']);
        if (isset($HTTP_POST_VARS['pay_ids'])){
          $pay_ids = tep_db_prepare_input(implode(";", $HTTP_POST_VARS['pay_ids']));
        }
        tep_db_query("insert into " . TABLE_SHIP2PAY . " (shipment, payments_allowed,status) values ('" . tep_db_input($shp_id) . "', '" . tep_db_input($pay_ids)."',0)");
        tep_redirect(tep_href_link(FILENAME_SHIP2PAY));
        break;
      case 'save':
        $s2p_id = tep_db_prepare_input($HTTP_GET_VARS['s2p_id']);
        $shp_id = tep_db_prepare_input($HTTP_POST_VARS['shp_id']);
        if (isset($HTTP_POST_VARS['pay_ids'])){
          $pay_ids = tep_db_prepare_input(implode(";", $HTTP_POST_VARS['pay_ids']));
        }
        tep_db_query("update " . TABLE_SHIP2PAY . " set payments_allowed = '" . tep_db_input($pay_ids) . "', shipment = '" . tep_db_input($shp_id) . "' where s2p_id = ". tep_db_input($s2p_id));
        tep_redirect(tep_href_link(FILENAME_SHIP2PAY, 'page=' . $HTTP_GET_VARS['page'] . '&s2p_id=' . $s2p_id));
        break;
      case 'deleteconfirm':
        $s2p_id = tep_db_prepare_input($HTTP_GET_VARS['s2p_id']);
        tep_db_query("delete from " . TABLE_SHIP2PAY . " where s2p_id = " . tep_db_input($s2p_id));
        tep_redirect(tep_href_link(FILENAME_SHIP2PAY, 'page=' . $HTTP_GET_VARS['page']));
        break;
      case 'disable':
        $shp_id = tep_db_prepare_input($HTTP_GET_VARS['s2p_id']);
        tep_db_query("update " . TABLE_SHIP2PAY . " set status = 0 where s2p_id = " . tep_db_input($shp_id));
        tep_redirect(tep_href_link(FILENAME_SHIP2PAY, 'page=' . $HTTP_GET_VARS['page'] . '&s2p_id=' . $s2p_id));
        break;
      case 'enable':
        $shp_id = tep_db_prepare_input($HTTP_GET_VARS['s2p_id']);
        tep_db_query("update " . TABLE_SHIP2PAY . " set status = 1 where s2p_id = " . tep_db_input($shp_id));
        tep_redirect(tep_href_link(FILENAME_SHIP2PAY, 'page=' . $HTTP_GET_VARS['page'] . '&s2p_id=' . $s2p_id));
        break;
    }
  }
  

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/general.js"></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_SHIPMENT; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PAYMENTS; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $s2p_query_raw = "select s2p_id, shipment, payments_allowed, status from " . TABLE_SHIP2PAY;
  $s2p_split = new splitPageResults($HTTP_GET_VARS['page'], MAX_DISPLAY_SEARCH_RESULTS, $s2p_query_raw, $s2p_query_numrows);
  $s2p_query = tep_db_query($s2p_query_raw);
  while ($s2p = tep_db_fetch_array($s2p_query)) {
    if (((!$HTTP_GET_VARS['s2p_id']) || (@$HTTP_GET_VARS['s2p_id'] == $s2p['s2p_id'])) && (!$trInfo) && (substr($HTTP_GET_VARS['action'], 0, 3) != 'new')) {
      $trInfo = new objectInfo($s2p);
    }

    if ( (is_object($trInfo)) && ($s2p['s2p_id'] == $trInfo->s2p_id) ) {
      echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . tep_href_link(FILENAME_SHIP2PAY, 'page=' . $HTTP_GET_VARS['page'] . '&s2p_id=' . $trInfo->s2p_id . '&action=edit') . '\'">' . "\n";
    } else {
      echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . tep_href_link(FILENAME_SHIP2PAY, 'page=' . $HTTP_GET_VARS['page'] . '&s2p_id=' . $s2p['s2p_id']) . '\'">' . "\n";
    }
?>
                <td class="dataTableContent">&nbsp;<?php echo $s2p['shipment']; ?></td>
                <td class="dataTableContent"><?php echo $cPay->GetModuleName($s2p['payments_allowed']); ?></td>
                <td class="dataTableContent" align="center">
                <?php
                      if ($s2p['status'] == '1') {
                        echo tep_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_SHIP2PAY, 'page=' . $HTTP_GET_VARS['page'] . '&s2p_id=' . $s2p['s2p_id'] . '&action=disable') . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
                      } else {
                        echo '<a href="' . tep_href_link(FILENAME_SHIP2PAY, 'page=' . $HTTP_GET_VARS['page'] . '&s2p_id=' . $s2p['s2p_id'] . '&action=enable') . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . tep_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
                      }
                ?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($trInfo)) && ($s2p['s2p_id'] == $trInfo->s2p_id) ) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . tep_href_link(FILENAME_SHIP2PAY, 'page=' . $HTTP_GET_VARS['page'] . '&s2p_id=' . $s2p['s2p_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
  }
?>
              <tr>
                <td colspan="5"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $s2p_split->display_count($s2p_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $HTTP_GET_VARS['page'], TEXT_DISPLAY_NUMBER_OF_PAYMENTS); ?></td>
                    <td class="smallText" align="right"><?php echo $s2p_split->display_links($s2p_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $HTTP_GET_VARS['page']); ?></td>
                  </tr>
<?php
  if (!$HTTP_GET_VARS['action']) {
?>
                  <tr>
                    <td colspan="5" align="right"><?php echo '<a href="' . tep_href_link(FILENAME_SHIP2PAY, 'page=' . $HTTP_GET_VARS['page'] . '&action=new') . '">' . tep_image_button('button_insert.gif', IMAGE_INSERT) . '</a>'; ?></td>
                  </tr>
<?php
  }
?>
                </table></td>
              </tr>
            </table></td>
<?php
  $heading = array();
  $contents = array();
  switch ($HTTP_GET_VARS['action']) {
    case 'new':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_SHP2PAY . '</b>');
      $contents = array('form' => tep_draw_form('s2p', FILENAME_SHIP2PAY, 'page=' . $HTTP_GET_VARS['page'] . '&action=insert'));
      $contents[] = array('text' => TEXT_INFO_INSERT_INTRO);
      $contents[] = array('text' => '<br>' . TEXT_INFO_SHIPMENT . '<br>' . $shipping_modules->shipping_select('name="shp_id"'));
      $contents[] = array('text' => '<br>' . TEXT_INFO_PAYMENTS . '<br>' . $cPay->payment_multiselect('name="pay_ids[]"'));
      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_insert.gif', IMAGE_INSERT) . '&nbsp;<a href="' . tep_href_link(FILENAME_SHIP2PAY, 'page=' . $HTTP_GET_VARS['page']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_SHP2PAY . '</b>');
      $contents = array('form' => tep_draw_form('s2p', FILENAME_SHIP2PAY, 'page=' . $HTTP_GET_VARS['page'] . '&s2p_id=' . $trInfo->s2p_id  . '&action=save'));
      $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);
      $contents[] = array('text' => '<br>' . TEXT_INFO_SHIPMENT . '<br>' . $shipping_modules->shipping_select('name="shp_id"',$trInfo->shipment));
      $contents[] = array('text' => '<br>' . TEXT_INFO_PAYMENTS . '<br>' . $cPay->payment_multiselect('name="pay_ids[]"', $trInfo->payments_allowed));
      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_update.gif', IMAGE_UPDATE) . '&nbsp;<a href="' . tep_href_link(FILENAME_SHIP2PAY, 'page=' . $HTTP_GET_VARS['page'] . '&s2p_id=' . $trInfo->s2p_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_SHP2PAY . '</b>');
      $contents = array('form' => tep_draw_form('s2p', FILENAME_SHIP2PAY, 'page=' . $HTTP_GET_VARS['page'] . '&s2p_id=' . $trInfo->s2p_id  . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br><b>' . $trInfo->shipment . ' >> ' . $cPay->GetModuleName($trInfo->payments_allowed) . '</b>');
      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . '&nbsp;<a href="' . tep_href_link(FILENAME_SHP2PAY, 'page=' . $HTTP_GET_VARS['page'] . '&s2p_id=' . $trInfo->s2p_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    default:
      if (is_object($trInfo)) {
        $heading[] = array('text' => '<b>' . $trInfo->shipment . '</b>');
        $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_SHIP2PAY, 'page=' . $HTTP_GET_VARS['page'] . '&s2p_id=' . $trInfo->s2p_id . '&action=edit') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_SHIP2PAY, 'page=' . $HTTP_GET_VARS['page'] . '&s2p_id=' . $trInfo->s2p_id . '&action=delete') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
        $contents[] = array('text' => '<br>' . TEXT_INFO_PAYMENTS_ALLOWED . '<br><b>' . $cPay->GetModuleName($trInfo->payments_allowed) .'</b>');
      }
      break;
  }

  if ( (tep_not_null($heading)) && (tep_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
?>
          </tr>
        </table></td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
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