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
  if(!$HTTP_GET_VARS['info_id']) die("No page found.");
  $info_id = $HTTP_GET_VARS['info_id'];

  $sql=mysql_query('SELECT * FROM '.TABLE_INFORMATION.' WHERE visible=\'1\' AND information_id=\''.$info_id.'\'') or die(mysql_error());
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

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE . ' - ' . $INFO_TITLE; ?></title>
<base href="<?php echo (getenv('HTTPS') == 'on' ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<link rel="stylesheet" type="text/css" href="stylesheet.css">
<script language="javascript" src="includes/general.js"></script>
</head>
<body >

<!-- body //-->
<table border="0" width="100%" cellspacing="3" cellpadding="3">
  <tr>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
          <tr>
            <td class="pageHeading"><?php echo $INFO_TITLE; ?></td>
            <td align="right">&nbsp;
			</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="category_desc"><BR>
			   <?php echo $INFO_DESCRIPTION; ?>
			</td>
		</tr>
	</table>

</td>
</tr>
</table>

</td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>