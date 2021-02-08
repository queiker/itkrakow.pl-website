
		  <tr>
            <td class="bgs"><?php 
	echo  tep_draw_form('quick_find', tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'get'); 			
			
	echo '<div id="box_search">';

	echo '<div class="headPosW">'.BOX_HEADING_SEARCH.'</div>';

	echo '<div id="fsearch">';
	echo tep_draw_input_field('keywords', '', 'size="10" maxlength="64" style="width: ' . (BOX_WIDTH-30) . 'px"') . '&nbsp;'. '<br>' . tep_hide_session_id() . '<table cellpadding="4" border="0"><tr><td><a href="' . tep_href_link(FILENAME_ADVANCED_SEARCH) . '" class="linkW"><b>' . BOX_SEARCH_ADVANCED_SEARCH . '</b></a> &nbsp; &nbsp;</td><td align="right">' . tep_image_submit ('button_search2.gif', BOX_HEADING_SEARCH).'</td></tr></table>';
	echo '</div>';
	echo '</div>';
	echo '</form>';
?>
            </td>
          </tr>

	<tr><td class="sep"></td></tr>
