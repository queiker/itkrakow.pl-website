<?php
/*
  $Id: conditions.php,v 1.22 2003/06/05 23:26:22 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright by Marek Naborczyk, www.oscommerce.pl
  - dodatek do ot_loyalty_discount umozliwiajacy wyswietlenie wysokosci 
  obnizki przyslugujacej za dokonane zakupy
  

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
define('NAVBAR_TITLE', 'Program Lojalno¶ciowy');
define('FILENAME_LOYALTY', 'loyalty.php');



  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_LOYALTY));
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
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
	      <tr>
	        <td><?php
			$info_box_contents = array();
			$info_box_contents[] = array('text' => NAVBAR_TITLE);
			new infoBoxHeading($info_box_contents, true, true);
		  ?></td>
	      </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="main">Tutaj wstaw informacje o swoim programie lojalno¶ciowym.<br>
		Ponizsza tabela jest generowana automatycznie na podstawie konfiguracji z bazy danych.  Je¿eli jest pusta oznacza to, ¿e modu³ ten nie zosta³ zainstalowany</td>
      </tr>
	  <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
	  <tr>
	    <td>
		 <table align="center" width="145" border="1" cellspacing="0" cellpadding="5">
		<?
		$sql = "SELECT DISTINCT configuration_value FROM configuration WHERE  configuration_key = 'MODULE_LOYALTY_DISCOUNT_TABLE' LIMIT 1";
		$result = @mysql_query($sql);
		$result = @mysql_result($result, 0, 'configuration_value');
		$array = explode(',',$result);
		$i=0;
		while (($row = explode(':',$array[$i])) AND ($array[$i] !='')) {
			echo "<tr>
					<td width=\"75\" align=\"right\" class=\"main\">$row[0]z³</td>
					<td width=\"75\" align=\"right\" class=\"main\">$row[1]%</td>
				</tr>";
			++$i;
			}
		?>
		 </table>
		</td>
	  </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td align="right"><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
<?php include('includes/footer_0.php'); ?>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>