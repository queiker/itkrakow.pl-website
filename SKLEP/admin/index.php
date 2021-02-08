<?php
/*
  $Id: index.php,v 1.17 2003/02/14 12:57:29 dgw_ Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  
  $cat = array(array('title' => "Moje Konto",
                     'access' => 'true',
                     'image' => 'tick.gif',
                     'href' => tep_href_link(FILENAME_ADMIN_ACCOUNT),
                     'children' => array(array('title' => 'Moje Konto', 'link' => tep_href_link(FILENAME_ADMIN_ACCOUNT),
                                               'access' => 'true'),
                                         array('title' => 'Wyloguj', 'link' => tep_href_link(FILENAME_LOGOFF),
                                               'access' => 'true'))),
               array('title' => BOX_HEADING_ADMINISTRATOR,
                     'access' => tep_admin_check_boxes('administrator.php'),
                     'image' => 'tick.gif',
                     'href' => tep_href_link(tep_selected_file('administrator.php'), 'selected_box=administrator'),
                     'children' => array(array('title' => BOX_ADMINISTRATOR_MEMBER, 'link' => tep_href_link(FILENAME_ADMIN_MEMBERS, 'selected_box=administrator'),
                                               'access' => tep_admin_check_boxes(FILENAME_ADMIN_MEMBERS, 'sub_boxes')),
                                         array('title' => BOX_ADMINISTRATOR_BOXES, 'link' => tep_href_link(FILENAME_ADMIN_FILES, 'selected_box=administrator'),
                                               'access' => tep_admin_check_boxes(FILENAME_ADMIN_FILES, 'sub_boxes')))),
               array('title' => BOX_HEADING_CONFIGURATION,
                     'access' => tep_admin_check_boxes('configuration.php'),
                     'image' => 'tick.gif',
                     'href' => tep_href_link(FILENAME_CONFIGURATION, 'selected_box=configuration&gID=1'),
                     'children' => array(array('title' => BOX_CONFIGURATION_MYSTORE, 'link' => tep_href_link(FILENAME_CONFIGURATION, 'selected_box=configuration&gID=1'),
                                               'access' => tep_admin_check_boxes(FILENAME_CONFIGURATION, 'sub_boxes')),
                                         array('title' => BOX_CONFIGURATION_LOGGING, 'link' => tep_href_link(FILENAME_CONFIGURATION, 'selected_box=configuration&gID=10'),
                                               'access' => tep_admin_check_boxes(FILENAME_CONFIGURATION, 'sub_boxes')),
                                         array('title' => BOX_CONFIGURATION_CACHE, 'link' => tep_href_link(FILENAME_CONFIGURATION, 'selected_box=configuration&gID=11'),
                                               'access' => tep_admin_check_boxes(FILENAME_CONFIGURATION, 'sub_boxes')))),
               array('title' => BOX_HEADING_MODULES,
                     'access' => tep_admin_check_boxes('modules.php'),
                     'image' => 'tick.gif',
                     'href' => tep_href_link(tep_selected_file('modules.php'), 'selected_box=modules&set=payment'),
                     'children' => array(array('title' => BOX_MODULES_PAYMENT, 'link' => tep_href_link(FILENAME_MODULES, 'selected_box=modules&set=payment'),
                                               'access' => tep_admin_check_boxes(FILENAME_MODULES, 'sub_boxes')),
                                         array('title' => BOX_MODULES_SHIPPING, 'link' => tep_href_link(FILENAME_MODULES, 'selected_box=modules&set=shipping'),
                                               'access' => tep_admin_check_boxes(FILENAME_MODULES, 'sub_boxes')))),
               array('title' => BOX_HEADING_CATALOG,
                     'access' => tep_admin_check_boxes('catalog.php'),
                     'image' => 'tick.gif',
                     'href' => tep_href_link(tep_selected_file('catalog.php'), 'selected_box=catalog'),
                     'children' => array(array('title' => CATALOG_CONTENTS, 'link' => tep_href_link(FILENAME_CATEGORIES, 'selected_box=catalog'),
                                               'access' => tep_admin_check_boxes(FILENAME_CATEGORIES, 'sub_boxes')),
                                         array('title' => BOX_CATALOG_MANUFACTURERS, 'link' => tep_href_link(FILENAME_MANUFACTURERS, 'selected_box=catalog'),
                                               'access' => tep_admin_check_boxes(FILENAME_MANUFACTURERS, 'sub_boxes')))),
               array('title' => BOX_HEADING_LOCATION_AND_TAXES,
                     'access' => tep_admin_check_boxes('taxes.php'),
                     'image' => 'tick.gif',
                     'href' => tep_href_link(tep_selected_file('taxes.php'), 'selected_box=taxes'),
                     'children' => array(array('title' => BOX_TAXES_COUNTRIES, 'link' => tep_href_link(FILENAME_COUNTRIES, 'selected_box=taxes'),
                                               'access' => tep_admin_check_boxes(FILENAME_COUNTRIES, 'sub_boxes')),
                                         array('title' => BOX_TAXES_GEO_ZONES, 'link' => tep_href_link(FILENAME_GEO_ZONES, 'selected_box=taxes'),
                                               'access' => tep_admin_check_boxes(FILENAME_GEO_ZONES, 'sub_boxes')))),
               array('title' => BOX_HEADING_CUSTOMERS,
                     'access' => tep_admin_check_boxes('customers.php'),
                     'image' => 'tick.gif',
                     'href' => tep_href_link(tep_selected_file('customers.php'), 'selected_box=customers'),
                     'children' => array(array('title' => BOX_CUSTOMERS_CUSTOMERS, 'link' => tep_href_link(FILENAME_CUSTOMERS, 'selected_box=customers'),
                                               'access' => tep_admin_check_boxes(FILENAME_CUSTOMERS, 'sub_boxes')),
                                         array('title' => BOX_CUSTOMERS_ORDERS, 'link' => tep_href_link(FILENAME_ORDERS, 'selected_box=customers'),
                                               'access' => tep_admin_check_boxes(FILENAME_ORDERS, 'sub_boxes')))),
               array('title' => BOX_HEADING_LOCALIZATION,
                     'access' => tep_admin_check_boxes('localization.php'),
                     'image' => 'tick.gif',
                     'href' => tep_href_link(tep_selected_file('localization.php'), 'selected_box=localization'),
                     'children' => array(array('title' => BOX_LOCALIZATION_CURRENCIES, 'link' => tep_href_link(FILENAME_CURRENCIES, 'selected_box=localization'),
                                               'access' => tep_admin_check_boxes(FILENAME_CURRENCIES, 'sub_boxes')),
                                         array('title' => BOX_LOCALIZATION_LANGUAGES, 'link' => tep_href_link(FILENAME_LANGUAGES, 'selected_box=localization'),
                                               'access' => tep_admin_check_boxes(FILENAME_LANGUAGES, 'sub_boxes')))),
               array('title' => BOX_HEADING_REPORTS,
                     'access' => tep_admin_check_boxes('reports.php'),
                     'image' => 'tick.gif',
                     'href' => tep_href_link(tep_selected_file('reports.php'), 'selected_box=reports'),
                     'children' => array(array('title' => REPORTS_PRODUCTS, 'link' => tep_href_link(FILENAME_STATS_PRODUCTS_PURCHASED, 'selected_box=reports'),
                                               'access' => tep_admin_check_boxes(FILENAME_STATS_PRODUCTS_PURCHASED, 'sub_boxes')),
                                         array('title' => REPORTS_ORDERS, 'link' => tep_href_link(FILENAME_STATS_CUSTOMERS, 'selected_box=reports'),
                                               'access' => tep_admin_check_boxes(FILENAME_STATS_CUSTOMERS, 'sub_boxes')))),
               array('title' => BOX_HEADING_TOOLS,
                     'access' => tep_admin_check_boxes('tools.php'),
                     'image' => 'tick.gif',
                     'href' => tep_href_link(tep_selected_file('tools.php'), 'selected_box=tools'),
                     'children' => array(array('title' => TOOLS_BACKUP, 'link' => tep_href_link(FILENAME_BACKUP, 'selected_box=tools'),
                                               'access' => tep_admin_check_boxes(FILENAME_BACKUP, 'sub_boxes')),
                                         array('title' => TOOLS_BANNERS, 'link' => tep_href_link(FILENAME_BANNER_MANAGER, 'selected_box=tools'),
                                               'access' => tep_admin_check_boxes(FILENAME_BANNER_MANAGER, 'sub_boxes')),
                                         array('title' => TOOLS_FILES, 'link' => tep_href_link(FILENAME_FILE_MANAGER, 'selected_box=tools'),
                                               'access' => tep_admin_check_boxes(FILENAME_FILE_MANAGER, 'sub_boxes')))));

  $languages = tep_get_languages();
  $languages_array = array();
  $languages_selected = DEFAULT_LANGUAGE;
  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
    $languages_array[] = array('id' => $languages[$i]['code'],
                               'text' => $languages[$i]['name']);
    if ($languages[$i]['directory'] == $language) {
      $languages_selected = $languages[$i]['code'];
    }
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<style type="text/css"><!--
a { color:#990000; text-decoration:none; }
a:hover { color:#aabbdd; text-decoration:underline; }
a.text:link, a.text:visited { color: #000000; text-decoration: none; }
a:text:hover { color: #000000; text-decoration: underline; }
a.main:link, a.main:visited { color: #ffffff; text-decoration: none; }
A.main:hover { color: #ffffff; text-decoration: underline; }
a.sub:link, a.sub:visited { color: #dddddd; text-decoration: none; }
A.sub:hover { color: #dddddd; text-decoration: underline; }
.heading { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; line-height: 1.5; color: #ffffff; }
.main { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; line-height: 1.5; color: #ffffff; }
.main_false { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; line-height: 1.5; color: #dddddd; }
.sub { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; line-height: 1.5; color: #ffffff; }
.sub_false { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; line-height: 1.5; color: #C1C1C1; }
.text { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; line-height: 1.5; color: #000000; }
.menuBoxHeading { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #ffffff; font-weight: bold; background-color: #FF9A00; border-color: #FF9A00; border-style: solid; border-width: 1px; }
.infoBox { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #990000; background-color: #ffffff; border-color: #FF9A00; border-style: solid; border-width: 1px; }
.smallText { font-family: Verdana, Arial, sans-serif; font-size: 10px; }
.boxText { font-family: Verdana, Arial, sans-serif; font-size: 10px; color: #616060;}
//--></style>
</head>
<body  style="background: #4e4e4e;">
<?php
?>
<table border="0" width="600" height="100%" cellspacing="0" cellpadding="0" align="center" valign="middle">
  <tr>
    <td><table border="0" width="600" height="440" cellspacing="0" cellpadding="1" align="center" valign="middle">
      <tr>
        <td><table border="0" width="600" height="440" cellspacing="0" cellpadding="0">
          <tr bgcolor="#666666">
            <td colspan="2"><table border="0" width="460" height="390" cellspacing="0" cellpadding="2">
              <tr>
                <td width="185" valign="top"><table border="0" width="185" height="390" cellspacing="0" cellpadding="2">
                  <tr>
                    <td valign="center">
<?php
  $heading = array();
  $contents = array();

  $heading[] = array('params' => 'class="menuBoxHeading"',
                     'text'  => 'Mysklep.pl');

  $contents[] = array('params' => 'class="infoBox"',
                      'text'  => '<a href="http://www.mysklep.pl" target="_blank">Strona wsparcia</a><br>' .
					  			 '<a href="http://www.mysklep.pl/help_centrum.php" target="_blank">Formularz Pomocy</a><br>');
  $box = new box;
  echo $box->menuBox($heading, $contents);

  echo '<br>';

  $orders_contents = '';
  $orders_status_query = tep_db_query("select orders_status_name, orders_status_id from " . TABLE_ORDERS_STATUS . " where language_id = '" . $languages_id . "'");
  while ($orders_status = tep_db_fetch_array($orders_status_query)) {
    $orders_pending_query = tep_db_query("select count(*) as count from " . TABLE_ORDERS . " where orders_status = '" . $orders_status['orders_status_id'] . "'");
    $orders_pending = tep_db_fetch_array($orders_pending_query);
    if (tep_admin_check_boxes(FILENAME_ORDERS, 'sub_boxes') == true) { 
      $orders_contents .= '<a href="' . tep_href_link(FILENAME_ORDERS, 'selected_box=customers&status=' . $orders_status['orders_status_id']) . '">' . $orders_status['orders_status_name'] . '</a>: ' . $orders_pending['count'] . '<br>';
    } else {
      $orders_contents .= '' . $orders_status['orders_status_name'] . ': ' . $orders_pending['count'] . '<br>';
    }
  }
  $orders_contents = substr($orders_contents, 0, -4);

  $heading = array();
  $contents = array();

  $heading[] = array('params' => 'class="menuBoxHeading"',
                     'text'  => BOX_TITLE_ORDERS);

  $contents[] = array('params' => 'class="infoBox"',
                      'text'  => $orders_contents);

  $box = new box;
  echo $box->menuBox($heading, $contents);

  echo '<br>';

  $customers_query = tep_db_query("select count(*) as count from " . TABLE_CUSTOMERS);
  $customers = tep_db_fetch_array($customers_query);
  $products_query = tep_db_query("select count(*) as count from " . TABLE_PRODUCTS);
  $products = tep_db_fetch_array($products_query);

  $reviews_query = tep_db_query("select count(*) as count from " . TABLE_REVIEWS);
  $reviews = tep_db_fetch_array($reviews_query);
  $products_in_query = tep_db_query("select count(*) as count from " . TABLE_PRODUCTS . " where products_status = '1'");
  $products_in = tep_db_fetch_array($products_in_query);
  $products_out_query = tep_db_query("select count(*) as count from " . TABLE_PRODUCTS . " where products_status = '0'");
  $products_out = tep_db_fetch_array($products_out_query);
  $products_tmp_query = tep_db_query("select count(*) as count from " . TABLE_PRODUCTS . " where products_status = '1' and products_quantity < '1'");
  $products_tmp = tep_db_fetch_array($products_tmp_query);

  $heading = array();
  $contents = array();

  $heading[] = array('params' => 'class="menuBoxHeading"',
                     'text'  => BOX_TITLE_STATISTICS);

  $contents[] = array('params' => 'class="infoBox"',
                      'text'  => BOX_ENTRY_CUSTOMERS . ' ' . $customers['count'] . '<br>' .
                                 BOX_ENTRY_REVIEWS . ' ' . $reviews['count'] . '<br>' .
                                 BOX_ENTRY_PRODUCTS . ' ' . $products['count'] . '<br>' .
                                 BOX_ENTRY_PRODUCTS_IN . ' ' . $products_in['count'] . '<br>' .
                                 BOX_ENTRY_PRODUCTS_OUT. ' ' . $products_out['count']);

  $box = new box;
  echo $box->menuBox($heading, $contents);

  echo '<br>';

  $contents = array();

  if (getenv('HTTPS') == 'on') {
    $size = ((getenv('SSL_CIPHER_ALGKEYSIZE')) ? getenv('SSL_CIPHER_ALGKEYSIZE') . '-bit' : '<i>' . BOX_CONNECTION_UNKNOWN . '</i>');
    $contents[] = array('params' => 'class="infoBox"',
                        'text' => tep_image(DIR_WS_ICONS . 'locked.gif', ICON_LOCKED, '', '', 'align="right"') . sprintf(BOX_CONNECTION_PROTECTED, $size));
  } else {
    $contents[] = array('params' => 'class="infoBox"',
                        'text' => tep_image(DIR_WS_ICONS . 'unlocked.gif', ICON_UNLOCKED, '', '', 'align="right"') . BOX_CONNECTION_UNPROTECTED);
  }

  $box = new box;
  echo $box->tableBlock($contents);
?>
                    </td>
                  </tr>
                </table></td>
                      <td width="460" align="right" valign="center">
<table border="0" width="445" height="375" cellspacing="1" cellpadding="1">
                          <tr>
                    <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                      <tr><?php echo tep_draw_form('languages', 'index.php', '', 'get'); ?>
                        <td class="heading"><?php echo HEADING_TITLE; ?></td>
                        <td align="right"><?php echo tep_draw_pull_down_menu('language', $languages_array, $languages_selected, 'onChange="this.form.submit();"'); ?></td>
                      <?php echo tep_hide_session_id(); ?></form></tr>
                    </table></td>
                  </tr>
<?php
  $col = 2;
  $counter = 0;
  for ($i = 0, $n = sizeof($cat); $i < $n; $i++) {
    if ($cat[$i]['access'] == true) {
    $counter++;
    if ($counter < $col) {
      echo '                  <tr>' . "\n";
    }

    echo '                    <td><table border="0" cellspacing="0" cellpadding="2">' . "\n" .
         '                      <tr>' . "\n" .
         '                        <td><a href="' . $cat[$i]['href'] . '">' . tep_image(DIR_WS_IMAGES . 'categories/' . $cat[$i]['image'], $cat[$i]['title'], '34', '34') . '</a></td>' . "\n" .
         '                        <td><table border="0" cellspacing="0" cellpadding="1">' . "\n" .
         '                          <tr>' . "\n" .
         '                            <td class="main"><a href="' . $cat[$i]['href'] . '" class="main">' . $cat[$i]['title'] . '</a></td>' . "\n" .
         '                          </tr>' . "\n" .
         '                          <tr>' . "\n" .
         '                            <td class="sub_false">';

    $children = '';
    for ($j = 0, $k = sizeof($cat[$i]['children']); $j < $k; $j++) {
      if ($cat[$i]['children'][$j]['access'] == true) {
        $children .= '<a href="' . $cat[$i]['children'][$j]['link'] . '" class="sub">' . $cat[$i]['children'][$j]['title'] . '</a>, ';
      } else {
        $children .= '' . $cat[$i]['children'][$j]['title'] . ', ';
      }
    }
    echo substr($children, 0, -2);

    echo '</td> ' . "\n" .
         '                          </tr>' . "\n" .
         '                        </table></td>' . "\n" .
         '                      </tr>' . "\n" .
         '                    </table></td>' . "\n";

    if ($counter >= $col) {
      echo '                  </tr>' . "\n";
      $counter = 0;
    }
    } elseif ($cat[$i]['access'] == false) {
    $counter++;
    if ($counter < $col) {
      echo '                  <tr>' . "\n";
    }

    echo '                    <td><table border="0" cellspacing="0" cellpadding="2">' . "\n" .
         '                      <tr>' . "\n" .
         '                        <td>' . tep_image(DIR_WS_IMAGES . 'categories/' . $cat[$i]['image'], $cat[$i]['title'], '34', '34') . '</td>' . "\n" .
         '                        <td><table border="0" cellspacing="0" cellpadding="1">' . "\n" .
         '                          <tr>' . "\n" .
         '                            <td class="main_false">' . $cat[$i]['title'] . '</td>' . "\n" .
         '                          </tr>' . "\n" .
         '                          <tr>' . "\n" .
         '                            <td class="sub_false">';

    $children = '';
    for ($j = 0, $k = sizeof($cat[$i]['children']); $j < $k; $j++) {
      $children .= '' . $cat[$i]['children'][$j]['title'] . ', ';
    }
    echo substr($children, 0, -2);
    echo '</td> ' . "\n" .
         '                          </tr>' . "\n" .
         '                        </table></td>' . "\n" .
         '                      </tr>' . "\n" .
         '                    </table></td>' . "\n";

    if ($counter >= $col) {
      echo '                  </tr>' . "\n";
      $counter = 0;
    }
    }    
  }
?>
                </table>
                      </td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php require(DIR_WS_INCLUDES . 'footer.php'); ?></td>
      </tr>
    </table></td>
  </tr>
</table>

</body>

</html>