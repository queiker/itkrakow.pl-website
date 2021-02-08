<?php
/*
  $Id: password_forgotten.php,v 1.8 2003/06/08 08:14:17 ramroz Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Publikowane na zasadach licencji GNU General Public License

  T³umaczenie: Rafa³ Mróz ramroz@optimus.pl
  http://www.portalik.com

*/

define('NAVBAR_TITLE_1', 'Logowanie');
define('NAVBAR_TITLE_2', 'Zapomniane Has³o');
define('HEADING_TITLE', 'Zapomnia³em Swoje Has³o!');

define('TEXT_MAIN', 'Je¿eli zapomnia³e¶ has³o podaj swój adres e-mail a my wy¶lemy ci wiadomo¶æ z nowym has³em.');

define('TEXT_NO_EMAIL_ADDRESS_FOUND', 'B³±d: Podany Adres E-Mail nie zosta³ znaleziony w bazie naszych u¿ytkowników. Spróbuj ponownie.');

define('EMAIL_PASSWORD_REMINDER_SUBJECT', STORE_NAME . ' - Nowe Has³o');
define('EMAIL_PASSWORD_REMINDER_BODY', 'Z adresu ' . $REMOTE_ADDR . ' zosta³o wys³ane ¿±danie nowego has³a.' . "\n\n" . 'Twoje nowe has³o w sklepie \'' . STORE_NAME . '\' to:' . "\n\n" . '   %s' . "\n\n");

define('SUCCESS_PASSWORD_SENT', 'Nowe Has³o Zosta³o Wys³ane Na Twój Adres E-Mail.');
?>
