<table border="0" width="100%" cellspacing="0" cellpadding="2">

<?php
$listing_numrows_sql = $listing_sql;
//$listing_split = new splitPageResults($listing_sql, $HTTP_GET_VARS['page'], MAX_DISPLAY_NEWSDESK_SEARCH_RESULTS, 'p.newsdesk_id');
// $listing_split = new splitPageResults($listing_sql, MAX_DISPLAY_NEWSDESK_SEARCH_RESULTS, '*', $HTTP_GET_VARS['page']);
$listing_split = new splitPageResults($listing_sql, MAX_DISPLAY_NEWSDESK_SEARCH_RESULTS, 'p.newsdesk_id');
// fix counted products
$listing_numrows = tep_db_query($listing_numrows_sql);
$listing_numrows = tep_db_num_rows($listing_numrows);

?>

	<tr>
		<td>

<?php
$list_box_contents = array();

	 $newsy = array();

if ($listing_numrows > 0) {
	$number_of_products = '0';
	$listing_query = tep_db_query($listing_split->sql_query);
	while ($newsdesk_var = tep_db_fetch_array($listing_query)) {


		if ( DISPLAY_NEWSDESK_IMAGE ) {
			if ($newsdesk_var['newsdesk_image'] != '') {
				$insert_image = '<a href="' . tep_href_link(FILENAME_NEWSDESK_INFO, 'newsdesk_id=' . $newsdesk_var['newsdesk_id']) . '">' . tep_image_mini(DIR_WS_IMAGES . $newsdesk_var['newsdesk_image'], $newsdesk_var['newsdesk_article_name'], 90,90) . '</a>';
			}
		}

		if ( DISPLAY_NEWSDESK_DATE ) {
//			$insert_date = tep_date_short($newsdesk_var['newsdesk_date_added']);
			$insert_date = explode(' ',$newsdesk_var['newsdesk_date_added']);
			$insert_date = $insert_date[0];
		}

		if ( DISPLAY_NEWSDESK_HEADLINE ) {
			$insert_headline = '<a href="' . tep_href_link(FILENAME_NEWSDESK_INFO, 'newsdesk_id=' . $newsdesk_var['newsdesk_id']) . '"><b>' . $newsdesk_var['newsdesk_article_name'] . '</b></a>';
		}

//		if ( DISPLAY_NEWSDESK_SUMMARY ) {
			$insert_summary = osc_trunc_string(strip_tags($newsdesk_var['newsdesk_article_shorttext']),320);
//		}

		if ( DISPLAY_NEWSDESK_READMORE ) {
			$insert_readmore = '<div class="hright"><a class="more" href="' . tep_href_link(FILENAME_NEWSDESK_INFO, 'newsdesk_id=' . $newsdesk_var['newsdesk_id']) . '">' . TEXT_NEWSDESK_READMORE . '</a></div>';
		}


		$text .= "\n\n".'<table width="100%" border="0" class="tNewsy" cellspacing="5" cellpadding="0"><tr><td class="headline" colspan="2"><div class="fleft">'.$insert_headline.'</div><div class="fright">'.$insert_date.'</div></td></tr><tr><td width="100" align="center" valign="top">'.$insert_image.'</td><td valign="top" class="hjust">'.$insert_summary.$insert_readmore.'</td></tr></table><br>';

		$info_box_contents[$row] = array(
			'align' => 'left',
			'params' => 'class="smallText" valign="top"',
			'text' => $text);
		$row++;
	}

	echo $text;


	echo '</td>' . "\n";
	echo '</tr>' . "\n";
	} else {
?>

	<tr>
		<td class="smallText"><br>&nbsp;<?php echo TEXT_NO_ARTICLES ?>&nbsp;<br><br></td>
	</tr>

<?php
}
?>


</table>