<?php
/*
  $Id: advanced_search.php,v 1.15 2003/06/08 08:14:17 ramroz Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Publikowane na zasadach licencji GNU General Public License

  T³umaczenie: Rafa³ Mróz ramroz@optimus.pl
  http://www.portalik.com

*/

define('NAVBAR_TITLE_1', 'Wyszukiwanie Zaawansowane');
define('NAVBAR_TITLE_2', 'Wyniki Wyszukiwania');

define('HEADING_TITLE_1', 'Wyszukiwanie Zaawansowane');
define('HEADING_TITLE_2', 'Produkty spe³niaj±ce kryteria wyszukiwania');

define('HEADING_SEARCH_CRITERIA', 'Kryteria Wyszukiwania');

define('TEXT_SEARCH_IN_DESCRIPTION', 'Szukaj w opisach produktów');
define('ENTRY_CATEGORIES', 'Kategorie:');
define('ENTRY_INCLUDE_SUBCATEGORIES', 'Szukaj w podkategoriach');
define('ENTRY_MANUFACTURERS', 'Producenci:');
define('ENTRY_PRICE_FROM', 'Cena Od:');
define('ENTRY_PRICE_TO', 'Do:');
define('ENTRY_PRICE_TO_FULL', 'Cena Do:');
define('ENTRY_DATE_FROM', 'Data Od:');
define('ENTRY_DATE_TO', 'Do:');

define('TEXT_SEARCH_HELP_LINK', '<u>Pomoc</u> [?]');

define('TEXT_ALL_CATEGORIES', 'Wszystkie Kategorie');
define('TEXT_ALL_MANUFACTURERS', 'Wszyscy Producenci');

define('HEADING_SEARCH_HELP', 'Pomoc');
define('TEXT_SEARCH_HELP', 'Aby lepiej okre¶liæ wyniki wyszukiwania mo¿esz u¿yæ wyra¿eñ AND i/lub OR.<br><br>Na przyk³ad wyra¿enie <u>Microsoft AND mysz</u> wy¶wietli tylko produkty które zawieraj± oba s³owa. Z kolei dla wyra¿enia
<u>mysz OR klawiatura</u> wynikiem bêd± tylko wpisy z obydwoma lub którymkolwiek ze s³ów.<br><br>Dok³adne zapytania mo¿esz uzyskaæ za pomoc± ujmowania wyra¿enia w cudzys³ów.<br><br>Na przyk³ad, <u>"komputer przeno¶ny"</u>
poka¿e te produkty które bêd± zawiera³y dok³adnie takie wyra¿enie.<br><br>Nawiasy umo¿liwiaj± konstruowanie jeszcze bardziej zaawansowanych wyra¿eñ.<br><br>Na przyk³ad <u>Microsoft and (klawiatura or mysz or "visual basic")</u>.');
define('TEXT_CLOSE_WINDOW', '<u>Zamknij Okno</u> [x]');

define('TABLE_HEADING_IMAGE', '');
define('TABLE_HEADING_MODEL', 'Model');
define('TABLE_HEADING_PRODUCTS', 'Nazwa');
define('TABLE_HEADING_MANUFACTURER', 'Producent');
define('TABLE_HEADING_QUANTITY', 'Ilo¶æ');
define('TABLE_HEADING_PRICE', 'Cena');
define('TABLE_HEADING_WEIGHT', 'Waga');
define('TABLE_HEADING_BUY_NOW', 'Do Koszyka');

define('TEXT_NO_PRODUCTS', 'Nie ma produktów spe³niaj±cych zadane kryteria wyszukiwania.');

define('ERROR_AT_LEAST_ONE_INPUT', 'Przynajmniej jedno z pól w formularzu wyszukiwania musi byæ podane.');
define('ERROR_INVALID_FROM_DATE', 'B³êdna Data Od.');
define('ERROR_INVALID_TO_DATE', 'B³êdna Data Do.');
define('ERROR_TO_DATE_LESS_THAN_FROM_DATE', 'Data Do musi byæ wiêksza lub równa Dacie Od.');
define('ERROR_PRICE_FROM_MUST_BE_NUM', 'Cena Od musi byæ liczb±.');
define('ERROR_PRICE_TO_MUST_BE_NUM', 'Cena Do musi byæ liczb±.');
define('ERROR_PRICE_TO_LESS_THAN_PRICE_FROM', 'Cena Od musi byæ wiêksza lub równa Cenie Do.');
define('ERROR_INVALID_KEYWORDS', 'B³êdne Wyra¿enie Wyszukiwania.');
?>
