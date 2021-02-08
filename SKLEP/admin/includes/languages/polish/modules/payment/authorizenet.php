<?php
/*
  $Id: authorizenet.php,v 1.0 2003/06/08 08:14:17 ramroz Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Publikowane na zasadach licencji GNU General Public License

  T³umaczenie: Rafa³ Mróz ramroz@optimus.pl
  http://www.portalik.com

*/

  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_TITLE', 'Authorize.net');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_DESCRIPTION', 'Dane Testowe Karty:<br><br>Nr: 4111111111111111<br>Data Wa¿no¶ci: Dowolna');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_TYPE', 'Rodzaj Karty:');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_CREDIT_CARD_OWNER', 'W³a¶ciciel Karty:');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_CREDIT_CARD_NUMBER', 'Numer Karty:');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_CREDIT_CARD_EXPIRES', 'Data Wa¿no¶ci Karty:');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_JS_CC_OWNER', '* Imiê i Nazwisko w³a¶ciciela karty musi mieæ przynajmniej ' . CC_OWNER_MIN_LENGTH . ' zn.\n');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_JS_CC_NUMBER', '* Numer karty musi mie¶ przynajmniej ' . CC_NUMBER_MIN_LENGTH . ' zn.\n');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_ERROR_MESSAGE', 'Wyst±pi³ b³±d podczas przetwarzania twojej karty. Spróbuj ponownie.');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_DECLINED_MESSAGE', 'Twoja karta zosta³a odrzucona przez centrum autoryzacyjne. U¿yj innej karty lub skontaktuj siê ze swoim bankiem w celu wyja¶nienia.');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_ERROR', 'Bl±d w obs³udze karty!');
?>
