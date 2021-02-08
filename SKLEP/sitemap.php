<?php
/*
  $Id: sitemap.php,v1.0 2004/05/25 devosc Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_SITEMAP);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_SITEMAP));
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_TEMPLATES . $template . $language . '/stylesheet.css';?>">
</head>
<body>
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<?php include('includes/body.php'); ?>
    <td width="100%" valign="top">
	
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php
			$info_box_contents = array();
			$info_box_contents[] = array('text' => HEADING_TITLE);
			new infoBoxHeading($info_box_contents, true, true);
	  ?></td>
      </tr>
	</table>

	<table border="0" width="100%" cellspacing="0" cellpadding="0" class="blrb">
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2">
          <tr>
            <td width="50%" class="main" valign="top"><?php require DIR_WS_CLASSES . 'category_tree.php'; $osC_CategoryTree = new osC_CategoryTree; echo $osC_CategoryTree->buildTree(); ?></td>
            <td width="50%" class="main" valign="top">
              <ul>
                <li><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">' . PAGE_ACCOUNT . '</a>'; ?></li>
                <ul>
                  <li><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL') . '">' . PAGE_ACCOUNT_EDIT . '</a>'; ?></li>
                  <li><?php echo '<a href="' . tep_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL') . '">' . PAGE_ADDRESS_BOOK . '</a>'; ?></li>
                  <li><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL') . '">' . PAGE_ACCOUNT_HISTORY . '</a>'; ?></li>
                  <li><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT_NEWSLETTERS, '', 'SSL') . '">' . PAGE_ACCOUNT_NOTIFICATIONS . '</a>'; ?></li>
                </ul>
                  <li><?php echo '<a href="' . tep_href_link(FILENAME_SHOPPING_CART) . '">' . PAGE_SHOPPING_CART . '</a>'; ?></li>
                  <li><?php echo '<a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . '">' . PAGE_CHECKOUT_SHIPPING . '</a>'; ?></li>
                  <li><?php echo '<a href="' . tep_href_link(FILENAME_ADVANCED_SEARCH) . '">' . PAGE_ADVANCED_SEARCH . '</a>'; ?></li>
                  <li><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_NEW) . '">' . PAGE_PRODUCTS_NEW . '</a>'; ?></li>
                  <li><?php echo '<a href="' . tep_href_link(FILENAME_SPECIALS) . '">' . PAGE_SPECIALS . '</a>'; ?></li>
                  <li><?php echo '<a href="' . tep_href_link(FILENAME_REVIEWS) . '">' . PAGE_REVIEWS . '</a>'; ?></li>
                  <li><?php echo BOX_HEADING_INFORMATION; ?></li>
                <ul>
<?php
// Information Pages Unlimited BEGIN
  $information_query=mysql_query('SELECT information_id, languages_id, info_title FROM ' . TABLE_INFORMATION .' WHERE visible=\'1\' and languages_id ='.$languages_id.' ORDER BY v_order')
    or die(mysql_error());

 while ($page = tep_db_fetch_array($information_query)) {
  $rows++;

  if($page['info_title'] != 'Contact Us'){
    $link = FILENAME_INFORMATION . '?info_id=' . $page['information_id'];
  }else{
    $link = FILENAME_CONTACT_US;
  }

  echo '<li><a href="' . tep_href_link($link) . '">' . $page['info_title'] . '</a></li>';
}
// Information Pages Unlimited END
?>
                  <li><?php echo '<a href="' . tep_href_link(FILENAME_CONTACT_US) . '">' . BOX_INFORMATION_CONTACT . '</a>'; ?></li>
                </ul>
              </ul>
            </td>
          </tr>
        </table>
<?php 
$back = sizeof($navigation->path)-2;
if (isset($navigation->path[$back])) {
echo '<br><br><a href="' . 
tep_href_link($navigation->path[$back]['page'], tep_array_to_string($navigation->path[$back]['get'], array('action')), $navigation->path[$back]['mode']) . '">' . 
tep_image_button('button_back.gif', IMAGE_BUTTON_CONTINUE_SHOPPING) . '</a>'; 
}
?>
		</td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
<?php include('includes/footer_1.php'); ?>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>