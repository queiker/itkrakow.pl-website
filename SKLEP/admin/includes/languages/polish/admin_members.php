<?php
/*
  $Id: admin_members.php,v 1.13 2002/08/19 01:45:58 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

if ($HTTP_GET_VARS['gID']) {
  define('HEADING_TITLE', 'Grupy Administracyjne');
} elseif ($HTTP_GET_VARS['gPath']) {
  define('HEADING_TITLE', 'Definiowanie uprawnieñ grup');
} else {
  define('HEADING_TITLE', 'Administratorzy');
}

define('TEXT_COUNT_GROUPS', 'Grupy: ');

define('TABLE_HEADING_NAME', 'Nazwa');
define('TABLE_HEADING_EMAIL', 'Adres E-mail');
define('TABLE_HEADING_PASSWORD', 'Has³o');
define('TABLE_HEADING_CONFIRM', 'Potwierdzenie Has³a');
define('TABLE_HEADING_GROUPS', 'Poziom uprawnieñ');
define('TABLE_HEADING_CREATED', 'Utworzono');
define('TABLE_HEADING_MODIFIED', 'Zmodyfikowano');
define('TABLE_HEADING_LOGDATE', 'Ostatnie Logowanie');
define('TABLE_HEADING_LOGNUM', 'Liczba Logowañ');
define('TABLE_HEADING_LOG_NUM', 'Liczba Logowañ');
define('TABLE_HEADING_ACTION', 'Dzia³ania');

define('TABLE_HEADING_GROUPS_NAME', 'Nazwy Grup');
define('TABLE_HEADING_GROUPS_DEFINE', 'Wybór boxów i plików');
define('TABLE_HEADING_GROUPS_GROUP', 'Poziom');
define('TABLE_HEADING_GROUPS_CATEGORIES', 'Kategorie uprawnieñ');


define('TEXT_INFO_HEADING_DEFAULT', 'Administrator ');
define('TEXT_INFO_HEADING_DELETE', 'Kasuj Uprawnienia ');
define('TEXT_INFO_HEADING_EDIT', 'Edycja Kategorii / ');
define('TEXT_INFO_HEADING_EDIT_GROUP', 'Edycja Nazwy Grupy ');
define('TEXT_INFO_EDIT_GROUP_INTRO', 'Edycja Nazwy Grupy ');
define('TEXT_INFO_HEADING_NEW', 'Nowy Administrator ');

define('TEXT_INFO_DEFAULT_INTRO', 'Grupa');
define('TEXT_INFO_DELETE_INTRO', 'Usun±æ Cz³onka <nobr><b>%s</b></nobr> <nobr>?</nobr>');
define('TEXT_INFO_DELETE_INTRO_NOT', 'Nie mo¿esz skasowaæ grupy  <nobr>%s !</nobr>');
define('TEXT_INFO_EDIT_INTRO', 'Nadaj poziom uprawnieñ tutaj: ');

define('TEXT_INFO_FULLNAME', 'Nazwa: ');
define('TEXT_INFO_FIRSTNAME', 'Imiê: ');
define('TEXT_INFO_LASTNAME', 'Nazwisko: ');
define('TEXT_INFO_EMAIL', 'Adres E-mail: ');
define('TEXT_INFO_PASSWORD', 'Has³o: ');
define('TEXT_INFO_CONFIRM', 'Potwierdzenie Has³a: ');
define('TEXT_INFO_CREATED', 'Utworzony: ');
define('TEXT_INFO_MODIFIED', 'Zmodyfikowany: ');
define('TEXT_INFO_LOGDATE', 'Ostanie Logowanie: ');
define('TEXT_INFO_LOGNUM', 'Liczba Logowañ: ');
define('TEXT_INFO_GROUP', 'Grupa: ');
define('TEXT_INFO_ERROR', '<font color="red">Podany adres jest ju¿ u¿ywany! Spróbuj ponownie!.</font>');

define('JS_ALERT_FIRSTNAME', '- Wymagane: Imiê \n');
define('JS_ALERT_LASTNAME', '- Wymagane: Nazwisko \n');
define('JS_ALERT_EMAIL', '- Wymagane: Adres E-mail \n');
define('JS_ALERT_EMAIL_FORMAT', '- Format Adres E-mail jest niepoprawny! \n');
define('JS_ALERT_EMAIL_USED', '- Adres E-mail jest ju¿ u¿ywany! \n');
define('JS_ALERT_LEVEL', '- Wymagane: Grupa \n');

define('ADMIN_EMAIL_SUBJECT', 'Nowy Administrator');
define('ADMIN_EMAIL_TEXT', 'Witaj %s,' . "\n\n" . 'Masz dostêp do panelu administracyjnego za pomoc± nastêpuj±cych danych. Po pierwszym logowaniu zmieñ swoje has³o!' . "\n\n" . 'Adres : %s' . "\n" . 'U¿ytkownik: %s' . "\n" . 'has³o: %s' . "\n\n" . 'Dziêkujemy!' . "\n" . '%s' . "\n\n" . 'Ten mail zosta³ wygenerowany automatycznie. Prosimy nie odpowiadaæ!'); 

define('TEXT_INFO_HEADING_DEFAULT_GROUPS', 'Administracja Grup± ');
define('TEXT_INFO_HEADING_DELETE_GROUPS', 'Kasuj Grupê ');

define('TEXT_INFO_DEFAULT_GROUPS_INTRO', '<b>Uwagi:</b><li><b>Edytuj:</b> edycja Nazwy Grupy.</li><li><b>Usuñ:</b> kasuj Grupê.</li><li><b>Zdefiniuj:</b> definiowanie uprawnieñ Grupy.</li>');
define('TEXT_INFO_DELETE_GROUPS_INTRO', 'Wszyscy cz³onkowie tej Grupy zostan± skasowani. Czy jeste¶ pewny, ¿e chcesz skasowaæ Grupê: <nobr><b>%s</b>?</nobr>');
define('TEXT_INFO_DELETE_GROUPS_INTRO_NOT', 'Nie mo¿esz skasowaæ tej grupy!');
define('TEXT_INFO_GROUPS_INTRO', 'Wprowad¼ nunikaln± nazwê grupy. Kliknij dalej!.');

define('TEXT_INFO_HEADING_GROUPS', 'Nowa grupa');
define('TEXT_INFO_GROUPS_NAME', ' <b>Nazwa Grupy:</b><br>Wprowad¼ unikaln± nazwê Grupy i kliknij dalej.<br>');
define('TEXT_INFO_GROUPS_NAME_FALSE', '<font color="red"><b>B³±d:</b> Liczba znaków w nazwie Grupy musi wynosiæ co najmniej 5.</font>');
define('TEXT_INFO_GROUPS_NAME_USED', '<font color="red"><b>B³±d:</b> Nazwa Grupy ju¿ istnieje!</font>');
define('TEXT_INFO_GROUPS_LEVEL', 'Poziom uprawnieñ: ');
define('TEXT_INFO_GROUPS_BOXES', '<b>Boxes Permission:</b><br>Give access to selected boxes.');
define('TEXT_INFO_GROUPS_BOXES_INCLUDE', 'Include files stored in: ');

define('TEXT_INFO_HEADING_DEFINE', 'Definiowanie Uprawnieñ Grupy');
if ($HTTP_GET_VARS['gPath'] == 1) {
  define('TEXT_INFO_DEFINE_INTRO', '<b>%s :</b><br>Nie mo¿na zmieniaæ uprawnieñ tej grupy.<br><br>');
} else {
  define('TEXT_INFO_DEFINE_INTRO', '<b>%s :</b><br>Zmian mo¿na dokonaæ poprzez zaznaczenie b±d¼ odznaczenie box\'ów i plików. Aby zachowaæ zmiany naci¶nij <b>Zachowaj</b>.<br><br>');
}

define('ADMIN_EMAIL_EDIT_SUBJECT', 'Modyfikacja danych osobowych');
define('ADMIN_EMAIL_EDIT_TEXT', 'Witaj %s,' . "\n\n" . 'Twoje dane osobowe zosta³y zmodyfikowane przez administratora.' . "\n\n" . 'Adres : %s' . "\n" . 'U¿ytkownik: %s' . "\n" . 'Has³o: %s' . "\n\n" . 'Dziêkujemy!' . "\n" . '%s' . "\n\n" . 'Ten mail zosta³ wygenerowany automatycznie. Prosimy nie odpowiadaæ!');
?>
