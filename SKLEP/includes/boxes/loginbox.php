<?php
/*
  LoginBox v5.2.wfc1.0
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

  IMPORTANT NOTE:

  This script is not part of the official osC distribution
  but an add-on contributed to the osC community. Please
  read the README and INSTALL documents that are provided
  with this file for further information and installation notes.

  LoginBox v5.0 was originally designed by Aubrey Kilian <aubrey@mycon.co.za>
  LoginBox v5.2 rewritten by Linda McGrath <osCOMMERCE@WebMakers.com>
  LoginBox v5.2.wfc1.0 modified by Justin of World Famous Comics <justin@wfcomics.com>
  LoginBox v5.21 modified by Noel Latsha <nrlatsha@nabcomdiamonds.com>
*/

// WebMakers.com Added: Do not show if on login or create account
if ( (!strstr($_SERVER['PHP_SELF'],'login.php')) and (!strstr($_SERVER['PHP_SELF'],'create_account.php')) and !tep_session_is_registered('customer_id') )  {
?>
<!-- loginbox //-->
<?php
    if (!tep_session_is_registered('customer_id')) {
?>
          <tr>
            <td class="borB">
<?php
    $info_box_contents = array();
    $info_box_contents[] = array('align' => 'left',
                                 'text'  => HEADER_TITLE_LOGIN);
    new infoBoxHeading($info_box_contents, false, false);
    $loginboxcontent = '
            <form name="login" method="post" action="' . tep_href_link(FILENAME_LOGIN, 'action=process', 'SSL') . '">
			<table border="0" width="100%" cellspacing="0" cellpadding="3">
              <tr>
                <td align="left" class="boxText">&nbsp;<input type="text" name="email_address" maxlength="96" size="22" value=" adres e-mail" onFocus="javascript: if(this.value=\' adres e-mail\') this.value=\'\'"><br />'.tep_draw_separator('pixel_trans.gif',1,5).'<br />
				&nbsp;<input type="password" name="password" maxlength="40" size="22" value="">
                </td>
                <td align="left" class="boxText">'.
				tep_image_submit('button_login.gif', IMAGE_BUTTON_LOGIN).
                '</td>
              </tr>
              <tr>
                <td align="center" class="boxText" colspan="3"><A HREF="' . tep_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'SSL') . '">'.LOGIN_BOX_PASSWORD_FORGOTTEN.'</A> &nbsp; | &nbsp; <A HREF="' . tep_href_link(FILENAME_CREATE_ACCOUNT, '','SSL') . '">'.LOGIN_BOX_NEW_ACCOUNT.'</A>
                </td>
              </tr>
            </table>
            </form>
              ';



    $info_box_contents = array();
    $info_box_contents[] = array('align' => 'center',
                                 'text'  => $loginboxcontent
                                );
    new infoBox($info_box_contents);
?>
            </td>
          </tr>
<?php
	echo '<tr><td class="sep"></td></tr>';
  }
?>
<!-- loginbox_eof //-->
<?php
} 
?>