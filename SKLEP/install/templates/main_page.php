<?php
/*
  $Id: main_page.php,v 1.4 2003/07/09 10:49:48 dgw_ Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>

<head>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=iso-8859-2">
<title>osCommerce// Mysklep </title>

<meta name="ROBOTS" content="NOFOLLOW">

<link rel="stylesheet" type="text/css" href="templates/main_page/stylesheet.css">

<script language="javascript" src="templates/main_page/javascript.js"></script>

</head>

<body text="#000000" bgcolor="#4E4E4E" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
<table width="778" height="100%" border="0" align="center" cellpadding="5" cellspacing="5" >
  <tr> 
    <td width="100%" align="center" valign="middle"><table width="100%" border="0" cellspacing="8" cellpadding="8" class="border" bgcolor="#ffffff">
        <tr>
          <td align="center" valign="middle"><img src="images/mysklep.gif" alt="Mysklep OSC"  border="0" usemap="#Map"><br>
            <br>
            <?php require('templates/pages/' . $page_contents); ?>
          </td>
        </tr>
      </table> </td>
  </tr>
</table>

<map name="Map">
  <area shape="rect" coords="63,2,140,16" href="http://www.mysklep.pl" target="_blank" alt="Design dla sklepów">
  <area shape="rect" coords="82,18,188,31" href="http://www.oscommerce.pl" target="_blank" alt="Forum oscommerce">
</map>
</body>

</html>
