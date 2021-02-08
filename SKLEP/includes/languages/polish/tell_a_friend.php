<?php
/*
  $Id: tell_a_friend.php,v 1.7 2003/06/08 08:14:17 ramroz Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Publikowane na zasadach licencji GNU General Public License

  T³umaczenie: Rafa³ Mróz ramroz@optimus.pl
  http://www.portalik.com

*/

define('NAVBAR_TITLE', 'Powiedz Znajomemu');
define('HEADING_TITLE', "Powiedz Znajomemu o '%s'");

define('FORM_TITLE_CUSTOMER_DETAILS', 'Twoje Dane');
define('FORM_TITLE_FRIEND_DETAILS', 'Dane Twojego Znajomego');
define('FORM_TITLE_FRIEND_MESSAGE', 'Twoja Wiadomo¶æ');

define('FORM_FIELD_CUSTOMER_NAME', 'Imiê i Nazwisko:');
define('FORM_FIELD_CUSTOMER_EMAIL', 'Adres Email:');
define('FORM_FIELD_FRIEND_NAME', 'Imiê Znajomego:');
define('FORM_FIELD_FRIEND_EMAIL', 'Adres Email Znajomego:');

define('TEXT_EMAIL_SUCCESSFUL_SENT', 'Twoja wiadomo¶æ na temat produktu <b>%s</b> zosta³a wys³ana na adres <b>%s</b>.');

define('TEXT_EMAIL_SUBJECT', 'Twój znajomy - %s poleci³ Ci doskona³y produkt ze sklepu %s');
define('TEXT_EMAIL_INTRO', 'Witaj %s!' . "\n\n" . 'Twój znajomy - %s pomy¶la³ ¿e mo¿esz byæ zainteresowany produktem %s ze sklepu %s.');
define('TEXT_EMAIL_LINK', 'Aby go obejrzeæ kliknij na poni¿szy link albo skopiuj go do swojej przegl±darki internetowej:' . "\n\n" . '%s');
define('TEXT_EMAIL_SIGNATURE', 'Pozdrowienia,' . "\n\n" . '%s');

define('ERROR_TO_NAME', 'B³±d: Imiê twojego znajomego musi byæ podane.');
define('ERROR_TO_ADDRESS', 'B³±d: Adres e-mail musi mieæ poprawny format.');
define('ERROR_FROM_NAME', 'B³±d: Twoje imiê nie mo¿e byæ puste.');
define('ERROR_FROM_ADDRESS', 'B³±d: Twój adres e-mail musi byæ aktualny i mieæ poprawny format.');
?>
