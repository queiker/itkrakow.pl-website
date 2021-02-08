<?php
/*
  $Id: polish.php,v 1.0 2003/06/08 08:14:17 ramroz Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Publikowane na zasadach licencji GNU General Public License

  Tłumaczenie: Rafał Mróz 
*/

// zobacz w katalogu $PATH_LOCALE/locale dostępne lokalizacje..
// w RedHacie powinno być 'pl_PL'
// we FreeBSD sprawdˇ 'pl_PL.ISO_8859-2'
// w Windows spróbuj 'pl', lub 'Polski'
@setlocale(LC_TIME, pl_PL.ISO_8859-2);

define('IMAGE_BUTTON_CREATE_ACCOUNT', 'Utwórz Konto');
define('DATE_FORMAT_SHORT', '%d %m %Y');  // używane przy strftime()
define('DATE_FORMAT_LONG', '%A, %d %B %Y'); // używane przy strftime()
define('DATE_FORMAT', 'd/m/Y'); // używane przy date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');

////
// Zwraca sformatowan± datę jako raw format
// $date powinna mieć format dd/mm/yyyy
// format raw date ma postać YYYYMMDD, lub DDMMYYYY
function tep_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 3, 2) . substr($date, 0, 2);
  }
}


define('HEADING_CHECKOUT', 'Kasa');
define('TEXT_CHECKOUT_INTRODUCTION', 'PrzejdĽ do kasy bez zakładania konta. Wybieraj±c tę opcję nie będziesz mógł śledzić statusu zamówienia ani przegl±dać historii swoich zakupów.');

define('PROCEED_TO_CHECKOUT', 'PrzejdĽ do kasy bez zakładania konta');

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'PLN');

// Global entries for the html tag
define('HTML_PARAMS','dir="LTR" lang="pl"');

// charset for web pages and emails
define('CHARSET', 'ISO-8859-2');

// page title
define('TITLE', STORE_NAME);

// header text in includes/header.php
define('HEADER_TITLE_CREATE_ACCOUNT', 'Utwórz Konto');
define('HEADER_TITLE_MY_ACCOUNT', 'Moje Konto');
define('HEADER_TITLE_CART_CONTENTS', 'Zawartość koszyka');
define('HEADER_TITLE_CHECKOUT', 'Zamówienie');
define('HEADER_TITLE_TOP', 'Top');
define('HEADER_TITLE_CATALOG', 'Katalog');
define('HEADER_TITLE_LOGOFF', 'Wyloguj się');
define('HEADER_TITLE_LOGIN', 'Zaloguj się');

define('BOX_HEADING_LOGIN_BOX_MY_ACCOUNT','Twoje Konto');

define('LOGIN_BOX_MY_ACCOUNT','Moje konto');
define('LOGIN_BOX_ACCOUNT_EDIT','Edycja konta');
define('LOGIN_BOX_ADDRESS_BOOK','Ksi±żka adresowa');
define('LOGIN_BOX_ACCOUNT_HISTORY','Historia zamówień');
define('LOGIN_BOX_PRODUCT_NOTIFICATIONS','Powiadomienia');

// footer text in includes/footer.php
define('FOOTER_TEXT_REQUESTS_SINCE', 'wywołań od');

// text for gender
define('MALE', 'Mężczyzna');
define('FEMALE', 'Kobieta');
define('MALE_ADDRESS', 'Pan');
define('FEMALE_ADDRESS', 'Pani');

// text for date of birth example
define('DOB_FORMAT_STRING', 'dd/mm/yyyy');

// categories box text in includes/boxes/categories.php
define('BOX_HEADING_CATEGORIES', 'Kategorie');

// manufacturers box text in includes/boxes/manufacturers.php
define('BOX_HEADING_MANUFACTURERS', 'Producenci');

// whats_new box text in includes/boxes/whats_new.php
define('BOX_HEADING_WHATS_NEW', 'Nowości');

// quick_find box text in includes/boxes/quick_find.php
define('BOX_HEADING_SEARCH', 'Wyszukiwanie');
define('BOX_SEARCH_TEXT', 'Wpisz słowo aby wyszukać produkt.');
define('BOX_SEARCH_ADVANCED_SEARCH', 'Zaawansowane');

// specials box text in includes/boxes/specials.php
define('BOX_HEADING_SPECIALS', 'Promocje');

// reviews box text in includes/boxes/reviews.php
define('BOX_HEADING_REVIEWS', 'Recenzje');
define('BOX_REVIEWS_WRITE_REVIEW', 'Napisz recenzję o tym produkcie!');
define('BOX_REVIEWS_NO_REVIEWS', 'Obecnie nie ma recenzji o produktach');
define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s z 5 Gwiazdek!');

// shopping_cart box text in includes/boxes/shopping_cart.php
define('BOX_HEADING_SHOPPING_CART', 'Koszyk');
define('BOX_SHOPPING_CART_EMPTY', '...jest pusty');

// order_history box text in includes/boxes/order_history.php
define('BOX_HEADING_CUSTOMER_ORDERS', 'Zamówienia');

// best_sellers box text in includes/boxes/best_sellers.php
define('BOX_HEADING_BESTSELLERS', 'Najczęściej kupowane');
define('BOX_HEADING_BESTSELLERS_IN', 'Bestsellery kategorii<br>&nbsp;&nbsp;');

// notifications box text in includes/boxes/products_notifications.php
define('BOX_HEADING_NOTIFICATIONS', 'Powiadomienia');
define('BOX_NOTIFICATIONS_NOTIFY', 'Informuj mnie o aktualizacjach produktu <b>%s</b>');
define('BOX_NOTIFICATIONS_NOTIFY_REMOVE', 'Nie informuj mnie o aktualizacjach produktu <b>%s</b>');

// manufacturer box text
define('BOX_HEADING_MANUFACTURER_INFO', 'Producent');
define('BOX_MANUFACTURER_INFO_HOMEPAGE', 'Strona Domowa %s');
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'Inne produkty');

// languages box text in includes/boxes/languages.php
define('BOX_HEADING_LANGUAGES', 'Języki');

// currencies box text in includes/boxes/currencies.php
define('BOX_HEADING_CURRENCIES', 'Waluty');

// information box text in includes/boxes/information.php
define('BOX_HEADING_INFORMATION', 'Informacje');
define('BOX_INFORMATION_PRIVACY', 'Bezpieczeństwo');
define('BOX_INFORMATION_CONDITIONS', 'Korzystanie z&nbsp;Serwisu');
define('BOX_INFORMATION_SHIPPING', 'Wysyłka i Zwroty');
define('BOX_INFORMATION_CONTACT', 'Kontakt');

// tell a friend box text in includes/boxes/tell_a_friend.php
define('BOX_HEADING_TELL_A_FRIEND', 'Dla Znajomego');
define('BOX_TELL_A_FRIEND_TEXT', 'Powiedz o tym produkcie komuś, kogo znasz.');

// checkout procedure text
define('CHECKOUT_BAR_DELIVERY', 'Dostawa');
define('CHECKOUT_BAR_PAYMENT', 'Płatność');
define('CHECKOUT_BAR_CONFIRMATION', 'Potwierdzenie');
define('CHECKOUT_BAR_FINISHED', 'Koniec!');

// pull down default text
define('PULL_DOWN_DEFAULT', '-- Wybierz --');
define('TYPE_BELOW', 'Wprowad· Poniżej');

// javascript messages
define('JS_ERROR', 'Wyst±piły błędy w trakcie przetwarzania formularza!\n\n');

define('JS_REVIEW_TEXT', '* Recenzja musi mieć przynajmniej ' . REVIEW_TEXT_MIN_LENGTH . ' znaków.\n');
define('JS_REVIEW_RATING', '* Musisz ocenić produkt który recenzujesz.'."\n");

define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Wybierz metodę płatności dla twojego zamówienia.\n');

define('JS_ERROR_SUBMITTED', 'Ten formularz został już wysłany. Kliknij OK i poczekaj na zakończenie procesu.');

define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'Wybierz metodę płatnośći dla twojego zamówienia.');

define('CATEGORY_COMPANY', 'Dane Firmy');
define('CATEGORY_PERSONAL', 'Dane Osobowe');
define('CATEGORY_ADDRESS', 'Dane Teleadresowe');
define('CATEGORY_CONTACT', 'Dane Kontaktowe');
define('CATEGORY_OPTIONS', 'Opcje');
define('CATEGORY_PASSWORD', 'Twoje Hasło');

define('ENTRY_COMPANY', 'Nazwa Firmy:');
define('ENTRY_COMPANY_ERROR', '');
define('ENTRY_COMPANY_TEXT', '');
define('ENTRY_GENDER', 'Płeć:');
define('ENTRY_GENDER_ERROR', 'Wybierz Płeć.');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME', 'Imię:');
define('ENTRY_FIRST_NAME_ERROR', 'Imię musi mieć min. ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' zn.');
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME', 'Nazwisko:');
define('ENTRY_LAST_NAME_ERROR', 'Nazwisko musi mieć min. ' . ENTRY_LAST_NAME_MIN_LENGTH . ' zn.');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH', 'Data Urodzenia:');
define('ENTRY_DATE_OF_BIRTH_ERROR', 'Data Urodzenia musi być w formacie: DD/MM/RRRR (np 21/05/1970)');
define('ENTRY_DATE_OF_BIRTH_TEXT', '* (np. 21/05/1970)');
define('ENTRY_EMAIL_ADDRESS', 'Adres E-mail:');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Adres E-Mail musi mieć min. ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' znaków.');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Twój Adres E-Mail ma niewłaściwy format - popraw go.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Twój Adres E-Mail już istnieje w naszej bazie - użyj innego albo zaloguj się.');
define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_STREET_ADDRESS', 'Ulica:');
define('ENTRY_STREET_ADDRESS_ERROR', 'Ulica musi mieć min. ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' zn.');
define('ENTRY_STREET_ADDRESS_TEXT', '*');
define('ENTRY_SUBURB', 'Dzielnica:');
define('ENTRY_SUBURB_ERROR', '');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE', 'Kod Pocztowy:');
define('ENTRY_POST_CODE_ERROR', 'Kod Pocztowy musi mieć min. ' . ENTRY_POSTCODE_MIN_LENGTH . ' zn.');
define('ENTRY_POST_CODE_TEXT', '* (np. 30-130)');
define('ENTRY_CITY', 'Miejscowość:');
define('ENTRY_CITY_ERROR', 'Miejscowość musi mieć min. ' . ENTRY_CITY_MIN_LENGTH . ' zn.');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE', 'Województwo:');
define('ENTRY_STATE_ERROR', 'Województwo musi mieć min. ' . ENTRY_STATE_MIN_LENGTH . ' zn.');
define('ENTRY_STATE_ERROR_SELECT', 'Wybierz Województwo z menu rozwijalnego.');
define('ENTRY_STATE_TEXT', '*');
define('ENTRY_COUNTRY', 'Kraj:');
define('ENTRY_COUNTRY_ERROR', 'Wybierz Kraj z menu rozwijalnego.');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_TELEPHONE_NUMBER', 'Nr Telefonu:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Nr Telefonu musi mieć min. ' . ENTRY_TELEPHONE_MIN_LENGTH . ' zn.');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER', 'Nr Faksu:');
define('ENTRY_FAX_NUMBER_ERROR', '');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER', 'Newsletter:');
define('ENTRY_NEWSLETTER_TEXT', '');
define('ENTRY_NEWSLETTER_YES', 'Zapisany');
define('ENTRY_NEWSLETTER_NO', 'Wypisany');
define('ENTRY_NEWSLETTER_ERROR', '');
define('ENTRY_PASSWORD', 'Hasło:');
define('ENTRY_PASSWORD_ERROR', 'Hasło musi mieć min. ' . ENTRY_PASSWORD_MIN_LENGTH . ' zn.');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'Powtórzone Hasło nie zgadza się z Hasłem.');
define('ENTRY_PASSWORD_TEXT', '*');
define('ENTRY_PASSWORD_CONFIRMATION', 'Powtórz Hasło:');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT', 'Obecne Hasło:');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR', 'Hasło musi mieć min. ' . ENTRY_PASSWORD_MIN_LENGTH . ' zn.');
define('ENTRY_PASSWORD_NEW', 'Nowe Hasło:');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', 'Nowe Hasło musi mieć min. ' . ENTRY_PASSWORD_MIN_LENGTH . ' zn.');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'Potwierdzenie Hasła musi zgadzać się z twoim Nowym Hasłem.');
define('PASSWORD_HIDDEN', '--UKRYTE--');

define('FORM_REQUIRED_INFORMATION', '* wymagane');

// constants for use in tep_prev_next_display function
define('TEXT_RESULT_PAGE', 'Strona:');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Lista od <b>%d</b> do <b>%d</b> (<b>%d</b> znalezionych)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Lista od <b>%d</b> do <b>%d</b> (<b>%d</b> znalezionych)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Lista od <b>%d</b> do <b>%d</b> (<b>%d</b> znalezionych)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Lista od <b>%d</b> do <b>%d</b> (<b>%d</b> znalezionych)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Lista od <b>%d</b> do <b>%d</b> (<b>%d</b> znalezionych)');

define('PREVNEXT_TITLE_FIRST_PAGE', 'Pierwsza Strona');
define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'Poprzednia Strona');
define('PREVNEXT_TITLE_NEXT_PAGE', 'Następna Strona');
define('PREVNEXT_TITLE_LAST_PAGE', 'Ostatnia Strona');
define('PREVNEXT_TITLE_PAGE_NO', 'Strona %d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Poprzednie Strony (%d)');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Następne Strony (%d)');
define('PREVNEXT_BUTTON_FIRST', '&laquo;PIERWSZA');
define('PREVNEXT_BUTTON_PREV', '[&laquo;&laquo;]');
define('PREVNEXT_BUTTON_NEXT', '[&raquo;&raquo;]');
define('PREVNEXT_BUTTON_LAST', 'OSTATNIA&raquo;');

define('IMAGE_BUTTON_ADD_ADDRESS', 'Dodaj Adres');
define('IMAGE_BUTTON_ADDRESS_BOOK', 'Ksi±żka Adresowa');
define('IMAGE_BUTTON_BACK', 'Powrót');
define('IMAGE_BUTTON_BUY_NOW', 'Do Koszyka');
define('IMAGE_BUTTON_CHANGE_ADDRESS', 'Zmień Adres');
define('IMAGE_BUTTON_CHECKOUT', 'Zamów!');
define('IMAGE_BUTTON_CONFIRM_ORDER', 'PotwierdĽ Zamówienie');
define('IMAGE_BUTTON_CONTINUE', 'Kontynuuj');
define('IMAGE_BUTTON_CONTINUE_SHOPPING', 'Kontynuuj Zakupy');
define('IMAGE_BUTTON_DELETE', 'Usuń');
define('IMAGE_BUTTON_EDIT_ACCOUNT', 'Edytuj Konto');
define('IMAGE_BUTTON_HISTORY', 'Historia Zamówień');
define('IMAGE_BUTTON_LOGIN', 'Zaloguj');
define('IMAGE_BUTTON_IN_CART', 'Do Koszyka');
define('IMAGE_BUTTON_NOTIFICATIONS', 'Informowanie o Produktach');
define('IMAGE_BUTTON_QUICK_FIND', 'Szybkie Wyszukiwanie');
define('IMAGE_BUTTON_REMOVE_NOTIFICATIONS', 'Usuń Informowanie o Produktach');
define('IMAGE_BUTTON_REVIEWS', 'Recenzje');
define('IMAGE_BUTTON_SEARCH', 'Szukaj');
define('IMAGE_BUTTON_SHIPPING_OPTIONS', 'Opcje Wysyłki');
define('IMAGE_BUTTON_TELL_A_FRIEND', 'Powiedz Znajomemu');
define('IMAGE_BUTTON_UPDATE', 'Aktualizuj');
define('IMAGE_BUTTON_UPDATE_CART', 'Aktualizuj Koszyk');
define('IMAGE_BUTTON_WRITE_REVIEW', 'Napisz Recenzję');

define('SMALL_IMAGE_BUTTON_DELETE', 'Usuń');
define('SMALL_IMAGE_BUTTON_EDIT', 'Edytuj');
define('SMALL_IMAGE_BUTTON_VIEW', 'Pokaż');

define('ICON_ARROW_RIGHT', 'więcej');
define('ICON_CART', 'Do Koszyka');
define('ICON_ERROR', 'Bł±d');
define('ICON_SUCCESS', 'Powiodło się');
define('ICON_WARNING', 'Uwaga');

define('TEXT_GREETING_PERSONAL', 'Witaj ponownie <span class="greetUser">%s!</span><br />Chcesz zobaczyć które z <a href="%s"><u>nowych produktów</u></a> s± w sprzedaży?');
define('TEXT_GREETING_PERSONAL_RELOGON', '<small>Jeżeli %s to nie ty, proszę <a href="%s"><u>zaloguj się</u></a> na swoje konto.</small>');
define('TEXT_GREETING_GUEST', 'Twój status: <span class="greetUser">Gość!</span> Zaloguj się <a href="%s"><u>tutaj</u></a>.<br> Jeśli nie masz u nas konta założysz je <a href="%s"><u>tutaj</u></a>.');

define('TEXT_SORT_PRODUCTS', 'Sortuj produkty ');
define('TEXT_DESCENDINGLY', 'malej±co');
define('TEXT_ASCENDINGLY', 'rosn±co');
define('TEXT_BY', ' wg ');

define('TEXT_REVIEW_BY', 'od %s');
define('TEXT_REVIEW_WORD_COUNT', '%s słów');
define('TEXT_REVIEW_RATING', 'Ocena: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Data Dodania: %s');
define('TEXT_NO_REVIEWS', 'Dla tego produktu nie napisano jeszcze recenzji!');

define('TEXT_NO_NEW_PRODUCTS', 'Nie ma nowych produktów.');

define('TEXT_UNKNOWN_TAX_RATE', 'Nieznana stawka podatku');

define('TEXT_REQUIRED', 'wymagane');

define('ERROR_TEP_MAIL', '<font face="Verdana, Arial" size="2" color="#ff0000"><b><small>BŁ·D TEP:</small> Nie można wysłać wiadomości przez wskazany serwer SMTP. Sprawdˇ konfigurację pliku php.ini i jeżeli jest to konieczne, popraw wpis dot. serwera SMTP.</b></font>');
define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Ostrzeżenie: Istnieje katalog instalacyjny w lokalizacji: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/install. Usuń ten katalog ze względów bezpieczeństwa.');
define('WARNING_CONFIG_FILE_WRITEABLE', 'Ostrzeżenie: Istnieje możliwość zapisu pliku konfiguracyjnego w lokalizacji: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/includes/configure.php. Istnieje ryzyko zagrożenia pracy systemu - zmień uprawnienia dla tego pliku.');
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Ostrzeżenie: Katalog dla sesji nie istnieje: ' . tep_session_save_path() . '. Sesje nie będ± działać dopóki nie zostanie utworzony katalog.');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Ostrzeżenie: Nie ma możliwości zapisu do katalogu sesji: ' . tep_session_save_path() . '. Sesje nie będ± działać dopóki nie zostan± ustawione właściwe uprawnienia dla tego katalogu.');
define('WARNING_SESSION_AUTO_START', 'Ostrzeżenie: Parametr session.auto_start jest aktywny - zablokuj go zmieniaj±c konfigurację pliku php.ini i zrestartuj serwer www.');
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Ostrzeżenie: Katalog dla produktów możliwych do ści±gnięcia (plików, programów itp) nie istnieje: ' . DIR_FS_DOWNLOAD . '. Produkty które można ści±gać nie będ± działały dopóki ten katalog nie zostanie utworzony.');

define('TEXT_CCVAL_ERROR_INVALID_DATE', 'Data ważności karty kredytowej jest błędna.<br>Proszę sprawdzić datę na karcie i spróbować ponownie.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'Wprowadzony numer karty kredytowej jest błędny.<br>Prosze sprawdzić numer na karcie i spróbować ponownie.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'Pierwsze cztery cyfry z numeru karty kredytowej to: %s<br>Nawet jeżeli ten numer jest poprawny to niestety nie akceptujemy tego typu kart kredytowej.<br>Jeżeli numer jest błędny proszę go poprawić i spróbowac ponownie');

define('BOX_HEADING_ARTICLECAT', 'Artykuły');
define('IMAGE_READ_ARTICLE', 'czytaj Artykuł');
define('TEXT_DISPLAY_NUMBER_OF_ARTICLES', 'Wyświetlono <b>%d</b> do <b>%d</b> (z  <b>%d</b> artykułów)');



/*
  Poniższa informacja o prawie autorskim może być
  modyfikowana lub usunięta jedynie gdy wygl±d serwisu
  został zmieniony i różni się od domyślnego zastrzeżonego
  prawem wygl±du osCommerce.

  Więcej informacji znajdziesz w FAQ na stronie wsparcia
  osCommerce:

        http://www.oscommerce.com/about/copyright

  Pozostaw ten komentarz nienaruszony wraz z następuj±cy±
  informacj± o prawach autorskich.
*/
define('FOOTER_TEXT_BODY', 'Design &copy; 2005 <a href="http://www.mysklep.pl" target="_blank" class="stopka">Mysklep.pl</a><br><a href="http://www.oscommerce.com" target="_blank"">Powered by </a><a href="http://www.oscommerce.pl" target="_blank" title="osCommerce - Profesjonalne Sklepy Internetowe" class="stopka">osCommerce PRO</a>');

//produkty polecane
define('TABLE_HEADING_FEATURED_PRODUCTS', 'Produkty polecane');
define('TABLE_HEADING_FEATURED_PRODUCTS_CATEGORY', 'Produkty polecane dla kategorii');

//pole NIP dla klienta
define('ENTRY_NIP', 'Numer NIP:');
define('ENTRY_NIP_ERROR', '');
define('ENTRY_NIP_TEXT','(np. 666-666-66-66)');

///polityka prywatnosci
define('ENTRY_PRIVACY_AGREEMENT', 'Przeczytałem ' . '<a href="' . tep_href_link(FILENAME_INFORMATION,'info_id=3') . '" target="_blank"><u>regulamin</u></a> i akceptuję go');
define('ENTRY_PRIVACY_AGREEMENT_ERROR', "Przeczytaj regulamin oraz zaakceptuj go. Jeżeli tego nie zrobisz, nie będziemy mogli  przyj±ć Twojej rejestracji.");

//dodatkowe pola dla klienta
define('ENTRY_STREET_ADDRESS_MIESZKANIE', 'Nr Lokalu:');
define('ENTRY_STREET_ADDRESS_MIESZKANIE_TEXT', '');
define('ENTRY_STREET_ADDRESS_DOM', 'Nr Domu:');
define('ENTRY_STREET_ADDRESS_DOM_TEXT', '*');

define('ENTRY_GMINA', 'Gmina:');
define('ENTRY_GMINA_TEXT', '');
define('ENTRY_POWIAT', 'Powiat:');
define('ENTRY_POWIAT_TEXT', '');
define('HEADER_TITLE_DEFAULT', 'Strona Główna');

//info o podatku
define('ALL_PRICES_NET','Ceny nie zawieraj± VAT');
define('ALL_PRICES_GRO','Ceny zawieraj± VAT');

//lista wybierana wojewodztw
define ('DEFAULT_COUNTRY', '170');
define('ENTRY_STATE_TEXT', '* (najpierw wybierz kraj)');
define('ENTRY_COUNTRY_TEXT', '* (Strona zostanie wczytana po wyborze)');

//box logowania
define('LOGIN_BOX_PASSWORD_FORGOTTEN','Zapomniałeś hasła?');
define('LOGIN_BOX_NEW_ACCOUNT','Nowy klient');
define('LOGIN_BOX_SAFE_LOGIN','Bezpieczne logowanie');

define('TABLE_HEADING_DEFAULT_SPECIALS','Promocje %s');

//require(DIR_WS_LANGUAGES . $language . '/' . 'center_shop.php');
define('RV_LAST', 'ostatnich');
define('RV_PROD', 'produktów');
define('IMAGE_BUTTON_CREATE_ACCOUNT', 'Utwórz Konto');
define('NAV_ORDER_INFO', 'Szczegóły Zamówienia');
//TotalB2B start
define('PRICES_LOGGED_IN_TEXT','Cena po zalogowaniu!');
//TotalB2B end
define('TEXT_BUY', 'Dodaj do koszyka: ');
define('TEXT_NOW', '');
define('TEXT_NO_PRODUCTS','Aktualnie brak produktów');

// BEGIN PopTheTop Reviews in Product Description
define('BOX_HEADING_REVIEWS', 'Recenzje');
define('BOX_HEADING_REVIEWS_CUSTOMERS', 'Opinie naszych Klientów');
define('BOX_REVIEWS_WRITE_REVIEW', 'Napisz recenzję o tym produkcie!');
define('BOX_REVIEWS_NO_REVIEWS', 'Obecnie nie ma recenzji o produktach');
define('BOX_REVIEWS_TEXT_OF_5_STARS', 'Ocena: %s na 5!');
define('RV_LAST', 'ostatnich');
define('RV_PROD', 'produktów');
define('SEE_PRODUCT_NOW','Szczegółowy opis ');

define('TEXT_REVIEW_AVERAGE', '¦rednia ocena Klientów');
define('TEXT_REVIEW_NONE', 'Jeszcze nie oceniano');
define('TEXT_REVIEW_INVITE', '(Możesz być pierwszy)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS_PRODUCT_INFO', 'Lista <b>%d</b> z <b>%d</b> recenzji');
define('TEXT_MORE','[więcej]');
define('LAST_UPDATE','Ostatnia aktualizacja: ');
define('BOX_INFORMATION_RETURNS', '¦ledĽ reklamacje');
define('STAR_TITLE', 'HIT Tygodnia'); // star product
define('STAR_READ_MORE', '  ... więcej'); 
// END PopTheTop Reviews in Product Description

define('TEXT_NOWY_KLIENT', 'Nowy klient'); 
define('TEXT_ZALOGUJ', 'Zaloguj się'); 
define('TEXT_WYLOGUJ', 'Wyloguj się'); 
define('TEXT_TWOJE_KONTO', 'Twoje konto'); 
define('TEXT_TWOJ_KOSZYK', 'Twój koszyk'); 
define('TEXT_NOWOSCI', 'Nowości'); 
define('TEXT_PROMOCJE', 'Promocje'); 
define('TEXT_CENNIK', 'Cennik'); 
define('TEXT_LOGIN_STATUS', 'Jesteś zalogowany jako'); 

define('TEXT_ALL', 'Wszystko');
define('TEXT_ALL_MANUFACTURERS_SHORT', ' Wszyscy ');
define('TEXT_ALL_MANUFACTURERS', 'Wszyscy Producenci');
define('TEXT_ALL_CATEGORIES_SHORT', ' Wszystkie ');
define('TEXT_ALL_CATEGORIES', 'Wszystkie Kategorie');
define('TEXT_ALL_AVL', 'Wszystkie Produkty');
define('TEXT_ON_AVL', 'Tylko Dostępne');

define('TEXT_SHOW_VIEW','Pokazuj produkty:');
define('TEXT_VIEW_STD','Standardowo');
define('TEXT_VIEW_BOX','W Boksach');

define('TEXT_SHOW_MANUFACTURERS', 'Pokaż producenta:');
define('TEXT_SHOW_CATEGORIES', 'Pokaż kategorie:');
define('TEXT_SHOW_AVL', 'Pokaż produkty:');
define('TEXT_SHOW_SORT', 'Sortuj produkty wg:');
define('TEXT_RAZEM','Razem: ');
define('TEXT_WARTOSC_ZAKUPOW','Wartość zakupów: ');
define('TEXT_PRODUKTOW_W_KOSZYKU','Produktów w koszyku: ');

define('VISITORS_ONLINE', 'Osób na stronie:');

define('TEXT_WRITE_TO_US','napisz do nas');
define('TEXT_OPINIA','opinia o ');
define('TEXT_RECENZJA','recenzja ');

// multiklient
define('ENTRY_EXTRA_FIELDS_ERROR','Pole %s musi mieć min. %d znaków.');
define('CATEGORY_EXTRA_FIELDS', 'Dane uzupełniaj±ce');

// MS
define('TABLE_HEADING_MULTIPLE','');
define('TEXT_QTY',' szt. ');

// wszyscy producenci
define('BOX_INFORMATION_ALLMANUFACTURERS', 'Oferta wg producentów');

// pasujace akcesoria
define('TEXT_XSELL_PRODUCTS','Produkty pokrewne');
define('TEXT_GWARANCJA_OBJETY_MIESIAC','Produkt objęty %s-miesięczn± gwarancj±');
define('TEXT_GWARANCJA_OBJETY_ROK','Produkt objęty %s-letni± gwarancj±');
define('TEXT_GWARANCJA_NIEOBJETY','Produkt nie jest objęty gwarancj±');	
define('TEXT_ZOBACZ_TAKZE','Zobacz także');	

// schowek
define('BOX_HEADING_CUSTOMER_WISHLIST','Schowek');
define('TEXT_WISHLIST_COUNT', 'W schowku znajduje się %s towarów.');
define('BOX_HEADING_SCHOWEK','Schowek');
define('TEXT_PRODUKTOW_W_SCHOWKU','Produktów w schowku: ');
define('TEXT_WARTOSC_SCHOWEK','Wartość produktów: ');

// newsy
define('BOX_HEADING_NEWSDESK', 'System newsów');
define('BOX_NEWSDESK', 'Zarz±dzanie artykułami');
define('BOX_NEWSDESK_REVIEWS', 'Zarz±dzanie komentarzami');

define('NEWSDESK_ARTICLES', 'Artykuły');
define('NEWSDESK_REVIEWS', 'Komentarze');

define('TABLE_HEADING_NEWSDESK', 'Newsy');
define('TEXT_NO_NEWSDESK_NEWS', 'Nie znaleziono wybranego newsa');
define('TEXT_NEWSDESK_READMORE', 'więcej');
define('TEXT_NEWSDESK_VIEWED', 'Ogl±dano:');

define('BOX_HEADING_NEWSDESK_CATEGORIES', 'Grupy Newsów');
define('BOX_HEADING_NEWSDESK_LATEST', 'Ostatnie Newsy');

define('TEXT_DISPLAY_NUMBER_OF_ARTICLES', 'Wyświetlanie <b>%d</b> to <b>%d</b> (z <b>%d</b> artykułów)');


//  define('DIR_WS_RSS', DIR_WS_INCLUDES . 'modules/newsdesk/rss/');
?>