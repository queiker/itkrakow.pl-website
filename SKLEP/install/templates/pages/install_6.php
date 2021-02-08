<?php
/*
  $Id: install_6.php,v 1.2 2003/07/12 08:10:08 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<p class="pageTitle">Instalacja</p>

<p><b style="color:red">Sprawd¼ poprawno¶æ wprowadzonych danych, je¿eli s± poprawne wci¶nij "Dalej"</b></p>

<form name="install" action="install.php?step=7" method="post">

<table width="95%" border="0" cellpadding="2" class="formPage">
  <tr>
    <td width="30%" valign="top">Serwer bazy danych:</td>
    <td width="70%" class="smallDesc">
      <?php echo osc_draw_input_field('DB_SERVER'); ?>
      <img src="images/layout/help_icon.gif" onClick="toggleBox('dbHost');"><br>
      <div id="dbHostSD">Mo¿e to byæ nazwa lub adres IP</div>
      <div id="dbHost" class="longDescription">np. sql.domena.pl, lub 212.168.0.1</div>
    </td>
  </tr>
  <tr>
    <td width="30%" valign="top">U¿ytkownik:</td>
    <td width="70%" class="smallDesc">
      <?php echo osc_draw_input_field('DB_SERVER_USERNAME'); ?>
      <img src="images/layout/help_icon.gif"  onClick="toggleBox('dbUser');"><br>
      <div id="dbUserSD">Nazwa u¿ytkownika bazy danych</div>
      <div id="dbUser" class="longDescription">Wpisany u¿ytkownik <B>musi mieæ uprawnienia</B> do tworzenia tabel w bazie danych.</div>
    </td>
  </tr>
  <tr>
    <td width="30%" valign="top">Has³o:</td>
    <td width="70%" class="smallDesc">
      <?php echo osc_draw_password_field('DB_SERVER_PASSWORD'); ?>
      <img src="images/layout/help_icon.gif" onClick="toggleBox('dbPass');"><br>
      <div id="dbPassSD">Has³o do bazy danych</div>
      <div id="dbPass" class="longDescription">Has³o jest u¿ywane wraz z nazw± u¿ytkownika i razem tworz± <b>konto u¿ytkownika</B>.</div>
    </td>
  </tr>
  <tr>
    <td width="30%" valign="top">Nazwa bazy danych:</td>
    <td width="70%" class="smallDesc">
      <?php echo osc_draw_input_field('DB_DATABASE'); ?>
      <img src="images/layout/help_icon.gif" onClick="toggleBox('dbName');"><br>
      <div id="dbNameSD">Nazwa bazy danych</div>
      <div id="dbName" class="longDescription">Providerzy internetowi stosuj± ró¿ne nazwy baz danych. Najcze¶ciej jest to nazwa taka sama jak nazwa u¿ytkownika ale mo¿e to byæ równie dobrze '22302s'. </div>
    </td>
  </tr>
  <tr>
    <td width="30%" valign="top">Sta³e po³±czenia:</td>
    <td width="70%" class="smallDesc">
      <?php echo osc_draw_checkbox_field('USE_PCONNECT', 'true'); ?>
      <img src="images/layout/help_icon.gif" onClick="toggleBox('dbConn');"><br>
      <div id="dbConnSD">W³±cza sta³e po³±czenia</div>
      <div id="dbConn" class="longDescription">Uwaga: Dotyczy tylko serwerów, na których znajduje siê tylko <b>jedna baza danych</B>. W przypadku serwerów (wiekszo¶æ) obs³uguj±cych wiele baz danych nie w³±czaj tej opcji !</div>
    </td>
  </tr>
  <tr>
    <td width="30%" valign="top">Przechowywanie sesji:</td>
    <td width="70%" class="smallDesc">
      <?php echo osc_draw_radio_field('STORE_SESSIONS', 'files', (isset($_POST['STORE_SESSIONS']) ? '' : true)); ?>&nbsp;Pliki&nbsp;&nbsp;<?php echo osc_draw_radio_field('STORE_SESSIONS', 'mysql'); ?>&nbsp;Baza danych&nbsp;&nbsp;
      <img src="images/layout/help_icon.gif" onClick="toggleBox('dbSess');"><br>
      <div id="dbSessSD">Sposób przechowywania sesji u¿ytkowników</div>
      <div id="dbSess" class="longDescription">Przechowuj sesje u¿ytkowników w plikach lub w bazie danych. Ze wzglêdów bezpieczeñstwa, na serwerach obs³uguj±cych wiele baz danych, <B>zaleca siê przechowywanie sesji w bazie danych</B>.</td></div>
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
    if (($key != 'x') && ($key != 'y') && ($key != 'DB_SERVER') && ($key != 'DB_SERVER_USERNAME') && ($key != 'DB_SERVER_PASSWORD') && ($key != 'DB_DATABASE') && ($key != 'USE_PCONNECT') && ($key != 'STORE_SESSIONS')) {
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
