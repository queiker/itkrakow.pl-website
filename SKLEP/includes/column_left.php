<?php
/*
  $Id: column_left.php,v 1.15 2003/07/01 14:34:54 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  if ((USE_CACHE == 'true') && empty($SID)) {
    echo tep_cache_categories_box();
  } else {
    include(DIR_WS_BOXES . 'categories.php');
  }

  require(DIR_WS_BOXES . 'search.php');



  require(DIR_WS_BOXES . 'specials.php');

//  require(DIR_WS_BOXES . 'search.php');  
  include(DIR_WS_BOXES . 'kontakt.php');
  
?>
	<tr>
		<td style="width: 100%"><span class="reklama">
		  <?php add_banners_group('banery_lewa'); ?>
		</span></td>
		</tr>
<?php

//  require(DIR_WS_BOXES . 'whats_new.php');

if((int)$HTTP_GET_VARS['products_id'] > 0 && basename($PHP_SELF) == FILENAME_PRODUCT_INFO) {
	  include(DIR_WS_BOXES . 'tell_a_friend.php');
}
?>