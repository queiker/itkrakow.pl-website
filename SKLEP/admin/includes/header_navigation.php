<?php
/*
  $Id: header_navigation.php,v 1.19 2003/04/27 16:11:52 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
  Updated by Gnidhal (fx@geniehalles.com)
*/
  $menu_dhtml = MENU_DHTML;
  $box_files_list = array( // array('administrator'  , 'administrator.php' , BOX_HEADING_ADMINISTRATOR),
  							array('catalog'        , 'catalog.php', BOX_HEADING_CATALOG),
                            array('customers'      , 'customers.php' , BOX_HEADING_CUSTOMERS),
                            array('reports'        , 'reports.php' , BOX_HEADING_REPORTS),
  							array('configuration'  , 'configuration.php', BOX_HEADING_CONFIGURATION),
                            array('localization'   , 'localization.php' , BOX_HEADING_LOCALIZATION),
                            array('modules'        , 'modules.php' , BOX_HEADING_MODULES),
                            array('keyword_show'   , 'keyword_show.php' , BOX_KEYWORD_SHOW),
                            array('taxes'          , 'taxes.php' , BOX_HEADING_LOCATION_AND_TAXES),
                            array('templates'      , 'templates.php' , BOX_HEADING_TEMPLATES),
                            array('tools'          , 'tools.php' , BOX_HEADING_TOOLS),
                            array('information'          , 'information.php' , BOX_HEADING_INFORMATION),
                            array('newsdesk'       , 'newsdesk.php' , BOX_HEADING_NEWSDESK),
                            array('wsparcie'       , 'wsparcie.php' , BOX_HEADING_WSPARCIE)
                          );

   echo '<!-- Menu bar #2. --> <div class="menuBar" style="width: 99.7%;">';
   foreach($box_files_list as $item_menu) {
   	 if (tep_admin_check_boxes($item_menu[1]) == true):
   	 		echo "<a class=\"menuButton\" href=\"\" onclick=\"return buttonClick(event, '".$item_menu[0]."Menu');\" onmouseover=\"buttonMouseover(event, '".$item_menu[0]."Menu');\">".$item_menu[2]."</a>";
   	 endif;
   }
   echo "</div>";
	 foreach($box_files_list as $item_menu) {
	   if (tep_admin_check_boxes($item_menu[1]) == true):
			 require(DIR_WS_BOXES. $item_menu[1] );
	 endif;
	 }
?>