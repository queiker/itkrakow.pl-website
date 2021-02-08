<?php
/*
  $Id: wishlist.php,v 3.0  2005/04/20 Dennis Blake
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE_WISHLIST', 'Schowek');
define('HEADING_TITLE2', 'Produkty w schowku');
define('BOX_TEXT_PRICE', 'Cena');
define('BOX_TEXT_PRODUCT', 'Nazwa');
define('BOX_TEXT_IMAGE', 'Zdjêcie');
define('BOX_TEXT_SELECT', 'Wybierz');

define('BOX_TEXT_VIEW', 'Poka¿');
define('BOX_TEXT_HELP', 'Pomoc');
define('BOX_WISHLIST_EMPTY', 'Aktualnie brak produktów');
//define('BOX_TEXT_NO_ITEMS', 'Aktualnie nie ma ¿adnych produktów na twojej li¶cie. <br /><br /><b><a href="' . tep_href_link(FILENAME_WISHLIST_HELP) . '"><u>Zobacz</u></a> jak korzystaæ z przechowalni.</b>');
define('BOX_TEXT_NO_ITEMS', '<br>Aktualnie nie ma ¿adnych produktów na twojej li¶cie. <br>');
define('TEXT_NAME', 'Imiê: ');
define('TEXT_EMAIL', 'E-mail: ');
define('TEXT_YOUR_NAME', 'Twoje Imiê: ');
define('TEXT_YOUR_EMAIL', 'Twój E-mail: ');
define('TEXT_MESSAGE', 'Wiadomo¶æ: ');
define('TEXT_ITEM_IN_CART', 'Produkt w koszyku');
define('TEXT_ITEM_NOT_AVAILABLE', 'Produkt jest ju¿ niedostêpny');
define('TEXT_DISPLAY_NUMBER_OF_WISHLIST', 'Wy¶wietlono <b>%d</b> do <b>%d</b> (z <b>%d</b> produktów z schowku.)');

define('WISHLIST_EMAIL_TEXT', 'Mo¿esz przes³aæ produkty ze schowka do znajomych lub rodziny. Napisz krótk± wiadomo¶æ, która zostanie przes³ana razem z list± produktów.');

define('WISHLIST_EMAIL_TEXT_GUEST', 'Mo¿esz przes³aæ produkty ze schowka do znajomych lub rodziny. Pamiêtaj aby podaæ swój adres e-mail oraz imiê. Napisz krótk± wiadomo¶æ, która zostanie przes³ana razem z list± produktów.');

define('WISHLIST_EMAIL_SUBJECT', ' przesy³a ci listê wybranych produktów ze sklepu ' . STORE_NAME);  //Customers name will be automatically added to the beginning of this.
define('WISHLIST_SENT', 'Produkty ze schowka zosta³y przes³ane.');
define('WISHLIST_EMAIL_LINK', '

$from_name, ogólnodostêpny schowek znajduje siê pod adresem:
$link

Dziêkujemy,
' . STORE_NAME); //$from_name = Customers name  $link = public wishlist link

define('WISHLIST_EMAIL_GUEST', 'Dziêkujemy,
' . STORE_NAME);

define('ERROR_YOUR_NAME' , 'Podaj Imiê.');
define('ERROR_YOUR_EMAIL' , 'Podaj adres e-mail.');
define('ERROR_VALID_EMAIL' , 'Podaj poprawny adres e-mail.');
define('ERROR_ONE_EMAIL' , 'Musisz podaæ co najmniej jedno imiê i adres e-mail.');
define('ERROR_ENTER_EMAIL' , 'Podaj adres e-mail.');
define('ERROR_ENTER_NAME' , 'Podaj imiê adresata.');
define('ERROR_MESSAGE', 'Wpisz krótk± wiadomo¶æ.');
?>