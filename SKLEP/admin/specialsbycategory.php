<?php
/*
  $Id: specialsbycategory.php,v 1.4 2005/06/29 23:03:00 calimeross Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2005 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
  <title><?php echo HEADING_TITLE; ?></title>
  <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
  <script language="javascript" src="includes/general.js"></script>
</head>
<body bgcolor="#FFFFFF" onload="SetFocus();">

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
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
		</td>

  <td valign="top">

<!----------------------- Actual code for Specials Admin starts here ------------------------->
<?php
  //Fetch all variables
  $fullprice = (isset($_GET['fullprice']) ? $_GET['fullprice'] : '');
  $productid = (isset($_GET['productid']) ? (int)$_GET['productid'] : '0');
  $inputupdate = (isset($_GET['inputupdate']) ? $_GET['inputupdate'] : '');
  $categories = (isset($_GET['categories']) ? (int)$_GET['categories'] : '0');
  
  //BoF Added v1.4
  $manufacturer = (isset($_GET['manufacturer']) ? (int)$_GET['manufacturer'] : '0');
  if ($manufacturer) {
  	$man_filter = " and manufacturers_id = '$manufacturer' ";
  } else {
    $man_filter = ' ';
  }
  //EoF Added v1.4
  
  if (array_key_exists('discount',$_GET)) {
  	if (is_numeric($_GET['discount'])) {
  	  $discount = (float)$_GET['discount'];
    } else {
  	  $discount = -1;    	
    }
  } else { 
  	$discount = -1;
  }

  if ($fullprice == 'yes')
    tep_db_query("DELETE FROM " . TABLE_SPECIALS . " WHERE products_id=$productid;");
  else if($inputupdate == "yes"){
    $inputspecialprice = (isset($_GET['inputspecialprice']) ? $_GET['inputspecialprice'] : '');
    if (substr($inputspecialprice, -1) == '%') {
      $productprice = (isset($_GET['productprice']) ? (float)$_GET['productprice'] : '');
      $specialprice = ($productprice - (($inputspecialprice / 100) * $productprice));
    } else if (substr($inputspecialprice, -1) == 'i') {
      $taxrate = (isset($_GET['taxrate']) ? (float)$_GET['taxrate'] : '1');
      $productprice = (isset($_GET['productprice']) ? (float)$_GET['productprice'] : '');
      $specialprice = ($inputspecialprice /(($taxrate/100)+1));
    } else {
     	$specialprice = $inputspecialprice;
    }
    $alreadyspecial = tep_db_query ("SELECT * FROM " . TABLE_SPECIALS . " WHERE products_id=$productid");
    $specialproduct= tep_db_fetch_array($alreadyspecial);
    if ($specialproduct["specials_id"]){
      //print ("Database updated. Status:".$specialproduct["status"]);
      tep_db_query ("UPDATE " . TABLE_SPECIALS . " SET specials_new_products_price='$specialprice' where products_id=$productid  "); 
    } else{
      //print("New product added to specials table");
      $today = date("Y-m-d H:i:s");
// Fix v1.3 - spell out columns so this also works when columns have been added to the specials table.
// Fix v1.4 - set default expiration date to '0' and last modified to $today.
//      tep_db_query ("INSERT INTO " . TABLE_SPECIALS . " VALUES ('','$productid','$specialprice','$today','','','','1')");
      tep_db_query ("INSERT INTO " . TABLE_SPECIALS . " (specials_id, products_id, specials_new_products_price, specials_date_added, specials_last_modified, expires_date, date_status_change, status ) VALUES ('','$productid','$specialprice','$today','$today','0','','1')");
    }
  }
?>
<br>
<form action="<?php echo $current_page; ?>" method="get">
<table width="100%"><tr class="dataTableHeadingRow"><td class="dataTableHeadingContent" colspan="6">
<?php
  echo TEXT_SELECT_CAT .'&nbsp;' . tep_draw_pull_down_menu('categories', tep_get_category_tree(), $categories);

  //BoF Added v1.4 allow selection by manufacturer
  $manufacturers_array = array(array('id' => '', 'text' => TEXT_NONE));
  $manufacturers_query = tep_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS . " order by manufacturers_name");
  while ($manufacturers = tep_db_fetch_array($manufacturers_query)) {
    $manufacturers_array[] = array('id' => $manufacturers['manufacturers_id'],
                                 'text' => $manufacturers['manufacturers_name']);
  }
  echo TEXT_SELECT_MAN . '&nbsp;' . tep_draw_pull_down_menu('manufacturer',$manufacturers_array, $manufacturer) .'&nbsp;&nbsp;&nbsp;' ;
  //EoF Added v1.4

  echo TEXT_ENTER_DISCOUNT . ':&nbsp; ';
?>
<input type="text" size="4" name="discount" value="<?php 
  if ($discount > 0) { echo $discount; }
  echo '">' . TEXT_PCT_AND . '&nbsp;'; 
  
?>
  
  
<input type="submit" value="<?php echo TEXT_BUTTON_SUBMIT.'">'.tep_hide_session_id();?>
</form></td></tr>
<tr class="dataTableContent"><td class="dataTableContent" colspan="6">
<br>
<ul><li><?php echo TEXT_INSTRUCT_1; ?></li>
<li><?php echo TEXT_INSTRUCT_2; ?></li>
</ul>
<br>
</td></tr>
<?
  if ($discount == -1) {
  	//echo 'do nothing';
  } else if ($discount == 0) {
  	//BoF Changed v1.4 
  	if ($categories) {
      $result2 = tep_db_query("select p.products_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . 
                              " ptc where p.products_id=ptc.products_id and ptc.categories_id=$categories" . $man_filter);
    } else {
      $result2 = tep_db_query("select p.products_id from " . TABLE_PRODUCTS . " p where 1=1" . $man_filter);
    }
  	//EoF Changed v1.4 

    while ( $row = tep_db_fetch_array($result2) ){
      $allrows[] = $row["products_id"];
    }
    tep_db_query("DELETE FROM " . TABLE_SPECIALS . " WHERE products_id in ('".implode("','",$allrows)."')");
  } else if ($discount > 0) {  
    $specialprice = $discount / 100;
    
  	//BoF Changed v1.4 
  	if ($categories) {
      $result2 = tep_db_query("select p.products_id, p.products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . 
                              " ptc where p.products_id=ptc.products_id and ptc.categories_id=$categories" . $man_filter);
    } else {
    	$result2 = tep_db_query("select p.products_id, p.products_price from " . TABLE_PRODUCTS . " p where 1=1 " . $man_filter);
    }
  	//EoF Changed v1.4 

    while ( $row = tep_db_fetch_array($result2) ){
      $hello2 = $row["products_price"];
      $hello3 = $hello2 * $specialprice;
      $hello4 = $hello2 - $hello3;
      $number = $row["products_id"];
      $result3 = tep_db_query("select * from " . TABLE_SPECIALS . " where products_id = $number");
      $num_rows = tep_db_num_rows($result3);
      if ($num_rows == 0){
      	//echo "Insert into specials (products_id, specials_new_products_price) values ($number, '$hello4')"; 
        //Fix v1.4 set default expiration date to '0' and status active.
        //tep_db_query("Insert into " . TABLE_SPECIALS . " (products_id, specials_new_products_price) values ($number, '$hello4')");
        tep_db_query ("INSERT INTO " . TABLE_SPECIALS . " (products_id, specials_new_products_price, specials_date_added, specials_last_modified, expires_date, date_status_change, status ) VALUES ('$number','$hello4','$today','$today','0','','1')");
      } else {
        //echo "Update specials set specials_new_products_price='$hello4' where products_id=$number";
        tep_db_query ("Update " . TABLE_SPECIALS . " set specials_new_products_price='$hello4' where products_id=$number");
      }
    }
  }
  print ("
            <tr class=\"dataTableHeadingRow\">
            <td class=\"dataTableHeadingContent\">". TABLE_HEADING_PRODUCTS ."</td>
            <td class=\"dataTableHeadingContent\">" . TABLE_HEADING_PRODUCTS_PRICE ."</td>
            <td class=\"dataTableHeadingContent\">" . TABLE_HEADING_SPECIAL_PRICE ."</td>
            <td class=\"dataTableHeadingContent\">" . TABLE_HEADING_PCT_OFF ."</td>
            <td class=\"dataTableHeadingContent\">" . TABLE_HEADING_FULL_PRICE . "</td>
            <td class=\"dataTableHeadingContent\">" . TABLE_HEADING_ACTION . "</td>
            </tr>");

  //BoF Changed v1.4             
  if ($categories) {
  	$result2 = tep_db_query("SELECT * FROM " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . 
                          " ptc, " . TABLE_PRODUCTS . " p where pd.products_id=ptc.products_id and p.products_id=ptc.products_id 
               and ptc.categories_id = $categories and pd.language_id = " .(int)$languages_id . $man_filter . " order by pd.products_name asc ");
  } else if ($manufacturer) {
  	$result2 = tep_db_query("SELECT * FROM " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p where pd.products_id=p.products_id 
               and pd.language_id = " .(int)$languages_id . $man_filter . " order by pd.products_name asc ");
  } else {
  	$result2 = tep_db_query("SELECT * FROM " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . 
                          " ptc, " . TABLE_PRODUCTS . " p where pd.products_id=ptc.products_id and p.products_id=ptc.products_id 
               and ptc.categories_id = $categories and pd.language_id = " .(int)$languages_id . $man_filter . " order by pd.products_name asc ");  	
  }
 	//EoF Changed v1.4 

  while ( $row = tep_db_fetch_array($result2) ) {
    $number = $row["products_id"];
    $result3 = tep_db_query("SELECT * FROM " . TABLE_SPECIALS . " where products_id=$number");
    $num_rows = tep_db_num_rows($result3);
    if ($num_rows == 0) {
      $specialprice = "none";
      $implieddiscount = '';
    } else {
      while ( $row2 = tep_db_fetch_array($result3) ) {
        $specialprice = $row2["specials_new_products_price"];
        if ($row["products_price"] > 0) {
          $implieddiscount = '-'.(int)(100-(($specialprice / $row["products_price"])*100)).'%';
        } else {
        	$implieddiscount = '';
        }
      }
     }
    $tax_rate = tep_get_tax_rate($row['products_tax_class_id']);

    print("<form action=\"$current_page\" method=\"get\">");
    print("
    <tr class=\"dataTableRow\" onmouseover=\"rowOverEffect(this)\" onmouseout=\"rowOutEffect(this)\" >
    <td class=\"dataTableContent\">" . $row["products_name"] . "</td>
    <td class=\"dataTableContent\">" . $row["products_price"] . "</td>
    <td class=\"dataTableContent\"><input name=\"inputspecialprice\" type=\"text\" value=\"$specialprice\"></td>
    <td class=\"dataTableContent\">$implieddiscount </td>
    <td class=\"dataTableContent\"><input type=\"checkbox\" name=\"fullprice\" value=\"yes\"></td>
    <td class=\"dataTableContent\"><input type=\"hidden\" name=\"categories\" value=\"" . $categories ."\">
    <input type=\"hidden\" name=\"productprice\" value=\"" . $row["products_price"] . "\">
    <input type=\"hidden\" name=\"taxrate\" value=\"" . $tax_rate . "\">    
    <input type=\"hidden\" name=\"productid\" value=\"" . $row["products_id"] . "\">
    <input type=\"hidden\" name=\"inputupdate\" value=\"yes\">
    <input type=\"submit\" value=\"" . TEXT_BUTTON_UPDATE . "\"></td></tr>".tep_hide_session_id()."</form>");
  }
  print ("</table>");
?>
<!------------------------ Code for Specials Admin ends here --------------------------->
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
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
