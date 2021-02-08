<?php
/*
  $Id: create_account_process.php,v 1.0 2003/03/25 10:30:17 ramroz Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Publikowane na zasadach licencji GNU General Public License

  T³umaczenie: Rafa³ Mróz ramroz@optimus.pl
  http://www.portalik.com
  modyfikacje "odkalkowuj±ce" : devein@acmosis.eu.org
  
*/

define('NAVBAR_TITLE_1', 'Za³ó¿ konto');
define('NAVBAR_TITLE_2', 'Uzupe³nianie danych');
define('HEADING_TITLE', 'Informacje o moim koncie');

define('EMAIL_SUBJECT', 'Witaj w sklepie ' . STORE_NAME);
define('EMAIL_GREET_MR', 'Szanowny Panie ' . stripslashes($HTTP_POST_VARS['lastname']) . ',' . "\n\n");
define('EMAIL_GREET_MS', 'Szanowna Pani ' . stripslashes($HTTP_POST_VARS['lastname']) . ',' . "\n\n");
define('EMAIL_GREET_NONE', 'Drogi ' . stripslashes($HTTP_POST_VARS['firstname']) . ',' . "\n\n");
define('EMAIL_WELCOME', 'Witamy w sklepie <b>' . STORE_NAME . '</b>.' . "\n\n");
define('EMAIL_TEXT', 'Dziêki rejestracji masz mo¿liwo¶æ skorzystania z <b>wielu us³ug</b> jakie oferujemy naszym u¿ytkownikom. Niektóre z nich to:' . "\n\n" . '
<li><b>Trwa³y Koszyk</b> - Ka¿dy produkt dodany do koszyka pozostaje w nim do momentu zamówienia lub usuniêcia.' . "\n" . '<li><b>Ksi±¿ka Adresowa</b> - Teraz mo¿emy dostarczyæ produkty które zamówisz pod wskazany przez ciebie adres!
To dobry sposób na wys³anie komu¶ prezentu urodzinowego.' . "\n" . '<li><b>Historia Zamówieñ</b> - Zobacz historiê zamówieñ które u nas sk³ada³e¶.' . "\n" . '<li><b>Opiniowanie Produktów</b> - Podziel siê swoimi opiniami o produktach z innymi klientami.' . "\n\n");
define('EMAIL_CONTACT', 'W celu uzyskania pomocy skontaktuj siê droga elektroniczn± z w³a¶cicielem sklepu: ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n\n");
define('EMAIL_WARNING', '<b>UWAGA:</b> Ten adres email otrzymali¶my od jednego z naszych klientów podczas jego rejestracji. Je¿eli to nie Ty zak³ada³e¶ to konto wy¶lij wiadomo¶æ na adres ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n");
?>
