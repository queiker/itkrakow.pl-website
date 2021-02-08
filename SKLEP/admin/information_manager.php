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


require('includes/application_top.php');
require(DIR_WS_LANGUAGES . $language . '/' . 'information.php');

$adgrafics_information = tep_db_prepare_input($_GET['adgrafics_information']);
$information_id = (int)tep_db_prepare_input($_GET['information_id']);

function browse_information () {
global $languages_id;
	$query="SELECT * FROM " . TABLE_INFORMATION . " WHERE languages_id=$languages_id ORDER BY v_order";
	$daftar = mysql_db_query(DB_DATABASE, $query) or die("Information ERROR: ".mysql_error());$c=0;
	while ($buffer = mysql_fetch_array($daftar)) {$result[$c]=$buffer;$c++;}
return $result;
}

function read_data ($information_id) {
	$result=mysql_fetch_array(mysql_db_query(DB_DATABASE, "SELECT * FROM " . TABLE_INFORMATION . " WHERE information_id='".(int)$information_id."'"));
return $result;
}

$warning=tep_image(DIR_WS_ICONS . 'warning.gif', WARNING_INFORMATION); 

function error_message($error) {
	global $warning;
	switch ($error) {
		case "20":return "<tr class=messageStackError><td>$warning ." . ERROR_20_INFORMATION . "</td></tr>";break;
		case "80":return "<tr class=messageStackError><td>$warning " . ERROR_80_INFORMATION . "</td></tr>";break;
		default:return $error;
	}
}

  $languages = tep_get_languages();
  $languages_array = array();
  $languages_selected = DEFAULT_LANGUAGE;
  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
    $languages_array[] = array('id' => $languages[$i]['code'],
                               'text' => $languages[$i]['name']);
    if ($languages[$i]['directory'] == $language) {
      $languages_selected = $languages[$i]['code'];
    }
  }

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" type="text/javascript" src="includes/javascript/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="includes/javascript/tiny_mce/opcje.js"></script>
<script language="javascript" type="text/javascript" src="includes/general.js"></script>
<script language="javascript" type="text/javascript"><!--
function infoPreviewWindow(url,id) {
  window.open(url,id,'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=550,height=300,screenX=100,screenY=100,top=100,left=100')
}
//--></script>
</head>
<body bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top">
<table border=0 width="100%">
<tr><td align="right"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                      <tr><?php echo tep_draw_form('languages', 'information_manager.php', '', 'get'); ?>
                        <td align="right"><?php echo tep_draw_pull_down_menu('language', $languages_array, $languages_selected, 'onChange="this.form.submit();"').tep_hide_session_id(); ?></td>
                      </form></tr>
                    </table></td></tr>
<?

		if(isset($_POST['information_id']) && tep_not_null($_POST['information_id'])) {
			$information_id = $_POST['information_id'];
		}

		if(isset($_POST['description']) && tep_not_null($_POST['description'])) {
			$description = $_POST['description'];
		}

		if(isset($_POST['info_title']) && tep_not_null($_POST['info_title'])) {
			$info_title = $_POST['info_title'];
		}

		if(isset($_POST['v_order']) && tep_not_null($_POST['v_order'])) {
			$v_order = $_POST['v_order'];
		}

switch($adgrafics_information) {

case "Added":
		$data=browse_information();
 		$no=1;
		 if (sizeof($data) > 0) {while (list($key, $val)=each($data)) {$no++; }	} ;
		$title="" . ADD_QUEUE_INFORMATION . " #$no";
		echo tep_draw_form('',FILENAME_INFORMATION_MANAGER, 'adgrafics_information=AddSure');
		include('information_form.php');
	break;

case "AddSure":
	function add_information ($data) {
	global $languages_id;
	$query ="INSERT INTO " . TABLE_INFORMATION . " VALUES(null, '$data[visible]', '$data[v_order]', '$data[info_title]', '$data[description]','$languages_id')";
	mysql_db_query(DB_DATABASE, $query) or die ("Information ERROR: ".mysql_error());
	}
		if ($v_order && $info_title && $description) {
		if ((INT)$v_order) {
		add_information($HTTP_POST_VARS);
		$data=browse_information();
		$title="" . tep_image(DIR_WS_ICONS . 'confirm_red.gif', CONFIRM_INFORMATION) .SUCCED_INFORMATION . ADD_QUEUE_INFORMATION . " $v_order ";
		include('information_list.php');
		} else {$error="20";}
		} else {$error="80";}

	break;

case "Edit":
		if ($information_id) {
		$edit=read_data($information_id);

		$data=browse_information();
		$button=array("Update");
		$title="" . EDIT_ID_INFORMATION . " $information_id";
		//echo form("$PHP_SELF?adgrafics_information=Update", $hidden);
		echo tep_draw_form('',FILENAME_INFORMATION_MANAGER, 'adgrafics_information=Update');
		echo tep_draw_hidden_field('information_id', "$information_id");
		include('information_form.php');
		} else {$error="80";}
	break;

case "Update":
	function update_information ($data) {
	mysql_db_query(DB_DATABASE, "UPDATE " . TABLE_INFORMATION . " SET info_title='$data[info_title]', description='$data[description]', visible='$data[visible]', v_order=$data[v_order] WHERE information_id=$data[information_id]") or die ("update_information: ".mysql_error());
	}

		if ($information_id && $description && $v_order) {
			if ((INT)$v_order) {
				update_information($_POST);
				$data=browse_information();
				$title="$confirm " . UPDATE_ID_INFORMATION . " $information_id " . SUCCED_INFORMATION . "";
				include('information_list.php');
			} else {
				$error="20";
			} 
		} else {
			$error="80";
		}
	break;

      case 'Visible':
	function tep_set_information_visible($information_id, $visible) {
	if ($visible == '1') {
	return tep_db_query("update " . TABLE_INFORMATION . " set visible = '0' where information_id = '" . $information_id . "'");
	} else{
	return tep_db_query("update " . TABLE_INFORMATION . " set visible = '1' where information_id = '" . $information_id . "'");
	} 
	}
		tep_set_information_visible($information_id, $visible);
		$data=browse_information();
		if ($visible == '1') {	$vivod=DEACTIVATION_ID_INFORMATION;
		}else{$vivod=ACTIVATION_ID_INFORMATION;}
		$title="$confirm $vivod $information_id " . SUCCED_INFORMATION . "";
		include('information_list.php');
        break;

case "Delete":
		if ($information_id) {
		$delete=read_data($information_id);
		$data=browse_information();
		$title="" . DELETE_CONFITMATION_ID_INFORMATION . " $information_id";
		echo "<tr class=pageHeading><td>$title  </td></tr>";
		echo "<tr><td>" . TITLE_INFORMATION . " $delete[info_title]</td></tr><tr><td align=right>";
		echo tep_draw_form('',FILENAME_INFORMATION_MANAGER, "adgrafics_information=DelSure&information_id=$val[information_id]");
		echo tep_draw_hidden_field('information_id', "$information_id");
		echo tep_image_submit('button_delete.gif', IMAGE_DELETE);
		echo '<a href="' . tep_href_link(FILENAME_INFORMATION_MANAGER, '', 'NONSSL') . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>';
		echo tep_hide_session_id() . "</form></td></tr>";
		} else {$error="80";}
		break;


case "DelSure":
	function delete_information ($information_id) {
	mysql_db_query(DB_DATABASE, "DELETE FROM " . TABLE_INFORMATION . " WHERE information_id=$information_id");
	}
		if ($information_id) {
		delete_information($information_id);
		$data=browse_information();
		$title="$confirm " . DELETED_ID_INFORMATION . " $information_id " . SUCCED_INFORMATION . "";
		include('information_list.php');
		} else {$error="80";}
		break;
default:
		$data=browse_information();
		$title="" . MANAGER_INFORMATION . "";
		include('information_list.php');
	}
if ($error) {
		$content=error_message($error);
		echo $content;
		$data=browse_information();
 		$no=1;
		 if (sizeof($data) > 0) {while (list($key, $val)=each($data)) {$no++; }	} ;
		$title="" . ADD_QUEUE_INFORMATION . " $no";
		echo tep_draw_form('',FILENAME_INFORMATION_MANAGER, 'adgrafics_information=AddSure');
		include('information_form.php');
}
?>
</table>
</td>


<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>