<?php
/*
  $Id: banner_manager.php,v 1.17 2003/06/08 08:14:17 ramroz Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Publikowane na zasadach licencji GNU General Public License

  T³umaczenie: Rafa³ Mróz ramroz@optimus.pl
  http://www.portalik.com

*/

define('HEADING_TITLE', 'Zarz±dzanie Banerami');

define('TABLE_HEADING_BANNERS', 'Baner');
define('TABLE_HEADING_GROUPS', 'Grupa');
define('TABLE_HEADING_STATISTICS', 'Wy¶wietleñ / Klikniêæ');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_ACTION', 'Dzia³anie');

define('TEXT_BANNERS_TITLE', 'Nazwa Banera:');
define('TEXT_BANNERS_URL', 'URL Banera:');
define('TEXT_BANNERS_GROUP', 'Grupa:');
define('TEXT_BANNERS_NEW_GROUP', ', lub wprowad¼ now± grupê banerów poni¿ej');
define('TEXT_BANNERS_IMAGE', 'Obrazek:');
define('TEXT_BANNERS_IMAGE_LOCAL', ', lub podaj ¶cie¿kê do pliku lokalnego');
define('TEXT_BANNERS_IMAGE_TARGET', 'Obrazek Zapisz Do:');
define('TEXT_BANNERS_HTML_TEXT', 'Tekst HTML:');
define('TEXT_BANNERS_EXPIRES_ON', 'Wygasa Dnia:');
define('TEXT_BANNERS_OR_AT', ', lub po');
define('TEXT_BANNERS_IMPRESSIONS', 'wy¶wietleniach.');
define('TEXT_BANNERS_SCHEDULED_AT', 'Rozpoczêcie Dnia:');
define('TEXT_BANNERS_BANNER_NOTE', '<b>Informacje o Banerze:</b><ul><li>U¿yj obrazka lub tekstu HTML jako banera - nie obu na raz.</li><li>Tekst HTML ma wy¿szy priorytet ni¿ obrazek.</li></ul>');
define('TEXT_BANNERS_INSERT_NOTE', '<b>Informacje o Obrazku:</b><ul><li>Katalogi w których chcesz umie¶ciæ obrazki musz± mieæ odpowiednie uprawnienia (zapis)!</li><li>Nie wype³niaj pola \'Obrazek Zapisz Do\' je¿eli wgrywasz obrazek na serwer
(np., je¿eli u¿ywasz lokalnego obrazka - znajduj±cego siê na dysku serwera).</li><li>Pole \'Obrazek Zapisz Do\' musi wskazywaæ na istniej±cy katalog i koñczyæ siê slashem (np. banners/).</li></ul>');
define('TEXT_BANNERS_EXPIRCY_NOTE', '<b>Informacje o Wyga¶niêciu:</b><ul><li>Tylko jedno z dwóch pól powinno byæ wype³nione</li><li>Je¿eli nie chcesz aby baner wygas³ automatycznie pozostaw to pole puste</li></ul>');
define('TEXT_BANNERS_SCHEDULE_NOTE', '<b>Informacje o Rozpoczêciu:</b><ul><li>Je¿eli pole \'Rozpoczêcie Dnia\' jest ustawione  emisja banera rozpocznie siê w tym dniu.</li><li>Wszystkie banery z ustawion± dat± startu emisji zaznaczone
 s± jako wy³±czone. W³±cz± siê gdy data rozpoczêcia nadejdzie.</li></ul>');

define('TEXT_BANNERS_DATE_ADDED', 'Data Dodania:');
define('TEXT_BANNERS_SCHEDULED_AT_DATE', 'Rozpoczêcie Dnia: <b>%s</b>');
define('TEXT_BANNERS_EXPIRES_AT_DATE', 'Wygasa Dnia: <b>%s</b>');
define('TEXT_BANNERS_EXPIRES_AT_IMPRESSIONS', 'Wygasa Po: <b>%s</b> wy¶wietl.');
define('TEXT_BANNERS_STATUS_CHANGE', 'Zmiana Statusu: %s');

define('TEXT_BANNERS_DATA', 'D<br>A<br>N<br>E');
define('TEXT_BANNERS_LAST_3_DAYS', 'Ostatnie 3 Dni');
define('TEXT_BANNERS_BANNER_VIEWS', 'Wy¶wietlenia');
define('TEXT_BANNERS_BANNER_CLICKS', 'Klikniêcia');

define('TEXT_INFO_DELETE_INTRO', 'Czy na pewno chcesz usun±æ ten baner?');
define('TEXT_INFO_DELETE_IMAGE', 'Usuñ równie¿ obrazek');

define('SUCCESS_BANNER_INSERTED', 'Powiod³o siê: Baner zosta³ dodany.');
define('SUCCESS_BANNER_UPDATED', 'Powiod³o siê: Baner zosta³ zaktualizowany.');
define('SUCCESS_BANNER_REMOVED', 'Powiod³o siê: Baner zosta³ usuniêty.');
define('SUCCESS_BANNER_STATUS_UPDATED', 'Powiod³o siê: Status banera zosta³ zaktualizowany.');

define('ERROR_BANNER_TITLE_REQUIRED', 'B³±d: Wymagana nazwa banera.');
define('ERROR_BANNER_GROUP_REQUIRED', 'B³±d: Wymagana grupa banera.');
define('ERROR_IMAGE_DIRECTORY_DOES_NOT_EXIST', 'B³±d: Katalog nie istnieje: %s');
define('ERROR_IMAGE_DIRECTORY_NOT_WRITEABLE', 'B³±d: Nie mo¿na zapisywaæ do katalogu: %s');
define('ERROR_IMAGE_DOES_NOT_EXIST', 'B³±d: Obrazek nie istnieje.');
define('ERROR_IMAGE_IS_NOT_WRITEABLE', 'B³±d: Obrazek nie mo¿e zostaæ usuniêty.');
define('ERROR_UNKNOWN_STATUS_FLAG', 'B³±d: Nieznany status.');

define('ERROR_GRAPHS_DIRECTORY_DOES_NOT_EXIST', 'B³±d: Katalog wykresów nie istnieje. Proszê utworzyæ katalog \'graphs\' w katalogu \'images\'.');
define('ERROR_GRAPHS_DIRECTORY_NOT_WRITEABLE', 'B³±d: Nie mo¿na zapistywaæ do katalogu wykresów.');
?>
