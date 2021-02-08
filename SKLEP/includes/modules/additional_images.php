<?php
/*
  $Id: additional_images.php,v 1.0 2003/02/28 dgw_ Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce
 $new_products['images_description']
  AUTHOR: Zaenal Muttaqin <zaenal@paramartha.org>  
  Released under the GNU General Public License  
*/
?>
<?php
if((int)tep_db_prepare_input($HTTP_GET_VARS['products_id']) > 0) {
  $images_product = tep_db_query("SELECT ai.additional_images_id, ai.products_id, ai.images_description, ai.popup_images, pd.products_name FROM " . TABLE_ADDITIONAL_IMAGES . " ai LEFT JOIN ".TABLE_PRODUCTS_DESCRIPTION." pd on ai.products_id = pd.products_id WHERE ai.products_id = '" . (int)tep_db_prepare_input($HTTP_GET_VARS['products_id']) . "' AND pd.language_id = '".(int)$languages_id."'");
  if (!tep_db_num_rows($images_product)) {
// nie aktywujemy zakladki zdjec dodatkowych
  } else {
?>
<!-- additional_images //-->
	<table width="100%">	
	  <tr>
	    <td>

<?php
  $info_box_contents = array();
  $row = 0;
  $col = 0;
  while ($new_products = tep_db_fetch_array($images_product)) {
    $info_box_contents[$row][$col] = array('align' => 'center',
                                           'params' => 'class="smallText" width="25%" valign="top"',
                                           'text' => '<a href="'. DIR_WS_IMAGES . $new_products['popup_images'] .'" title="'.(($new_products['images_description'])?str_replace('"','\'\'',$new_products['images_description']):str_replace('"','\'\'',$new_products['products_name'])).' " rel="lightbox['.$new_products['products_id'].']">' . tep_image_mini(DIR_WS_IMAGES . $new_products['popup_images'], $new_products['images_description'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'hspace="5" vspace="5" style="border: 1px solid #CCC;"') . '<br>' . tep_image_button('image_enlarge.gif') . '</a>'
                                          );
    $col ++;
    if ($col >= 3) {
      $col = 0;
      $row ++;
    }
  }
  new imagesBox($info_box_contents);
?>
	    </td>
	  </tr>
	</table>
<!-- additional_images_eof //-->
<?php
  }
}
?>