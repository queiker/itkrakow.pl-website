<?php
/*
 $Id: popup_add_image.php,v 1.0 2003/02/28 dgw_ Exp $

 osCommerce, Open Source E-Commerce Solutions
 http://www.oscommerce.com

 Copyright (c) 2003 osCommerce

 AUTHOR: Zaenal Muttaqin <zaenal@paramartha.org>   Released under the GNU General Public License  */

 require('includes/application_top.php');

 $navigation->remove_current_page();
 if((int)tep_db_prepare_input($HTTP_GET_VARS['imagesID']) > 0) {
   $products_query = tep_db_query("SELECT images_description, popup_images FROM " . TABLE_ADDITIONAL_IMAGES . " WHERE additional_images_id = '" . (int)tep_db_prepare_input($HTTP_GET_VARS['imagesID']) . "'");
   $products_values = tep_db_fetch_array($products_query);
 } else {
   $products_values = '';
 }
?>
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<title><?php echo $products_values['images_description'] . ' - ' . STORE_NAME; ?></title>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<script language="javascript"><!--
var i=0;
function resize() {
 if (navigator.appName == 'Mozilla') i=40;
 if (document.images[0]) window.resizeTo(document.images[0].width +30, document.images[0].height+60-i);
 self.focus();
}
//--></script>
</head>
<body onload="resize();">
<?php echo tep_image_maxi(DIR_WS_IMAGES . $products_values['popup_images'], $products_values['images_description'], POPUP_IMAGE_WIDTH, POPUP_IMAGE_HEIGHT); ?>
</body>
</html>
<?php require('includes/application_bottom.php'); ?> 