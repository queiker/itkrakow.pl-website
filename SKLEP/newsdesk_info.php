<?php
require('includes/functions/newsdesk_general.php');
require('includes/application_top.php');
require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_NEWSDESK_INFO);

// set application wide parameters
// this query set is for NewsDesk

$configuration_query = tep_db_query("select configuration_key as cfgKey, configuration_value as cfgValue from " . TABLE_NEWSDESK_CONFIGURATION . "");
while ($configuration = tep_db_fetch_array($configuration_query)) {
	define($configuration['cfgKey'], $configuration['cfgValue']);
}

// lets retrieve all $HTTP_GET_VARS keys and values..
$get_params = tep_get_all_get_params();
$get_params_back = tep_get_all_get_params(array('reviews_id')); // for back button
$get_params = substr($get_params, 0, -1); //remove trailing &
if ($get_params_back != '') {
    $get_params_back = substr($get_params_back, 0, -1); //remove trailing &
} else {
    $get_params_back = $get_params;
}

// BOF Wolfen added code to retrieve backpath
$get_backpath = tep_get_all_get_params();
$get_backpath_back = tep_get_all_get_params(array('newdesk_id')); // for back button
$get_backpath = substr($get_backpath, 0, -15); //remove trailing &
if ($get_backpath_back != '') {
    $get_backpath_back = substr($get_backpath_back, 0, -15); //remove trailing &
} else {
    $get_backpath_back = $get_backpath;
}
// EOF Wolfen added code to retrieve backpath

// BOF Added by Wolfen
// calculate category path
if ($HTTP_GET_VARS['newsPath']) {
$newsPath = tep_db_prepare_input($HTTP_GET_VARS['newsPath']);
} elseif ($HTTP_GET_VARS['newsdesk_id'] && !$HTTP_GET_VARS['newsPath']) {
$newsPath = newsdesk_get_product_path((int)$HTTP_GET_VARS['newsdesk_id']);
} else {
$newsPath = '';
}

if (strlen($newsPath) > 0) {
$newsPath_array = newsdesk_parse_category_path($newsPath);
$newsPath = implode('_', $newsPath_array);
$current_category_id = $newsPath_array[(sizeof($newsPath_array)-1)];
} else {
$current_category_id = 0;
}

if (isset($newsPath_array)) {
$n = sizeof($newsPath_array);
for ($i = 0; $i < $n; $i++) {

$categories_query = tep_db_query(

"select categories_name from " . TABLE_NEWSDESK_CATEGORIES_DESCRIPTION . " where categories_id = '" . (int)$newsPath_array[$i] 

. "' and language_id='" . $languages_id . "'"

);

if (tep_db_num_rows($categories_query) > 0) {

$categories = tep_db_fetch_array($categories_query);

$breadcrumb->add($categories['categories_name'], tep_href_link(FILENAME_NEWSDESK_INDEX, 'newsPath=' 

. implode('_', array_slice($newsPath_array, 0, ($i+1)))));

} else {

break;

}

}

} 


if ($HTTP_GET_VARS['newsdesk_id']) {
$model_query = tep_db_query("select newsdesk_article_name from " . TABLE_NEWSDESK_DESCRIPTION . " where newsdesk_id = '" . (int)$HTTP_GET_VARS['newsdesk_id'] . "'");

$model = tep_db_fetch_array($model_query);
$breadcrumb->add($model['newsdesk_article_name'], tep_href_link(FILENAME_NEWSDESK_INFO, 'newsPath=' . $newsPath . '&newsdesk_id=' 
. (int)$HTTP_GET_VARS['newsdesk_id']));

}
// EOF Added by Wolfen

?>

<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<base href="<?php echo (getenv('HTTPS') == 'on' ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_TEMPLATES . $template . $language . '/stylesheet.css';?>">
</head>
<body>
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<? include('includes/body.php'); ?>

    <td width="100%" valign="top">
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php
			$info_box_contents = array();
			$info_box_contents[] = array('text' => TEXT_NEWSDESK_HEADING);
			new infoBoxHeading($info_box_contents, true, true);
	  ?></td>
      </tr>
	</table>

	<table border="0" width="100%" cellspacing="0" cellpadding="0" class="blrb">
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
	  <tr>
		<td>
<?php
$product_info = tep_db_query("
select p.newsdesk_id, pd.newsdesk_article_name, pd.newsdesk_article_description, pd.newsdesk_article_shorttext, 
p.newsdesk_image, p.newsdesk_image_two, p.newsdesk_image_three, pd.newsdesk_article_url, pd.newsdesk_article_url_name, pd.newsdesk_article_viewed, p.newsdesk_date_added, 
p.newsdesk_date_available 
from " . TABLE_NEWSDESK . " p, " . TABLE_NEWSDESK_DESCRIPTION . " pd where p.newsdesk_id = '" . (int)$HTTP_GET_VARS['newsdesk_id'] . "' 
and pd.newsdesk_id = '" . (int)$HTTP_GET_VARS['newsdesk_id'] . "' and pd.language_id = '" . (int)$languages_id . "'");

if (!tep_db_num_rows($product_info)) { // product not found in database
?>

<table border="0" width="100%" cellspacing="3" cellpadding="3">
	<tr>
		<td class="main"><br><?php echo TEXT_NEWS_NOT_FOUND; ?></td>
	</tr>
	<tr>
		<td align="right">
			<br>
<a href="<?php echo tep_href_link(FILENAME_DEFAULT, '', 'NONSSL'); ?>"><?php echo tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></a>
		</td>
	</tr>
</table>

<?php
} else {
	tep_db_query("update " . TABLE_NEWSDESK_DESCRIPTION . " set newsdesk_article_viewed = newsdesk_article_viewed+1 where newsdesk_id = '" . (int)$HTTP_GET_VARS['newsdesk_id'] . "' and language_id = '" . (int)$languages_id . "'");
	$product_info_values = tep_db_fetch_array($product_info);
	$insert_image3 = $insert_image2 = $insert_image1 = '';
	if ($product_info_values['newsdesk_image'] != 'Array') {
		if (($product_info_values['newsdesk_image'] != '') && is_file(DIR_WS_IMAGES.$product_info_values['newsdesk_image'])) {
			$insert_image1 = ''. tep_image_midi(DIR_WS_IMAGES . $product_info_values['newsdesk_image'], $product_info_values['newsdesk_article_name'], '150', '250'). '';
		}
	}

	if ($product_info_values['newsdesk_image_two'] != 'Array') {
		if (($product_info_values['newsdesk_image_two'] != '') && is_file(DIR_WS_IMAGES.$product_info_values['newsdesk_image_two'])) {
			$insert_image2 = ''. tep_image_midi(DIR_WS_IMAGES . $product_info_values['newsdesk_image_two'], $product_info_values['newsdesk_article_name'], '150', '250'). '';
		}
	}

	if ($product_info_values['newsdesk_image_three'] != 'Array') {
		if (($product_info_values['newsdesk_image_three'] != '') && is_file(DIR_WS_IMAGES.$product_info_values['newsdesk_image_three'])) {
			$insert_image3 = ''. tep_image_midi(DIR_WS_IMAGES . $product_info_values['newsdesk_image_three'], $product_info_values['newsdesk_article_name'], '150', '250'). '';
		}
	}
?>


<table border="0" width="100%" cellspacing="0" cellpadding="3">
	<tr>
		<td class="main"><B><?php echo $product_info_values['newsdesk_article_name']; ?></B></td>
		<td class="miniText" align="right">&nbsp;
			<?php echo sprintf(TEXT_NEWSDESK_DATE, tep_date_long($product_info_values['newsdesk_date_added']));; ?>
		</td>
	</tr>
</table>

<table border="0" width="100%" cellspacing="3" cellpadding="0">
	<tr>
		<td width="100%" class="main" valign="top"><table width="100%"><tr><td class="main" valign="top">
<?php 
	if(DISPLAY_NEWSDESK_SUMMARY == 1) {
		echo stripslashes($product_info_values['newsdesk_article_shorttext']).'<br><br>'; 
	}

	echo stripslashes($product_info_values['newsdesk_article_description']).'<br>'; 

##	if ($product_info_values['newsdesk_article_url']) {

echo '</td>';


if(tep_not_null($insert_image1) || tep_not_null($insert_image2) || tep_not_null($insert_image3)) {
	echo '<td width="150" valign="top" align="center"><div style="padding: 5 5 5 5;">'.$insert_image1.$insert_image2.$insert_image3.'</div></td>';
}

?>

</tr></table>
<?php 
	if(tep_not_null($product_info_values['newsdesk_article_url_name'])) {
?>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td class="main">
<?php $newslink = ($product_info_values['newsdesk_article_url_name']); ?>
<?php echo sprintf(TEXT_NEWSDESK_LINK . '<a href="%s" target="_blank"><u>' . $newslink . '</u></a>.', $product_info_values['newsdesk_article_url']); ?>
		</td>
	</tr>
</table>
<?php
	}
##} 
?>

<?php
$reviews = tep_db_query("select count(*) as count from " . TABLE_NEWSDESK_REVIEWS . " where approved='1' and newsdesk_id = '" . (int)$HTTP_GET_VARS['newsdesk_id'] . "'");
$reviews_values = tep_db_fetch_array($reviews);
?>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<?php
if ( DISPLAY_NEWSDESK_VIEWCOUNT ) {
?>
	<tr>
		<td class="main"><?php echo TEXT_NEWSDESK_VIEWED . $product_info_values['newsdesk_article_viewed'] ?></td>
	</tr>
<?php
}
?>
<?php
if ( DISPLAY_NEWSDESK_REVIEWS ) {
?>
	<tr>
		<td class="main"><?php echo TEXT_NEWSDESK_REVIEWS . ' ' . $reviews_values['count']; ?></td>
	</tr>
<?php
}
?>
</table>

		</td>
	</tr>
</table>

<?php
if ( DISPLAY_NEWSDESK_REVIEWS ) {
	if ($reviews_values['count'] > 0) {
?>
	<tr>
		<td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
	</tr>
<?php
		require FILENAME_NEWSDESK_ARTICLE_REQUIRE;
	}
}
?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">

<?php 
if ( DISPLAY_NEWSDESK_REVIEWS ) {
?>
	<tr>
		<td colspan="3"><?php echo tep_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
	</tr>
	<tr>
		<td class="main">
<?php
	echo '<a href="' . tep_href_link(FILENAME_NEWSDESK_REVIEWS_WRITE, $get_params, 'NONSSL') . '">' . tep_image_button('button_write_review.gif',
	IMAGE_BUTTON_WRITE_REVIEW) . '</a>';
?>
		</td>
<?php
}
?>

		<td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>

<?php
// BOF Wolfen added code for button case
if ($get_backpath_back = $get_backpath) {
echo '<td align="right" class="main"><a href="' . tep_href_link(FILENAME_NEWSDESK_INDEX, $get_backpath) . '">' . tep_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>' . tep_draw_separator('pixel_trans.gif', '10', '1') . '<a href="' . tep_href_link(FILENAME_DEFAULT, '', 'NONSSL') . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a></td>';
} else { 
echo '<td align="right" class="main"><a href="' . tep_href_link(FILENAME_DEFAULT, '', 'NONSSL') . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a></td>';
}
// EOF Wolfen added code for button case
?>		

		<td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
	</tr>
</table>

		</td>
	</tr>
</table>

<?php } ?>
    </td>
<!-- body_text_eof //-->
<? include('includes/footer_0.php'); ?>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>