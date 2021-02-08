<?php
/*
  $Id: info_shopping_cart.php,v 1.19 2003/02/13 03:01:48 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require("includes/application_top.php");

  $navigation->remove_current_page();

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_INFO_SHOPPING_CART);
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

<?php
  $info_box_contents = array();
  $info_box_contents[] = array('text' => HEADING_TITLE);

  new infoBoxHeading($info_box_contents, true, true);

  $info_box_contents = array();
  $info_box_contents[] = array('text' => '<b><i>'. SUB_HEADING_TITLE_1.'</i></b><br>'. SUB_HEADING_TEXT_1.'<BR /><BR />'.
'<b><i>'. SUB_HEADING_TITLE_2.'</i></b><br>'. SUB_HEADING_TEXT_2.'<BR /><BR />'.
'<b><i>'. SUB_HEADING_TITLE_3.'</i></b><br>'. SUB_HEADING_TEXT_3.'<BR /><BR />');

  new infoBox($info_box_contents);
?>
<div align="right"><a class="boxText" style="color:green; font-weight:bold;" href="javascript:window.close();"><?php echo TEXT_CLOSE_WINDOW; ?></a></div>
</body>
</html>
<?php
  require("includes/counter.php");
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>