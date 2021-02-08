<?php
/*
  $Id: login.php,v 1.14 2003/06/08 08:14:17 ramroz Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Publikowane na zasadach licencji GNU General Public License

  T³umaczenie: Rafa³ Mróz ramroz@optimus.pl
  http://www.portalik.com

*/

define('NAVBAR_TITLE', 'Logowanie');
define('HEADING_TITLE', 'Witaj, Zaloguj Siê');

define('HEADING_NEW_CUSTOMER', 'Nowy Klient');
define('TEXT_NEW_CUSTOMER', 'Jestem nowym klientem.');
define('TEXT_NEW_CUSTOMER_INTRODUCTION', 'Tworz±c konto w ' . STORE_NAME . ' bêdziesz móg³ szybciej robiæ zakupy, ¶ledziæ status swoich zamówieñ i ogl±daæ historiê swoich zakupów.');

define('HEADING_RETURNING_CUSTOMER', 'Zarejestrowany Klient');
define('TEXT_RETURNING_CUSTOMER', 'Jestem zarejestrowanym klientem i mam ju¿ konto.');

define('TEXT_PASSWORD_FORGOTTEN', 'Zapomnia³e¶ has³o? Kliknij tutaj.');

//TotalB2B start
define('TEXT_LOGIN_ERROR', 'B³±d: Adres E-Mail i/lub Has³o nie zgadzaj± siê i/lub konto nie zosta³o Aktywowane.');
//TotalB2B end

define('TEXT_VISITORS_CART', '<font color="#ff0000"><b>INFORMACJA:</b></font> Zawarto¶æ twojego &quot;Koszyka Go¶cia&quot; zostanie dodana do twojego &quot;Koszyka Klienta&quot; w momencie zalogowania. <a href="javascript:session_win();">[Wiêcej informacji]</a>');

define('PWA_FAIL_ACCOUNT_EXISTS', 'Istnieje ju¿ konto dla adresu email: {EMAIL_ADDRESS}.  Musisz siê zalogowaæ podaj±c has³o przed przej¶ciem do finalizacji zamówienia.');
define('HEADING_CHECKOUT', '<font size="2">Przejd¼ do finalizacji zamówienia</font>');
define('TEXT_CHECKOUT_INTRODUCTION', 'Przejd¼ do kasy bez zak³adania konta. Wybieraj±c tê opcjê nie bêdziesz móg³ ¶ledziæ statusu zamówienia ani przegl±daæ historii swoich zakupów.');
define('PROCEED_TO_CHECKOUT', 'Przejd¼ do Kasy');

?>
