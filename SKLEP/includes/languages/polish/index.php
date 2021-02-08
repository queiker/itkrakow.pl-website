<?php
/*
  $Id: index.php,v 1.1 2003/06/08 08:14:17 ramroz Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Publikowane na zasadach licencji GNU General Public License

  T³umaczenie: Rafa³ Mróz ramroz@optimus.pl
  http://www.portalik.com

*/

define('TEXT_MAIN', '');
define('TABLE_HEADING_NEW_PRODUCTS', 'Nowe produkty %s');
define('TABLE_HEADING_UPCOMING_PRODUCTS', 'Wkrótce');
define('TABLE_HEADING_DATE_EXPECTED', 'Data wprowadzenia');
define('TABLE_HEADING_DEFAULT_SPECIALS', 'Promocje %s');

if ( ($category_depth == 'products') || (isset($HTTP_GET_VARS['manufacturers_id'])) ) {
  define('HEADING_TITLE', 'Lista produktów');
  define('TABLE_HEADING_IMAGE', '');
  define('TABLE_HEADING_MODEL', 'Model');
  define('TABLE_HEADING_PRODUCTS', 'Nazwa');
  define('TABLE_HEADING_MANUFACTURER', 'Producent');
  define('TABLE_HEADING_QUANTITY', 'Ilo¶æ');
  define('TABLE_HEADING_PRICE', 'Cena');
  define('TABLE_HEADING_WEIGHT', 'Waga');
  define('TABLE_HEADING_BUY_NOW', 'Do Koszyka');
  define('TEXT_NO_PRODUCTS', 'Brak produktów w tej kategorii.');
  define('TEXT_NO_PRODUCTS2', 'Brak produktów tego producenta.');
  define('TEXT_NUMBER_OF_PRODUCTS', 'Ilo¶æ Produktów: ');
  define('TEXT_SHOW', '<b>Poka¿:</b>');
  define('TEXT_BUY', 'Do koszyka: \'');
  define('TEXT_NOW', '');
  define('TEXT_ALL', 'Wszystko');
  define('TEXT_ALL_MANUFACTURERS', 'Wszyscy Producenci');
  define('TEXT_ALL_CATEGORIES', 'Wszystkie Kategorie');
  define('TEXT_ALL_AVL', 'Wszystkie Produkty');
  define('TEXT_ON_AVL', 'Tylko Dostêpne');

  define('TEXT_SHOW_MANUFACTURERS', 'Poka¿ producenta:');
  define('TEXT_SHOW_CATEGORIES', 'Poka¿ kategorie:');
  define('TEXT_SHOW_AVL', 'Poka¿ produkty:');
  define('TEXT_SHOW_SORT', 'Sortuj produkty wg:');
  define('TEXT_PRODUKTU',' Produktu');
} elseif ($category_depth == 'top') {
  define('HEADING_TITLE', 'Witamy w naszym serwisie !');
} elseif ($category_depth == 'nested') {
  define('HEADING_TITLE', 'Kategorie');

}
?>
