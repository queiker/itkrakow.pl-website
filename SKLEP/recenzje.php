<?php

define('MAX_REVIEWS_IN_PRODUCT_INFO_FULL',20);
		  $reviews_query = tep_db_query("select count(*) as count from " . TABLE_REVIEWS . " where products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "'");
		  $reviews = tep_db_fetch_array($reviews_query);
		  $reviews_query_average = tep_db_query("select (avg(reviews_rating)) as average_rating from " . TABLE_REVIEWS . " where products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "'");
		  $reviews_average = tep_db_fetch_array($reviews_query_average);
		  $reveiws_stars = $reviews_average['average_rating'];
		  $reveiws_rating = number_format($reveiws_stars,0);
?>
<table width="100%" cellspacing="0" cellpadding="0">
<?php
if (MAX_REVIEWS_IN_PRODUCT_INFO_FULL > 0) {
  $reviews_query = tep_db_query("select r.reviews_id, rd.reviews_text, r.reviews_rating, r.date_added, r.customers_name, r.approved from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd where r.approved = '1' AND r.products_id = '" . $HTTP_GET_VARS['products_id'] . "' and rd.reviews_id = r.reviews_id and rd.languages_id = '" . (int)$languages_id . "' order by r.reviews_id DESC");
  $num_rows = tep_db_num_rows($reviews_query);

  if ($num_rows > 0) {
    $row = 0;

	   if ($reviews['count'] > 0) {
?>
      <tr>
      	<td class="smallText">
      	<table width="100%">
				<tr>
					<td class="main" valign="top" style="font-size:11px;"><b><?php echo BOX_HEADING_REVIEWS_CUSTOMERS; ?></b></td>
					<td align="right" class="smallText"><FONT COLOR="#4e4e4e"><?php echo TEXT_REVIEW_AVERAGE . ': ' . tep_image_t('stars_' . $reveiws_rating . '.gif', '', 'style="vertical-align: middle;"') . ''; ?></font></td>
				</tr>
			</table>
			</td>
		</tr>
<?php
	   } else {
?>
      <tr>
        <td class="smallText"><FONT COLOR="#4e4e4e"><?php echo sprintf(TEXT_DISPLAY_NUMBER_OF_REVIEWS_PRODUCT_INFO, $row, $num_rows); ?></font></td>
      </tr>
<?php
	   }

    while (($reviews_values = tep_db_fetch_array($reviews_query)) && ($row < MAX_REVIEWS_IN_PRODUCT_INFO_FULL)) {
      $row++;
      $date_added = tep_date_short($reviews_values['date_added']);
		// Write product reviews
?>
<?php
// END PopTheTop Product Info Reviews
?>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
      	<td>
			<table border="0" width="90%" cellspacing="1" cellpadding="2" class="infoBoxG" align="center">
				<tr class="infoBoxContentsG">
					<td>
					<table border="0" width="100%" cellspacing="0" cellpadding="2">
						<tr>
							<td valign="top" class="smallText" align="justify"><?php
//htmlspecialchars(	
echo '<FONT COLOR="#4e4e4e"><b>Napisano:</b>  <span class="smallText">' . $date_added . '</span></font><br>' . nl2br(strip_tags($reviews_values['reviews_text'])) . '<br><br>' . sprintf(tep_image_t('stars_' . $reviews_values['reviews_rating'] . '.gif', sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, $reviews_values['reviews_rating']))) ?></td>
						</tr>
					</table>
					</td>
				</tr>
			</table>
			</td>
      </tr>
<?php
    } // END while (($reviews_values...
?>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '15'); ?></td>
      </tr>
	  <?php
	  if($row != $num_rows) {
	  ?>
	  <tr>
		<td align="right" class="smallText"><span style="color: #4e4e4e"><?php echo sprintf(TEXT_DISPLAY_NUMBER_OF_REVIEWS_PRODUCT_INFO, $row, $num_rows); ?></span></td>
	  </tr>
	  <?php 
	  }
	  ?>
      <tr>
        <td>
        <table border="0" width="100%" cellspacing="1" cellpadding="2" >
	        <tr>
	        		<td>
	        		<table border="0" width="100%" cellspacing="0" cellpadding="2">
						<tr>
							<td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
							<TD ALIGN="left" VALIGN="middle" CLASS="main">
<?php
    if ($num_rows > MAX_REVIEWS_IN_PRODUCT_INFO_FULL) {
		echo '<a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS, substr(tep_get_all_get_params(), 0, -1)) . '">' . tep_image_button('button_more_reviews.gif', IMAGE_BUTTON_MORE_REVIEWS) . '</a></td>';
		echo '							<TD ALIGN="right" VALIGN="middle" CLASS="main"><a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, substr(tep_get_all_get_params(), 0, -1)) . '">' . tep_image_button('button_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW) . '</a></td>';
		echo '							<td width="10">' . tep_draw_separator('pixel_trans.gif', '10', '1') . '</td>';
	 } else {
		echo '<a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, substr(tep_get_all_get_params(), 0, -1)) . '">' . tep_image_button('button_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW) . '</a></td>';
	 }
?>
						</tr>
					</table>
					</td>
	        </tr>
        </table>
		  </td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td>
      </tr>

<?php
    } else { // if ($num_rows < 0)...
?>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td>
      </tr>
      <tr>
      	<td class="main"><div class="plr">
			<?php echo TEXT_NO_REVIEWS . '<br><br><a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, substr(tep_get_all_get_params(), 0, -1)) . '">' . tep_image_button('button_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW) . '</a>'; ?><br /><br /></div>
		</td>
      </tr>
<?php
  }
}
// END PopTheTop Product Info Reviews
?>
</table>