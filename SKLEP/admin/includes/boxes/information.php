<?php
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
<!-- information //-->
          <tr>
            <td>
<?php
  $heading = array();
  $contents = array();

  $heading[] = array('text'  => BOX_HEADING_INFORMATION,
                     'link'  => tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('selected_box')) . 'selected_box=information'));

  $cfg_groups = '';
  $configuration_groups_query = tep_db_query("select configuration_group_id as cgID, configuration_group_title as cgTitle from " . TABLE_NEWSDESK_CONFIGURATION_GROUP . " where visible = '1' order by sort_order");

  while ($configuration_groups = tep_db_fetch_array($configuration_groups_query)) {
	$cfg_groups .= '<a href="' . tep_href_link(FILENAME_NEWSDESK_CONFIGURATION, 'gID=' . $configuration_groups['cgID'], 'NONSSL') . '" class="menuBoxContentLink">' . $configuration_groups['cgTitle'] . '</a><br>';
  }

  if ($selected_box == 'information' || $menu_dhtml == true) {
    $contents[] = array('text'  =>	tep_admin_files_boxes(FILENAME_INFORMATION_MANAGER, BOX_INFORMATION_MANAGER) .
							        tep_admin_files_boxes(FILENAME_DEFINE_MAINPAGE, BOX_CATALOG_DEFINE_MAINPAGE) .
									tep_admin_files_boxes(FILENAME_NEWSDESK, BOX_NEWSDESK) .
									tep_admin_files_boxes(FILENAME_NEWSDESK_REVIEWS, BOX_NEWSDESK_REVIEWS).
									''.$cfg_groups.''
	);
  }

  $box = new box;
  echo $box->menuBox($heading, $contents);
?>
            </td>
          </tr>
<!-- information_eof //-->