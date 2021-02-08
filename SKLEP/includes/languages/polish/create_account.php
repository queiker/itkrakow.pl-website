<?php
/*
  $Id: create_account.php,v 1.11 2003/06/08 08:14:17 ramroz Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Publikowane na zasadach licencji GNU General Public License

  T³umaczenie: Rafa³ Mróz ramroz@optimus.pl
  http://www.portalik.com

*/

define('NAVBAR_TITLE', 'Za³ó¿ Konto');
define('HEADING_TITLE', 'Informacje o Moim Koncie');
define('HEADING_TITLE_NO_ACCOUNT','Dane do zamówienia');

define('TEXT_ORIGIN_LOGIN', '<span class="infoWarning">INFORMACJA:</span> Je¿eli masz ju¿ konto w naszym sklepie, zaloguj siê na <a href="%s"><u>tej stronie</u></a>.');

define('EMAIL_SUBJECT', 'Witaj w sklepie ' . STORE_NAME);
define('EMAIL_GREET_MR', 'Szanowny Panie %s,' . "\n\n");
define('EMAIL_GREET_MS', 'Szanowna Pani %s,' . "\n\n");
define('EMAIL_GREET_NONE', 'Drogi %s' . "\n\n");
define('EMAIL_WELCOME', 'Witamy w sklepie <b>' . STORE_NAME . '</b>.' . "\n\n");
define('EMAIL_TEXT', 'Dziêki rejestracji masz mo¿liwo¶æ skorzystania z <b>wielu us³ug</b> jakie oferujemy naszym u¿ytkownikom. Niektóre z nich to:' . "\n\n" . ' <li><b>Trwa³y Koszyk</b> - Ka¿dy produkt dodany do koszyka pozostaje w nim do momentu zamówienia lub usuniêcia.' . "\n" . '<li><b>Ksi±¿ka Adresowa</b> - Teraz mo¿emy dostarczyæ produkty które zamówisz pod wskazany przez ciebie adres! To dobry sposób na wys³anie komu¶ prezentu urodzinowego.' . "\n" . '<li><b>Historia Zamówieñ</b> - Zobacz historiê zamówieñ które u nas sk³ada³e¶.' . "\n" . ' <li><b>Opiniowanie Produktów</b> - Podziel siê swoimi opiniami o produktach z innymi klientami.' . "\n\n");
define('EMAIL_CONTACT', 'W celu uzyskania pomocy skontaktuj siê droga elektroniczn± z w³a¶cicielem sklepu: ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n\n");
define('EMAIL_WARNING', '<b>UWAGA:</b> Ten adres email otrzymali¶my od jednego z naszych klientów podczas jego rejestracji. Je¿eli to nie Ty zak³ada³e¶ to konto wy¶lij wiadomo¶æ na adres ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n");
//PWA start
define('PWA_HEADING_TITLE', 'Informacje do zamówienia');
define('PWA_FAIL_ACCOUNT_EXISTS', 'Istnieje ju¿ konto utworzone dla adresu e-mail {EMAIL_ADDRESS}.  Musisz siê zalogowaæ podaj±c w³a¶ciwe has³o zanim bêdziesz móg³ kontynuowaæ procedurê zamawiania.');
//PWA end
//TotalB2B start
define('EMAIL_VALIDATE_SUBJECT', 'Nowy Klient w '. STORE_NAME);
define('EMAIL_VALIDATE', 'Nowy Klient zarejestrowany w '. STORE_NAME);
define('EMAIL_VALIDATE_PROFILE', 'Aby zobaczyæ profil Klienta kliknij:');
define('EMAIL_VALIDATE_ACTIVATE', 'Aby aktywowaæ Klienta kliknij:');
//TotalB2B end
?>
