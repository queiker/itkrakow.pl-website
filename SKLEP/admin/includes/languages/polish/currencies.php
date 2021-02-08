<?php
/*
  $Id: currencies.php,v 1.12 2003/06/08 08:14:17 ramroz Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Publikowane na zasadach licencji GNU General Public License

  T³umaczenie: Rafa³ Mróz ramroz@optimus.pl
  http://www.portalik.com

*/

define('HEADING_TITLE', 'Waluty');

define('TABLE_HEADING_CURRENCY_NAME', 'Waluta');
define('TABLE_HEADING_CURRENCY_CODES', 'Kod');
define('TABLE_HEADING_CURRENCY_VALUE', 'Warto¶æ');
define('TABLE_HEADING_ACTION', 'Dzia³anie');

define('TEXT_INFO_EDIT_INTRO', 'Wprowad¼ niezbêdne zmiany');
define('TEXT_INFO_CURRENCY_TITLE', 'Nazwa:');
define('TEXT_INFO_CURRENCY_CODE', 'Kod:');
define('TEXT_INFO_CURRENCY_SYMBOL_LEFT', 'Symbol z Lewej:');
define('TEXT_INFO_CURRENCY_SYMBOL_RIGHT', 'Symbol z Prawej:');
define('TEXT_INFO_CURRENCY_DECIMAL_POINT', 'Separator Decymalny:');
define('TEXT_INFO_CURRENCY_THOUSANDS_POINT', 'Separator Tysiêcy:');
define('TEXT_INFO_CURRENCY_DECIMAL_PLACES', 'Ilo¶æ Miejsc Po Przecinku:');
define('TEXT_INFO_CURRENCY_LAST_UPDATED', 'Ostatnia Aktalizacja:');
define('TEXT_INFO_CURRENCY_VALUE', 'Warto¶æ:');
define('TEXT_INFO_CURRENCY_EXAMPLE', 'Przyk³ad:');
define('TEXT_INFO_INSERT_INTRO', 'Wprowad¼ now± walutê i jej niezbêdne dane');
define('TEXT_INFO_DELETE_INTRO', 'Czy na pewno chcesz usun±æ t± walutê?');
define('TEXT_INFO_HEADING_NEW_CURRENCY', 'Nowa Waluta');
define('TEXT_INFO_HEADING_EDIT_CURRENCY', 'Edytuj Walutê');
define('TEXT_INFO_HEADING_DELETE_CURRENCY', 'Usuñ Walutê');
define('TEXT_INFO_SET_AS_DEFAULT', TEXT_SET_DEFAULT . ' (wymaga rêcznej aktualizacji kursu waluty)');
define('TEXT_INFO_CURRENCY_UPDATED', 'Kurs wymiany dla %s (%s) zosta³ pomy¶lnie zaktualizowany poprzez serwer %s.');

define('ERROR_REMOVE_DEFAULT_CURRENCY', 'B³±d: Domy¶lna waluta nie mo¿e byæ usuniêta. Wybierz inn± walutê jako domy¶ln± i spróbuj ponownie.');
define('ERROR_CURRENCY_INVALID', 'B³±d: Kur wymiany dla %s (%s) nie zosta³ zaktualizowany poprzez serwer %s. Czy taki symbol waluty istnieje?');
define('WARNING_PRIMARY_SERVER_FAILED', 'Uwaga: Podstawowy serwer aktualizacji kursów wymiany (%s) nie odpowiedzia³ na akutualizacjê waluty %s (%s) - próbujê na drugim zapasowym serwerze.');
?>
