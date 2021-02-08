<!-- newsdesk //-->
<?php

// set application wide parameters
// this query set is for NewsDesk

$configuration_query = tep_db_query("select configuration_key as cfgKey, configuration_value as cfgValue from " . TABLE_NEWSDESK_CONFIGURATION . "");
while ($configuration = tep_db_fetch_array($configuration_query)) {
	define($configuration['cfgKey'], $configuration['cfgValue']);
}

$newsdesk_var_query = tep_db_query('select p.newsdesk_id, pd.language_id, pd.newsdesk_article_name, pd.newsdesk_article_description, pd.newsdesk_article_shorttext, pd.newsdesk_article_url, pd.newsdesk_article_url_name, 
 p.newsdesk_image, p.newsdesk_image_two, p.newsdesk_image_three, p.newsdesk_date_added, p.newsdesk_last_modified, pd.newsdesk_article_viewed, 
 p.newsdesk_date_available, p.newsdesk_status  from ' . TABLE_NEWSDESK . ' p, ' . TABLE_NEWSDESK_DESCRIPTION . ' 
 pd WHERE pd.newsdesk_id = p.newsdesk_id and pd.language_id = "' . $languages_id . '" and newsdesk_status = 1 and p.newsdesk_sticky = 0 ORDER BY newsdesk_date_added DESC LIMIT ' . MAX_DISPLAY_NEWSDESK_NEWS);

if (!tep_db_num_rows($newsdesk_var_query)) { // there is no news
	echo '<!-- ' . TEXT_NO_NEWSDESK_NEWS . ' -->';

} else {

echo '
		<tr><td class="sep"></td></tr>
		<tr>
			<td>
';

	$info_box_contents = array();
	$info_box_contents[] = array('align' => 'left',
                                 'text'  => TABLE_HEADING_NEWSDESK);

	if(tep_not_null($naglowek)) {
		echo '<div class="container"><div id="bh'.$naglowek.'">';
		echo '</div>';
		echo '<div class="bhd">'.$dodatek.'</div></div>';

	} else {
		new infoBoxHeading($info_box_contents, false, false, false, 'nh.png');
	}


	$info_box_contents = array();
	$row = 0;
	while ($newsdesk_var = tep_db_fetch_array($newsdesk_var_query)) {


		if ( DISPLAY_NEWSDESK_IMAGE ) {
			if ($newsdesk_var['newsdesk_image'] != '') {
				$insert_image = '<a href="' . tep_href_link(FILENAME_NEWSDESK_INFO, 'newsdesk_id=' . $newsdesk_var['newsdesk_id']) . '">' . tep_image_mini(DIR_WS_IMAGES . $newsdesk_var['newsdesk_image'], '', 150,150) . '</a>';
			}
		}

		if ( DISPLAY_NEWSDESK_DATE ) {
			$insert_date = tep_date_short($newsdesk_var['newsdesk_date_added']);
		}

		if ( DISPLAY_NEWSDESK_HEADLINE ) {
			$insert_headline = '<a href="' . tep_href_link(FILENAME_NEWSDESK_INFO, 'newsdesk_id=' . $newsdesk_var['newsdesk_id']) . '" class="miniText"><b>' . $newsdesk_var['newsdesk_article_name'] . '</b></a>';
		}

		if ( DISPLAY_NEWSDESK_SUMMARY ) {
			$insert_summary = $newsdesk_var['newsdesk_article_shorttext'];
		}

		if ( DISPLAY_NEWSDESK_READMORE ) {
			$insert_readmore = '<br><br><a class="more" href="' . tep_href_link(FILENAME_NEWSDESK_INFO, 'newsdesk_id=' . $newsdesk_var['newsdesk_id']) . '">' . TEXT_NEWSDESK_READMORE . '</a> &nbsp; </div>';
		}

//		$text = '<table width="100%" class="tNewsy" cellspacing="10" cellpadding="4"><tr><td class="headline" colspan="2">'.$insert_date .' &nbsp; &nbsp; &nbsp; '.$insert_headline.'</td></tr><tr><td width="5" valign="top">'.$insert_image.'</td><td valign="top">'.$insert_summary.$insert_readmore.'</td></tr></table>';
		$text = '<table width="100%" class="tNewsy" cellspacing="2" cellpadding="4"><tr><td width="100">'.tep_image_t('gfx/arrow_or.gif').' &nbsp; <i>'.$insert_date .'</i> </td><td>'.$insert_headline.'</td></tr></table>';

		$info_box_contents[$row] = array(
			'align' => 'left',
			'params' => 'class="smallText" valign="top"',
			'text' => $text);
		$insert_image = '';
		$insert_image_two = '';
		$insert_image_three = '';
		$row++;
	}

	if(tep_db_num_rows($newsdesk_var_query) >= MAX_DISPLAY_NEWSDESK_NEWS) {
		$info_box_contents[$row] = array(
			'align' => 'left',
			'params' => 'class="smallText" valign="top"',
			'text' => '<p class="tNewsy tNewsyAll"><a href="'.tep_href_link(FILENAME_NEWSDESK_INDEX,'newsPath=1').'">Zobacz wszystkie</a></p>');
	
	}

	new infoBox($info_box_contents);

	echo '
			</td>
		</tr>
';
}
?>
<!-- newsdesk_eof //-->
