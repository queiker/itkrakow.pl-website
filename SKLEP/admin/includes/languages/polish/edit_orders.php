<?php
/*
  $Id: edit_orders.php,v 2.5 2006/04/28 10:42:44 ams Exp $
  polish
  
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2006 osCommerce
  
  T³umaczenie: Mariusz Gawdziñski
  http://www.gawdzinski.pl
  
  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Edytuj Zamówienie');
define('HEADING_TITLE_NUMBER', 'Nr');
define('HEADING_TITLE_DATE', 'z');
define('HEADING_SUBTITLE', 'Wykonaj zmiany w zamówieniu i naci¶nij znajduj±cy siê poni¿ej przycisk Aktualizuj.');
define('HEADING_TITLE_STATUS', 'Status');
define('ADDING_TITLE', 'Dodaj produkt do tego zamówienia');

define('HINT_UPDATE_TO_CC', 'Ustaw metodê p³atno¶ci na ');
//ENTRY_CREDIT_CARD should be whatever is saved in your db as the payment method
//when your customer pays by Credit Card
define('ENTRY_CREDIT_CARD', 'Karta Kredytowa');
define('HINT_UPDATE_TO_CC2', ' a automatycznie poka¿± siê dodatkowe pola. Pola Karty Kredytowej sa ukryte je¿eli inna metoda p³atno¶ci jest wybrana.');
define('HINT_PRODUCTS_PRICES', 'Kalkulacja wagi i ceny wykonywana jest w locie, ale musisz wcisn±æ przycisk aktualizuj w celu zapisania zmian.');
define('HINT_SHIPPING_ADDRESS', 'Je¿eli adres dostawy zostanie zmieniony, zaktualizowana mo¿e zostaæ równie¿ strefa podatkowa. Musisz w takim przypadku ponownie wcisn±c przycik aktualizuj w celu poprawnej aktualizacji stawek podatków.');
define('HINT_TOTALS', 'Mo¿esz nadawaæ rabaty wpisuj±c ujemne warto¶ci. Ka¿de pole z wpisan± warto¶ci± równ± 0 jest kasowane przy aktualizacji (wyj±tkiem jest dostawa).  Waga, podsuma, podatek, i warto¶ci koñcowe nie s± edytowalne. Po aktualizacji mo¿liwe niewielkie ró¿nice w warto¶ciach, wynikaj±ce glównie z zaokr±glania.');
define('HINT_PRESS_UPDATE', 'Przycisk "Aktualizuj" zachowa wykonane zmiany.');
define('HINT_BASE_PRICE', 'Cena (bazowa) to cena produktu przed dodaniem cech (np. cena katalogowa produktu)');
define('HINT_PRICE_EXCL', 'Cena (netto) to Cena z uwzglêdnieniem przypisaneych do danego towaru cech');
define('HINT_PRICE_INCL', 'Cena (brutto) to Cena (netto) razy podatek');
define('HINT_TOTAL_EXCL', 'Warto¶æ (netto) to Cena (netto) razy ilo¶æ');
define('HINT_TOTAL_INCL', 'Warto¶æ (brutto) to Cena (netto) razy podatek i ilo¶æ');

define('TABLE_HEADING_COMMENTS', 'Komentarz');
define('TABLE_HEADING_STATUS', 'Nowy Status');
define('TABLE_HEADING_QUANTITY', 'Ilo¶æ');
define('TABLE_HEADING_PRODUCTS_MODEL', 'Model');
define('TABLE_HEADING_PRODUCTS_WEIGHT', 'Waga');
define('TABLE_HEADING_PRODUCTS', 'Produkt');
define('TABLE_HEADING_TAX', 'Podatek %');
define('TABLE_HEADING_BASE_PRICE', 'Cena (base)');
define('TABLE_HEADING_UNIT_PRICE', 'Cena (netto)');
define('TABLE_HEADING_UNIT_PRICE_TAXED', 'Cena (brutto)');
define('TABLE_HEADING_TOTAL_PRICE', 'Warto¶æ (netto)');
define('TABLE_HEADING_TOTAL_PRICE_TAXED', 'Warto¶æ (brutto)');
define('TABLE_HEADING_TOTAL_MODULE', 'Ca³kowity Koszt');
define('TABLE_HEADING_TOTAL_AMOUNT', 'Koszt');
define('TABLE_HEADING_TOTAL_WEIGHT', 'Sumaryczna Waga: ');
define('TABLE_HEADING_DELETE', 'Usun±æ?');
define('TABLE_HEADING_SHIPPING_TAX', 'Shipping tax: ');

define('TABLE_HEADING_CUSTOMER_NOTIFIED', 'Stan Powiadomienia');
define('TABLE_HEADING_DATE_ADDED', 'Data Powiadomienia');

define('ENTRY_CUSTOMER_NAME', 'Imiê i Nazwisko');
define('ENTRY_CUSTOMER_COMPANY', 'Firma');
define('ENTRY_CUSTOMER_ADDRESS', 'Adres Klienta');
define('ENTRY_CUSTOMER_SUBURB', 'Suburb');
define('ENTRY_CUSTOMER_CITY', 'Miasto');
define('ENTRY_CUSTOMER_STATE', 'Województwo');
define('ENTRY_CUSTOMER_POSTCODE', 'Kod Pocztowy');
define('ENTRY_CUSTOMER_COUNTRY', 'Kraj');
define('ENTRY_CUSTOMER_PHONE', 'Telefon');
define('ENTRY_CUSTOMER_EMAIL', 'E-Mail');
define('ENTRY_ADDRESS', 'Adres');

define('ENTRY_SHIPPING_ADDRESS', 'Adres Dostawy');
define('ENTRY_BILLING_ADDRESS', 'Adres P³atnika');
define('ENTRY_PAYMENT_METHOD', 'Metoda P³atno¶ci:');
define('ENTRY_CREDIT_CARD_TYPE', 'Typ Karty:');
define('ENTRY_CREDIT_CARD_OWNER', 'W³a¶ciciel Karty:');
define('ENTRY_CREDIT_CARD_NUMBER', 'Numer Karty:');
define('ENTRY_CREDIT_CARD_EXPIRES', 'Data Wa¿no¶ci:');
define('ENTRY_SUB_TOTAL', 'Podsuma:');

//do not put a colon (" : ") in the definition of ENTRY_TAX
//ie entry should be 'Tax' NOT 'Tax:'
define('ENTRY_TAX', 'Podatek');

define('ENTRY_TOTAL', 'Razem:');
define('ENTRY_STATUS', 'Status Zamówienia:');
define('ENTRY_NOTIFY_CUSTOMER', 'Powiadomiæ Klienta:');
define('ENTRY_NOTIFY_COMMENTS', 'Wys³aæ Komentarz:');

define('TEXT_NO_ORDER_HISTORY', 'Brak Zamówieñ');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('EMAIL_TEXT_SUBJECT', 'Zestawienie zamówienia w sklepie '.STORE_NAME);
define('EMAIL_TEXT_ORDER_NUMBER', 'Numer Zamówienia:');
define('EMAIL_TEXT_INVOICE_URL', 'Szczegó³y Zamówienia pod adresem URL:');
define('EMAIL_TEXT_DATE_ORDERED', 'Data Zamówienia:');
define('EMAIL_TEXT_STATUS_UPDATE', 'Dziêkujemy bardzo za zakupy w naszym sklepie!' . "\n\n" . 'Status Twojego zamówienia zosta³ zaktualizowany' . "\n\n" . 'Nowy status: %s' . "\n\n");
define('EMAIL_TEXT_STATUS_UPDATE2', 'W razie jakichkolwiek pytañ, w±tpliwo¶ci prosimy o kontakt z nami. Mo¿esz to zrobiæ odpowiadaj±c na ten e-mail lub dzwoni±c bezpo¶rednio do naszego sklepu.' . "\n\n" . 'Pozdrawiamy i Zapraszamy Ponownie<br> ' . STORE_NAME . "\n");
define('EMAIL_TEXT_COMMENTS_UPDATE', 'Poni¿ej znajduje siê komentarz do z³o¿onego zamówienia:' . "\n\n%s\n\n");

define('ERROR_ORDER_DOES_NOT_EXIST', 'B£¡D: Brak zamówienia');
define('SUCCESS_ORDER_UPDATED', 'Wykonano: zamówienie zosta³o zaktualizowane.');

define('ADDPRODUCT_TEXT_CATEGORY_CONFIRM', 'OK');
define('ADDPRODUCT_TEXT_SELECT_PRODUCT', 'Wybierz produkt');
define('ADDPRODUCT_TEXT_PRODUCT_CONFIRM', 'OK');
define('ADDPRODUCT_TEXT_SELECT_OPTIONS', 'Wybierz cechê');
define('ADDPRODUCT_TEXT_OPTIONS_CONFIRM', 'OK');
define('ADDPRODUCT_TEXT_OPTIONS_NOTEXIST', 'Produkt nie posiada dodatkowych cech, pomijamy ...');
define('ADDPRODUCT_TEXT_CONFIRM_QUANTITY', 'sztuk tego produktu');
define('ADDPRODUCT_TEXT_CONFIRM_ADDNOW', 'Dodaj');
define('ADDPRODUCT_TEXT_STEP', 'Krok');
define('ADDPRODUCT_TEXT_STEP1', ' &laquo; Wybierz Katalog. ');
define('ADDPRODUCT_TEXT_STEP2', ' &laquo; Wybierz Produkt. ');
define('ADDPRODUCT_TEXT_STEP3', ' &laquo; Wybierz Cechê. ');

define('MENUE_TITLE_CUSTOMER', '1. Dane Klienta');
define('MENUE_TITLE_PAYMENT', '2. Metoda P³atno¶ci');
define('MENUE_TITLE_ORDER', '3. Zamówione Produkty');
define('MENUE_TITLE_TOTAL', '4. Zni¿ki, Wysy³ka , Razem');
define('MENUE_TITLE_STATUS', '5. Status i Powiadomienia');
define('MENUE_TITLE_UPDATE', '6. Aktualizacja Danych');

define('ENTRY_NOTIFY', 'Powiadomienia:');
define('ENTRY_NOTIFY_CUSTOMER', 'Powiadom Klienta o zmianach statusu');
define('ENTRY_NOTIFY_CUSTOMER_HEADING', 'Zmiany statusu przesy³ane mailem');
define('ENTRY_NOTIFY_CUSTOMER_INFO', 'Klient otrzyma skrócon± informacjê zawieraj±c± informacje o: <br /> - numerze zamówienia, którego zmiany dotycz±<br /> - statusie po zmianie<br /> - link do zamówienia, które zosta³o zmienione');
define('ENTRY_NOTIFY_ZAMOWIENIE', 'Prze¶lij Klientowi zestawienie zamówienia');
define('ENTRY_NOTIFY_ZAMOWIENIE_HEADING', 'Zestawienie zamówienia przesy³ane mailem');
define('ENTRY_NOTIFY_ZAMOWIENIE_INFO', 'Klient otrzyma pe³ne dane zamówienia, informacje o p³atno¶ci i formie dostawy.<br /> Bêd± to dane zaktualizowane i zawiera³y bêd± m.in.:<br /> - informacje o produktach [cena, ilo¶æ, nazwa]<br /> - informacje o formie i kosztach dostawy<br /> - informacje o wybranej formie p³atno¶ci, w tym ew. dane do przelewu [zaznacz poni¿ej]<br /> - adres dostawy');
define('ENTRY_NOTIFY_NOTHING', 'Nie wysy³aj do Klienta ¿adnych powiadomieñ');
define('ENTRY_NOTIFY_COMMENTS', 'Dodaj komentarze');
define('ENTRY_NOTIFY_BANK', 'Do³±cz dane do przelewu');
define('TEXT_EMAIL_BANKTRANSFER', 'Dane do przelewu');

define('ENTRY_NAME', 'Imiê i nazwisko:');
define('ENTRY_CITY_STATE', 'Miasto, województwo:');
define('ENTRY_CURRENCY_TYPE', 'Waluta');
define('ENTRY_CURRENCY_VALUE', 'Kurs');
define('HINT_UPDATE_CURRENCY', 'Ustaw walutê zamówienia na');
define('TABLE_HEADING_OT_TOTALS', 'Modu³ podsumy zamówienia');
define('TABLE_HEADING_OT_VALUES', 'Koszt');
define('TABLE_HEADING_SHIPPING_QUOTES', 'Sposób wysy³ki');
define('TEXT_PACKAGE_WEIGHT_COUNT', '');
define('TABLE_HEADING_NEW_STATUS', 'Status zamówienia');
define('ENTRY_CUSTOMER', 'Dane klienta');
define('AJAX_SUBMIT_COMMENT', 'Dodaj komentarz do zamówienia');
define('AJAX_CONFIRM_COMMENT_DELETE', 'Usun±æ komentarz?');
define('AJAX_MESSAGE_STACK_SUCCESS', 'Dane zosta³y poprawnie zaktualizowane.');
define('TEXT_STEP_1', 'Krok 1');
define('TEXT_PRODUCT_SEARCH', 'Wyszukaj produkt');
define('TEXT_CLOSE_POPUP', 'Zamknij okienko');
define('TEXT_SELECT_CATEGORY', 'Wybierz kategoriê');
define('TEXT_STEP_2', 'Krok 2');
define('TEXT_SELECT_PRODUCT', 'Wybierz produkt');
define('TEXT_STEP_3', 'Krok 3');
define('TEXT_SKIP_NO_OPTIONS', 'Pominiêty - brak opcji produktu');
define('TEXT_STEP_4', 'Krok 4');
define('TEXT_QUANTITY', 'Ilo¶æ zamawianego produktu');
define('TEXT_BUTTON_ADD_PRODUCT', 'Dodaj produkt');
define('TEXT_ALL_CATEGORIES', 'Wszystkie kategorie');
define('TEXT_BUTTON_SELECT_OPTIONS', 'Wybierz opcjê');
define('TEXT_NO_ORDER_PRODUCTS', 'Nie dodano ¿adnego produktu do zamówienia!');

define('AJAX_NEW_ORDER_EMAIL', 'Czy wys³aæ do Klienta powiadomienie z pe³nym zestawieniem zamówionych towarów/us³ug ?');
define('AJAX_SUCCESS_EMAIL_SENT', 'Powiadomienie wys³ane');

define('EMAIL_TEXT_DATE_MODIFIED', 'Data utworzenia');
define('EMAIL_TEXT_PRODUCTS', 'Zamawiane produkty');
define('EMAIL_TEXT_DELIVERY_ADDRESS', 'Adres dostawy');
define('EMAIL_TEXT_BILLING_ADDRESS', 'Adres p³atnika');
define('EMAIL_TEXT_PAYMENT_METHOD', 'Sposób p³atno¶ci');
define('EMAIL_TEXT_FOOTER', '');
define('IMAGE_ADD_NEW_OT', 'dodaj poni¿ej nowy wpis sumy zamówienia');
define('IMAGE_REMOVE_NEW_OT', 'usuñ ten wpis sumy zamówienia');

define('AJAX_LOADING', '£adowanie...');
define('ENTRY_SEND_NEW_ORDER_CONFIRMATION','Wys³aæ pe³ne zestawienie:');
define('IMAGE_NEW_ORDER_EMAIL','Kliknij aby wys³aæ pe³ne zestawienie do klienta');
?>