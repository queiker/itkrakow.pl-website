<?php
define('HEADING_TITLE', 'System newsów - zarz±dzanie kategoriami i newsami');
define('HEADING_TITLE_SEARCH', 'Szukaj:');
define('HEADING_TITLE_GOTO', 'Id¼ do:');

define('TABLE_HEADING_ID', 'ID');
define('TABLE_HEADING_CATEGORIES_NEWSDESK', 'Kategoria / Artyku³');
define('TABLE_HEADING_DATE', 'Data');
define('TABLE_HEADING_ACTION', 'Dzia³anie');
define('TABLE_HEADING_STATUS', 'Status');

define('IMAGE_NEW_STORY', 'Nowy artyku³');

define('TEXT_CATEGORIES', 'Kategorie:');
define('TEXT_SUBCATEGORIES', 'Podkategorie:');
define('TEXT_NEWSDESK', 'Artyku³y:');
define('TEXT_NEW_NEWSDESK', 'Nowy artyku³ w kategorii &quot;%s&quot;');

define('TABLE_HEADING_LATEST_NEWS_HEADLINE', 'Tytu³');
define('TEXT_NEWS_ITEMS', 'News Items:');
define('TEXT_INFO_HEADING_DELETE_ITEM', 'Delete Item');
define('TEXT_DELETE_ITEM_INTRO', 'Are you sure you want to permanently delete this item?');

define('TEXT_LATEST_NEWS_HEADLINE', 'Headline:');

define('IMAGE_NEW_NEWS_ITEM', 'New news item');

define('TEXT_NEWSDESK_STATUS', 'Status:');
define('TEXT_NEWSDESK_AVAILABLE', 'W³±czony');
define('TEXT_NEWSDESK_NOT_AVAILABLE', 'Wy³±czony');

define('TEXT_NEWSDESK_URL', 'Zewnêtrzny link WWW:');
define('TEXT_NEWSDESK_URL_WITHOUT_HTTP', '<small>(bez http://)</small>');
define('TEXT_NEWSDESK_URL_NAME', 'Nazwa linka:');

define('TEXT_NEWSDESK_SUMMARY', 'Wstêp:');
define('TEXT_NEWSDESK_CONTENT', 'G³ówna tre¶æ:');
define('TEXT_NEWSDESK_HEADLINE', 'Tytu³:');

define('TEXT_NEWSDESK_DATE_AVAILABLE', 'Data publikacji:');
define('TEXT_NEWSDESK_DATE_ADDED', 'Dodano:');

define('TEXT_NEWSDESK_ADDED_LINK_HEADER', "This is the link you've added:");
//define('TEXT_NEWSDESK_ADDED_LINK', '<a href="http://%s" target="blank"><u>' . $newslink . '</u></a>');

define('TEXT_NEWSDESK_ADDED_LINK_HEADER_NAME', "This is the link name you've added:");
define('TEXT_NEWSDESK_ADDED_LINK_NAME', '<a href="http://%s" target="blank"><u>link name</u></a>');

define('TEXT_NEWSDESK_PRICE_INFO', 'Price:');
define('TEXT_NEWSDESK_TAX_CLASS', 'Tax Class:');
define('TEXT_NEWSDESK_AVERAGE_RATING', '¦rednia ocena:');
define('TEXT_NEWSDESK_QUANTITY_INFO', 'Quantity:');
define('TEXT_DATE_ADDED', 'Dodano:');
define('TEXT_DATE_AVAILABLE', 'Dostêpny od dnia:');
define('TEXT_LAST_MODIFIED', 'Ostatnia modyfikacja:');
define('TEXT_IMAGE_NONEXISTENT', 'OBRAZEK NIE ISTNIEJE');
define('TEXT_NO_CHILD_CATEGORIES_OR_story', 'Dodaj now± kategoriê lub artyku³ w kategorii <br>&nbsp;<br><b>%s</b>');

define('TEXT_EDIT_INTRO', 'Please make any necessary changes');
define('TEXT_EDIT_CATEGORIES_ID', 'Id kategorii:');
define('TEXT_EDIT_CATEGORIES_NAME', 'Nazwa kategorii:');
define('TEXT_EDIT_CATEGORIES_IMAGE', 'Obrazek kategorii:');
define('TEXT_EDIT_SORT_ORDER', 'Nr do sortowania:');

define('TEXT_INFO_COPY_TO_INTRO', 'Wybierz now± kategoriê dla artyku³u');
define('TEXT_INFO_CURRENT_CATEGORIES', 'Aktualna kategoria:');

define('TEXT_INFO_HEADING_MOVE_PRODUCT','Przenie¶ artyku³');
define('TEXT_INFO_HEADING_NEW_CATEGORY', 'Nowa kategoria');
define('TEXT_INFO_HEADING_EDIT_CATEGORY', 'Edytuj kategoriê');
define('TEXT_INFO_HEADING_DELETE_CATEGORY', 'Usuñ kategoriê');
define('TEXT_INFO_HEADING_MOVE_CATEGORY', 'Przenie¶ kategoriê');
define('TEXT_INFO_HEADING_DELETE_NEWS', 'Usuñ artyku³y');
define('TEXT_INFO_HEADING_MOVE_NEWS', 'Przenie¶ artyku³y');
define('TEXT_INFO_HEADING_COPY_TO', 'Kopiuj do');

define('TEXT_DELETE_CATEGORY_INTRO', 'Czy na pewno usun±æ kategoriê?');
define('TEXT_DELETE_PRODUCT_INTRO', 'Czy na pewno usun±æ artyku³?');

define('TEXT_DELETE_WARNING_CHILDS', '<b>UWAGA:</b> Ta kategoria zawiera podkategorie. Ilo¶æ  %s.');
define('TEXT_DELETE_WARNING_NEWSDESK', '<b>UWAGA:</b> Ta kategoria zawiera artyku³y. Ilo¶æ: %s.');

define('TEXT_MOVE_NEWSDESK_INTRO', 'Wybierz kategoriê, do której przenie¶æ artyku³ <b>%s</b>');
define('TEXT_MOVE_CATEGORIES_INTRO', 'Wybierz kategoriê, do której przenie¶æ kategoriê <b>%s</b>');
define('TEXT_MOVE', 'Przenie¶ <b>%s</b> do:');

define('TEXT_NEW_CATEGORY_INTRO', 'Uzupe³nij pola aby dodaæ now± kategoriê');
define('TEXT_CATEGORIES_NAME', 'Nazwa kategorii:');
define('TEXT_CATEGORIES_IMAGE', 'Obrazek kategorii:');
define('TEXT_SORT_ORDER', 'Sortowanie:');

define('EMPTY_CATEGORY', 'Brak kategorii');

define('TEXT_HOW_TO_COPY', 'Sposób kopiowania:');
define('TEXT_COPY_AS_LINK', 'Link do artyku³u');
define('TEXT_COPY_AS_DUPLICATE', 'Duplikuj artyku³');

define('ERROR_CANNOT_LINK_TO_SAME_CATEGORY', 'Error: Can not link Articles in the same category.');
define('ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE', 'Error: Catalog images directory is not writeable: ' . DIR_FS_CATALOG_IMAGES);
define('ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST', 'Error: Catalog images directory does not exist: ' . DIR_FS_CATALOG_IMAGES);

define('TEXT_NEWSDESK_START_DATE', 'Data publikacji:');
define('TEXT_DATE_FORMAT', 'Format daty:');

define('TEXT_SHOW_STATUS', 'Status');

define('TEXT_DELETE_IMAGE', 'Delete Image(s) ?');
define('TEXT_DELETE_IMAGE_INTRO', 'BEWARE:: Deleting this/these image(s) will completely remove it/them. If you use this/these image(s) elsewhere -- I warned you !!');

define('TEXT_NEWSDESK_STICKY', 'Przyklejony');
define('TEXT_NEWSDESK_STICKY_ON', 'W³');
define('TEXT_NEWSDESK_STICKY_OFF', 'Wy³');
define('TABLE_HEADING_STICKY', 'Sticky');

define('TEXT_NEWSDESK_IMAGE', 'Zdjêcia do artyku³u:');

define('TEXT_NEWSDESK_IMAGE_ONE', 'Zdjêcie nr 1:');
define('TEXT_NEWSDESK_IMAGE_TWO', 'Zdjêcie nr 2:');
define('TEXT_NEWSDESK_IMAGE_THREE', 'Zdjêcie nr 3:');

define('TEXT_NEWSDESK_IMAGE_SUBTITLE', 'Wpisz nazwê Zdjêcia nr 1:');
define('TEXT_NEWSDESK_IMAGE_SUBTITLE_TWO', 'Wpisz nazwê Zdjêcia nr 2:');
define('TEXT_NEWSDESK_IMAGE_SUBTITLE_THREE', 'Wpisz nazwê Zdjêcia nr 3:');

define('TEXT_NEWSDESK_IMAGE_PREVIEW_ONE', 'Zdjêcie nr 1:');
define('TEXT_NEWSDESK_IMAGE_PREVIEW_TWO', 'Zdjêcie nr 2:');
define('TEXT_NEWSDESK_IMAGE_PREVIEW_THREE', 'Zdjêcie nr 3:');

?>