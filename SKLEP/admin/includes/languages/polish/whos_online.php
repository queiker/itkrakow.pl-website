<?php
/*
  $Id: whos_online.php,v 3.5.4 2008/7/8 SteveDallas Exp $
  
  2008 Jul 08 v3.5.4 Glen Hoag aka SteveDallas Modified TEXT_NUMBER_OF_CUSTOMERS for formatting change
  2008 Jun 13 v3.5   Glen Hoag aka SteveDallas Moved version number out of language files
                                               Added string TEXT_ACTIVE_CUSTOMERS
                                               Added string TEXT_SHOW_BOTS

  updated version number because of version number jumble and provide installation instructions.
  corection french by azer
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

// added for version 1.9 - to be translated to the right language BOF ******
define('AZER_WHOSONLINE_WHOIS_URL', 'http://www.dnsstuff.com/tools/whois.ch?ip='); //for version 2.9 by azer - whois ip
define('TEXT_NOT_AVAILABLE', '   <b>Note:</b> N/A = Adres IP nieznany'); //for version 2.9 by azer was missing
define('TEXT_LAST_REFRESH', 'Ostatnie od¶wie¿enie'); //for version 2.9 by azer was missing
define('TEXT_EMPTY', 'Empty'); //for version 2.8 by azer was missing
define('TEXT_MY_IP_ADDRESS', 'Mój adres IP '); //for version 2.8 by azer was missing
define('TABLE_HEADING_COUNTRY', 'Kraj'); // azerc : 25oct05 for contrib whos_online with country and flag
// added for version 1.9 EOF *************************************************

define('HEADING_TITLE', 'Statystyki odwiedzin sklepu');  // Version update to 3.2 because of multiple 1.x and 2.x jumble.  apr-07 by nerbonne
define('TABLE_HEADING_ONLINE', 'Online');
define('TABLE_HEADING_CUSTOMER_ID', 'ID');
define('TABLE_HEADING_FULL_NAME', 'Nazwa');
define('TABLE_HEADING_IP_ADDRESS', 'Adres IP');
define('TABLE_HEADING_ENTRY_TIME', 'Wej¶cie');
define('TABLE_HEADING_LAST_CLICK', 'Ost. klik');
define('TABLE_HEADING_LAST_PAGE_URL', 'Ostatni URL');
define('TABLE_HEADING_ACTION', 'Dzia³anie');
define('TABLE_HEADING_SHOPPING_CART', 'Koszyk');
define('TEXT_SHOPPING_CART_SUBTOTAL', 'Podsuma');
define('TEXT_NUMBER_OF_CUSTOMERS', 'U¿ytkowników(s) online (uznawani za nieaktywnych po 5 minutach. Usuwani po 15 minutach)');
define('TABLE_HEADING_HTTP_REFERER', 'Referer?');
define('TEXT_HTTP_REFERER_URL', 'HTTP Referer URL');
define('TEXT_HTTP_REFERER_FOUND', 'Tak');
define('TEXT_HTTP_REFERER_NOT_FOUND', 'Nie');
define('TEXT_STATUS_ACTIVE_CART', 'Aktywny z koszykiem');
define('TEXT_STATUS_ACTIVE_NOCART', 'Aktywny bez koszyka');
define('TEXT_STATUS_INACTIVE_CART', 'Nieaktywny z koszykiem');
define('TEXT_STATUS_INACTIVE_NOCART', 'Nieaktywny bez koszyka');
define('TEXT_STATUS_NO_SESSION_BOT', 'Nieaktywny robot bez sesji'); //Azer !!! check if right description
define('TEXT_STATUS_INACTIVE_BOT', 'Nieaktywny robot z sesj± '); //Azer !!! check if right description
define('TEXT_STATUS_ACTIVE_BOT', 'Aktywny robot z sesj± '); //Azer !!! check if right description
define('TABLE_HEADING_COUNTRY', 'Kraj');
define('TABLE_HEADING_USER_SESSION', 'Sesja?');
define('TEXT_IN_SESSION', 'Tak');
define('TEXT_NO_SESSION', 'Nie');

define('TEXT_OSCID', 'osCsid');
define('TEXT_PROFILE_DISPLAY', 'Profil wy¶wietlania');
define('TEXT_USER_AGENT', 'User Agent');
define('TEXT_ERROR', 'B³±d!');
define('TEXT_ADMIN', 'Admin');
define('TEXT_DUPLICATE_IP', 'Zdyblowane adresy IP');
define('TEXT_BOTS', 'Roboty');
define('TEXT_ME', 'Ja!');
define('TEXT_ALL', 'Wszyscy');
define('TEXT_REAL_CUSTOMERS', 'Rzeczywi¶ci klienci');
define('TEXT_ACTIVE_CUSTOMERS', ' aktywnych.');

define('TEXT_YOUR_IP_ADDRESS', 'Twój Adres IP');
define('TEXT_SET_REFRESH_RATE', 'Czêstotliwo¶æ od¶wie¿ania');
define('TEXT_NONE_', 'Wy³aczone');
define('TEXT_CUSTOMERS', 'Klienci');
define('TEXT_SHOW_BOTS', 'Roboty');
?>
