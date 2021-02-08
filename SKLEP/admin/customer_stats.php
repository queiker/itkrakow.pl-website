<?php
/*================================================================*\
#################################################################### 
#               Customer Registration Stats v 1.0
#                            by Chemo
#
# ---------------------------------------------------------------- # 
# --------- Released under the GNU General Public License -------- #
# ---------------------------------------------------------------- #
# 
# 							* CREDITS *
#	     This report is based on the work of Charly Wilhelm 
#
# 							* ABOUT *
#	This contribution was created to generate customer registration
#	reports for an osCommerce store.  Reports can be generated on a
#	daily, weekly, monthly, or yearly timeframe.
#
# 	This report is self contained and only one file needs to be
#	uploaded.  
#
#	Add a link to the page in admin/includes/boxes/reports.php
####################################################################
\*================================================================*/

   require ('includes/application_top.php');

# Begin class definition
class creport {
	var $begindate, $enddate, $globalstartdate, $globalenddate, $mode, $numrecords;
	var $values = array();
	function creport () {
	  $firstQuery = tep_db_query("select UNIX_TIMESTAMP(min(customers_info_date_account_created)) as first FROM customers_info");
      $first = tep_db_fetch_array($firstQuery);
	  
	  $this->globalstartdate = mktime(0, 0, 0, date("m", $first['first']), date("d", $first['first']), date("Y", $first['first']));
	  $this->begindate = $this->globalstartdate;	 
	  $this->globalenddate = mktime(0, 0, 0, date("m", time()), date("d", time()), date("Y", time()));
	  $this->enddate = $this->globalenddate;
	  $this->enddateclean = date("F j, Y", $this->enddate);
	  
	  $timeframequery = "SELECT * FROM `customers_info` WHERE UNIX_TIMESTAMP(`customers_info_date_account_created`) >= '".$this->globalstartdate."' AND UNIX_TIMESTAMP(`customers_info_date_account_created`) <= '".$this->enddate."'";
	  $timeframearray = tep_db_query($timeframequery);
	  $this->numrecords = mysql_num_rows($timeframearray);	
	}
	
	function getnext() {
	if ($this->begindate < $this->globalstartdate) {
        $this->begindate = $this->globalstartdate;
      } 
	  switch ($this->mode) {
        // yearly
        case '1':
          $sd = $this->begindate;
          $ed = mktime(0, 0, 0, date("m", $sd), date("d", $sd), date("Y", $sd) + 1);
          break;
        // monthly
        case '2':
          $sd = $this->begindate;
          $ed = mktime(0, 0, 0, date("m", $sd) + 1, 1, date("Y", $sd));
          break;
        // weekly
        case '3':
          $sd = $this->begindate;
          $ed = mktime(0, 0, 0, date("m", $sd), date("d", $sd) + 7, date("Y", $sd));
          break;
        // daily
        case '4':
          $sd = $this->begindate;
          $ed = mktime(0, 0, 0, date("m", $sd), date("d", $sd) + 1, date("Y", $sd));
          break;
		default:
          $sd = $this->begindate;
          $ed = mktime(0, 0, 0, date("m", $sd), date("d", $sd) + 7, date("Y", $sd));
		  break;
			
      }//end switch
	  if ($this->enddate > $this->globalenddate) $this->enddate = $this->globalenddate; 
      if ($ed > $this->enddate) $ed = $this->enddate;
	  	  
	  $timeframequery = "SELECT * FROM `customers_info` WHERE UNIX_TIMESTAMP(`customers_info_date_account_created`) >= '".$sd."' AND UNIX_TIMESTAMP(`customers_info_date_account_created`) <= '".$ed."'";
	  $this->begindate = $ed;	  
	  $timeframearray = tep_db_query($timeframequery);
	  $this->numrecords = mysql_num_rows($timeframearray);
	  $this->values[] = $this->numrecords;
	  echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'"><td width="125px" align="left" class="dataTableContent">'.date("D M j, y", $sd).'</td><td width="125px" align="left" class="dataTableContent">'. date("D M j, y", $ed).'</td><td class="dataTableContent"><b>'.$this->numrecords.'</b></td></tr>'; 		
	}# end getnext
}# end creport class

# Crete a new instance of the creport class
$report = new creport; 

	if ( $_POST['mode'] ) 
	{    
		$mode = $_POST['mode'];
  	}
  	if ($mode < 1 || $mode > 4) {
    	$mode = 2;
  	}
	  if ($_POST['startday'] && $_POST['startmonth'] && $_POST['startyear']){
	  $report->begindate = mktime(0, 0, 0, $_POST['startmonth'], $_POST['startday'], $_POST['startyear']); }
if ($_POST['endday'] && $_POST['endmonth'] && $_POST['endyear']){
	  $report->enddate = mktime(0, 0, 0, $_POST['endmonth'], $_POST['endday'], $_POST['endyear']); }
	$report->mode = $mode;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
<title>Customer Account Creation Report</title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/general.js"></script>
</head>


<body  bgcolor="#FFFFFF">
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
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo 'Raport o Nowych Klientach'; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
	  <tr>
		<td class="main">
		<p class="main">Dane od <b><?php  echo date("D M j, Y", $report->begindate); ?></b> do <b><?php  echo date("D M j, Y", $report->enddate); ?></b></p>		
		<p class="menuBoxHeading">Wszystkich kont Klientów: <b><?php  echo $report->numrecords; ?></b></p>		
<form name="options" method="post" action="<?php echo $PHP_SELF; ?>" class="menuBoxHeading">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td valign="top" width="125px">
		
		  <input name="mode" type="radio" value="1" <?php if ($mode == 1) echo "checked"; ?>> Rocznie<br>
		  <input name="mode" type="radio" value="2" <?php if ($mode == 2) echo "checked"; ?>> Miesiecznie<br>
		  <input name="mode" type="radio" value="3" <?php if ($mode == 3) echo "checked"; ?>> Tygodniowo<br>
		  <input name="mode" type="radio" value="4" <?php if ($mode == 4) echo "checked"; ?>> Dziennie<br>
          </td>
				<td valign="top">
			  <table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
				  <td>
				  	<b>od dnia</b> (d m R)<br>
					<input name="startday" type="text" size="2" maxlength="2" value="<?php echo date("j", $report->begindate); ?>">
					<input name="startmonth" type="text" value="<?php echo date("n", $report->begindate); ?>" size="2" maxlength="2">
					<input name="startyear" type="text" size="4" maxlength="4" value="<?php echo date("Y", $report->begindate); ?>">			       
				   </td>
				</tr>
				<tr>
				<td><br>
				  	<b>do dnia</b> (d m R)<br>
					<input name="endday" type="text" value="<?php echo date("j", $report->enddate); ?>" size="2" maxlength="2">
					<input name="endmonth" type="text" value="<?php echo date("n", $report->enddate); ?>" size="2" maxlength="2">
					<input name="endyear" type="text" size="4" value="<?php echo date("Y", $report->enddate); ?>"  maxlength="4">
					 <input type="submit" name="Submit" value="Poka¿">
					 <?php echo tep_hide_session_id() ; ?></form>	
				</td>
				</tr>
				</table>

				</td>
				</tr></table>
		</td>
	  </tr>

	<tr>
	  <td valign="top" class"menuBoxHeading">

<br>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr class="dataTableHeadingRow"><td width="125px" align="left" class="dataTableHeadingContent">od dnia</td><td width="125px" align="left" class="dataTableHeadingContent">do dnia</td><td align="left" class="dataTableHeadingContent">Liczba utworzonych kont</td></tr>
<?

while ($report->begindate < $report->enddate) {
  $report->getnext();
  }
?>  
   
   </table>
   </td></tr></table>
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php');?>
