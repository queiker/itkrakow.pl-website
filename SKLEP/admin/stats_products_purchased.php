<?php
/*
  $Id: stats_products_purchased.php,v 1.29 2003/06/29 22:50:52 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

	// Start Reset
//	$page = (isset($HTTP_GET_VARS['page']) ? $HTTP_GET_VARS['page'] : '1' ); 
  $resetPurchased = (isset($HTTP_GET_VARS['resetPurchased']) ? $HTTP_GET_VARS['resetPurchased'] : '');
  if (tep_not_null($resetPurchased)) {
    if ($resetPurchased < 1) {
			 // Reset ALL counts
			 tep_db_query("update " . TABLE_PRODUCTS . " set products_ordered = 0 where 1");
		} else {
			 // Reset selected product count
			 tep_db_query("update " . TABLE_PRODUCTS . " set products_ordered = 0 where products_id = $resetPurchased");
		}
	}
	// End Reset

// bof sort
	// remeber sort order when switching pages
  if (isset($HTTP_GET_VARS['purchasedSortOrder']))
  {
    $purchasedSortOrder = $HTTP_GET_VARS['purchasedSortOrder'];
    tep_session_register('purchasedSortOrder');
  }
  if (isset($HTTP_GET_VARS['page']))
  {
    $page = $HTTP_GET_VARS['page'];
    tep_session_register('page');
  }
  if(!isset($page)) $page = 1;

  switch ($purchasedSortOrder) 
  {
      case "name-asc":
          $sortOrderPurchased = "pd.products_name ASC, p.products_ordered DESC";
          break;
      case "name-desc":
          $sortOrderPurchased = "pd.products_name DESC, p.products_ordered DESC";
          break;
      case "purchased-asc":
          $sortOrderPurchased = "p.products_ordered ASC, pd.products_name ASC";
          break;
      case "purchased-desc":
          $sortOrderPurchased = "p.products_ordered DESC, pd.products_name ASC";
          break;
      default:
          $sortOrderPurchased = "p.products_ordered DESC, pd.products_name ASC";
  }
// eof sort
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/general.js"></script>
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
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_NUMBER; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS; ?>&nbsp;<a href="<?php echo tep_href_link(FILENAME_STATS_PRODUCTS_PURCHASED, 'purchasedSortOrder=name-asc&page=' . $page, 'NONSSL') . '">'.tep_image_button('ic_up.gif').'</a>'; ?>&nbsp;<a href="<?php echo tep_href_link(FILENAME_STATS_PRODUCTS_PURCHASED, 'purchasedSortOrder=name-desc&page=' . $page, 'NONSSL') . '">'.tep_image_button('ic_down.gif').'</a>'; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_PURCHASED; ?>&nbsp;<a href="<?php echo tep_href_link(FILENAME_STATS_PRODUCTS_PURCHASED, 'purchasedSortOrder=purchased-asc&page=' . $page, 'NONSSL') . '">'.tep_image_button('ic_up.gif').'</a>'; ?>&nbsp;<a href="<?php echo tep_href_link(FILENAME_STATS_PRODUCTS_PURCHASED, 'purchasedSortOrder=purchased-desc&page=' . $page, 'NONSSL') . '">'.tep_image_button('ic_down.gif').'</a>'; ?></td>
								<!-- Start Reset -->
                <td class="dataTableHeadingContent" align="center"><a href="<?php echo tep_href_link(FILENAME_STATS_PRODUCTS_PURCHASED, 'resetPurchased=0&page=' . $page . '&purchasedSortOrder='. $purchasedSortOrder, NONSSL) . '" style="color: yellow;">'.STATS_CLEAR_ALL.'</a>'; ?>&nbsp;</td>
								<!-- End Reset -->
              </tr>
<?php
  if (isset($HTTP_GET_VARS['page']) && ($HTTP_GET_VARS['page'] > 1)) $rows = $HTTP_GET_VARS['page'] * MAX_DISPLAY_SEARCH_RESULTS - MAX_DISPLAY_SEARCH_RESULTS;
  $products_query_raw = "select p.products_id, p.products_ordered, pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where pd.products_id = p.products_id and pd.language_id = '" . $languages_id. "' and p.products_ordered > 0 group by pd.products_id order by $sortOrderPurchased";
  $products_split = new splitPageResults($HTTP_GET_VARS['page'], MAX_DISPLAY_SEARCH_RESULTS, $products_query_raw, $products_query_numrows);

  //$rows = 0;
  $products_query = tep_db_query($products_query_raw);
  while ($products = tep_db_fetch_array($products_query)) {
    $rows++;

    if (strlen($rows) < 2) {
      $rows = '0' . $rows;
    }
?>
              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href='<?php echo tep_href_link(FILENAME_CATEGORIES, 'action=new_product_preview&read=only&pID=' . $products['products_id'] . '&origin=' . FILENAME_STATS_PRODUCTS_PURCHASED . '?page=' . $HTTP_GET_VARS['page'], 'NONSSL'); ?>'">
                <td class="dataTableContent"><?php echo $rows; ?>.</td>
                <td class="dataTableContent"><?php echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'action=new_product_preview&read=only&pID=' . $products['products_id'] . '&origin=' . FILENAME_STATS_PRODUCTS_PURCHASED . '?page=' . $HTTP_GET_VARS['page'], 'NONSSL') . '">' . $products['products_name'] . '</a>'; ?></td>
                <td class="dataTableContent" align="center"><?php echo $products['products_ordered']; ?>&nbsp;</td>
								<!-- Start Reset -->
                <td class="dataTableContent" align="center"><a href="<?php echo tep_href_link(FILENAME_STATS_PRODUCTS_PURCHASED, 'resetPurchased=' . $products['products_id'] . '&page=' . $page . '&purchasedSortOrder=' . $purchasedSortOrder) . '">'.tep_image(DIR_WS_IMAGES.'icon_reset.gif').'</a>'; ?>&nbsp;</td>
								<!-- End Reset -->
              </tr>
<?php
  }
?>
            </table></td>
          </tr>
          <tr>
            <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td class="smallText" valign="top"><?php echo $products_split->display_count($products_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $HTTP_GET_VARS['page'], TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></td>
                <td class="smallText" align="right"><?php echo $products_split->display_links($products_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $HTTP_GET_VARS['page']); ?>&nbsp;</td>
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
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
