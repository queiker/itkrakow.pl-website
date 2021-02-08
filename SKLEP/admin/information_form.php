<?PHP
  /*
  Module: Information Pages Unlimited
  		  File date: 2003/03/02
		  Based on the FAQ script of adgrafics
  		  Adjusted by Joeri Stegeman (joeri210 at yahoo.com), The Netherlands

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Released under the GNU General Public License
  */
?>
<tr class=pageHeading><td><?php echo $title ?></td></tr>
<tr class="dataTableRow"><td class="main"><font color=red>
<?
echo QUEUE_INFORMATION_LIST;
$data=browse_information();
$no=1;
if (sizeof($data) > 0) {
  while (list($key, $val)=each($data)) {
		echo "$val[v_order], ";
		$no++;
		}
} 
?>
</font>
</td></tr>
	<tr><td>
<table border="0" cellpadding="0" cellspacing="2">
<tr><td class="main"><?php echo QUEUE_INFORMATION;?> </td>
<td class="main">
<?php if ($edit[v_order]) {$no=$edit[v_order];}; echo tep_draw_input_field('v_order', "$no", 'size=3 maxlength=4'); ?>
<?php  
echo ' '.VISIBLE_INFORMATION;
if ($edit[visible]==1) {
echo tep_image(DIR_WS_ICONS . 'icon_status_green.gif', INFORMATION_ID_ACTIVE); 
}else{
echo tep_image(DIR_WS_ICONS . 'icon_status_red.gif', INFORMATION_ID_DEACTIVE); 
}
?>
<?php if ($edit[visible]) {$checked= "checked";}; echo tep_draw_checkbox_field('visible', '1', "$checked") . VISIBLE_INFORMATION_DO; ?>
</td>
</tr>

<tr><td class="main"><?php echo TITLE_INFORMATION;?><br></td>
	<td><?php echo tep_draw_input_field('info_title', "$edit[info_title]", 'maxlength=255'); ?></td>
</tr>

<tr><td class="main"><?php echo DESCRIPTION_INFORMATION;?><br>
</td>
<td>
<?php echo tep_draw_textarea_field('description', '', '100%', '20', "$edit[description]"); ?>

</td>
</tr>
<tr><td></td>
<td align=right>
<?php
echo tep_image_submit('button_insert.gif', IMAGE_INSERT);
echo '<a href="' . tep_href_link(FILENAME_INFORMATION_MANAGER, '', 'NONSSL') . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>';
 ?>
</td>
</tr>
</table>
</form>
	</td></tr>