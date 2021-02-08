<?php
/*
  $Id: admin_members.php,v 1.13 2002/08/19 01:45:58 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Administracja Kontem');

define('TABLE_HEADING_ACCOUNT', 'Moje Konto');

define('TEXT_INFO_FULLNAME', '<b>Nazwa: </b>');
define('TEXT_INFO_FIRSTNAME', '<b>Imiê: </b>');
define('TEXT_INFO_LASTNAME', '<b>Nazwisko: </b>');
define('TEXT_INFO_EMAIL', '<b>Adres E-mail: </b>');
define('TEXT_INFO_PASSWORD', '<b>Has³o: </b>');
define('TEXT_INFO_PASSWORD_HIDDEN', '-UKRYTE-');
define('TEXT_INFO_PASSWORD_CONFIRM', '<b>Potwierdzenie has³a: </b>');
define('TEXT_INFO_CREATED', '<b>Utworzony: </b>');
define('TEXT_INFO_LOGDATE', '<b>Ostatnie Logowanie: </b>');
define('TEXT_INFO_LOGNUM', '<b>Liczba Logowañ: </b>');
define('TEXT_INFO_GROUP', '<b>Grupa: </b>');
define('TEXT_INFO_ERROR', '<font color="red">Podany Adres E-mail jest ju¿ u¿ywany! Spróbuj ponownie!.</font>');
define('TEXT_INFO_MODIFIED', 'Zmodyfikowany: ');

define('TEXT_INFO_HEADING_DEFAULT', 'Edycja Konta ');
define('TEXT_INFO_HEADING_CONFIRM_PASSWORD', 'Potwierdzenie dotychczasowego has³a ');
define('TEXT_INFO_INTRO_CONFIRM_PASSWORD', 'Has³o:');
define('TEXT_INFO_INTRO_CONFIRM_PASSWORD_ERROR', '<font color="red"><b>B³±d:</b> niepoprawne has³o!</font>');
define('TEXT_INFO_INTRO_DEFAULT', 'Kliknij <b>Edycja</b> aby zmieniæ parametry konta.');
define('TEXT_INFO_INTRO_DEFAULT_FIRST_TIME', '<br><b>UWAGA:</b><br>Witaj <b>%s</b>, zalogowa³e¶ siê po raz pierwszy. Zalecana jest zmiana has³a!');
define('TEXT_INFO_INTRO_DEFAULT_FIRST', '<br><b>UWAGA:</b><br>Witaj <b>%s</b>, zalecana jest zmiana adresu e-mail: (<font color="red">admin@localhost.pl</font>) i has³a!');
define('TEXT_INFO_INTRO_EDIT_PROCESS', 'Wszystkie pola s± wymagane. Klinij zachowaj aby zapisaæ zmiany.');

define('JS_ALERT_FIRSTNAME',        '- Wymagane: Imiê \n');
define('JS_ALERT_LASTNAME',         '- Wymagane: Nazwisko \n');
define('JS_ALERT_EMAIL',            '- Wymagane: Addres E-mail \n');
define('JS_ALERT_PASSWORD',         '- Wymagane: Has³o \n');
define('JS_ALERT_FIRSTNAME_LENGTH', '- Imie musi byæ d³u¿sze ni¿ ');
define('JS_ALERT_LASTNAME_LENGTH',  '- Nazwisko musi byæ d³u¿sze ni¿ ');
define('JS_ALERT_PASSWORD_LENGTH',  '- Has³o musi byæ d³u¿sze ni¿ ');
define('JS_ALERT_EMAIL_FORMAT',     '- Format adresu e-mail jest niepoprawny! \n');
define('JS_ALERT_EMAIL_USED',       '- Podany adres e-mail jest ju¿ u¿ywany! \n');
define('JS_ALERT_PASSWORD_CONFIRM', '- Podane has³a nie s± takie same! \n');
define('ADMIN_EMAIL_SUBJECT', 'Zmiana has³a');
define('ADMIN_EMAIL_TEXT', 'Witaj %s,' . "\n\n" . 'Twoje has³o do panelu administracyjnego zosta³o zmienione. Je¿eli nast±pi³o to bez twojej wiedzy koniecznie skontaktuj siê z administratorem!' . "\n\n" . 'Adres : %s' . "\n" . 'U¿ytkownik: %s' . "\n" . 'has³o: %s' . "\n\n" . 'Dziêkujemy!' . "\n" . '%s' . "\n\n" . 'Ten mail zosta³ wygenerowany automatycznie. Prosimy nie odpowiadaæ!');
?>
