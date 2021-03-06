<td>
<?php
//BOF: MaxiDVD Returning Customer Info SECTION
//===========================================================
$returning_customer_title = TEXT_RETURNING_CUSTOMER;
$returning_customer_info = '<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td class="plrm">

	<table width="70%" border="0" cellspacing="2" cellpadding="0" align="left">
	  <tr>
	    <td class="main">' . ENTRY_EMAIL_ADDRESS . '</td>
	    <td>' . tep_draw_input_field('email_address') . '</td>	
	  </tr>
	  <tr>
	    <td class="main">' . ENTRY_PASSWORD . '</td>
		<td>' . tep_draw_password_field('password') . '</td>
	  </tr>
	  <tr>
	    <td></td>
		<td><a href="' . tep_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'SSL') . '">' . TEXT_PASSWORD_FORGOTTEN . '</a></td>
	  </tr>
	</table>
	<table width="30%" border="0" cellspacing="0" cellpadding="0" align="right">
	  <tr>
		<td align="center" class="smalltext" valign="middle"><br />' . tep_image_submit('button_login.gif', IMAGE_BUTTON_LOGIN) . '</td>
	  </tr>
	</table>
	</td>
  </tr>
</table>  
';
//===========================================================
?>

<?php
  $info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
                               'text'  => $returning_customer_title );
  new infoBoxHeading($info_box_contents, true, false);

  $info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
                               'text'  => $returning_customer_info);
  new infoBox($info_box_contents);
?>

<?php
//EOF: MaxiDVD Returning Customer Info SECTION
//===========================================================

	echo tep_draw_separator('pixel_trans.gif',1,10);

//MaxiDVD New Account Sign Up SECTION
//===========================================================
$create_account_title = HEADING_NEW_CUSTOMER;
$create_account_info = '<table border="0" width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100%" class="plrm" colspan="3">' . TEXT_NEW_CUSTOMER_INTRODUCTION . '</td>
  </tr>
  <tr>
    <td width="100%" class="main" colspan="3">' . tep_draw_separator('pixel_trans.gif', '100%', '10') . '</td>
  </tr>
  <tr>
    <td width="70%" class="main"></td>
    <td width="30%" rowspan="3" align="center"><a href="' . tep_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL') . '">' . tep_image_button('button_create_account.gif', IMAGE_BUTTON_CREATE_ACCOUNT) . '</a>' . '</td>
  </tr>
</table>';
//===========================================================
?>

<?php
  $info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
                               'text'  => $create_account_title );
  new infoBoxHeading($info_box_contents, false, false);

  $info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
                               'text'  => $create_account_info);
  new infoBox($info_box_contents);
?>

<?php
//EOF: MaxiDVD New Account Sign Up SECTION
//===========================================================

	echo tep_draw_separator('pixel_trans.gif',1,10);

//BOF: MaxiDVD Purchase With-Out An Account SECTION
//===========================================================
if (($cart->count_contents() > 0) && (!isset($HTTP_GET_VARS['my_account_f']) || $HTTP_GET_VARS['my_account_f'] !=1)) 	// only display of box if something in cart
{
$pwa_checkout_title = HEADING_CHECKOUT;
$pwa_checkout_info = '<table border="0" width="100%" cellpadding="0" cellspacing="0">

  <tr>
    <td width="100%" class="plrm" colspan="3">' . TEXT_CHECKOUT_INTRODUCTION . '</td>
  </tr>
  <tr>
    <td width="100%" class="main" colspan="3">' . tep_draw_separator('pixel_trans.gif', '100%', '10') . '</td>
  </tr>
  <tr>
    <td width="70%" class="main"></td>
    <td width="30%" rowspan="3" align="center">' . '<a href="' . tep_href_link(FILENAME_CHECKOUT, '', 'SSL') . '">' . tep_image_button('button_checkout.gif', IMAGE_BUTTON_CHECKOUT) . '</a>' . '<br></td>
  </tr>
</table>';
//===========================================================
?>

<?php
  $info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
                               'text'  => $pwa_checkout_title );
  new infoBoxHeading($info_box_contents, true, true);

  $info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
                               'text'  => $pwa_checkout_info);
  new infoBox($info_box_contents);
?>

  <?php
}
//EOF: MaxiDVD Purchase With-Out An Account SECTION
//===========================================================
?>
</td>
