<?
/*
  $Id: napraw_produkty.php,v 1.1 2007/01/15 15:42:00 HoL Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
  using Emmett script - www.vn2designs.com
*/

  $action = (isset($HTTP_POST_VARS['action']) ? $HTTP_POST_VARS['action'] : '');
  $kategoria = (isset($HTTP_POST_VARS['kategoria']) ? $HTTP_POST_VARS['kategoria'] : '');



 require('includes/application_top.php');

  if (tep_not_null($action)) {


switch($action)
	  {

case TXT_DEL : 

	        if (isset($HTTP_POST_VARS['prod_id'])) {
          $product_id = tep_db_prepare_input($HTTP_POST_VARS['prod_id']);

            $delimg_query = tep_db_query("select popup_images from " . TABLE_ADDITIONAL_IMAGES . " where products_id = '" . (int)$product_id . "'");
            while ($delimg = tep_db_fetch_array($delimg_query)){
                if (tep_not_null($delimg['popup_images']) && file_exists(DIR_FS_CATALOG_IMAGES.$delimg['popup_images']) )
                  if (!unlink (DIR_FS_CATALOG_IMAGES.$delimg['popup_images']))
                     $messageStack->add_session(ERROR_DEL_IMG_XTRA.$delimg['popup_images'], 'error');
                  else
                     $messageStack->add_session(SUCCESS_DEL_IMG_XTRA.$delimg['popup_images'], 'success');
            }
            tep_db_query("delete from " . TABLE_ADDITIONAL_IMAGES . " where products_id = '" . (int)$product_id . "'");
            tep_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$product_id. "'");
            tep_db_query("delete from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id. "'");
            tep_db_query("delete from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$product_id. "'");
            tep_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int)$product_id. "'");

          $product_categories_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$product_id . "'");
          $product_categories = tep_db_fetch_array($product_categories_query);

          if ($product_categories['total'] == '0') {
            tep_remove_product($product_id);
          }
        }

        if (USE_CACHE == 'true') {
          tep_reset_cache_block('categories');
          tep_reset_cache_block('also_purchased');
        }

 $messageStack->add(DEL_SUCCESS, 'success');


break;

case TXT_SWITCH : 

        if (isset($HTTP_POST_VARS['prod_id'])) {

        $product_id = tep_db_prepare_input($HTTP_POST_VARS['prod_id']);
		
		$querry = "INSERT INTO  " . TABLE_PRODUCTS_TO_CATEGORIES . "  SET `products_id` = " . $product_id . ", `categories_id` = " . $kategoria . ";";
		tep_db_query($querry);

 $messageStack->add(SWITCH_SUCCESS, 'success');

		}
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

<style>
<!--
.button { border: 1px #ccc solid; background: #eee; }
-->
</style>

</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
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
        <td>

<br>
<!-- <table cellspacing="0" cellpadding="4" border="1" align="center"> -->

<TABLE BORDER=0 CELLPADDING=5 CELLSPACING=1 style="border: 1px solid #CCC;">
<TR class="dataTableHeadingRow" bgcolor=silver>
<th class="dataTableHeadingContent"><?php echo TXT_ID; ?></td>
<th class="dataTableHeadingContent"><?php echo TXT_NAZWA; ?></td>
<th class="dataTableHeadingContent"><?php echo TXT_AKCJA_1; ?></td>
<th class="dataTableHeadingContent"><?php echo TXT_KATEGORIA; ?></td>
<th class="dataTableHeadingContent"><?php echo TXT_AKCJA_2; ?></td>
</tr>

<?
$nl = "\n";

// produkty bez nazwy
	$p_array = array();
	$p_error_query = tep_db_query("select products_id, products_model from " . TABLE_PRODUCTS . " order by products_id");
	while (  $results = tep_db_fetch_array($p_error_query)) {
		$p_array[] = $results['products_id'];
		$model[$results['products_id']] = $results['products_model'];
	}
	
	$pd_array = array();
	$pd_error_query = tep_db_query("select products_id, products_name from " . TABLE_PRODUCTS_DESCRIPTION . " WHERE language_id = '".(int)$languages_id."' order by products_id");
	while ( $results = tep_db_fetch_array($pd_error_query)) {
		$pd_array[] = $results['products_id'];
		$nazwa[$results['products_id']] = $results['products_name'];
	}

	$products_error = array();
	$products_error = array_diff($p_array, $pd_array);
	reset($products_error); 

	$licz=0;$co='';
	echo '<tr><td class="main" colspan="5" align="center" width="100%" style="background: #EEE; border: 1px solid #CCC;">Produkty bez nazwy</td></tr>';
	foreach($products_error as $pe) {
		$licz++;
		echo '<form method="post"><input type=hidden name=prod_id value=' . $products_error['products_id'] . '><tr>' . 
		'<td class="smalltext">' . $pe.' ['.$model[$pe].'] </td>' . 
		'<td class="smalltext"> '.$nazwa[$pe].' </td>' .
		'<td class="smalltext"><input class="button" type="submit" name="action" value="' . TXT_DEL . '"></td>' .
		'</tr></form>' . $nl ;
	}

	if($licz == 0) echo '<tr><td colspan="5" class="smalltext">' . TXT_BRAK . '</td><tr>';

// produkty bez kategorii


	$drzewo_kategorii = tep_get_category_tree(); // zapisanie do tablicy drzewka kategorii

	$p2c_array = array();
	$p2c_error_query = tep_db_query("select products_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " order by products_id");
	while ( $results = tep_db_fetch_array($p2c_error_query)) {
		$p2c_array[] = $results['products_id'];
	}
	
	$products_error = array();
	$products_error = array_diff($p_array, $p2c_array);
	reset($products_error); 

	$licz=0;$co='';
	echo '<tr><td class="main" colspan="5" align="center" width="100%" style="background: #EEE; border: 1px solid #CCC;">Produkty bez przypisanej kategorii</td></tr>';
	foreach($products_error as $pe) {
			$licz++;
			echo '<form method="post"><input type=hidden name=prod_id value=' . $pe . '><tr>' . 
			'<td class="smalltext">' . $pe.' ['.$model[$pe].'] </td>' . 
			'<td class="smalltext"> '.$nazwa[$pe].' </td>' .
			'<td class="smalltext"><input class="button" type="submit" name="action" value="' . TXT_DEL . '"></td>' .
			'<td class="smalltext">' . tep_draw_pull_down_menu('kategoria', $drzewo_kategorii, 0, '') . '</td>' .
			'<td class="smalltext"><input class="button" type="submit" name="action" value="' . TXT_SWITCH . '"></td>' .
			'</tr></form>' . $nl ;
	}
	if($licz == 0) echo '<tr><td colspan="5" class="smalltext">' . TXT_BRAK . '</td><tr>';

?>
</table>
		</td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
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
