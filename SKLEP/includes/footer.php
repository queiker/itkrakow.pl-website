<?php
/*
  $Id: footer.php,v 1.28 2004/04/08 02:20:20 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2004 osCommerce

  Released under the GNU General Public License


*/

	$q = tep_db_query("SELECT count(*) as online FROM " . TABLE_WHOS_ONLINE);
	$osoby = tep_db_fetch_array($q);

//  require(DIR_WS_INCLUDES . 'counter.php');
?> 
<br />
<table width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td class="footB">&nbsp;&nbsp;<?php echo strftime(DATE_FORMAT_LONG); ?><br />&nbsp;&nbsp;<?php echo VISITORS_ONLINE.' '.$osoby['online']; ?>
		</td>
		<td class="footB" align="right"><?php
			if(tep_session_is_registered('customer_id') && !tep_session_is_registered('noaccount')) {

										echo '<a href="'.tep_href_link(FILENAME_LOGOFF).'" class="linkG">' . TEXT_WYLOGUJ . '</a> &nbsp; | &nbsp; ';
			} else {
										echo '<a href="'.tep_href_link(FILENAME_CREATE_ACCOUNT).'" class="linkG">'.TEXT_NOWY_KLIENT.'</a> &nbsp; | &nbsp;  ';
										echo '<a href="'.tep_href_link(FILENAME_LOGIN).'" class="linkG">' . TEXT_ZALOGUJ . '</a> &nbsp; | &nbsp; ';
			}

			if(!tep_session_is_registered('noaccount')) {
										echo '<a href="'.tep_href_link(FILENAME_ACCOUNT).'" class="linkG">' . TEXT_TWOJE_KONTO . '</a> &nbsp; | &nbsp; ';
			}

										echo '<a href="'.tep_href_link(FILENAME_SHOPPING_CART).'" class="linkG">' . TEXT_TWOJ_KOSZYK . '</a> &nbsp; | &nbsp; ';
										echo '<a href="'.tep_href_link(FILENAME_PRODUCTS_NEW).'" class="linkG">' . TEXT_NOWOSCI . '</a> &nbsp; | &nbsp; ';
										echo '<a href="'.tep_href_link(FILENAME_SPECIALS).'" class="linkG">' . TEXT_PROMOCJE . '</a> &nbsp; | &nbsp; ';
										echo '<a href="'.tep_href_link(FILENAME_CENNIK).'" class="linkG">'.TEXT_CENNIK.'</a> ';
			?>
		</td>
	</tr>
</table>

<div style="padding: 0px 5px 5px 5px;">
	<div style="height:70px; display: block;">
	<a href="javascript:void(0)" class="platnosci_01"></a>
	<a href="javascript:void(0)" class="platnosci_02"></a>
	<a href="javascript:void(0)" class="platnosci_03"></a>
	<a href="javascript:void(0)" class="platnosci_04"></a>
	<a href="javascript:void(0)" class="platnosci_09"></a>
	<a href="javascript:void(0)" class="platnosci_05"></a>
	<a href="javascript:void(0)" class="platnosci_06"></a>
	<a href="javascript:void(0)" class="platnosci_07"></a>
	<a href="javascript:void(0)" class="platnosci_08"></a>
	</div>
	<div style="float: left; display: block;" class="cp_foot">Copyright &copy; <?php echo date(Y);?> <a href="<?php echo HTTP_SERVER.DIR_WS_HTTP_CATALOG; ?>" class="cp_foot" title="<?php echo STORE_NAME;?>"><?php echo str_replace('http://','',HTTP_SERVER); ?></a><br />
	<?php echo (DISPLAY_PRICE_WITH_TAX == 'true')?'Podane ceny zawieraj± podatek VAT.':'Podane ceny nie zawieraj± podatku VAT.';?></div>

	<div style="float: right; text-align: right;" class="cp_foot">Projekt graficzny i oprogramowanie &copy; 2010 <a href="http://www.mysklep.pl" target="_blank" title="Sklepy internetowe"><?php echo tep_image_t('gfx/mysklep.png','Sklepy internetowe','style="vertical-align:middle"'); ?></a><br />
	Powered by osCommerce <a href="http://www.oscommerce.pl" class="cp_foot">PRO</a>  Wszelkie prawa zastrze¿one.</div>

</div>

<?php
// [0001] WebMakers.com Added: Center Shop
// This goes at the very end of the footer after all the tables
  if ( CENTER_SHOP_ON == 'on' ) {
// [0001] close table used to center
?>
      </td></tr>
   </table>
<?php
    if ( CENTER_SHOP_BACKGROUND_ON == 'on' ) {	    
// [0001] Add color to bottom of screen for large displays - needed especially on notebooks that run at 1600x1200
// close table used for outer bgcolor around the shop
?>

  </td></tr>
</table>
<?php
    }
  }
// [0001] EOF: WebMakers.com Added: Center Shop
?>

<div align="center" class="smallText" style="width: 100%">

  <div style="width: 90px; height: 20px; display: inline;"></div>

</div>


<div align="center">
<?php 
//grupy banerow generowane automatycznie
   add_banners_group('stopka'); 
?>
</div>