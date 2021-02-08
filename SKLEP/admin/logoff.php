<?php
/*
  $Id: logoff.php,v 1.12 2003/02/13 03:01:51 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_LOGOFF);

//tep_session_destroy();
  tep_session_unregister('login_id');
  tep_session_unregister('login_firstname');
  tep_session_unregister('login_groups_id');
  tep_session_unregister('pd');
  tep_session_unregister('pnd');
  tep_session_unregister('ipd');
  tep_session_unregister('ipnd');
  tep_session_unregister('pa');

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<style type="text/css"><!--
a { color:#080381; text-decoration:none; }
a:hover { color:#aabbdd; text-decoration:underline; }
a.text:link, a.text:visited { color: #ffffff; text-decoration: none; }
a:text:hover { color: #000000; text-decoration: underline; }
a.sub:link, a.sub:visited { color: #638C2E; text-decoration: none; }
A.sub:hover { color: #638C2E; text-decoration: underline; }
.sub { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; line-height: 1.5; color: #dddddd; }
.text { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; color: #B80101; }
.smallText { font-family: Verdana, Arial, sans-serif; font-size: 10px; }
.login_heading { font-family: Verdana, Arial, sans-serif; font-size: 12px; color: #FBFBFB;}
.login { font-family: Verdana, Arial, sans-serif; font-size: 10px; color: #4e4e4e;}
.footer { font-family: Tahoma, Arial, sans-serif; font-size: 10px; color: #85AB5E;}
a.footer:link { font-family: Verdana, Arial, sans-serif; font-size: 10px; color: #85AB5E; font-weight: normal; text-decoration: none; }
a.footer:hover { font-family: Verdana, Arial, sans-serif; font-size: 10px; color: #F67207; font-weight: normal; text-decoration: underline; }
CHECKBOX, INPUT, RADIO, SELECT, TEXTAREA, FILE { font-family: Verdana, Arial, sans-serif; font-size: 11px; }
//--></style>
</head>
<body style="background: #4e4e4e url(images/gfx/bg.png);">

<table border="0" width="600" height="100%" cellspacing="0" cellpadding="0" align="center" valign="middle">
  <tr>
    <td><table border="0" width="600" height="240" cellspacing="0" cellpadding="0" align="center" valign="middle">
      <tr style="background: #4e4e4e url(images/gfx/bg.png);">
        <td><table border="0" width="600" height="240" cellspacing="0" cellpadding="0">
          <tr style="background: #4e4e4e url(images/gfx/bg.png);">
            <td height="68" colspan="2" align="center"><?php echo tep_image(DIR_WS_IMAGES . 'gfx/sklep_internetowy.png', 'Powered by osCommerce.pl'); ?><br /></td>
          </tr>
          <tr style="background: #4e4e4e url(images/gfx/bg.png);">
            <td colspan="2" align="center" valign="middle">
                            <table width="280" border="0" cellspacing="0" cellpadding="2">
                              <tr>
                                <td class="login_heading" valign="top"><b><?php echo HEADING_TITLE; ?></b></td>
                              </tr>
                              <tr>
                                <td class="login_heading" align="justify"><?php echo TEXT_MAIN; ?></td>
                              </tr>
                              <tr>
                                <td class="login_heading" align="right"><?php echo '<a class="login_heading" href="' . tep_href_link(FILENAME_LOGIN, '', 'SSL') . '">' . tep_image_button('button_back_small.png', IMAGE_BACK) . '</a>'; ?></td>
                              </tr>
                              <tr>
                                <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '30'); ?></td>
                              </tr>
                            </table>
            </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>

</body>

</html>
