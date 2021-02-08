<?php 

define('SHOW_QUANTITY',false); // true - show, false - hide quantity 
define('SHOW_MARKED_OUT_STOCK',false); // show marked out of stock (true - show, false - hide) 
//define('TAX_INCREASE', 22); // 0 - No increase, 1 - Add 1%, 5 - Add 5%, Any number - add number% 
define('SHOW_MODEL',false); // true - show model, false - hide model 

$czas = date("Y-m-d");
$aNow = localtime();
		$godzina =  $aNow[2]; 
		$minuta = $aNow[1]; $minuta = (($minuta<10)?'0'.$minuta:$minuta);
		$sekunda = $aNow[0]; $sekunda = (($sekunda<10)?'0'.$sekunda:$sekunda);
$data = $czas." ".$godzina.":".$minuta.":".$sekunda;
$czas = $godzina.":".$minuta.":".$sekunda;

require('includes/application_top.php'); 
// the following cPath references come from application_top.php 
$category_depth = 'top'; 
if (isset($cPath) && tep_not_null($cPath)) { 
$categories_products_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " where categories_id = '" . (int)$current_category_id . "'"); 
$cateqories_products = tep_db_fetch_array($categories_products_query); 
if ($cateqories_products['total'] > 0) { 
$category_depth = 'products'; // display products 
} else { 
$category_parent_query = tep_db_query("select count(*) as total from " . TABLE_CATEGORIES . " c where parent_id = '" . (int)$current_category_id . "'"); 
$category_parent = tep_db_fetch_array($category_parent_query); 
if ($category_parent['total'] > 0) { 
$category_depth = 'nested'; // navigate through the categories 
} else { 
$category_depth = 'products'; // category has no products, but display the 'no products' message 
} 
} 
} 
require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CENNIK); 
$breadcrumb->add(TITLE_PRICE, tep_href_link(FILENAME_CENNIK, '', 'SSL')); 
?> 
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>"> 
<title><?php echo HEADING_TITLE . ' - ' . TITLE; ?></title> 
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>"> 
<link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_TEMPLATES . $template . $language . '/stylesheet.css';?>">
</head> 

<body>
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<?php include('includes/body.php'); ?>
    <td width="100%" valign="top">
	
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php
			$info_box_contents = array();
			$info_box_contents[] = array('text' => HEADING_TITLE);
			new infoBoxHeading($info_box_contents, true, true);
	  ?></td>
      </tr>
	</table>

	<table border="0" width="100%" cellspacing="0" cellpadding="0" class="blrb">
<tr><td class="smallText"><br />[<?php echo 'Cennik wygenerowano: ' .strftime(DATE_FORMAT_LONG).' '.$czas; ?>]</td></tr>
<tr> 
<td class="clear"> 
<?php 
// cennik poczatek 
// group have products? 
function check_products($id_group){ 
$products_price_query = tep_db_query("select products_to_categories.products_id FROM products_to_categories where products_to_categories.categories_id = " . (int)$id_group . " LIMIT 0,1"); 
if($products_price = tep_db_fetch_array($products_price_query)){ 
return true; 
} 
return false; 
} 

// list products determined group 
function get_products($id_group){ 
	global $currencies, $languages_id;
$query = ""; 
if(!SHOW_MARKED_OUT_STOCK){ 
$query = " AND p.products_status =1"; 
} 
$products_price_query = tep_db_query("select pd.products_name, p.products_quantity, p.products_price, p.products_model, p.products_tax_class_id, ptc.products_id, ptc.categories_id FROM ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd, ".TABLE_PRODUCTS_TO_CATEGORIES." ptc WHERE p.products_id = pd.products_id " . $query . " and p.products_id = ptc.products_id and ptc.categories_id = '" . (int)$id_group . "' AND pd.language_id='" . (int)$languages_id . "' order by pd.products_name"); 
$x=0; 
while ($products_price = tep_db_fetch_array($products_price_query)){ 
$spec=$cell = tep_get_products_special_price($products_price['products_id']); 

if($cell == 0) 
	$cell = $products_price['products_price']; 
if($x==1) { 
	$y=1;
	$x = 0; 
}else{ 
	$y=2;
	$x++; 
} 
$quantity = ""; 
$model = ""; 
if(SHOW_QUANTITY) 
	$quantity = "<td width=\"90\" align=\"right\" class=\"pd2p\">(".$products_price['products_quantity'].")</td>"; 
if(SHOW_MODEL) 
	$model = "<td width=\"90\" align=\"right\" class=\"pd2p\">[".$products_price['products_model']."]</td>"; 
print "<tr class=\"".(($y==1)?'pd2p':'pd2po')."\">".$model."<td width=\"1000\" class=\"pd2p\">&nbsp;&nbsp;&nbsp;<a href=\"" . tep_href_link(FILENAME_PRODUCT_INFO, "products_id=" . $products_price['products_id']) . "\" class=\"inv\">".str_replace('& ','&amp; ',$products_price['products_name'])."</a></td>".$quantity."<td width=\"85\" align=\"right\" ".(($spec==0)?'':'style="color: red; font-weight:bold;"').">".$currencies->display_price_nodiscount($cell,tep_get_tax_rate($products_price['products_tax_class_id']))."</td></tr>"; 
} 
} 


// get all groups 
function get_group($id_parent,$position){ 
	global $languages_id;
$groups_price_query = tep_db_query("select c.categories_id, cd.categories_name from ".TABLE_CATEGORIES." c, ".TABLE_CATEGORIES_DESCRIPTION." cd where c.categories_id = cd.categories_id and c.parent_id = ".$id_parent." AND cd.language_id=".$languages_id." order by cd.categories_name, c.sort_order"); 
while ($groups_price = tep_db_fetch_array($groups_price_query)){ 
$str = ""; 
for($i = 0; $i < $position; $i++){ 
$str = $str . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; 
} 
$class = "cennik"; 
if($position == 0) { 
$class = "hN2c"; 
print "<tr ><td colspan=\"4\" width=\"1000\" class=\"pd2p\">&nbsp;</td></tr>"; // 
} 
if(check_products($groups_price['categories_id']) || $position == 0){ 
print "<tr><td colspan=\"4\" width=\"1000\" class=\"".$class."\"><strong>&nbsp;".$str.$groups_price['categories_name']."</strong></td></tr>"."\n"; 
get_products($groups_price['categories_id']); 
} 
get_group($groups_price['categories_id'],$position+1); // 
} 
} 
?> 
<table width="100%" border="0" cellspacing="1" cellpadding="0"> 
<?php 
get_group(0,0); 
?> 
</table> 
</td> 
</tr> 
      <tr>
        <td class="clear"><BR /><BR /><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
				<td class="main" align="left"><?php echo '<a href="javascript:history.back()">' . tep_image_button('button_back.gif', IMAGE_BUTTON_CONTINUE_SHOPPING) . '</a>'; ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
<?php include('includes/footer_1.php'); ?>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>