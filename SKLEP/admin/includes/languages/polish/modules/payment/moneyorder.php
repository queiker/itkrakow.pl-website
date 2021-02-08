<?php
/*
  $Id: moneyorder.php,v 1.0 2003/03/25 10:30:17 ramroz Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Publikowane na zasadach licencji GNU General Public License

  T³umaczenie: Rafa³ Mróz ramroz@optimus.pl
  http://www.portalik.com

*/

  define('MODULE_PAYMENT_MONEYORDER_TEXT_TITLE', 'Czek/Przelew');
  define('MODULE_PAYMENT_MONEYORDER_TEXT_DESCRIPTION', 'Wp³ata Dla:&nbsp;' . MODULE_PAYMENT_MONEYORDER_PAYTO . '<br><br>Nale¿no¶æ Wys³aæ Do:<br>' . nl2br(STORE_NAME_ADDRESS) . '<br><br>' . 'Twoje zamówienie bêdzie realizowane dopiero gdy uregulujesz nale¿no¶æ.');
  define('MODULE_PAYMENT_MONEYORDER_TEXT_EMAIL_FOOTER', "Wp³ata Dla: ". MODULE_PAYMENT_MONEYORDER_PAYTO . "\n\nNale¿no¶æ Wys³aæ Do:\n" . STORE_NAME_ADDRESS . "\n\n" . 'Twoje zamówienie bêdzie realizowane dopiero gdy uregulujesz nale¿no¶æ.');
?>
