<?php
/*
  $Id: install.php,v 1.8 2003/07/09 01:11:06 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>

<p class="pageTitle">Instalacja</p>

<form name="install" action="install.php?step=2" method="post">

<p><b>Wybierz opcje instalacji:</b></p>

<table width="95%" border="0" cellpadding="2" class="formPage">
  <tr>
    <td width="30%" valign="top">Import bazy danych:</td>
    <td width="70%" class="smallDesc">
      <?php echo osc_draw_checkbox_field('install[]', 'database', true); ?>
      <img src="images/layout/help_icon.gif" onClick="toggleBox('dbImport');"><br>
      <div id="dbImportSD">Zainstaluje bazê danych oraz przyk³adowe dane</div>
      <div id="dbImport" class="longDescription">Zaznaczaj±c tê opcjê Instalator zaimportuje bazê danych oraz podstawowe dane (wymagane przy pierwszej instalacji)</div>
    </td>
  </tr>
  <tr>
    <td width="30%" valign="top">Automatyczna konfiguracja:</td>
    <td width="70%" class="smallDesc">
      <?php echo osc_draw_checkbox_field('install[]', 'configure', true); ?>
      <img src="images/layout/help_icon.gif" onClick="toggleBox('autoConfig');"><br>
      <div id="autoConfigSD">Zapisze pliki konfiguracyjne</div>
      <div id="autoConfig" class="longDescription">Zaznaczaj±c tê opcjê Instalator zapisze automatycznie dane instalacyjne do plików konfiguracyjnych (configure.php)</div>
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

</form>
