<?php
/*=======================================================================*\
|| #################### //-- SCRIPT INFO --// ########################### ||
|| #	Script name: meta_tags.php                                      # ||
|| #	Contribution: cDynamic Meta Tags                                # ||
|| #	Version: 1.2e                                                   # ||
|| #	Date: April 4 2005                                              # ||
|| # ------------------------------------------------------------------ # ||
|| #################### //-- COPYRIGHT INFO --// ######################## ||
|| #	Copyright (C) 2005 Chris LaRocque								# ||
|| #																	# ||
|| #	This script is free software; you can redistribute it and/or	# ||
|| #	modify it under the terms of the GNU General Public License		# ||
|| #	as published by the Free Software Foundation; either version 2	# ||
|| #	of the License, or (at your option) any later version.			# ||
|| #																	# ||
|| #	This script is distributed in the hope that it will be useful,	# ||
|| #	but WITHOUT ANY WARRANTY; without even the implied warranty of	# ||
|| #	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the	# ||
|| #	GNU General Public License for more details.					# ||
|| #																	# ||
|| #	Script is intended to be used with:								# ||
|| #	osCommerce, Open Source E-Commerce Solutions					# ||
|| #	http://www.oscommerce.com										# ||
|| #	Copyright (c) 2003 osCommerce									# ||
|| ###################################################################### ||
\*========================================================================*/
#--------------------------------------------------------------------------#
############################################################################ 
# cache path... make sure it is the same as you 
# specified in includes/meta_tags.php (if you changed it) MUST HAVE READ/WRITE CHMOD to 777
/*
$meta_cache_files_path = DIR_FS_CATALOG.'cache/'; //this should work for most

# DO NOT ALTER OR EDIT BELOW THIS LINE UNLESS YOU KNOW WHAT YOU ARE DOING #
 foreach (glob($meta_cache_files_path."{*.meta-cache}", GLOB_BRACE) as $filename_page) {
	   unlink($filename_page);
	   }
		
     $exists = mysql_query("SELECT 1 FROM cache LIMIT 0");
     if ($exists) tep_db_query("DELETE FROM cache WHERE cache_name LIKE '%meta-cache'");
*/
?>