<?php
/*
  $Id: banner.php,v 1.12 2003/06/20 00:12:59 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

////
// Sets the status of a banner
  function tep_set_banner_status($banners_id, $status) {
    if ($status == '1') {
      return tep_db_query("update " . TABLE_BANNERS . " set status = '1', date_status_change = now(), date_scheduled = NULL where banners_id = '" . (int)$banners_id . "'");
    } elseif ($status == '0') {
      return tep_db_query("update " . TABLE_BANNERS . " set status = '0', date_status_change = now() where banners_id = '" . (int)$banners_id . "'");
    } else {
      return -1;
    }
  }

////
// Auto activate banners
  function tep_activate_banners() {
    $banners_query = tep_db_query("select banners_id, date_scheduled from " . TABLE_BANNERS . " where date_scheduled != ''");
    if (tep_db_num_rows($banners_query)) {
      while ($banners = tep_db_fetch_array($banners_query)) {
        if (date('Y-m-d H:i:s') >= $banners['date_scheduled']) {
          tep_set_banner_status($banners['banners_id'], '1');
        }
      }
    }
  }

////
// Auto expire banners
  function tep_expire_banners() {
    $banners_query = tep_db_query("select b.banners_id, b.expires_date, b.expires_impressions, sum(bh.banners_shown) as banners_shown from " . TABLE_BANNERS . " b, " . TABLE_BANNERS_HISTORY . " bh where b.status = '1' and b.banners_id = bh.banners_id group by b.banners_id");
    if (tep_db_num_rows($banners_query)) {
      while ($banners = tep_db_fetch_array($banners_query)) {
        if (tep_not_null($banners['expires_date'])) {
          if (date('Y-m-d H:i:s') >= $banners['expires_date']) {
            tep_set_banner_status($banners['banners_id'], '0');
          }
        } elseif (tep_not_null($banners['expires_impressions'])) {
          if ( ($banners['expires_impressions'] > 0) && ($banners['banners_shown'] >= $banners['expires_impressions']) ) {
            tep_set_banner_status($banners['banners_id'], '0');
          }
        }
      }
    }
  }

////
// Display a banner from the specified group or banner id ($identifier)
  function tep_display_banner($action, $identifier, $target='_blank', $link='') {
    if ($action == 'dynamic') {
      $banners_query = tep_db_query("select count(*) as count from " . TABLE_BANNERS . " where status = '1' and banners_group = '" . $identifier . "'");
      $banners = tep_db_fetch_array($banners_query);
      if ($banners['count'] > 0) {
        $banner = tep_random_select("select banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where status = '1' and banners_group = '" . $identifier . "'");
      } else {
        return '<b>TEP ERROR! (tep_display_banner(' . $action . ', ' . $identifier . ') -> No banners with group \'' . $identifier . '\' found!</b>';
      }
    } elseif ($action == 'static') {
      if (is_array($identifier)) {
        $banner = $identifier;
      } else {
        $banner_query = tep_db_query("select banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where status = '1' and banners_id = '" . (int)$identifier . "'");
        if (tep_db_num_rows($banner_query)) {
          $banner = tep_db_fetch_array($banner_query);
        } else {
          return '<b>TEP ERROR! (tep_display_banner(' . $action . ', ' . $identifier . ') -> Banner with ID \'' . $identifier . '\' not found, or status inactive</b>';
        }
      }
    } else {
      return '<b>TEP ERROR! (tep_display_banner(' . $action . ', ' . $identifier . ') -> Unknown $action parameter value - it must be either \'dynamic\' or \'static\'</b>';
    }

    if (tep_not_null($banner['banners_html_text'])) {
      $banner_string = $banner['banners_html_text'];
    } else {
	  if(tep_not_null($link)) {
	      $banner_string = '<a href="' . tep_href_link(FILENAME_REDIRECT, 'action=show&goto=' . $banner['banners_id']) . '" target="'.$target.'">' . tep_image(DIR_WS_IMAGES . $banner['banners_image'], $banner['banners_title']) . '</a>';
	  } else {
	      $banner_string = '<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . '" target="'.$target.'">' . tep_image(DIR_WS_IMAGES . $banner['banners_image'], $banner['banners_title']) . '</a>';
	  }
    }

    tep_update_banner_display_count($banner['banners_id']);

    return $banner_string;
  }

////
// Check to see if a banner exists
  function tep_banner_exists($action, $identifier) {
    if ($action == 'dynamic') {
      return tep_random_select("select banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where status = '1' and banners_group = '" . $identifier . "'");
    } elseif ($action == 'static') {
      $banner_query = tep_db_query("select banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where status = '1' and banners_id = '" . (int)$identifier . "'");
      return tep_db_fetch_array($banner_query);
    } else {
      return false;
    }
  }

////
// Update the banner display statistics
  function tep_update_banner_display_count($banner_id) {
    $banner_check_query = tep_db_query("select count(*) as count from " . TABLE_BANNERS_HISTORY . " where banners_id = '" . (int)$banner_id . "' and date_format(banners_history_date, '%Y%m%d') = date_format(now(), '%Y%m%d')");
    $banner_check = tep_db_fetch_array($banner_check_query);

    if ($banner_check['count'] > 0) {
      tep_db_query("update " . TABLE_BANNERS_HISTORY . " set banners_shown = banners_shown + 1 where banners_id = '" . (int)$banner_id . "' and date_format(banners_history_date, '%Y%m%d') = date_format(now(), '%Y%m%d')");
    } else {
      tep_db_query("insert into " . TABLE_BANNERS_HISTORY . " (banners_id, banners_shown, banners_history_date) values ('" . (int)$banner_id . "', 1, now())");
    }
  }

////
// Update the banner click statistics
  function tep_update_banner_click_count($banner_id) {
    tep_db_query("update " . TABLE_BANNERS_HISTORY . " set banners_clicked = banners_clicked + 1 where banners_id = '" . (int)$banner_id . "' and date_format(banners_history_date, '%Y%m%d') = date_format(now(), '%Y%m%d')");
  }

//// osC Pro 1.1
// Automatyczne pobieranie nazw grup
function add_banners_group($baner_group){ 
 if(!$baner_group) {
	$i=0;
	$banners_query = tep_db_query("select * from " . TABLE_BANNERS . " where status = '1'"); 
	while($wiersz=mysql_fetch_array ($banners_query)) { 
	  $banners_group[$i]=$wiersz["banners_group"];
	  $i++;
	}
    while($i>0){
		if ($banner = tep_banner_exists('dynamic', $banners_group[rand(0,$i-1)])) { 
			echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">"; 
			echo "<tr><td align=\"center\">"; 
			echo tep_display_banner('static', $banner,'_blank','true'); 
			echo "</td></tr></table>"; 
			$i=-1;
		} 
    }	 
 } else {
	if ($banner = tep_banner_exists('dynamic', $baner_group)) { 
	echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">"; 
	echo "<tr><td align=\"center\">"; 
	echo tep_display_banner('static', $banner,'_blank','true'); 
	echo "</td></tr></table>"; 
	} 
 }
}

// banery dla strony glownej
function add_banners_naglowek($baner_group,$target='_self'){ 
 if(!$baner_group) {
	$i=0;
	$banners_query = tep_db_query("select * from " . TABLE_BANNERS . " where status = '1'"); 
	while($wiersz=mysql_fetch_array ($banners_query)) { 
	  $banners_group[$i]=$wiersz["banners_group"];
	  $i++;
	}
    while($i>0){
		if ($banner = tep_banner_exists('dynamic', $banners_group[rand(0,$i-1)])) { 
			echo '<div style="text-align: center; width: 100%">'; 
			echo tep_display_banner('static', $banner, $target); 
			echo '</div>';
			$i=-1;
		} 
    }	 
 } else {
	if ($banner = tep_banner_exists('dynamic', $baner_group)) { 
		echo '<div style="text-align: center; width: 100%">'; 
		echo tep_display_banner('static', $banner, $target); 
		echo '</div>'; 
	} 
 }
}
?>