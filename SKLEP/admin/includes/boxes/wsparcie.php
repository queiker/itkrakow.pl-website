<?php
/*
  $Id: wsparcie.php,v 1.00 2009/12/29 00:00:00 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- tools //-->
          <tr>
            <td>
<?php
  $heading = array();
  $contents = array();

  $heading[] = array('text'  => 'wsparcie',
                     'link'  => tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('selected_box')) . 'selected_box=wsparcie'));

  if ($selected_box == 'wsparcie' || $menu_dhtml == true) {
    $contents[] = array('text'  => '<a href="http://rejestracja.mysklep.pl" target="_blank" class="menuBoxContentLink">Rejestracja oprogramowania</a><br>' .
                                   '<a href="http://www.mysklep.pl/sklep/help_centrum.php" target="_blank" class="menuBoxContentLink">Formularz pomocy technicznej</a><br>' .
                                   '<a href="http://www.mysklep.pl/sklep/pomoc/" target="_blank" class="menuBoxContentLink">Regulamin dzia³u pomocy</a>');
  }

  $box = new box;
  echo $box->menuBox($heading, $contents);
?>
            </td>
          </tr>
<!-- tools_eof //-->
