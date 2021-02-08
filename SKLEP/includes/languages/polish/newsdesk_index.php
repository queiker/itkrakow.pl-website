<?php
define('NEWS_TEXT_FIELD_REQUIRED', 'Pole wymagane.');
define('NEWS_BOX_CATEGORIES_CHOOSE', 'Wybierz kategoriê');
if ( ($category_depth == 'products') ) {

define('HEADING_TITLE', 'Artyku³y');

define('TABLE_HEADING_IMAGE', 'Image');
define('TABLE_HEADING_ARTICLE_NAME', 'Tytu³');
define('TABLE_HEADING_ARTICLE_SHORTTEXT', 'Summary');
define('TABLE_HEADING_ARTICLE_DESCRIPTION', 'Content');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_DATE_AVAILABLE', 'Data');
define('TABLE_HEADING_ARTRICLE_URL', 'URL to outside resource');
define('TABLE_HEADING_ARTRICLE_URL_NAME', 'URL Name');

define('TEXT_NO_ARTICLES', 'Aktualnie brak artyku³ów w wybranej kategorii.');

define('TEXT_NUMBER_OF_ARTICLES', 'Number of Articles: ');
define('TEXT_SHOW', '<b>Show:</b>');

} elseif ($category_depth == 'top') {

define('HEADING_TITLE', 'Nowe artyku³y?');

} elseif ($category_depth == 'nested') {

define('HEADING_TITLE', 'Kategorie artyku³ów');

} else {
define('HEADING_TITLE', 'Artyku³y');
}

?>