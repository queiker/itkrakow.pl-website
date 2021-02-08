<?php
/*
  $Id: login.php,v 1.17 2003/02/14 12:57:29 dgw_ Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

define('ADMIN_EMAIL_SUBJECT', 'Nowe has³o administratora'); 
define('ADMIN_EMAIL_TEXT', 'Witaj %s,' . "\n\n" . 'Masz dostêp do panelu administracyjnego za pomoc± nastêpuj±cych danych. Po pierwszym logowaniu zmieñ swoje has³o!' . "\n\n" . 'Adres : %s' . "\n" . 'U¿ytkownik: %s' . "\n" . 'has³o: %s' . "\n\n" . 'Dziêkujemy!' . "\n" . '%s' . "\n\n" . 'Ten mail zosta³ wygenerowany automatycznie. Prosimy nie odpowiadaæ!');

  
  if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'process')) {
    $email_address = tep_db_prepare_input($HTTP_POST_VARS['email_address']);
    $firstname = tep_db_prepare_input($HTTP_POST_VARS['firstname']);
    $log_times = $HTTP_POST_VARS['log_times']+1;
    if ($log_times >= 4) {
      tep_session_register('password_forgotten');
    }
      
// Check if email exists
    $check_admin_query = tep_db_query("select admin_id as check_id, admin_firstname as check_firstname, admin_lastname as check_lastname, admin_email_address as check_email_address from " . TABLE_ADMIN . " where admin_email_address = '" . tep_db_input($email_address) . "'");
    if (!tep_db_num_rows($check_admin_query)) {
      $HTTP_GET_VARS['login'] = 'fail';
    } else {
      $check_admin = tep_db_fetch_array($check_admin_query);
      if ($check_admin['check_firstname'] != $firstname) {
        $HTTP_GET_VARS['login'] = 'fail';
      } else {
        $HTTP_GET_VARS['login'] = 'success';
        
        function randomize() {
          $salt = "ABCDEFGHIJKLMNOPQRSTUVWXWZabchefghjkmnpqrstuvwxyz0123456789";
          srand((double)microtime()*1000000); 
          $i = 0;
    
          while ($i <= 7) {
            $num = rand() % 33;
    	    $tmp = substr($salt, $num, 1);
    	    $pass = $pass . $tmp;
    	    $i++;
  	  }
  	  return $pass;
        }
        $makePassword = randomize();
      
        tep_mail($check_admin['check_firstname'] . ' ' . $check_admin['admin_lastname'], $check_admin['check_email_address'], ADMIN_EMAIL_SUBJECT, sprintf(ADMIN_EMAIL_TEXT, $check_admin['check_firstname'], HTTP_SERVER . DIR_WS_ADMIN, $check_admin['check_email_address'], $makePassword, STORE_OWNER), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);            
        tep_db_query("update " . TABLE_ADMIN . " set admin_password = '" . tep_encrypt_password($makePassword) . "' where admin_id = '" . $check_admin['check_id'] . "'");
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
                <td colspan="2" align="center" valign="middle"> <?php echo tep_draw_form('login', FILENAME_PASSWORD_FORGOTTEN, 'action=process'); ?>
                            <table width="285" border="0" cellspacing="0" cellpadding="2">
                              <tr>
                                <td class="login_heading" valign="top" align="center">&nbsp;<b><?php echo HEADING_PASSWORD_FORGOTTEN; ?></b></td>
                              </tr>
                              <tr>
                                <td height="100%" width="100%" valign="top" align="center">
                                <table border="0" height="100%" width="100%" cellspacing="0" cellpadding="1">
                                  <tr><td><table border="0" width="100%" height="100%" cellspacing="3" cellpadding="2">
<?php
  if ($HTTP_GET_VARS['login'] == 'success') {
    $success_message = TEXT_FORGOTTEN_SUCCESS;
  } elseif ($HTTP_GET_VARS['login'] == 'fail') {
    $info_message = TEXT_FORGOTTEN_ERROR;
  }
  if (tep_session_is_registered('password_forgotten')) {
?>
                                    <tr>
                                      <td class="smallText" align="center"><?php echo TEXT_FORGOTTEN_FAIL; ?></td>
                                    </tr>
                                    <tr>
                                      <td align="center" valign="top"><?php echo '<a href="' . tep_href_link(FILENAME_LOGIN, '' , 'SSL') . '">' . tep_image_button('button_back_small.png', IMAGE_BACK) . '</a>'; ?></td>
                                    </tr>
<?php
  } elseif (isset($success_message)) {
?>
                                    <tr>
                                      <td class="smallText" style="color: #FFF;" align="center"><?php echo $success_message; ?></td>
                                    </tr>
                                    <tr>
                                      <td align="center" valign="top"><?php echo '<a href="' . tep_href_link(FILENAME_LOGIN, '' , 'SSL') . '">' . tep_image_button('button_back_small.png', IMAGE_BACK) . '</a>'; ?></td>
                                    </tr>
<?php
  } else {
    if (isset($info_message)) {
?>
                                    <tr>
                                      <td class="smallText" align="center" style="color: #FFF;"><?php echo $info_message; ?><?php echo tep_draw_hidden_field('log_times', $log_times); ?></td>
                                    </tr>
<?php
    }
?>                                    
                                    <tr>
                                      <td class="login" align="center"><?php echo tep_draw_input_field('firstname','imiê','style="background: #FFF; border: 1px solid #4e4e4e; color: #777; text-align: center;" onFocus="javascript: if(this.value==\'imiê\')this.value=\'\'"'); ?></td>
                                    </tr>
                                    <tr>
                                      <td class="login" align="center"><?php echo tep_draw_input_field('email_address','adres e-mail','style="background: #FFF; border: 1px solid #4e4e4e; color: #777; text-align: center;" onFocus="javascript: if(this.value==\'adres e-mail\')this.value=\'\'"'); ?></td>
                                    </tr>
                                    <tr>
                                      <td align="center" valign="top"><?php echo '<a href="' . tep_href_link(FILENAME_LOGIN, '' , 'SSL') . '">' . tep_image_button('button_back_small.png', IMAGE_BACK) . '</a> ' . tep_image_submit('button_confirm_small.png', IMAGE_BUTTON_LOGIN); ?>&nbsp;</td>
                                    </tr>
<?php
  }
?>   
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
