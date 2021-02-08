<?php
/*
  $Id: login.php,v 1.17 2003/02/14 12:57:29 dgw_ Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  
  if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'process')) {
    $email_address = tep_db_prepare_input($HTTP_POST_VARS['email_address']);
    $password = tep_db_prepare_input($HTTP_POST_VARS['password']);

// Check if email exists
    $check_admin_query = tep_db_query("select admin_id as login_id, admin_groups_id as login_groups_id, admin_firstname as login_firstname, admin_email_address as login_email_address, admin_password as login_password, admin_modified as login_modified, admin_logdate as login_logdate, admin_lognum as login_lognum from " . TABLE_ADMIN . " where admin_email_address = '" . tep_db_input($email_address) . "'");
    if (!tep_db_num_rows($check_admin_query)) {
      $HTTP_GET_VARS['login'] = 'fail';
    } else {
      $check_admin = tep_db_fetch_array($check_admin_query);
      // Check that password is good
      if (!tep_validate_password($password, $check_admin['login_password'])) {
        $HTTP_GET_VARS['login'] = 'fail';
      } else {
        if (tep_session_is_registered('password_forgotten')) {
          tep_session_unregister('password_forgotten');
        }

        $login_id = $check_admin['login_id'];
        $login_groups_id = $check_admin[login_groups_id];
        $login_firstname = $check_admin['login_firstname'];
        $login_email_address = $check_admin['login_email_address'];
        $login_logdate = $check_admin['login_logdate'];
        $login_lognum = $check_admin['login_lognum'];
        $login_modified = $check_admin['login_modified'];

        tep_session_register('login_id');
        tep_session_register('login_groups_id');
        tep_session_register('login_firstname');

        //$date_now = date('Ymd');
        tep_db_query("update " . TABLE_ADMIN . " set admin_logdate = now(), admin_lognum = admin_lognum+1 where admin_id = '" . $login_id . "'");

        if (($login_lognum == 0) || !($login_logdate) || ($login_email_address == 'admin@localhost.pl') || ($login_modified == '0000-00-00 00:00:00')) {
          tep_redirect(tep_href_link(FILENAME_ADMIN_ACCOUNT));
        } else {
          tep_redirect(tep_href_link(FILENAME_STATS_ORDERS_TRACKING));
        }

      }
    }
  }

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_LOGIN);
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
a.sub:link, a.sub:visited { color: #638C2E; text-decoration: none; font-weight: normal;}
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
                <td colspan="2" align="center" valign="middle"> <?php echo tep_draw_form('login', FILENAME_LOGIN,'action=process'); ?> 
							<table width="280" border="0" cellspacing="0" cellpadding="2">
                              <tr>
                                <td height="100%" width="100%" valign="top" align="center">
                                <table border="0" height="100%" width="100%" cellspacing="0" cellpadding="1" style="background: #4e4e4e url(images/gfx/bg.png);"> 
                                  <tr><td><table border="0" width="100%" height="100%" cellspacing="3" cellpadding="2" style="background: #4e4e4e url(images/gfx/bg.png);">
<?php
  if ($HTTP_GET_VARS['login'] == 'fail') {
    $info_message = TEXT_LOGIN_ERROR;
  }
  if (isset($info_message)) {
?>
                                    <tr>
                                      <td colspan="2" class="smallText" align="center" style="color: #FFF;"><?php echo $info_message; ?></td>
                                    </tr>
<?php
  } else {
?>
<?php
  }
?>                                    
                                    <tr>
                                      <td class="login" align="center"><?php echo tep_draw_input_field('email_address','login','style="background: #FFF; border: 1px solid #4e4e4e; color: #777; text-align: center;" onFocus="javascript: if(this.value==\'login\')this.value=\'\'"'); ?></td>
                                    </tr>
                                    <tr>
                                      <td class="login" align="center"><?php echo tep_draw_password_field('password','',false); ?></td>
                                    </tr>
                                    <tr>
                                      <td align="center" valign="top" class="smalltext"><?php echo tep_image_submit('button_confirm_small.png', ' '); ?><br /><a href="<?php echo tep_href_link(FILENAME_PASSWORD_FORGOTTEN); ?>" style="color: #BBB;">zapomnia³em has³o</a></td>
                                    </tr>
                                  </table></td></tr>
                                </table>
                                </td>
                              </tr>
                            </table>
                          </form>
                  </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>