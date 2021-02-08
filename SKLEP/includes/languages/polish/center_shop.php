<?php
// WebMakers.com Added: CENTER SHOP CONTROL
// /catalog/includes/languages/english/center_shop.php
// in english.php require(DIR_WS_LANGUAGES . $language . '/' . 'center_shop.php');

define('CENTER_SHOP_ON','1'); // Center the shop
define('CENTER_SHOP_WIDTH','780'); // Width for the shop
define('CENTER_SHOP_BACKGROUND_ON','1'); // Turn on a background around the shop
define('CENTER_SHOP_BACKGROUND_COLOR_OUT',"#808080"); // Use what bgcolor for the outside of the shop
define('CENTER_SHOP_BACKGROUND_COLOR',"FFFFFF"); // Use what bgcolor for the inside of the shop
define('CENTER_SHOP_PADDING','5'); // Add cellpadding to the outter color

// Header image information
define('HEADER_IMG_LINK_ON','1');
define('HEADER_IMG_LINK_NEW_WIN','1');
// Change domain name to your's
if (HEADER_IMG_LINK_NEW_WIN=='1') {
  define('HEADER_IMG_LINK','http://www.oscommerce.pl" target="_blank');
} else {
  define('HEADER_IMG_LINK','http://www.oscommerce.pl');
}
define('HEADER_IMG_PIC', 'thewebmakerscorner_logo.gif');
define('HEADER_IMG_ALT', ' osCommerce Professional ');
?>