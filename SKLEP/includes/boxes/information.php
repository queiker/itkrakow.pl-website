<?php
  /*
  $Id: product_notification.php,v 1.6 2002/11/22 18:56:08 dgw_ Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
  */
?>
<!-- information //-->
          <tr>
            <td class="borB">
<?php
  // Retrieve information from Info table
  $informationString = "";
  $info_box_contents = array();
  $info_box_contents[] = array('text' => BOX_HEADING_INFORMATION);

  new infoBoxHeading($info_box_contents, false, false);
// joles
//$sql=mysql_query('SELECT information_id, info_title FROM ' . TABLE_INFORMATION .' WHERE visible=\'1\' ORDER BY v_order')
$sql=mysql_query('SELECT information_id, languages_id, info_title FROM ' . TABLE_INFORMATION .' WHERE visible=\'1\' and languages_id ='.(int)$languages_id.' ORDER BY v_order')
 
    or die(mysql_error());
  while($row=mysql_fetch_array($sql)):
	$filename_information = tep_href_link(FILENAME_INFORMATION,'info_id=' . $row['information_id']);
	$informationString .= '<a class="menu_box_link" href="' . $filename_information . '">'.tep_image_t('gfx/arb.gif','-',' style="vertical-align: middle"') .' &nbsp; '. $row['info_title'] . '</a>';
  endwhile;

  $info_box_contents = array();
  $info_box_contents[] = array('text' =>	$informationString .
                                         	'<a class="menu_box_link" href="' . tep_href_link(FILENAME_CONTACT_US) . '">'.tep_image_t('gfx/arb.gif','-',' style="vertical-align: middle"') .' &nbsp; '. BOX_INFORMATION_CONTACT . '</a>');

  new infoBox($info_box_contents);
?>
            </td>
          </tr>
<!-- information_eof //-->

	<tr><td class="sep"></td></tr>	
