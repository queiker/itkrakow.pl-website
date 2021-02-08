<?php
/*
  $Id: backup.php,v 1.16 2003/06/08 08:14:17 ramroz Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Publikowane na zasadach licencji GNU General Public License

  T³umaczenie: Rafa³ Mróz ramroz@optimus.pl
  http://www.portalik.com

*/

define('HEADING_TITLE', 'Administracja Archiwami Bazy Danych');

define('TABLE_HEADING_TITLE', 'Nazwa');
define('TABLE_HEADING_FILE_DATE', 'Data');
define('TABLE_HEADING_FILE_SIZE', 'Rozmiar');
define('TABLE_HEADING_ACTION', 'Dzia³anie');

define('TEXT_INFO_HEADING_NEW_BACKUP', 'Nowe Archiwum');
define('TEXT_INFO_HEADING_RESTORE_LOCAL', 'Przywracanie Danych');
define('TEXT_INFO_NEW_BACKUP', 'Nie przerywaj procesu archiwizacji - mo¿e potrwaæ kilka minut.');
define('TEXT_INFO_UNPACK', '<br><br>(po rozpakowaniu pliku z archiwum)');
define('TEXT_INFO_RESTORE', 'Nie przerywaj procesu przywracania.<br><br>Im wiêksze archiwum tym wiêcej czasu zajmie ten proces!<br><br>Je¿eli to mo¿liwe u¿yj klienta mysql.<br><br>Na przyk³ad:<br><br><b>mysql -h' . DB_SERVER . ' -u' . DB_SERVER_USERNAME .  ' -p ' . DB_DATABASE . ' < %s </b> %s');
define('TEXT_INFO_RESTORE_LOCAL', 'Nie przerywaj procesu przywracania.<br><br>Im wiêksze archiwum tym wiêcej czasu zajmie ten proces!');
define('TEXT_INFO_RESTORE_LOCAL_RAW_FILE', 'Wczytany plik musi mieæ format sql (tekstowy).');
define('TEXT_INFO_DATE', 'Data:');
define('TEXT_INFO_SIZE', 'Rozmiar:');
define('TEXT_INFO_COMPRESSION', 'Kompresja:');
define('TEXT_INFO_USE_GZIP', 'U¿yj GZIP');
define('TEXT_INFO_USE_ZIP', 'U¿yj ZIP');
define('TEXT_INFO_USE_NO_COMPRESSION', 'Bez Kompresji (Czysty SQL)');
define('TEXT_INFO_DOWNLOAD_ONLY', 'Tylko ¶ci±ganie pliku (nie przechowuj go na serwerze)');
define('TEXT_INFO_BEST_THROUGH_HTTPS', 'Najlepiej z po³±czeniem HTTPS');
define('TEXT_DELETE_INTRO', 'Czy na pewno chcesz usun±æ to archiwum?');
define('TEXT_NO_EXTENSION', 'Brak');
define('TEXT_BACKUP_DIRECTORY', 'Katalog Archiwum:');
define('TEXT_LAST_RESTORATION', 'Ostatnie Przywracanie:');
define('TEXT_FORGET', '(<u>zapomnij</u>)');

define('ERROR_BACKUP_DIRECTORY_DOES_NOT_EXIST', 'B³±d: Katalog archiwizacji nie istnieje. Ustaw go w pliku configure.php.');
define('ERROR_BACKUP_DIRECTORY_NOT_WRITEABLE', 'B³±d: Nie mo¿na zapisywaæ do katalogu archiwizacji.');
define('ERROR_DOWNLOAD_LINK_NOT_ACCEPTABLE', 'B³±d: Problem z linkiem do ¶ci±gniêcia pliku.');

define('SUCCESS_LAST_RESTORE_CLEARED', 'Powiod³o siê: Data ostatniego odtworzenia zosta³a usuniêta.');
define('SUCCESS_DATABASE_SAVED', 'Powiod³o siê: Baza zosta³a zachowana.');
define('SUCCESS_DATABASE_RESTORED', 'Powiod³o siê: Baza zosta³a przywrócona.');
define('SUCCESS_BACKUP_DELETED', 'Powiod³o siê: Archiwum zosta³o usuniête.');

?>
