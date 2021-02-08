<?php
/*
  $Id: column_right.php,v 1.17+ 2003/06/09 22:06:41 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
//  require(DIR_WS_BOXES. 'loginbox.php');

  if ((USE_CACHE == 'true') && empty($SID)) {
    echo tep_cache_manufacturers_box();
  } else {
    include(DIR_WS_BOXES . 'manufacturers.php');
  }

  include(DIR_WS_BOXES . 'shopping_cart.php');

  if($wishList->count_wishlist() != '0') {
	  include(DIR_WS_BOXES . 'wishlist.php');
  }

  include(DIR_WS_BOXES . 'information.php');
  include(DIR_WS_BOXES . 'best_sellers.php');
  include(DIR_WS_BOXES . 'product_notifications.php');
?>
	<tr>
		<td style="width: 100%"><span class="reklama">
		  <?php add_banners_group('banery_prawa'); ?>
		</span></td>
		</tr>
<?php
?>