<?php
/*
  $Id: create_account.php,v 1.13 2003/05/19 20:17:51 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE_CREATE_ACCOUNT', 'Utwórz konto klienta');
define('PULL_DOWN_DEFAULT', 'Wybierz');
define('HEADING_TITLE','Nowe konto klienta');

define('HEADING_TITLE_CREATE_ACCOUNT_SUCCESS', 'Nowe konto zosta³o utworzone');

define('EMAIL_PASS_1', 'Twoje has³o: ');
define('EMAIL_PASS_2', "\n" . 'Mo¿esz je zmieniæ po zalogowaniu do sklepu.' . "\n\n");

define('EMAIL_SUBJECT', 'Witaj w sklepie ' . STORE_NAME);
define('EMAIL_GREET_MR', 'Szanowny Panie,' . "\n\n");
define('EMAIL_GREET_MS', 'Szanowna Pani,' . "\n\n");
define('EMAIL_GREET_NONE', 'Drogi Kliencie' . "\n\n");
define('EMAIL_WELCOME', 'Witamy w sklepie <b>' . STORE_NAME . '</b>.' . "\n\n");
define('EMAIL_TEXT', 'Dziêki rejestracji masz mo¿liwo¶æ skorzystania z <b>wielu us³ug</b> jakie oferujemy naszym u¿ytkownikom. Niektóre z nich to:' . "\n\n" . ' <li><b>Trwa³y Koszyk</b> - Ka¿dy produkt dodany do koszyka pozostaje w nim do momentu zamówienia lub usuniêcia.' . "\n" . '<li><b>Ksi±¿ka Adresowa</b> - Teraz mo¿emy dostarczyæ produkty które zamówisz pod wskazany przez ciebie adres! To dobry sposób na wys³anie komu¶ prezentu urodzinowego.' . "\n" . '<li><b>Historia Zamówieñ</b> - Zobacz historiê zamówieñ które u nas sk³ada³e¶.' . "\n" . ' <li><b>Opiniowanie Produktów</b> - Podziel siê swoimi opiniami o produktach z innymi klientami.' . "\n\n");
define('EMAIL_CONTACT', 'W celu uzyskania pomocy skontaktuj siê droga elektroniczn± z w³a¶cicielem sklepu: ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n\n");
define('EMAIL_WARNING', '<b>UWAGA:</b> Ten adres email otrzymali¶my od jednego z naszych klientów podczas jego rejestracji. Je¿eli to nie Ty zak³ada³e¶ to konto wy¶lij wiadomo¶æ na adres ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n");
define('ENTRY_CELL_NUMBER', 'Telefon komórkowy:');

define('ENTRY_CUSTOMERS_DISCOUNT', 'Zni¿ka Kliencka:');
define('ENTRY_CUSTOMERS_GROUPS_NAME', 'Grupa:');
define('', '');

define('CATEGORY_PASSWORD','Has³o startowe');
define('ENTRY_PASSWORD','Has³o:');
define('ENTRY_PASSWORD_CONFIRMATION','Potwierdzenie has³a:');
define('ENTRY_PASSWORD_TEXT','');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT','');
?>