<?php
/*
  $Id: header.php,v 1.19 2002/04/13 16:11:52 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  if ($messageStack->size > 0) {
    echo $messageStack->output();
  }
?>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr class="headerBar">
    <td class="headerBarContent">&nbsp;&nbsp;<?php if (tep_session_is_registered('login_id')) {
	
	if (tep_session_is_registered('login_id')) {
		if (getenv('HTTPS') == 'on') {
			$size = ((getenv('SSL_CIPHER_USEKEYSIZE')) ? 
					' '.getenv('SSL_CIPHER_USEKEYSIZE') . '-bit '.getenv('SSL_CIPHER'):' nieznane ').' ';
			$jaki_SSL =  tep_image(DIR_WS_ICONS . 'locked.gif', 'szyfrowanie SSL: '.$size, 16,16,' style="vertical-align: middle;"');
		} else {
			$jaki_SSL = tep_image(DIR_WS_ICONS . 'unlocked.gif', 'szyfrowanie: BRAK', 16,16,' style="vertical-align: middle;"');
		}
	
		echo $jaki_SSL;
	}

	if(tep_session_is_registered('login_firstname')) {
		echo ' Zalogowany jako: <b>'.$login_firstname.'</b> &nbsp; &Psi; &nbsp; ';
	}
	
	echo '<a href="' . tep_href_link(FILENAME_ADMIN_ACCOUNT, '', 'SSL') . '" class="headerLink">' . HEADER_TITLE_ACCOUNT . '</a> | <a href="' . tep_href_link(FILENAME_LOGOFF, '', 'NONSSL') . '" class="headerLink"><b>' . HEADER_TITLE_LOGOFF . '</b></a>'; } else { echo '<a href="' . tep_href_link(FILENAME_DEFAULT, '', 'NONSSL') . '" class="headerLink">' . HEADER_TITLE_TOP . '</a>'; }?></td>
    <td class="headerBarContent" align="right"><?php
	$t = rand(0,10);
	if (tep_session_is_registered('pd') && tep_session_is_registered('pnd') && tep_session_is_registered('ipd') && tep_session_is_registered('ipnd') &&  $t != 2) {
		echo '&radic; &nbsp; dostepnych: <span style="color: #99FF00"><b>'.$ipd.'</b></span> ['.$pd.'%] :: niedostepnych: <span style="color: #FF9933"><b>'.$ipnd.'</b></span> ['.$pnd.'%] &nbsp;';
	} else {
		$query = tep_db_query("select count(*) as count from " . TABLE_PRODUCTS . " WHERE products_status = '0'");
		$niedostepne = tep_db_fetch_array($query);
		$query = tep_db_query("select count(*) as count from " . TABLE_PRODUCTS . " WHERE products_status = '1'");
		$dostepne = tep_db_fetch_array($query);
		$ipd = $ipnd = 0;
		$pd = $pnd = 0;
		tep_session_register('pd');
		tep_session_register('pnd');
		tep_session_register('ipd');
		tep_session_register('ipnd');
		$ipd = $dostepne['count'];
		$ipnd = $niedostepne['count'];
		if(($ipd+$ipnd) == 0) {
			if($ipd==0) $pd = 0;
			if($ipnd==0) $pnd = 0;
		} else {
			$pd = round(($ipd/($ipd+$ipnd))*100,1);		
		}
		$pnd = round(100 - $pd,1);
		echo 'dostepnych: <span style="color: #99FF00"><b>'.$ipd.'</b></span> ['.$pd.'%] :: niedostepnych: <span style="color: #FF9933"><b>'.$ipnd.'</b></span> ['.$pnd.'%] &nbsp;';
	}

	$query = tep_db_query("SELECT count(*) as online FROM ".TABLE_WHOS_ONLINE);
	$result = tep_db_fetch_array($query);
	echo ':: &nbsp; osób online: <b>'.$result['online'].'</b> &nbsp;&nbsp;&nbsp; | ';
	?>


	<?php echo '<a href="' . tep_catalog_href_link() . '" class="headerLink">' . HEADER_TITLE_ONLINE_CATALOG . '</a> &nbsp;|&nbsp; <a href="' . tep_href_link(FILENAME_DEFAULT, '', 'NONSSL') . '" class="headerLink">' . HEADER_TITLE_ADMINISTRATION . '</a>'; ?>&nbsp;&nbsp;</td>
  </tr>
</table>
<?php if (MENU_DHTML == 'true') echo '<link rel="stylesheet" type="text/css" href="includes/menu.css">'; ?>
<?php if (MENU_DHTML == 'true') require(DIR_WS_INCLUDES . 'header_navigation.php'); 