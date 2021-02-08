<?php
/*
  $Id: shopping_cart.php,v 1.13 2003/06/08 08:14:17 ramroz Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Publikowane na zasadach licencji GNU General Public License

  T³umaczenie: Rafa³ Mróz ramroz@optimus.pl
  http://www.portalik.com

*/

define('NAVBAR_TITLE', 'Zawarto¶æ Koszyka');
define('HEADING_TITLE', 'Co Jest w Moim Koszyku?');
define('TABLE_HEADING_REMOVE', 'Usuñ');
define('TABLE_HEADING_QUANTITY', 'Ilo¶æ');
define('TABLE_HEADING_MODEL', 'Model');
define('TABLE_HEADING_PRODUCTS', 'Produkt(y)');
define('TABLE_HEADING_TOTAL', 'Suma');
define('TEXT_CART_EMPTY', 'Twój Koszyk jest pusty!');
define('SUB_TITLE_SUB_TOTAL', 'Podsuma:');
define('SUB_TITLE_TOTAL', 'Suma:');

define('OUT_OF_STOCK_CANT_CHECKOUT', 'Produktów zaznaczonych symbolem <b>' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '</b> nie ma aktualnie na magazynie w wystarczaj±cej ilo¶ci.<br>Proszê zmieniæ zamawian± ilo¶æ produktów zaznaczonych symbolem (' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '), Dziêkujemy');
define('OUT_OF_STOCK_CAN_CHECKOUT', 'Produktów zaznaczonych sybolem <b>' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '</b> nie ma aktualnie na magazynie w wystarczaj±cej ilo¶ci.<br>Mo¿esz wykupiæ te które mamy, a brakuj±c± ilo¶æ wy¶lemy najszybciej jak to tylko mo¿liwe.');
define('TEXT_ORDER_UNDER_MIN_AMOUNT', 'Wybrane towary musz± mieæ warto¶æ min. %s aby móc z³o¿yæ zamówienie.');




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