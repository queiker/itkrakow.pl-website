<?php
/*
  $Id: orders_tracking.php,v 2.5 August 20, 2004 02:00:00 

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 - 2004 osCommerce

  Orders Tracking originally developed by Kieth Waldorf
  v2.1, v2.3, v2.4, v2.5 updates by Jared Call with suggestions from the forums
  v2.2 updates by Robert Hellemans
  Localization work for English and Brazilian Portugese added by alan
  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

?>

<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
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
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="dataTableContent" valign="center">&nbsp;
            </td>

            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
		  <tr>
		      <td class="dataTableContent" valign="center" align="left" colspan="3"><br><?php
                 echo tep_draw_form('search', FILENAME_STATS_ORDERS_TRACKING, '', 'get');
                 echo HEADING_SELECT_YEAR . ' ' . tep_draw_input_field('year', '', 'size="4"');
                 echo '&nbsp;&nbsp;&nbsp;';
                 echo HEADING_SELECT_PROFIT_RATE . ' ' . tep_draw_input_field('profit_rate', '', 'size="2"');
                 echo '&#37;&nbsp;&nbsp;&nbsp;<input type="submit" value="'. HEADING_TITLE_RECALCULATE .'">';
                 echo tep_hide_session_id() . '</form></td>';
                ?>
            </td>
		  </td>
		  </tr>
        </table></td>
      </tr>
      <tr>
        <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">

<?php
setlocale(LC_MONETARY, 'en_US');

function get_month($mo, $yr) {
    $query = "SELECT * FROM orders WHERE date_purchased LIKE \"$yr-$mo%\"";
    $result = mysql_query($query) or die("Query failed : " . mysql_error());
    $month=0;
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
                $month++;
    }
    mysql_free_result($result);
    return $month;
}

function get_order_total($mo, $yr) {
    $query = "SELECT orders_id FROM orders WHERE date_purchased LIKE \"$yr-$mo%\" ORDER by orders_id";
    $result = mysql_query($query) or die("Query failed : " . mysql_error());
    $i=0;
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
        foreach ($line as $col_value) {
           if ( $i == 0 ) {
                $first=$col_value;
                $i++;
           } else {
                $last=$col_value;
           }
        }
    }
    mysql_free_result($result);

    $query = "SELECT sum(value) FROM orders_total WHERE orders_id >= \"$first\" and orders_id <= \"$last\" and class = \"ot_total\"";
    $result = mysql_query($query) or die("Query failed : " . mysql_error());
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
        foreach ($line as $col_value) {
                $total=$col_value;
        }
    }
    mysql_free_result($result);
    return $total;
}

function get_status($type) {
    $query = "SELECT orders_status FROM orders WHERE orders_status = \"$type\"";
    $result = mysql_query($query) or die("Query failed : " . mysql_error());
    $orders_this_status=0;
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
        foreach ($line as $col_value) {
           $orders_this_status++;
  	}
    }
    mysql_free_result($result);
    return $orders_this_status;
}


# Get total dollars in orders

    $query = "SELECT sum(value) FROM orders_total WHERE class = \"ot_total\"";
    $result = mysql_query($query) or die("Query failed : " . mysql_error());
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
        foreach ($line as $col_value) {
	    $grand_total=$col_value;
        }
    }
    mysql_free_result($result);

    
# Get total shipping charges

    $query = "SELECT sum(value) FROM orders_total WHERE class like \"ot_shipping\"";
    $result = mysql_query($query) or die("Query failed : " . mysql_error());
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
        foreach ($line as $col_value) {
	    $shipping=$col_value;
        }
    }
    mysql_free_result($result);


# Get total number of customers
    $query = "SELECT * FROM customers";
    $result = mysql_query($query) or die("Query failed : " . mysql_error());
    $customer_count=0;
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$customer_count++;
    }
    mysql_free_result($result);

    
# Get total number new customers

    $like = date('Y-m-d');
    $query = "SELECT customers_info_date_account_created FROM customers_info WHERE customers_info_date_account_created like \"$like%\"";
    $result = mysql_query($query) or die("Query failed : " . mysql_error());
    $newcust=0;
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$newcust++;
    }
    mysql_free_result($result);

    
# Whos online

    $query = "SELECT * FROM whos_online";
    $result = mysql_query($query) or die("Query failed : " . mysql_error());
    $whos_online=0;
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$whos_online++;
    }
    mysql_free_result($result);

    
# Whos online again

    $query = "SELECT * FROM whos_online WHERE customer_id != \"0\"";
    $result = mysql_query($query) or die("Query failed : " . mysql_error());
    $who_again=0;
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$who_again++;
    }
    mysql_free_result($result);

    
# How many orders today total

    $date = date('Y-m-d'); #2003-09-07%
    $query = "SELECT * FROM orders WHERE date_purchased LIKE \"$date%\"";
    $result = mysql_query($query) or die("Query failed : " . mysql_error());
    $today_order_count=0;
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$today_order_count++;
    }
    mysql_free_result($result);

    
# How many orders yesterday

    $mo = date('m');
    $today = date('d');
    $year = date('Y');
    
    $last_month = $mo-1;
    if ( $last_month == 0) $last_month = 12; //if jan, then last month is dec (12th mo, not 0th month)
    $yesterday = date('d') - 1;
    if ($yesterday == "0") //today is the first day of the month, now "Thirty days hath November . . ." for the prev month
     { $first_day_of_month=1;
       if ( ($last_month == 1) OR ($last_month == 3) OR ($last_month == 5) OR ($last_month == 7) OR ($last_month == 8) OR ($last_month == 10) OR ($last_month == 12) )
          $yesterday = "31";
        elseif  ( ($last_month == 4) OR ($last_month == 6) OR ($last_month == 9) OR ($last_month == 11) )
          $yesterday = "30";
//calculate Feb end day, including leap year calculation from http://www.mitre.org/tech/cots/LEAPCALC.html
        else {
              if ( ($year % 4) != 0) $yesterday = "28";
               elseif ( ($year % 400) == 0) $yesterday = "29";
               elseif ( ($year % 100) == 0) $yesterday = "28";
               else $yesterday = "29";
              }
     }

// set $yesterday_month so that we can properly run stats for yesterday, not the first day of last month
    if ($first_day_of_month == 1) 
       $yesterday_month = $last_month; 
    else $yesterday_month = $mo;

// set $yesterday_year so that we can properly run stats for yesterday, not the first day of last year or this month last year        
    if ( ($yesterday_month == 12) && ($first_day_of_month == 1) )
      $yesterday_year = $year - 1;
    else
      $yesterday_year = $year;

// next line to normalize $yesterday format to 2 digits
    if ($yesterday <10) {$yesterday = "0$yesterday";}
//    if ($yesterday_month <10) {$yesterday_month = "0$yesterday_month";}
//    if ($first_day_of_month == 1)  // if today is the first day of the month, then run yesterday stats for last_month,day instead of this_month,day
    $query = "SELECT * FROM orders WHERE date_purchased LIKE \"$yesterday_year-$yesterday_month-$yesterday%\"";
    $result = mysql_query($query) or die("Query failed : " . mysql_error());
    $yesterday_order_count=0;
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $yesterday_order_count++;
    }
    mysql_free_result($result);

# Get the last order_id

    $query = "SELECT orders_id FROM orders_total WHERE class = \"ot_total\" ORDER BY orders_id ASC";
    $result = mysql_query($query) or die("Query failed : " . mysql_error());
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
        foreach ($line as $col_value) {
		$latest_order_id=$col_value;
	}
    }
    mysql_free_result($result);

    
# Calculate the order_id number less the number of orders today

    $yesterday_last_order_id = $latest_order_id - $today_order_count;
    $twodaysago_last_order_id = $yesterday_last_order_id - $yesterday_order_count;

    
# Grab the sum of all orders greater than $yesterday_last_order_id
# In other words, how much have we done so far in sales today?

    $query = "SELECT sum(value) FROM orders_total WHERE orders_id > \"$yesterday_last_order_id\" and class = \"ot_total\"";
    $result = mysql_query($query) or die("Query failed : " . mysql_error());
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
        foreach ($line as $col_value) {
	    $orders_today=$col_value;
        }
    }
    mysql_free_result($result);

    
# Grab the sum of all orders greater than $twodaysago_last_order_id and less than yesterday_last_order_id
# In other words, how much did we do in sales yesterday?

    $query = "SELECT sum(value) FROM orders_total WHERE orders_id > \"$twodaysago_last_order_id\" and orders_id <= \"$yesterday_last_order_id\" and class = \"ot_total\"";    
    $result = mysql_query($query) or die("Query failed : " . mysql_error());
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
        foreach ($line as $col_value) {
	    $orders_yesterday=$col_value;
        }
    }
    mysql_free_result($result);

# How many repeat orders today total

    $date = date('Y-m-d');
    $query = "SELECT * FROM orders WHERE date_purchased LIKE \"$date%\" AND customers_id < \"$yesterday_last_order_id\"";
    $result = mysql_query($query) or die("Query failed : " . mysql_error());
    $repeat_orders=0;
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$repeat_orders++;
    }
    mysql_free_result($result);

# Find all repeat orders

    $date = date('Y-m-d');
    $query = "SELECT customers_id FROM orders ORDER by customers_id";
    $result = mysql_query($query) or die("Query failed : " . mysql_error());
    $repeats=0;
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
        foreach ($line as $col_value) {
	    $cust_id=$col_value;
		if ( $cust_id == $cust_id_last ) {
		$repeats++;
		}
	    $cust_id_last=$cust_id;
    	}
    }
    mysql_free_result($result);

// if a profit rate has been entered as part of the URL, use that profit rate, else 30%
    if (isset($HTTP_GET_VARS['profit_rate'])) {
	    $year=$HTTP_GET_VARS['profit_rate'];
    }
    else {
	    $profit_rate=abs(AKTUALIZACJE_DOMYSLNA_MARZA);
    }
    if ($profit_rate=="") {
	    $profit_rate=abs(AKTUALIZACJE_DOMYSLNA_MARZA);
    }

    $profit_rate_display=$profit_rate;
    
// divide profit_rate by 100 to get correct multiplier value
    $profit_rate = $profit_rate / 100;
    
    
# How many per month

// if a year has been entered as part of the URL, use that year instead
    if (isset($HTTP_GET_VARS['year'])) $year=$HTTP_GET_VARS['year'];
      else $year = date('Y'); #current year

    
    $month = date('M'); #current month

    $dec = get_month("12", $year);
    $nov = get_month("11", $year);
    $oct = get_month("10", $year);
    $sep = get_month("09", $year);
    $aug = get_month("08", $year);
    $jul = get_month("07", $year);
    $jun = get_month("06", $year);
    $may = get_month("05", $year);
    $apr = get_month("04", $year);
    $mar = get_month("03", $year);
    $feb = get_month("02", $year);
    $jan = get_month("01", $year);
    $current_month = get_month($mo, $year);


# Only Process Month Info if Month has info to process
# Always tally totals, even if zero

# while ($i < 13)
# (
#   $month_avg = $month_total / $current_month;
#   $current_month_total = get_order_total($i, $year);
#   $order = $order + $current_month_total;
#   )
#   $i++;

$jan_total = get_order_total("01", $year);
if ($jan != 0)   $jan_avg = $jan_total / $jan;
$order = $order + $jan_total;

$feb_total = get_order_total("02", $year);
if ($feb != 0)  $feb_avg = $feb_total / $feb;
$order = $order + $feb_total;

$mar_total = get_order_total("03", $year);
if ($mar != 0)   $mar_avg = $mar_total / $mar;
$order = $order + $mar_total;

$apr_total = get_order_total("04", $year);
if ($apr != 0)   $apr_avg = $apr_total / $apr;
$order = $order + $apr_total;

$may_total = get_order_total("05", $year);
if ($may != 0)   $may_avg = $may_total / $may;
$order = $order + $may_total;

$jun_total = get_order_total("06", $year);
if ($jun != 0)   $jun_avg = $jun_total / $jun;
$order = $order + $jun_total;

$jul_total = get_order_total("07", $year);
if ($jul != 0)   $jul_avg = $jul_total / $jul;
$order = $order + $jul_total;

$aug_total = get_order_total("08", $year);
if ($aug != 0)   $aug_avg = $aug_total / $aug;
$order = $order + $aug_total;

$sep_total = get_order_total("09", $year);
if ($sep != 0)   $sep_avg = $sep_total / $sep;
$order = $order + $sep_total;

$oct_total = get_order_total("10", $year);
if ($oct != 0)   $oct_avg = $oct_total / $oct;
$order = $order + $oct_total;

$nov_total = get_order_total("11", $year);
if ($nov != 0)   $nov_avg = $nov_total / $nov;
$order = $order + $nov_total;

$dec_total = get_order_total("12", $year);
if ($dec != 0)   $dec_avg = $dec_total / $dec;
$order = $order + $dec_total;

$current_month_total = get_order_total($mo, $year);
if ($current_month != 0)   $current_month_avg = $current_month_total / $current_month;


# Daily Averages
if ($today_order_count !=0 ) 	$today_avg = $orders_today / $today_order_count;
  else $today_avg = 0;
if ($yesterday_order_count != 0) $yesterday_avg = $orders_yesterday / $yesterday_order_count;
  else ($yesterday_avg = 0);

$daily = $current_month / $today;
$daily_total = $current_month_total / $today;

if ($daily) $daily_avg = $daily_total / $daily;
  else ($daily_avg = 0);

  
# Calculate days in this month for accurate sales projection

if ( ($mo == 1) OR ($mo == 3) OR ($mo == 5) OR ($mo == 7) OR ($mo == 8) OR ($mo == 10) OR ($mo == 12) )
      $days_this_month = "31";
  elseif ( ($mo == 4) OR ($mo == 6) OR ($mo == 9) OR ($mo == 11) )
           $days_this_month = "30";
           
//calculate Feb end day, including leap year calculation from http://www.mitre.org/tech/cots/LEAPCALC.html
    else {
          if ( ($year % 4) != 0) $days_this_month = "28";
          elseif ( ($year % 400) == 0) $days_this_month = "29";
          elseif ( ($year % 100) == 0) $days_this_month = "28";
              else $days_this_month = "29";
         }

         
# Projected Profits this month
$projected = $daily * $days_this_month;
$projected_total = $daily_total * $days_this_month;

$gross_profit = $grand_total * $profit_rate;

$year_profit = $order * $profit_rate;

If ($newcust != 0) $close_ratio = $today_order_count / $newcust;
  else $close_ratio = 0;

  
# format test into current
        $total_orders = $jan + $feb + $mar + $apr + $may + $jun + $jul + $aug + $sep + $oct + $nov + $dec;
	if ($total_orders != 0)   $total = $order / $total_orders;
	$total = number_format($total,2,'.',',');

	$order = number_format($order,2,'.',',');
	$grand_total = number_format($grand_total,2,'.',',');

    	$gross_profit = number_format($gross_profit,2,'.',',');
    	$year_profit = number_format($year_profit,2,'.',',');

    	$projected = number_format($projected,0,'.',',');
    	$projected_total = number_format($projected_total,2,'.',',');

    	$close_ratio = number_format($close_ratio,2,'.',',');

       	$yesterday_avg = number_format($yesterday_avg,2,'.',',');

	$dec_total_p = number_format(($dec_total*$profit_rate),2,'.',',');
	$nov_total_p = number_format(($nov_total*$profit_rate),2,'.',',');
	$oct_total_p = number_format(($oct_total*$profit_rate),2,'.',',');
	$sep_total_p = number_format(($sep_total*$profit_rate),2,'.',',');
	$aug_total_p = number_format(($aug_total*$profit_rate),2,'.',',');
	$jul_total_p = number_format(($jul_total*$profit_rate),2,'.',',');
	$jun_total_p = number_format(($jun_total*$profit_rate),2,'.',',');
	$may_total_p = number_format(($may_total*$profit_rate),2,'.',',');
	$apr_total_p = number_format(($apr_total*$profit_rate),2,'.',',');
	$mar_total_p = number_format(($mar_total*$profit_rate),2,'.',',');
	$feb_total_p = number_format(($feb_total*$profit_rate),2,'.',',');
	$jan_total_p = number_format(($jan_total*$profit_rate),2,'.',',');

	$dec_total = number_format($dec_total,2,'.',',');
	$nov_total = number_format($nov_total,2,'.',',');
	$oct_total = number_format($oct_total,2,'.',',');
	$sep_total = number_format($sep_total,2,'.',',');
	$aug_total = number_format($aug_total,2,'.',',');
	$jul_total = number_format($jul_total,2,'.',',');
	$jun_total = number_format($jun_total,2,'.',',');
	$may_total = number_format($may_total,2,'.',',');
	$apr_total = number_format($apr_total,2,'.',',');
	$mar_total = number_format($mar_total,2,'.',',');
	$feb_total = number_format($feb_total,2,'.',',');
	$jan_total = number_format($jan_total,2,'.',',');


       	$orders_today = number_format($orders_today,2,'.',',');
       	$orders_yesterday = number_format($orders_yesterday,2,'.',',');

       	$dec_avg = number_format($dec_avg,2,'.',',');
       	$nov_avg = number_format($nov_avg,2,'.',',');
       	$oct_avg = number_format($oct_avg,2,'.',',');
       	$sep_avg = number_format($sep_avg,2,'.',',');
       	$aug_avg = number_format($aug_avg,2,'.',',');
       	$jul_avg = number_format($jul_avg,2,'.',',');
       	$jun_avg = number_format($jun_avg,2,'.',',');
       	$may_avg = number_format($may_avg,2,'.',',');
       	$apr_avg = number_format($apr_avg,2,'.',',');
       	$mar_avg = number_format($mar_avg,2,'.',',');
       	$feb_avg = number_format($feb_avg,2,'.',',');
       	$jan_avg = number_format($jan_avg,2,'.',',');

       	$today_avg = number_format($today_avg,2,'.',',');

if ($total_orders !=0) $shipping_avg = $shipping / $total_orders;
  else $shipping_avg = 0;

       	$shipping_avg = number_format($shipping_avg,2,'.',',');
       	$shipping = number_format($shipping,2,'.',',');

    	$daily = number_format($daily,2,'.',',');
    	$daily_total = number_format($daily_total,2,'.',',');
    	$daily_avg = number_format($daily_avg,2,'.',',');
?>

<CENTER>
<TABLE BORDER=1 CELLPADDING=5 CELLSPACING=1>
<TR class="dataTableHeadingRow" bgcolor=silver><th class="dataTableHeadingContent"><?php echo HEADING_TITLE_DESCRIPTION; ?><th class="dataTableHeadingContent"><?php echo HEADING_TITLE_ORDER_COUNT; ?><th class="dataTableHeadingContent"><?php echo HEADING_TITLE_VALOR; ?><th class="dataTableHeadingContent"><?php echo HEADING_TITLE_AVERAGE; ?></TR>

<TR class="dataTableRow">
  <td class="dataTableContent" align="left"><A href="orders.php?selected_box=customers&status=1"><?php echo HEADING_TITLE_TODAY; ?> <?php echo "$mo-$today"; ?></a></TD><td class="dataTableContent" align="left"><A href="orders.php?selected_box=customers&status=1"><?php echo "$today_order_count ($repeat_orders)"; ?> *</a></TD>
  <td class="dataTableContent" align=right> <?php echo $orders_today ?></TD>
  <td class="dataTableContent" align=right> <?php echo $today_avg ?></TD>
</TR>
<TR class="dataTableRow">
  <td class="dataTableContent"><?php echo HEADING_TITLE_YESTERDAY; ?> <?php echo "$yesterday_month-$yesterday"; ?></TD>
  <td class="dataTableContent"><?php echo $yesterday_order_count ?></TD>
  <td class="dataTableContent" align=right> <?php echo $orders_yesterday ?></TD>
  <td class="dataTableContent" align=right> <?php echo $yesterday_avg ?></TD>
</TR>
<TR class="dataTableRow">
  <td class="dataTableContent"><?php echo HEADING_TITLE_DAILY_AVERAGE; ?> <?php echo $month ?></TD>
  <td class="dataTableContent"><?php echo $daily ?></TD><td class="dataTableContent" align=right> <?php echo $daily_total ?></TD>
  <td class="dataTableContent" align=right> <?php echo $daily_avg ?></TD>
</TR>
<TR class="dataTableRow">
  <td class="dataTableContent"><?php echo HEADING_TITLE_PROJECTION; ?> <?php echo $month ?></TD>
  <td class="dataTableContent"><?php echo $projected ?></TD>
  <td class="dataTableContent" align=right> <?php echo $projected_total ?></TD>
  <td class="dataTableContent" align=right>&nbsp;</TD>
</TR>

<TR class="dataTableHeadingRow" bgcolor=silver><td class="dataTableContent" class="dataTableHeadingContent" COLSPAN=4><b><center><br><span class="WhiteText"><?php echo HEADING_TITLE_MONTH_TOTAL; ?></span></b></center></TD></TR>

<TR>
<TR class="dataTableRow"><td class="dataTableContent" >Sty <?php echo $year ?> </TD><td class="dataTableContent" >  <?php echo $jan ?></TD>
<td class="dataTableContent"  align=right> <?php echo $jan_total ?><br /><span style="color: #999"><?php echo $jan_total_p;?></TD>
<td class="dataTableContent"  align=right> <?php echo $jan_avg ?></TD></TR>

<TR>
<TR class="dataTableRow"><td class="dataTableContent" >Lut <?php echo $year ?> </TD><td class="dataTableContent" > <?php echo $feb ?></TD>
<td class="dataTableContent"  align=right> <?php echo $feb_total ?><br /><span style="color: #999"><?php echo $feb_total_p;?></TD>
<td class="dataTableContent"  align=right> <?php echo $feb_avg ?></TD></TR>

<TR>
<TR class="dataTableRow"><td class="dataTableContent" >Mar <?php echo $year ?> </TD><td class="dataTableContent" > <?php echo $mar ?></TD>
<td class="dataTableContent"  align=right> <?php echo $mar_total ?><br /><span style="color: #999"><?php echo $mar_total_p;?></TD>
<td class="dataTableContent"  align=right> <?php echo $mar_avg ?></TD></TR>

<TR>
<TR class="dataTableRow"><td class="dataTableContent" >Kwi <?php echo $year ?> </TD><td class="dataTableContent" > <?php echo $apr ?></TD>
<td class="dataTableContent"  align=right> <?php echo $apr_total ?><br /><span style="color: #999"><?php echo $apr_total_p;?></TD>
<td class="dataTableContent"  align=right> <?php echo $apr_avg ?></TD></TR>

<TR>
<TR class="dataTableRow"><td class="dataTableContent" >Maj <?php echo $year ?> </TD><td class="dataTableContent" > <?php echo $may ?></TD>
<td class="dataTableContent"  align=right> <?php echo $may_total ?><br /><span style="color: #999"><?php echo $may_total_p;?></TD>
<td class="dataTableContent"  align=right> <?php echo $may_avg ?></TD></TR>

<TR>
<TR class="dataTableRow"><td class="dataTableContent" >Cze <?php echo $year ?> </TD><td class="dataTableContent" > <?php echo $jun ?></TD>
<td class="dataTableContent"  align=right> <?php echo $jun_total ?><br /><span style="color: #999"><?php echo $jun_total_p;?></TD>
<td class="dataTableContent"  align=right> <?php echo $jun_avg ?></TD></TR>

<TR>
<TR class="dataTableRow"><td class="dataTableContent" >Lip <?php echo $year ?> </TD><td class="dataTableContent" > <?php echo $jul ?></TD>
<td class="dataTableContent"  align=right> <?php echo $jul_total ?><br /><span style="color: #999"><?php echo $jul_total_p;?></TD>
<td class="dataTableContent"  align=right> <?php echo $jul_avg ?></TD></TR>

<TR>
<TR class="dataTableRow"><td class="dataTableContent" >Sie <?php echo $year ?> </TD><td class="dataTableContent" > <?php echo $aug ?></TD>
<td class="dataTableContent"  align=right> <?php echo $aug_total ?><br /><span style="color: #999"><?php echo $aug_total_p;?></TD>
<td class="dataTableContent"  align=right> <?php echo $aug_avg ?></TD></TR>

<TR>
<TR class="dataTableRow"><td class="dataTableContent" >Wrz <?php echo $year ?> </TD><td class="dataTableContent" > <?php echo $sep ?></TD>
<td class="dataTableContent"  align=right> <?php echo $sep_total ?><br /><span style="color: #999"><?php echo $sep_total_p;?></TD>
<td class="dataTableContent"  align=right> <?php echo $sep_avg ?></TD></TR>

<TR>
<TR class="dataTableRow"><td class="dataTableContent" >Paz <?php echo $year ?> </TD><td class="dataTableContent" > <?php echo $oct ?></TD>
<td class="dataTableContent"  align=right> <?php echo $oct_total ?><br /><span style="color: #999"><?php echo $oct_total_p;?></TD>
<td class="dataTableContent"  align=right> <?php echo $oct_avg ?></TD></TR>

<TR>
<TR class="dataTableRow"><td class="dataTableContent" >Lis <?php echo $year ?> </TD><td class="dataTableContent" > <?php echo $nov ?></TD>
<td class="dataTableContent"  align=right> <?php echo $nov_total ?><br /><span style="color: #999"><?php echo $nov_total_p;?></TD>
<td class="dataTableContent"  align=right> <?php echo $nov_avg ?></TD></TR>

<TR>
<TR class="dataTableRow"><td class="dataTableContent" >Gru <?php echo $year ?> </TD><td class="dataTableContent" > <?php echo $dec ?></TD>
<td class="dataTableContent"  align=right> <?php echo $dec_total ?><br /><span style="color: #999"><?php echo $dec_total_p;?></TD>
<td class="dataTableContent"  align=right> <?php echo $dec_avg ?></TD></TR>

<TR class="dataTableRow" >
<td class="dataTableContent" NOWRAP><B>Razem <?php echo $year ?> </TD><td class="dataTableContent"><B><?php echo "$total_orders / $repeats"; ?> *</TD><td class="dataTableContent" align=right><B> <?php echo $order ?></TD><td class="dataTableContent" align=right><B> <?php echo $total ?></TD></TR>
<TR class="dataTableRow" ><td class="dataTableContent"><B><?php echo $year ?> Dochód @ <?php echo $profit_rate_display ?>%</TD><td class="dataTableContent" colspan=2 align=right><B> <?php echo $year_profit ?></TD><td class="dataTableContent" align=right>&nbsp;</TD></TR>

<TR valign="bottom"><TD bgcolor=silver colspan=4></TD></TR>
<TR class="dataTableRow" ><td class="dataTableContent"><a href="/admin/customers.php"><?php echo HEADING_TITLE_TOTAL_CUSTOMERS; ?></a></TD><td class="dataTableContent"><?php echo $customer_count ?></TD><td class="dataTableContent"><A href="whos_online.php"><?php echo HEADING_TITLE_TOTAL_CUSTOMERS_ONLINE; ?></a></TD><td class="dataTableContent"><?php echo "$whos_online / $who_again"; ?> *</TD></TR>
<TR class="dataTableRow" ><td class="dataTableContent"><?php echo HEADING_TITLE_NEW_CUSTOMERS_TODAY; ?></TD><td class="dataTableContent"><?php echo $newcust ?></TD><td class="dataTableContent"><?php echo HEADING_TITLE_CLOSE_RATIO; ?></TD><td class="dataTableContent"><?php echo $close_ratio ?>%</TR>

<TR class="dataTableHeadingRow" bgcolor=silver><td class="dataTableContent" class="dataTableHeadingRow" COLSPAN=4><b><center><br><span class="WhiteText"><?php echo HEADING_TITLE_ORDER_STATUS; ?></span></b></center></TD></TR>

<?php
  $orders_status_query = tep_db_query("select orders_status_name, orders_status_id from " . TABLE_ORDERS_STATUS . " where language_id = '" . $languages_id . "'");
  while ($orders_status = tep_db_fetch_array($orders_status_query)) {
    $orders_pending_query = tep_db_query("select count(*) as count from " . TABLE_ORDERS . " where orders_status = '" . $orders_status['orders_status_id'] . "'");
    $orders_pending = tep_db_fetch_array($orders_pending_query);
    $orders_contents .= '<tr class="dataTableRow"><td class="dataTableContent"><a href="' . tep_href_link(FILENAME_ORDERS, 'selected_box=orders&status=' . $orders_status['orders_status_id']) . '">' . $orders_status['orders_status_name'] . '</font></a></td><td class="dataTableContent">' . $orders_pending['count'] . '</td><td class="dataTableContent" colspan="2" align="right">&nbsp;</td></tr>';
  }
//  $orders_contents = substr($orders_contents, 0, -5);
echo $orders_contents;
?>

<TR class="dataTableHeadingRow" bgcolor=silver><td class="dataTableContent" class="dataTableHeadingRow" COLSPAN=4><b><center><br><span class="WhiteText"><?php echo HEADING_TITLE_GRAND_TOTAL; ?></span></b></center></TD></TR>
<TR class="dataTableRow" ><td class="dataTableContent"><B><?php echo HEADING_TITLE_GRAND_TOTAL2; ?></TD><td class="dataTableContent" colspan=2 align=right><B> <?php echo $grand_total ?></TD><td class="dataTableContent" align=right>&nbsp;</TD></TR>
<TR class="dataTableRow" ><td class="dataTableContent"><B><?php echo HEADING_TITLE_GROSS_PROF . $profit_rate_display .'%'; ?></TD><td class="dataTableContent" colspan=2 align=right><B> <?php echo $gross_profit ?></TD><td class="dataTableContent" align=right>&nbsp;</TD></TR>
<TR class="dataTableRow" ><td class="dataTableContent"><B><?php echo HEADING_TITLE_SHI_CHA; ?></TD><td class="dataTableContent" colspan=2 align=right><B> <?php echo $shipping ?></TD><td class="dataTableContent" align=right><B> <?php echo $shipping_avg ?></TD></TR>

</TABLE>

<span class="smallText">
<br>
<?php echo HEADING_TITLE_TEXT_1; ?>
<BR>
<?php echo HEADING_TITLE_TEXT_2; ?></span>


            </td>

          </tr>
        </table></td>
	<td align="left" valign="top" nowrap class="smalltext">
		<table cellspacing="1" cellpadding="5" style="background:#000;">
		<tr class="dataTableHeadingRow">
			<td class="dataTableHeadingContent"	>
			<b>Nowi Klienci</b>
			</td>
		</tr>
		<tr>
			<td align="left" valign="top" nowrap class="smalltext" style="background:#FBFBFB;">
				<table cellspacing="0" cellpadding="3" style="background:#FFF;">

<?php 
		$klienci_query = tep_db_query("SELECT c.customers_id, c.customers_firstname, c.customers_lastname, c.customers_email_address, ci.customers_info_date_account_created as date_created from ".TABLE_CUSTOMERS." c, ".TABLE_CUSTOMERS_INFO." ci where c.customers_id = ci.customers_info_id and c.purchased_without_account = '0' and TO_DAYS(NOW()) - TO_DAYS(ci.customers_info_date_account_created) <= 3 order by c.customers_id DESC");
		$row=0;
		$czas0 = date("Y-m-d");
		while($klienci = tep_db_fetch_array($klienci_query)) {
			$czas1 = substr($klienci['date_created'], 0, 10);
			echo '<tr style="background:#FBFBFB;"><td class="smalltext" >'.$klienci['customers_id'].' . <a href="'.tep_href_link(FILENAME_CUSTOMERS,'actions=edit&cID='.$klienci['customers_id'].'&action=edit').'"'.(($czas0==$czas1)?' style="color: green; font-weight:bold;"':'').'>' . $klienci['customers_firstname'].' '.$klienci['customers_lastname'].'</a></td><td class="smalltext"> ['.$klienci['date_created'].']</td></tr>';

		}
?>
				</table>
			</td>
		</tr>
		<tr class="dataTableHeadingRow">
			<td class="dataTableHeadingContent"	>
			<b>Nowe Zamówienia</b>
			</td>
		</tr>
		<tr>
			<td align="left" valign="top" nowrap class="smalltext" style="background:#FBFBFB;">
				<table cellspacing="0" cellpadding="3" style="background:#FFF;">

<?php 
		$zamowienia_query = tep_db_query("SELECT o.orders_id, o.customers_id, o.customers_name, o.date_purchased as date_created, o.purchased_without_account, ot.value from ".TABLE_ORDERS." o, ".TABLE_ORDERS_TOTAL." ot where o.orders_id = ot.orders_id and TO_DAYS(NOW()) - TO_DAYS(o.date_purchased) <= 3 and ot.class = 'ot_total' order by o.orders_id DESC");
		$row=0;
		$czas0 = date("Y-m-d");

		while($zamowienia = tep_db_fetch_array($zamowienia_query)) {
			$query = tep_db_query("SELECT count(orders_id) as zamowienia FROM ".TABLE_ORDERS." WHERE customers_id = '".(int)$zamowienia['customers_id']."'");
			$result = tep_db_fetch_array($query);
			$czas1 = substr($zamowienia['date_created'], 0, 10);
			echo '<tr style="background:#FBFBFB;"><td class="smalltext" >'.$zamowienia['orders_id'].' . <a href="'.tep_href_link(FILENAME_ORDERS,'oID='.$zamowienia['orders_id'].'&action=edit').'"'.(($czas0==$czas1)?' style="color: green; font-weight:bold;"':'').'>['.$result['zamowienia'].'] ' . $zamowienia['customers_name'].'</a></td><td class="smalltext"> ['.$zamowienia['date_created'].'] <b>'.$currencies->format($zamowienia['value'], false).'</b></td></tr>';

		}
?>
				</table>
			</td>
		</tr>

		<tr class="dataTableHeadingRow">
			<td class="dataTableHeadingContent"	>
			<b>Do zamówienia:</b>
			</td>
		</tr>
		<tr>
			<td align="left" valign="top" nowrap class="smalltext" style="background:#FBFBFB;">
				<table cellspacing="0" cellpadding="3" style="background:#FFF;">
<div id="dhtmltooltip" class="smallText"></div>

<script type="text/javascript">

/***********************************************
* Cool DHTML tooltip script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

var offsetxpoint=-60 //Customize x offset of tooltip
var offsetypoint=20 //Customize y offset of tooltip
var ie=document.all
var ns6=document.getElementById && !document.all
var enabletip=false
if (ie||ns6)
var tipobj=document.all? document.all["dhtmltooltip"] : document.getElementById? document.getElementById("dhtmltooltip") : ""

function ietruebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function ddrivetip(thetext, thecolor, thewidth){
if (ns6||ie){
if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px"
if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor
tipobj.innerHTML=thetext
enabletip=true
return false
}
}

function positiontip(e){
if (enabletip){
var curX=(ns6)?e.pageX : event.clientX+ietruebody().scrollLeft;
var curY=(ns6)?e.pageY : event.clientY+ietruebody().scrollTop;
//Find out how close the mouse is to the corner of the window
var rightedge=ie&&!window.opera? ietruebody().clientWidth-event.clientX-offsetxpoint : window.innerWidth-e.clientX-offsetxpoint-20
var bottomedge=ie&&!window.opera? ietruebody().clientHeight-event.clientY-offsetypoint : window.innerHeight-e.clientY-offsetypoint-20

var leftedge=(offsetxpoint<0)? offsetxpoint*(-1) : -1000

//if the horizontal distance isn't enough to accomodate the width of the context menu
if (rightedge<tipobj.offsetWidth)
//move the horizontal position of the menu to the left by it's width
tipobj.style.left=ie? ietruebody().scrollLeft+event.clientX-tipobj.offsetWidth+"px" : window.pageXOffset+e.clientX-tipobj.offsetWidth+"px"
else if (curX<leftedge)
tipobj.style.left="5px"
else
//position the horizontal position of the menu where the mouse is positioned
tipobj.style.left=curX+offsetxpoint+"px"

//same concept with the vertical position
if (bottomedge<tipobj.offsetHeight)
tipobj.style.top=ie? ietruebody().scrollTop+event.clientY-tipobj.offsetHeight-offsetypoint+"px" : window.pageYOffset+e.clientY-tipobj.offsetHeight-offsetypoint+"px"
else
tipobj.style.top=curY+offsetypoint+"px"
tipobj.style.visibility="visible"
}
}

function hideddrivetip(){
if (ns6||ie){
enabletip=false
tipobj.style.visibility="hidden"
tipobj.style.left="-1000px"
tipobj.style.backgroundColor='white'
tipobj.style.width='390'
}
}

document.onmousemove=positiontip

</script>
<?php 

	    $date = date('Y-m-d'); #2003-09-07%

		$zamowienia_query = tep_db_query("SELECT o.orders_id, o.date_purchased as date_created, o.purchased_without_account, op.products_id, op.products_name, op.products_model, op.products_price, op.products_tax, op.products_quantity from ".TABLE_ORDERS." o,  ".TABLE_ORDERS_PRODUCTS." op where o.orders_status = '".DEFAULT_ORDERS_STATUS_ID."' AND o.orders_id = op.orders_id and (TO_DAYS(now()) - TO_DAYS(o.date_purchased)) < 7 order by op.products_name ASC");
		$row=0;
		$czas0 = date("Y-m-d");

###########
# status
    $products_statuses[] = array('id' => '0',
                               'text' => 'nowe');
    $products_statuses[] = array('id' => '1',
                               'text' => 'zamowione');
#
###########
		$zamowien = array();
		$sumy['wartosc'] = 0;
		$sumy['sztuk'] = 0;
		$sumy['produktow'] =0;

	while($zamowienia = tep_db_fetch_array($zamowienia_query)) {
			$czas1 = substr($zamowienia['date_created'], 0, 10);
		
		if(!in_array($zamowienia['orders_id'],$zamowien)) {
			$zamowien [] = $zamowienia['orders_id'];
		}
###########
# kategoria
		$query = tep_db_query("SELECT cd.categories_name, cd.categories_id FROM ".TABLE_CATEGORIES_DESCRIPTION." cd LEFT JOIN ".TABLE_PRODUCTS_TO_CATEGORIES." ptc on cd.categories_id = ptc.categories_id WHERE ptc.products_id = '".(int)$zamowienia['products_id']."' and language_id = '" . (int)$languages_id . "' LIMIT 1");
		$results = tep_db_fetch_array($query);
		$kategoria = tep_output_generated_category_path($results['categories_id']);
		// zmiana nazwy kategorii
		$kategoria = str_replace('"','``',$kategoria);
# kategoria
###########
# status

	switch($zamowienia['products_status']) {
		case '0':
			$status = tep_draw_pull_down_menu($zamowienia['products_id'].'_'.$zamowienia['orders_id'], $products_statuses, $zamowienia['products_status'], 'style=" font-size: 8px; border: 1px solid #CCC; width: 45px"');
		case '1':
			$status = tep_draw_pull_down_menu($zamowienia['products_id'].'_'.$zamowienia['orders_id'], $products_statuses, $zamowienia['products_status'], 'style=" font-size: 8px; border: 1px solid #CCC; width: 45px"' );
		default:
			$status = tep_draw_pull_down_menu($zamowienia['products_id'].'_'.$zamowienia['orders_id'], $products_statuses, $zamowienia['products_status'], 'style=" font-size: 8px; border: 1px solid #CCC; width:45px"' );
	}
# status
###########
# dane

	$query = tep_db_query("SELECT products_status, products_price, products_tax_class_id as tax_id, products_quantity, products_date_available FROM ".TABLE_PRODUCTS." WHERE products_id = '".(int)$zamowienia['products_id']."'");
	$result = tep_db_fetch_array($query);

	if ( $result['products_quantity'] > 0) {
		$mag = ' ' . '<img src=images/icons/icon_status_green.gif>';
	} else if (($result['products_quantity'] <1) && ($result['products_date_available'] > date('Y-m-d H:i:s'))) {
		$mag = ' ' . '<img src=images/icons/icon_status_yellow.gif>';	
	} else if (($result['products_quantity'] <1) && (!tep_not_null($result['products_date_available']))) {
		$mag = ' ' . '<img src=images/icons/icon_status_red.gif>';	
	} else {
		$mag = ' ' . '<img src=images/icons/icon_status_red_light.gif>';	
	}

	if($result['products_status'] == '0') {
		$obr = '<img src=images/icons/icon_status_blue.gif>'.$mag;
	} else {
		$obr = $mag;	
	}

	$dane = ' '. $obr . ' ' . $currencies->display_price($result['products_price'],'22');

#
###########
#

#
###########
# link

	$link = '<a href="'.tep_href_link(FILENAME_CATEGORIES,'pID='.$zamowienia['products_id'].'&action=new_product').'"'.(($czas0==$czas1)?' ':'').'" title="['.$zamowienia['date_created'].']" onMouseover="ddrivetip(\''.(($zamowienia['purchased_without_account']=='1')?'<img src=images/icons/unlocked.gif>':'<img src=images/icons/locked.gif>').$zamowienia['date_created'].$dane.'<br>'.$kategoria.'\')"; onMouseout="hideddrivetip()">[' . $zamowienia['products_model'].'] '.$zamowienia['products_name'].'</a>';
#
###########
#


			echo '<tr style="background:#FBFBFB;"><td style="font-family: Tahoma; font-size: 9px;" NOWRAP>'. 
				$obr . ' ' .// stan produktu
				'<a href="'.tep_href_link(FILENAME_ORDERS,'oID='.$zamowienia['orders_id'].'&action=edit').'">'. $zamowienia['orders_id'].'</a> '. // id zamowienia z linkiem do edycji
## BOF: eskulap - wy³aczone pokazywanie statusu
//				$status .' '. // status produktu w zamowieniu
## EOF: eskulap - wy³aczone pokazywanie statusu
				$link . ''. // ;ink do edycji produktu
				'</td><td  style="font-family: Tahoma; font-size: 9px;" NOWRAP align="right"><b>'.
				$zamowienia['products_quantity'].' x '.$currencies->display_price($zamowienia['products_price'], $zamowienia['products_tax']).'</b></td></tr>';

## dodawanie danych do podsumowania
		$sumy['wartosc'] += ($zamowienia['products_price'] * ((100+$zamowienia['products_tax'])/100));
		$sumy['sztuk'] += $zamowienia['products_quantity'];
		$sumy['produktow'] += 1;
		}

?>
				</table>
			<br />
<?php
		echo 'Zamówienia: '. sizeof($zamowien).'<br />';
		echo 'Wartosc: <b>' . $currencies->format($sumy['wartosc'], false) .'</b><br />';
		echo 'Sztuk: ' . $sumy['sztuk'].'<br />';
		echo 'Produktów: ' . $sumy['produktow'].'<br />';
?>
			<br />
<?php
// legenda
	$leg = '<div style="color: #999;">Legenda: <br />';
	$leg .= '<img src=images/icons/icon_status_green.gif>'. ' - dostepne<br />';
	$leg .= '<img src=images/icons/icon_status_yellow.gif>'. ' - w zapowiedziach, brak na magazynie<br />';
	$leg .= '<img src=images/icons/icon_status_red_light.gif>'.' - brak na magazynie<br />';
	$leg .= '<img src=images/icons/icon_status_red.gif>'.' - brak na magazynie, czas realizacji nieznany<br />';
	$leg .= '<img src=images/icons/icon_status_blue.gif>'.' - produkt wy³aczony z oferty<br />';
	$leg .= '</div>';

	echo $leg;
?><br />
			</td>
		</tr>

		</table>
	</td>	
      </tr>
    </table></td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>

<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
</body>
</html>
