<?php
/*
  $Id: install_5.php,v 1.22 2003/07/09 01:11:06 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  $https_www_address = str_replace('http://', 'https://', $_POST['HTTP_WWW_ADDRESS']);
?>

<p class="pageTitle">Instalacja</p>

<p><b>Konfiguracja sklepu</b></p>

<form name="install" action="install.php?step=6" method="post">

<p><b>Wpisz dane bezpiecznego serwera WWW:</b></p>

<table width="95%" border="0" cellpadding="2" class="formPage">
  <tr>
    <td width="30%" valign="top">Bezpieczny adres WWW:</td>
    <td width="70%" class="smallDesc">
      <?php echo osc_draw_input_field('HTTPS_WWW_ADDRESS', $https_www_address); ?>
      <img src="images/layout/help_icon.gif" onClick="toggleBox('httpsWWW');"><br>
      <div id="httpsWWWSD">Pe³ny adres WWW, pod którym znajduje siê zabezpieczony protoko³em SSL sklep.</div>
      <div id="httpsWWW" class="longDescription">np.  <i>https://www.twojadomena/sklep/</i></div>
    </td>
  </tr>
  <tr>
    <td width="30%" valign="top">Domena dla plików cookie:</td>
    <td width="70%" class="smallDesc">
      <?php echo osc_draw_input_field('HTTPS_COOKIE_DOMAIN', $_POST['HTTP_COOKIE_DOMAIN']); ?>
      <img src="images/layout/help_icon.gif" onClick="toggleBox('httpsCookieD');"><br>
      <div id="httpsCookieDSD">Domena, dla której przechowywaæ pliki cookie</div>
      <div id="httpsCookieD" class="longDescription">np. <i>ssl.twojadomena.com</i></div>
    </td>
  </tr>
  <tr>
    <td width="30%" valign="top">¦cie¿ka do plików cookie:</td>
    <td width="70%" class="smallDesc">
      <?php echo osc_draw_input_field('HTTPS_COOKIE_PATH', $_POST['HTTP_COOKIE_PATH']); ?>
      <img src="images/layout/help_icon.gif" onClick="toggleBox('dbCookieP');"><br>
      <div id="dbCookiePSD">Katalog, w którym bêd± przechowywane pliki cookie</div>
      <div id="dbCookieP" class="longDescription">Ograniczenie cookie tylko do jednego katalogu, np. <i>/sklep/</i></div>
    </td>
  </tr>
</table>

<p>&nbsp;</p>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><a href="index.php"><img src="images/button_cancel.gif" border="0" alt="Anuluj"></a></td>
    <td align="center"><input type="image" src="images/button_continue.gif" border="0" alt="Dalej"></td>
  </tr>
</table>

<?php
  reset($_POST);
  while (list($key, $value) = each($_POST)) {
    if (($key != 'x') && ($key != 'y')) {
      if (is_array($value)) {
        for ($i=0; $i<sizeof($value); $i++) {
          echo osc_draw_hidden_field($key . '[]', $value[$i]);
        }
      } else {
        echo osc_draw_hidden_field($key, $value);
      }
    }
  }
?>

</form>
