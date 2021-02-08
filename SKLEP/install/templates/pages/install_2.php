<?php
/*
  $Id: install_2.php,v 1.7 2003/07/12 08:10:08 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>

<p class="pageTitle">Instalacja</p>

<p><b>Import bazy danych</b></p>

<?php
  if (isset($_POST['DB_SERVER']) && !empty($_POST['DB_SERVER']) && isset($_POST['DB_TEST_CONNECTION']) && ($_POST['DB_TEST_CONNECTION'] == 'true')) {
    $db = array();
    $db['DB_SERVER'] = trim(stripslashes($_POST['DB_SERVER']));
    $db['DB_SERVER_USERNAME'] = trim(stripslashes($_POST['DB_SERVER_USERNAME']));
    $db['DB_SERVER_PASSWORD'] = trim(stripslashes($_POST['DB_SERVER_PASSWORD']));
    $db['DB_DATABASE'] = trim(stripslashes($_POST['DB_DATABASE']));

    $db_error = false;
    osc_db_connect($db['DB_SERVER'], $db['DB_SERVER_USERNAME'], $db['DB_SERVER_PASSWORD']);

    if ($db_error == false) {
      osc_db_test_create_db_permission($db['DB_DATABASE']);
    }

    if ($db_error != false) {
?>
<form name="install" action="install.php?step=2" method="post">

<table width="95%" border="0" cellpadding="2" class="formPage">
  <tr>
    <td>
      <p>Test po³±czenia z baz± danych <b>NIE POWIÓD£ SIÊ</b>.</p>
      <p>Wyst±pi³ nastêpuj±cy b³±d:</p>
      <p class="boxme"><?php echo $db_error; ?></p>
      <p>Wci¶nij przycisk <i>Powrót</i> aby poprawiæ ustawienia bazy danych.</p>
      <p>Je¶li potrzebujesz pomocy, skontaktuj siê ze swoim providerem internetowym.</p>
    </td>
  </tr>
</table>

<?php
      reset($_POST);
      while (list($key, $value) = each($_POST)) {
        if (($key != 'x') && ($key != 'y') && ($key != 'DB_TEST_CONNECTION')) {
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

<p>&nbsp;</p>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><a href="index.php"><img src="images/button_cancel.gif" border="0" alt="Anuluj"></a></td>
    <td align="center"><input type="image" src="images/button_back.gif" border="0" alt="Powrót"></td>
  </tr>
</table>

</form>

<?php
    } else {
      $script_filename = getenv('PATH_TRANSLATED');
      if (empty($script_filename)) {
        $script_filename = getenv('SCRIPT_FILENAME');
      }

      $script_filename = str_replace('\\', '/', $script_filename);
      $script_filename = str_replace('//', '/', $script_filename);

      $dir_fs_www_root_array = explode('/', dirname($script_filename));
      $dir_fs_www_root = array();
      for ($i=0, $n=sizeof($dir_fs_www_root_array)-1; $i<$n; $i++) {
        $dir_fs_www_root[] = $dir_fs_www_root_array[$i];
      }
      $dir_fs_www_root = implode('/', $dir_fs_www_root) . '/';
?>

<form name="install" action="install.php?step=3" method="post">

<table width="95%" border="0" cellpadding="2" class="formPage">
  <tr>
    <td>
      <p>Test po³±czenia z baz± danych <b>POWIÓD£ SIÊ</b>.</p>
      <p>Wci¶nij przycisk <b>Dalej</B> aby rozpocz±æ procedurê importu bazy danych.</p>
      <p>Uwaga! Nie nale¿y przerywaæ procesu importu bazy danych, dane mog± ulec uszkodzeniu.</p>
      <p>Plik zawieraj±cy bazê danych powinien znajdowaæ siê w katalogu:</p>
      <p><?php echo $dir_fs_www_root . 'install/oscommerce.sql'; ?></p>
    </td>
  </tr>
</table>

<?php
      reset($_POST);
      while (list($key, $value) = each($_POST)) {
        if (($key != 'x') && ($key != 'y') && ($key != 'DB_TEST_CONNECTION')) {
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

<p>&nbsp;</p>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><a href="index.php"><img src="images/button_cancel.gif" border="0" alt="Anuluj"></a></td>
    <td align="center"><input type="image" src="images/button_continue.gif" border="0" alt="Dalej"></td>
  </tr>
</table>

</form>

<?php
    }
  } else {
?>

<form name="install" action="install.php?step=2" method="post">

<p><b>Wpisz dane dotycz±ce serwera bazy danych:</b></p>

<table width="95%" border="0" cellpadding="2" class="formPage">
  <tr>
    <td width="30%" valign="top">Serwer bazy danych:</td>
    <td width="70%" class="smallDesc">
      <?php echo osc_draw_input_field('DB_SERVER'); ?>
      <img src="images/layout/help_icon.gif" onClick="toggleBox('dbHost');"><br>
      <div id="dbHostSD">Mo¿e to byæ nazwa lub adres IP</div>
      <div id="dbHost" class="longDescription">np. sql.domena.pl, 212.168.0.1 lub localhost</div>
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
      <?php echo osc_draw_radio_field('STORE_SESSIONS', 'files', true); ?>&nbsp;Pliki&nbsp;&nbsp;<?php echo osc_draw_radio_field('STORE_SESSIONS', 'mysql'); ?>&nbsp;Baza danych&nbsp;&nbsp;
      <img src="images/layout/help_icon.gif" onClick="toggleBox('dbSess');"><br>
      <div id="dbSessSD">Sposób przechowywania sesji u¿ytkowników</div>
      <div id="dbSess" class="longDescription">Przechowuj sesje u¿ytkowników w plikach lub w bazie danych. Ze wzglêdów bezpieczeñstwa, na serwerach obs³uguj±cych wiele baz danych, <B>zaleca siê przechowywanie sesji w bazie danych</B>.</td></div>
    </td>
  </tr>
</table>

<p>&nbsp;</p>

<table border="0" width="100%" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center"><a href="index.php"><img src="images/button_cancel.gif" border="0" alt="Anuluj"></a></td>
    <td align="center"><input type="image" src="images/button_continue.gif" border="0" alt="Dalej"></td>
  </tr>
</table>

<?php
  reset($_POST);
  while (list($key, $value) = each($_POST)) {
    if (($key != 'x') && ($key != 'y') && ($key != 'DB_SERVER') && ($key != 'DB_SERVER_USERNAME') && ($key != 'DB_SERVER_PASSWORD') && ($key != 'DB_DATABASE') && ($key != 'USE_PCONNECT') && ($key != 'STORE_SESSIONS') && ($key != 'DB_TEST_CONNECTION')) {
      if (is_array($value)) {
        for ($i=0; $i<sizeof($value); $i++) {
          echo osc_draw_hidden_field($key . '[]', $value[$i]);
        }
      } else {
        echo osc_draw_hidden_field($key, $value);
      }
    }
  }

  echo osc_draw_hidden_field('DB_TEST_CONNECTION', 'true');
?>

</form>

<?php
  }
?>
