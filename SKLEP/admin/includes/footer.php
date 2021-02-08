<?php
/*
  $Id: footer.php,v 1.13 2004/04/08 02:20:03 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  if (substr(basename($PHP_SELF), 0, 5) != 'login' && substr(basename($PHP_SELF), 0, 8) != 'password') {
?>
<div align="center" class="boxText" style="color: #CCC;">Powered by <a style="color: #CCCCCC;" href="http://www.mysklep.pl" target="_blank">Mysklep.pl</a><br />

</div>
<br />
<?php
  }
?>