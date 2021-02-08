<?php
/*
  $Id: header.php,v 1.42 2003/06/10 18:20:38 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

// check if the 'install' directory exists, and warn of its existence
  if (WARN_INSTALL_EXISTENCE == 'true') {
    if (file_exists(dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/install')) {
      $messageStack->add('header', WARNING_INSTALL_DIRECTORY_EXISTS, 'warning');
    }
  }

// check if the configure.php file is writeable
  if (WARN_CONFIG_WRITEABLE == 'true') {
    if ( (file_exists(dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/includes/configure.php')) && (is_writeable(dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/includes/configure.php')) ) {
      $messageStack->add('header', WARNING_CONFIG_FILE_WRITEABLE, 'warning');
    }
  }

// check if the session folder is writeable
  if (WARN_SESSION_DIRECTORY_NOT_WRITEABLE == 'true') {
    if (STORE_SESSIONS == '') {
      if (!is_dir(tep_session_save_path())) {
        $messageStack->add('header', WARNING_SESSION_DIRECTORY_NON_EXISTENT, 'warning');
      } elseif (!is_writeable(tep_session_save_path())) {
        $messageStack->add('header', WARNING_SESSION_DIRECTORY_NOT_WRITEABLE, 'warning');
      }
    }
  }

// check session.auto_start is disabled
  if ( (function_exists('ini_get')) && (WARN_SESSION_AUTO_START == 'true') ) {
    if (ini_get('session.auto_start') == '1') {
      $messageStack->add('header', WARNING_SESSION_AUTO_START, 'warning');
    }
  }

  if ( (WARN_DOWNLOAD_DIRECTORY_NOT_READABLE == 'true') && (DOWNLOAD_ENABLED == 'true') ) {
    if (!is_dir(DIR_FS_DOWNLOAD)) {
      $messageStack->add('header', WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT, 'warning');
    }
  }

  if ($messageStack->size('header') > 0) {
    echo $messageStack->output('header');
  }   

       
// [0001] BOF: WebMakers.com Added: Center Shop
// This goes before any other table of the shop

    if ( CENTER_SHOP_ON == 'on' ) {
 
// [0001] Background Color ON/OFF and CellPadding for around the shop?

      if ( CENTER_SHOP_BACKGROUND_ON == 'on' ) {
?>
	<a name="top"></a>
    <table width="100%" cellspacing="20" border="0">
      <tr><td>
<?php
      }    
// [0001] Shop Width Size and Shop Background Color
?>
    <table width="<?php echo CENTER_SHOP_WIDTH; ?>" align="center" style="background: transparent; border: 2px; border-color:D0D0D0; border-style: solid" CELLSPACING="0" CELLPADDING="5" >
      <tr><td style="background: #FFF;" >
<?php
// [0001] The rest of this <td> statement is located at the end of footer.php
 }
?>

<table width="100%" cellspacing="0" cellpadding="0" style="padding: 0 0 5 0;">
	<tr>
		<td width="10"><?php echo tep_image_t('gfx/bg_top_left.gif');?></td>
		<td class="head_menu">
<?php
if(tep_session_is_registered('customer_id') && !tep_session_is_registered('noaccount')) {
//
} else {
	echo '<a href="' . tep_href_link(FILENAME_CREATE_ACCOUNT) . '">' . TEXT_NOWY_KLIENT . '</a> &nbsp; | &nbsp; ';
}
if(tep_session_is_registered('customer_id') && !tep_session_is_registered('noaccount')) {
	echo '<a href="' . tep_href_link(FILENAME_LOGOFF,'','SSL') . '">' . TEXT_WYLOGUJ . '</a> &nbsp; | &nbsp; ';
} else {
	echo '<a href="' . tep_href_link(FILENAME_LOGIN,'','SSL') . '">' . TEXT_ZALOGUJ . '</a> &nbsp; | &nbsp; ';
}
if(!tep_session_is_registered('noaccount')) {
	echo '<a href="' . tep_href_link(FILENAME_ACCOUNT,'','SSL') . '">' . TEXT_TWOJE_KONTO . '</a> &nbsp; | &nbsp; ';
}
echo '<a href="' . tep_href_link(FILENAME_SHOPPING_CART) . '">' . TEXT_TWOJ_KOSZYK . '</a> &nbsp; | &nbsp; ';
echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_NEW) . '">' . TEXT_NOWOSCI . '</a> &nbsp; | &nbsp; ';
echo '<a href="' . tep_href_link(FILENAME_SPECIALS) . '">' . TEXT_PROMOCJE . '</a>';
?>
		</td>
		<td width="10"><?php echo tep_image_t('gfx/bg_top_right.gif');?></td>
	</tr>
</table>

<div class="top_naglowek">
		  <?php add_banners_naglowek('naglowek_'.DEFAULT_TEMPLATE); ?>
		</div>

<?php
  if (isset($HTTP_GET_VARS['error_message']) && tep_not_null($HTTP_GET_VARS['error_message'])) {
?>
        <table border="0" width="100%" cellspacing="0" cellpadding="2" >
  <tr class="headerError">
    <td class="headerError"><?php echo htmlspecialchars(urldecode($HTTP_GET_VARS['error_message'])); ?></td>
  </tr>
</table>
<?php
  }

  if (isset($HTTP_GET_VARS['info_message']) && tep_not_null($HTTP_GET_VARS['info_message'])) {
?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr class="headerInfo">
    <td class="headerInfo"><?php echo htmlspecialchars($HTTP_GET_VARS['info_message']); ?></td>
  </tr>
</table>
        <?php
  }
?>



<script type="text/javascript">
<!-- <![CDATA[
function rowOverEffect(object) {
  if (object.className == 'moduleRow') object.className = 'moduleRowOver';
}

function rowOutEffect(object) {
  if (object.className == 'moduleRowOver') object.className = 'moduleRow';
}
// ]]> -->
</script>