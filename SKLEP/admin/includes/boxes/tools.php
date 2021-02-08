<?php
/*
  $Id: tools.php,v 1.20 2002/03/16 00:20:11 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- tools //-->
          <tr>
            <td>
<?php
  $heading = array();
  $contents = array();

  $heading[] = array('text'  => BOX_HEADING_TOOLS,
                     'link'  => tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('selected_box')) . 'selected_box=tools'));

  if ($selected_box == 'tools' || $menu_dhtml == true) {
    $contents[] = array('text'  => tep_admin_files_boxes(FILENAME_BACKUP, BOX_TOOLS_BACKUP) .
                                   tep_admin_files_boxes(FILENAME_NAPRAW_PRODUKTY, BOX_TOOLS_NAPRAW_PRODUKTY) .
                                   tep_admin_files_boxes(FILENAME_ADMIN_NOTES, BOX_TOOLS_ADMIN_NOTES) . 
                                   tep_admin_files_boxes(FILENAME_BANNER_MANAGER, BOX_TOOLS_BANNER_MANAGER) . 
                                   tep_admin_files_boxes(FILENAME_CACHE, BOX_TOOLS_CACHE) .
                                   tep_admin_files_boxes(FILENAME_DEFINE_LANGUAGE, BOX_TOOLS_DEFINE_LANGUAGE) .
                                   tep_admin_files_boxes(FILENAME_FILE_MANAGER, BOX_TOOLS_FILE_MANAGER) .
                                   tep_admin_files_boxes(FILENAME_MAIL, BOX_TOOLS_MAIL) .
                                   tep_admin_files_boxes(FILENAME_NEWSLETTERS, BOX_TOOLS_NEWSLETTER_MANAGER) .
                                   tep_admin_files_boxes(FILENAME_SERVER_INFO, BOX_TOOLS_SERVER_INFO) .
                                   tep_admin_files_boxes(FILENAME_WHOS_ONLINE, BOX_TOOLS_WHOS_ONLINE));
  }

  $box = new box;
  echo $box->menuBox($heading, $contents);
?>
            </td>
          </tr>
<!-- tools_eof //-->
