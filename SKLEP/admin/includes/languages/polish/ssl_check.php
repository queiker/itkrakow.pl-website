<?php
/*
  $Id: ssl_check.php,v 1.1 2003/06/08 08:14:17 ramroz Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Publikowane na zasadach licencji GNU General Public License

  T³umaczenie: Rafa³ Mróz ramroz@optimus.pl
  http://www.portalik.com

*/

define('NAVBAR_TITLE', 'Weryfikacja Zabezpieczeñ');
define('HEADING_TITLE', 'Weryfikacja Zabezpieczeñ');

define('TEXT_INFORMATION', 'Wykryli¶my ¿e twoja przegl±darka wygenerowa³a inny identyfikator sesji SSL (SSL Session ID) ni¿ u¿ywany na naszych stronach.<br><br>Z powodów bezpieczeñstwa musisz siê zalogowaæ na swoje konto ponownie aby kontynuowaæ zakupy.
<br><brNiektóre przegl±darki jak Konqueror 3.1 nie potrafi± generowaæ ID sesji w protokole SSL którym my wymagamy. Je¿eli u¿ywasz takiej przegl±darki, zalecamy zainstalowanie innej jak np. <a href="http://www.microsoft.com/ie/" target="_blank">
Microsoft Internet Explorer</a>, <a href="http://channels.netscape.com/ns/browsers/download_other.jsp" target="_blank">Netscape</a> albo <a href="http://www.mozilla.org/releases/" target="_blank">Mozilla</a>, wtedy bêdzie mo¿na kontynuowaæ zakupy.<br><br>We have taken this measurement of security for your benefit, and apologize upfront if any inconveniences are caused.<br><br>Please contact the store owner if you have any questions relating to this requirement, or to continue purchasing products offline.');

define('BOX_INFORMATION_HEADING', 'Prywatno¶æ i Bezpieczeñstwo');
define('BOX_INFORMATION', 'Sprawdzamy ID sesji SSL generowanej automatycznie przez twoj± przegl±darkê podczas ka¿dego ¿±dania strony w protokole SSL.<br><br>To upewnia nas ¿e to Ty jeste¶ osob± która porusza siê po stronie u¿ywaj±c twojego konta a nie
kto¶ inny.');
?>
