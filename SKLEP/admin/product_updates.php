<?php
/*
  $Id: product_updates.php,v 1.1 2005/02/12 Exp $

  osCommerce
  http://www.oscommerce.com

  Copyright (c) 2005

  Released under the GNU General Public License\
*/

  require('includes/application_top.php');

  reset($HTTP_GET_VARS);
  foreach($HTTP_GET_VARS as $key => $value) {
	if(!is_array($key)) {
		$$key = $value;
	}
  }

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();
  $action = (isset($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : '');

  if ($HTTP_GET_VARS['action'] == 'update') {
    foreach ($_POST['event_record'] as $id => $row) {
    tep_db_query("UPDATE " . TABLE_PRODUCTS . " SET products_price = '" . tep_db_prepare_input($row['products_price']) . "', products_weight = '" . tep_db_prepare_input($row['products_weight']) . "', products_quantity = '" . tep_db_prepare_input($row['products_quantity']) . "' where products_id = '" . (int)tep_db_prepare_input($row['products_id']) . "'");
    $products_updated = true;
    }
      if ($products_updated == true) {
        $messageStack->add_session(SUCCESS_PRODUCTS_UPDATED, 'success');
      } else {
        $messageStack->add_session(WARNING_PRODUCTS_NOT_UPDATED, 'warning');
      }
    tep_redirect(tep_href_link(FILENAME_PRODUCT_UPDATES));
  }

  if ($HTTP_GET_VARS['action'] == 'export') {
   $csv_output = TABLE_HEADING_PRODUCT_ID . "," . TABLE_HEADING_PMAN . "," . TABLE_HEADING_PNAME . "," . TABLE_HEADING_PMODEL . "," . TABLE_HEADING_PPRICE . "," . TABLE_HEADING_PWEIGHT . "," . TABLE_HEADING_PQTY;
   $csv_output .= "\n";
   $csv_query = tep_db_query("select p.products_id, p.manufacturers_id, p.products_quantity, p.products_price, p.products_weight, p.products_model, pd.products_name, m.manufacturers_id, m.manufacturers_name from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p LEFT JOIN " . TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id  where p.products_id = pd.products_id group by pd.products_name order by pd.products_name ASC");
      while ($csv = tep_db_fetch_array($csv_query)) {
       $csv_output .= $csv['products_id'] . "," . $csv['manufacturers_name'] . "," . $csv['products_name'] . "," . $csv['products_model'] . "," . $currencies->format($csv['products_price']) . "," . $csv['products_weight'] . "," . $csv['products_quantity'] . "\n";
      }
   $saveas = 'product_stock-price_report_' . strftime("%m-%d-%Y");
   header("Content-Disposition: attachment; filename=$saveas.csv");
   print $csv_output;
   exit;
  }
?>
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script type="text/javascript" language="javascript" src="includes/general.js"></script>
</head>
<body  bgcolor="#FFFFFF">
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
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2"><?php echo tep_draw_form('stockprice', FILENAME_PRODUCT_UPDATES, 'action=update', 'post'); ?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>

               <?php
          switch ($listing) {
          case "prod":
              $order = "p.products_id";
              break;
          case "prod-desc":
              $order = "p.products_id DESC";
              break;
          case "manu":
              $order = "m.manufacturers_name";
              break;
          case "manu-desc":
              $order = "m.manufacturers_name DESC";
              break;
          case "name":
              $order = "pd.products_name";
              break;
          case "name-desc":
              $order = "pd.products_name DESC";
              break;
		  case "model":
              $order = "p.products_model";
              break;
          case "model-desc":
              $order = "p.products_model DESC";
              break;
		  case "quantity":
              $order = "p.products_quantity";
              break;
          case "quantity-desc":
              $order = "p.products_quantity DESC";
              break;
		  case "weight":
              $order = "p.products_weight";
              break;
          case "weight-desc":
              $order = "p.products_weight DESC";
              break;
		  case "price":
              $order = "p.products_price";
              break;
          case "price-desc":
              $order = "p.products_price DESC";
              break;
          default:
              $order = "p.products_model ASC";
          }
          ?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><a href="<?php echo "$PHP_SELF?listing=prod"; ?>"><?php echo tep_image_button('ic_up.gif', ' Sortuj ' . TABLE_HEADING_PRODUCT_ID . ' --> A-B-C'); ?></a>&nbsp;<a href="<?php echo "$PHP_SELF?listing=prod-desc"; ?>"><?php echo tep_image_button('ic_down.gif', ' Sortuj ' . TABLE_HEADING_PRODUCT_ID . ' --> Z-X-Y'); ?></a><br><?php echo TABLE_HEADING_PRODUCT_ID; ?></td>
                <td class="dataTableHeadingContent"><a href="<?php echo "$PHP_SELF?listing=manu"; ?>"><?php echo tep_image_button('ic_up.gif', ' Sortuj ' . TABLE_HEADING_PMAN . ' --> A-B-C'); ?></a>&nbsp;<a href="<?php echo "$PHP_SELF?listing=manu-desc"; ?>"><?php echo tep_image_button('ic_down.gif', ' Sortuj ' . TABLE_HEADING_PMAN . ' --> Z-X-Y'); ?></a><br><?php echo TABLE_HEADING_PMAN; ?></td>
                <td class="dataTableHeadingContent"><a href="<?php echo "$PHP_SELF?listing=name"; ?>"><?php echo tep_image_button('ic_up.gif', ' Sortuj ' . TABLE_HEADING_PNAME . ' --> A-B-C'); ?></a>&nbsp;<a href="<?php echo "$PHP_SELF?listing=name-desc"; ?>"><?php echo tep_image_button('ic_down.gif', ' Sortuj ' . TABLE_HEADING_PNAME. ' --> Z-X-Y'); ?></a><br><?php echo TABLE_HEADING_PNAME; ?></td>
                <td class="dataTableHeadingContent"><a href="<?php echo "$PHP_SELF?listing=model"; ?>"><?php echo tep_image_button('ic_up.gif', ' Sortuj ' . TABLE_HEADING_PMODEL . ' --> A-B-C'); ?></a>&nbsp;<a href="<?php echo "$PHP_SELF?listing=model-desc"; ?>"><?php echo tep_image_button('ic_down.gif', ' Sortuj ' . TABLE_HEADING_PMODEL . ' --> Z-X-Y'); ?></a><br><?php echo TABLE_HEADING_PMODEL; ?></td>
                <td class="dataTableHeadingContent"><a href="<?php echo "$PHP_SELF?listing=weight"; ?>"><?php echo tep_image_button('ic_up.gif', ' Sortuj ' . TABLE_HEADING_PWEIGHT . ' --> A-B-C'); ?></a>&nbsp;<a href="<?php echo "$PHP_SELF?listing=weight-desc"; ?>"><?php echo tep_image_button('ic_down.gif', ' Sortuj ' . TABLE_HEADING_PWEIGHT . ' --> Z-X-Y'); ?></a><br><?php echo TABLE_HEADING_PWEIGHT; ?></td>
                <td class="dataTableHeadingContent"><a href="<?php echo "$PHP_SELF?listing=price"; ?>"><?php echo tep_image_button('ic_up.gif', ' Sortuj ' . TABLE_HEADING_PPRICE . ' --> A-B-C'); ?></a>&nbsp;<a href="<?php echo "$PHP_SELF?listing=price-desc"; ?>"><?php echo tep_image_button('ic_down.gif', ' Sortuj ' . TABLE_HEADING_PPRICE . ' --> Z-X-Y'); ?></a><br><?php echo TABLE_HEADING_PPRICE; ?></td>
                <td class="dataTableHeadingContent"><a href="<?php echo "$PHP_SELF?listing=quantity"; ?>"><?php echo tep_image_button('ic_up.gif', ' Sortuj ' . TABLE_HEADING_PQTY . ' --> A-B-C'); ?></a>&nbsp;<a href="<?php echo "$PHP_SELF?listing=quantity-desc"; ?>"><?php echo tep_image_button('ic_down.gif', ' Sortuj ' . TABLE_HEADING_PQTY . ' --> Z-X-Y'); ?></a><br><?php echo TABLE_HEADING_PQTY; ?></td>
              </tr>

<?php
  $countrows_query = tep_db_query("select * from " . TABLE_PRODUCTS . "");
  $countrows = tep_db_num_rows($countrows_query);
  $updates_raw = "select p.products_id, p.manufacturers_id, p.products_quantity, p.products_weight, p.products_price, p.products_model, pd.products_name, m.manufacturers_id, m.manufacturers_name from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p LEFT JOIN " . TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id where p.products_id = pd.products_id and language_id = '" . (int)$languages_id  . "' group by pd.products_name order by $order";
  $updates_split = new splitPageResults($HTTP_GET_VARS['page'], MAX_DISPLAY_SEARCH_RESULTS, $updates_raw, $countrows);
    $updates = tep_db_query($updates_raw);
      while ($row = tep_db_fetch_array($updates)) {
        $id = $row['products_id'];
        $updates_pman = $row['manufacturers_name'];
        $updates_pname = $row['products_name'];
        $updates_pmodel = $row['products_model'];
        $updates_pweight = $row['products_weight'];
        $updates_pprice = $row['products_price'];
        $updates_pqty = $row['products_quantity'];
?>
              <tr class="dataTableRow">
                <td class="dataTableContent"><?php echo $row['products_id'] . "<input type='hidden' name='event_record[" . $id . "][products_id]' value='".$id."'>"; ?></td>
                <td class="dataTableContent"><?php echo $row['manufacturers_name']; ?></td>
                <td class="dataTableContent"><?php echo '<a href="' . tep_catalog_href_link('product_info.php', 'products_id=' . $row['products_id']) . '">' . $row['products_name'] . '</a>'; ?></td>
                <td class="dataTableContent"><?php echo $row['products_model']; ?></td>
                <td class="dataTableContent"><?php echo tep_draw_input_field('event_record[' . $id . '][products_weight]', $row['products_weight'], 'size="6"'); ?></td>
                <td class="dataTableContent"><?php echo tep_draw_input_field('event_record[' . $id . '][products_price]', $row['products_price'], 'size="6"'); ?></td>
                <td class="dataTableContent"><?php echo tep_draw_input_field('event_record[' . $id . '][products_quantity]', $row['products_quantity'], 'size="6"'); ?></td>
              </tr>
<?php
  }
?>
              <tr>
                <td colspan="6"><?php echo tep_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
              </tr>
              <tr>
                <td colspan="3" align="left"><?php echo tep_image_submit('button_update.gif', IMAGE_UPDATE).tep_hide_session_id(); ?></form></td>
                <td colspan="3" align="right"><?php echo tep_draw_form('stockprice_report', FILENAME_PRODUCT_UPDATES, 'action=export', 'post'); ?><?php echo tep_image_submit('button_save.gif', IMAGE_SAVECSV).tep_hide_session_id(); ?></form></td>
              </tr>
              <tr>
                <td colspan="6"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="smallText" align="left" colspan="3"><?php echo $updates_split->display_count($countrows, MAX_DISPLAY_SEARCH_RESULTS, $HTTP_GET_VARS['page'], TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></td>
                <td class="smallText" align="right" colspan="3"><?php echo $updates_split->display_links($countrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $HTTP_GET_VARS['page'], tep_get_all_get_params(array('page', 'x', 'y', 'products_id'))); ?>&nbsp;</td>
              </tr>
            </table></td>
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
