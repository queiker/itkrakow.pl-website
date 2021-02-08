<?php
/*
  $Id: orders.php,v 1.25 2003/06/08 08:14:17 ramroz Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Publikowane na zasadach licencji GNU General Public License

  T³umaczenie: Rafa³ Mróz ramroz@optimus.pl
  http://www.portalik.com

*/

define('HEADING_TITLE', 'Zamówienia');
define('HEADING_TITLE_SEARCH', 'ID Zamówienia:');
define('HEADING_TITLE_STATUS', 'Status:');

define('TABLE_HEADING_COMMENTS', 'Komentarze');
define('TABLE_HEADING_CUSTOMERS', 'Klient');
define('TABLE_HEADING_ORDER_TOTAL', 'Warto¶æ Zamówienia');
define('TABLE_HEADING_DATE_PURCHASED', 'Data Zakupu');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_ACTION', 'Dzia³anie');
define('TABLE_HEADING_QUANTITY', 'Ilo¶æ');
define('TABLE_HEADING_PRODUCTS_MODEL', 'Model');
define('TABLE_HEADING_PRODUCTS', 'Produkt');
define('TABLE_HEADING_TAX', 'Podatek');
define('TABLE_HEADING_TOTAL', 'Suma');
define('TABLE_HEADING_PRICE_EXCLUDING_TAX', 'Cena (netto)');
define('TABLE_HEADING_PRICE_INCLUDING_TAX', 'Cena (brutto)');
define('TABLE_HEADING_TOTAL_EXCLUDING_TAX', 'Warto¶æ (netto)');
define('TABLE_HEADING_TOTAL_INCLUDING_TAX', 'Warto¶æ (brutto)');

define('TABLE_HEADING_CUSTOMER_NOTIFIED', 'Klient Poinformowany');
define('TABLE_HEADING_ACCOUNT', 'Konto');
define('TABLE_HEADING_DATE_ADDED', 'Data Dodania');

define('ENTRY_CUSTOMER', 'Klient:');
define('ENTRY_SOLD_TO', 'P£ATNIK:');
define('ENTRY_DELIVERY_TO', 'Dostarczyæ Do:');
define('ENTRY_SHIP_TO', 'ODBIORCA:');
define('ENTRY_SHIPPING_ADDRESS', 'Adres Dostawy:');
define('ENTRY_BILLING_ADDRESS', 'Adres P³atnika:');
define('ENTRY_PAYMENT_METHOD', 'Sposób Zap³aty:');
define('ENTRY_CREDIT_CARD_TYPE', 'Rodzaj Karty Kredytowej:');
define('ENTRY_CREDIT_CARD_OWNER', 'W³a¶ciciel Karty:');
define('ENTRY_CREDIT_CARD_NUMBER', 'Numer Karty:');
define('ENTRY_CREDIT_CARD_EXPIRES', 'Data Wa¿no¶ci Karty:');
define('ENTRY_SUB_TOTAL', 'Podsuma:');
define('ENTRY_TAX', 'Podatek:');
define('ENTRY_SHIPPING', 'Wysy³ka:');
define('ENTRY_TOTAL', 'Suma:');
define('ENTRY_DATE_PURCHASED', 'Data Zakupu:');
define('ENTRY_STATUS', 'Status:');
define('ENTRY_DATE_LAST_UPDATED', 'Data Ostatniej Zmiany:');
define('ENTRY_NOTIFY_CUSTOMER', 'Poinformuj Klienta:');
define('ENTRY_NOTIFY_COMMENTS', 'Do³±cz Komentarze:');
define('ENTRY_PRINTABLE', 'Wydrukuj Fakturê');

define('TEXT_INFO_HEADING_DELETE_ORDER', 'Usuñ Zamówienie');
define('TEXT_INFO_DELETE_INTRO', 'Czy jeste¶ pewien ¿e chcesz usun±æ to zamówienie?');
define('TEXT_INFO_RESTOCK_PRODUCT_QUANTITY', 'Uzupe³nij zapas dla tego produktu');
define('TEXT_DATE_ORDER_CREATED', 'Date Utworzenia:');
define('TEXT_DATE_ORDER_LAST_MODIFIED', 'Ostatnia Zmiana:');
define('TEXT_INFO_PAYMENT_METHOD', 'Sposób Zap³aty:');

define('TEXT_ALL_ORDERS', 'Wszystkie Zamówienia');
define('TEXT_NO_ORDER_HISTORY', 'Historia Zamówienia Niedostêpna');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('EMAIL_TEXT_SUBJECT', 'Aktualizacja Zamówienia');
define('EMAIL_TEXT_ORDER_NUMBER', 'Nr Zamówienia:');
define('EMAIL_TEXT_INVOICE_URL', 'Szczegó³owa Faktura:');
define('EMAIL_TEXT_DATE_ORDERED', 'Data Zamówienia:');
define('EMAIL_TEXT_STATUS_UPDATE', 'Zosta³ zmieniony status twojego zamówienia.' . "\n\n" . 'Nowy status: %s' . "\n\n" . 'Je¿eli masz jakiekolwiek pytania odpowiedz na ten email.' . "\n");
define('EMAIL_TEXT_COMMENTS_UPDATE', 'Komentarze do twojego zamówienia: ' . "\n\n%s\n\n");

define('ERROR_ORDER_DOES_NOT_EXIST', 'B³±d: Zamówienie nie istnieje.');
define('SUCCESS_ORDER_UPDATED', 'Powiod³o siê: Zamówienie zosta³o zaktualizowane.');
define('WARNING_ORDER_NOT_UPDATED', 'Uwaga: Nie ma czego zmieniaæ. Zamówienie nie zosta³o zaktualizowane.');

?>
