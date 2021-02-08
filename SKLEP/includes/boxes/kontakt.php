<?php

?>
<!-- kontakt //-->

<tr>
  <td class="borB"> 
<?php
  $info_box_contents = array();
  $info_box_contents[] = array('text' => BOX_INFORMATION_CONTACT);

  new infoBoxHeading($info_box_contents, false, false);

if(STORE_NAME && tep_not_null(STORE_NAME)) {
$k_info= '<tr>
				<td valign="middle" class="kontakt"><div align="left">'.tep_image_t('gfx/icon_info.gif','','style="vertical-align: middle;"').'&nbsp; '.STORE_NAME.'</div></td>
           </tr>';
}

if(KONTAKT_EMAIL_1 && tep_not_null(KONTAKT_EMAIL_1)) {
$k_email= '<tr>
				<td valign="middle" class="kontakt"><div align="left">'.tep_image_t('gfx/icon_mail.gif','','style="vertical-align: middle;"').'&nbsp; <a class="kontakt" href="'.tep_href_link(FILENAME_CONTACT_US).'">'.TEXT_WRITE_TO_US.' </a></div></td>
           </tr>';
}

if(KONTAKT_TELEFON_1 && tep_not_null(KONTAKT_TELEFON_1)) {
$k_nr_tel = '<tr>
				<td valign="middle" class="kontakt"><div align="left">'.tep_image_t('gfx/icon_tel.gif','','style="vertical-align: middle;"').'&nbsp; '.KONTAKT_TELEFON_1.' </div></td>
			</tr>';
}

if(KONTAKT_FAX_1 && tep_not_null(KONTAKT_FAX_1)) {
$k_nr_fax = '<tr>
				<td valign="middle" class="kontakt"><div align="left">'.tep_image_t('gfx/icon_fax.gif','','style="vertical-align: middle;"').'&nbsp; '.KONTAKT_FAX_1.' </div></td>
			</tr>';
}


if(KONTAKT_GSM_1 && tep_not_null(KONTAKT_GSM_1)) {
$k_nr_gsm = '<tr>
				<td valign="middle" class="kontakt"><div align="left">'.tep_image_t('gfx/icon_tel.gif','','style="vertical-align: middle;"').'&nbsp; '.KONTAKT_GSM_1.' </div></td>
			</tr>';
}

if(KONTAKT_NR_GG_1 && tep_not_null(KONTAKT_NR_GG_1)) {
$k_nr_gg = '<tr>
				<td valign="middle" class="kontakt"><div align="left">'.tep_image_t('gfx/icon_gg.gif','','style="vertical-align: middle;"').'&nbsp; <a href="gg:'.KONTAKT_NR_GG_1.'">'.KONTAKT_NR_GG_1 .'</a></div></td>
			</tr>';
}

if(KONTAKT_SKYPE_1 && tep_not_null(KONTAKT_SKYPE_1)) {
//require_once("includes/classes/class.phpSkypeStatus.php");
$skypeid=KONTAKT_SKYPE_1;
// new status
//$status = new phpSkypeStatus($skypeid);

// if param image = 1 return just the image

$k_skype = '<tr>
				<td valign="middle" class="kontakt"> <div align="left">'.tep_image_t('gfx/icon_skype.gif','','style="vertical-align: middle;"').' &nbsp; <a href="CALLTO://'.KONTAKT_SKYPE_1.'"> '.KONTAKT_SKYPE_1.' </a></div></td>
			</tr>';
}

if(KONTAKT_GODZINY_1 && tep_not_null(KONTAKT_GODZINY_1)) {
$k_godziny = '<tr>
				<td valign="middle" class="kontakt"><div align="left">'.tep_image_t('gfx/icon_zegarek.gif','','style="vertical-align: middle;"').'&nbsp; '.KONTAKT_GODZINY_1.' </div></td>
             </tr>';
}

  $info_box_contents = array();
  $info_box_contents[] = array('text' => '<div style="padding-left: 10px; padding-right: 10px;">' . '<div align="center"><table width="100%" border="0">' .
				$k_info .
				$k_email .
				$k_nr_tel .
				$k_nr_gsm .
				$k_nr_fax .
				$k_godziny.
				$k_nr_gg .
				$k_skype .

                '</table> </div>'.'</div>');
    
  new infoBox($info_box_contents);
?>
  
  </td>
</tr>
<!-- information_eof //-->

	<tr><td class="sep"></td></tr>
