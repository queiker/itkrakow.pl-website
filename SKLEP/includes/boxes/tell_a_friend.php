<?php
/*
  $Id: tell_a_friend.php,v 1.17 2003/06/10 18:26:33 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- tell_a_friend //-->
          <tr>
            <td>
<?php
  $info_box_contents = array();
  $info_box_contents[] = array('text' => BOX_HEADING_TELL_A_FRIEND);

  new infoBoxHeading($info_box_contents, false, false);

  $info_box_contents = array();
  $info_box_contents[] = array('form' => tep_draw_form('tell_a_friend', tep_href_link(FILENAME_TELL_A_FRIEND, '', 'NONSSL', false), 'get'),
                               'align' => 'center',
                                'text' => '<div style="float: left; text-align: center; width: 170px;">'.tep_draw_input_field('to_email_address', '', 'size="20"') . '</div><div style="float: right; text-align: left; width: 40px;">' . tep_image_submit('button_tell_a_friend.gif', BOX_HEADING_TELL_A_FRIEND, 'style="vertical-align: middle;"') . tep_draw_hidden_field('products_id', (int)$HTTP_GET_VARS['products_id']) . tep_hide_session_id() . '</div><div style="text-align: center; clear: both; padding-top: 4px;">' . BOX_TELL_A_FRIEND_TEXT.'</div>');

  new infoBox($info_box_contents);
?>
            </td>
          </tr>
<!-- tell_a_friend_eof //-->

	<tr><td class="sep"></td></tr>
