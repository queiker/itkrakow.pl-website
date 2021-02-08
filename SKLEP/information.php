<?php
  /*
  Module: Information Pages Unlimited
  		  File date: 2003/03/03
		  Based on the FAQ script of adgrafics
  		  Adjusted by Joeri Stegeman (joeri210 at yahoo.com), The Netherlands

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Released under the GNU General Public License
  */

  require('includes/application_top.php');

  // Added for information pages
  if(!$HTTP_GET_VARS['info_id']) die("Nie ma takiej strony");
  $info_id = $HTTP_GET_VARS['info_id'];

  $sql=mysql_query('SELECT * FROM '.TABLE_INFORMATION.' WHERE visible=\'1\' AND information_id=\''.(int)$info_id.'\'') or die(mysql_error());
  $row=mysql_fetch_array($sql);
  $INFO_TITLE = stripslashes($row['info_title']);
  $INFO_DESCRIPTION = stripslashes($row['description']);

  // Only replace cariage return by <BR> if NO HTML found in text
  // Added as noticed by infopages module
  if (!preg_match("/([\<])([^\>]{1,})*([\>])/i", $INFO_DESCRIPTION)) {
  	$INFO_DESCRIPTION = str_replace("\r\n", "<br>\r\n", $INFO_DESCRIPTION ); 
  }

  // Need to do a check for if session is found...
  $INFO_FILELINK =  FILENAME_INFORMATION .
  					(stristr(tep_href_link(FILENAME_INFORMATION, '', 'NONSSL'), '?')?'&':'?') . 
					'info_id=' . $row['information_id'];

  $breadcrumb->add($INFO_TITLE, tep_href_link($INFO_FILELINK, '', 'NONSSL'));
?>
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo $INFO_TITLE . ' - ' . TITLE; ?></title>
<base href="<?php echo (getenv('HTTPS') == 'on' ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_TEMPLATES . $template . $language . '/stylesheet.css';?>">
</head>
<body>
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<?php include('includes/body.php'); ?>
    <td width="100%" valign="top">

	<table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php
			$info_box_contents = array();
			$info_box_contents[] = array('text' => $INFO_TITLE);
			new infoBoxHeading($info_box_contents, true, true);
	  ?></td>
      </tr>
	</table>

	<table border="0" width="100%" cellspacing="0" cellpadding="0" class="blrb">	
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
		<td class="category_desc"><?php echo $INFO_DESCRIPTION; ?><BR /></td>
	  </tr>
<?php
    $back = sizeof($navigation->path)-2;
    if (isset($navigation->path[$back])) {
?>
      <tr>
        <td class="buttons" align="left"><?php echo '<a href="' . tep_href_link($navigation->path[$back]['page'], tep_array_to_string($navigation->path[$back]['get'], array('action')), $navigation->path[$back]['mode']) . '">' . tep_image_button('button_back.gif', IMAGE_BUTTON_CONTINUE_SHOPPING) . '</a>'; ?></td>
      </tr>
<?php
    } else {
?>
      <tr>
        <td class="buttons" align="left"><?php echo '<a href="javascript: history.back();">' . tep_image_button('button_back.gif', IMAGE_BUTTON_CONTINUE_SHOPPING) . '</a>'; ?></td>
      </tr>
<?php
	}
?>
	</table>



</td>
<!-- body_text_eof //-->
<?php include('includes/footer_0.php'); ?>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>