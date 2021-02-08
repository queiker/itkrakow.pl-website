<?php
/*
  $Id: shopping_cart.php,v 1.73 2003/06/09 23:03:56 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require("includes/application_top.php");

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_SHOPPING_CART);
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_PRODUCT_INFO);
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_WISHLIST);

/*******************************************************************
******* ADD PRODUCT TO WISHLIST IF PRODUCT ID IS REGISTERED ********
*******************************************************************/

  if(tep_session_is_registered('wishlist_id')) {
	$wishList->add_wishlist($wishlist_id, $attributes_id);

	if(WISHLIST_REDIRECT == 'Yes') {
		tep_redirect(tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$wishlist_id));
	} else {
		tep_session_unregister('wishlist_id');
	}
  }


/*******************************************************************
****************** ADD PRODUCT TO SHOPPING CART ********************
*******************************************************************/

  if (isset($HTTP_POST_VARS['add_wishprod'])) {

//	if(isset($HTTP_POST_VARS['add_prod_x'])) {

		foreach ($HTTP_POST_VARS['add_wishprod'] as $value) {

			$product_id = tep_get_prid($value);
			$cart->add_cart($product_id, $cart->get_quantity(tep_get_uprid($product_id, $HTTP_POST_VARS['id'][$value]))+1, $HTTP_POST_VARS['id'][$value]);
		}
//	}
  }


/*******************************************************************
****************** DELETE PRODUCT FROM WISHLIST ********************
*******************************************************************/

  if (isset($HTTP_POST_VARS['add_wishprod'])) {
	if(isset($HTTP_POST_VARS['delete_prod_x'])) {
		foreach ($HTTP_POST_VARS['add_wishprod'] as $value) {
			$wishList->remove($value);
		}
	}
  }


/*******************************************************************
************* EMAIL THE WISHLIST TO MULTIPLE FRIENDS ***************
*******************************************************************/

  if (isset($HTTP_POST_VARS['email_prod_x'])) {

		$errors = false;
		$guest_errors = "";
		$email_errors = "";
		$message_error = "";

		if(strlen($HTTP_POST_VARS['message']) < '1') {
			$error = true;
			$message_error .= "<div class=\"messageStackError\"><img src=\"images/icons/error.gif\" /> " . ERROR_MESSAGE . "</div>";
		}			

  		if(tep_session_is_registered('customer_id')) {
			$customer_query = tep_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$customer_id . "'");
	  		$customer = tep_db_fetch_array($customer_query);
	
			$from_name = $customer['customers_firstname'] . ' ' . $customer['customers_lastname'];
			$from_email = $customer['customers_email_address'];
			$subject = $customer['customers_firstname'] . ' ' . WISHLIST_EMAIL_SUBJECT;
			$link = HTTP_SERVER . DIR_WS_CATALOG . FILENAME_WISHLIST_PUBLIC . "?public_id=" . $customer_id;
	
		//REPLACE VARIABLES FROM DEFINE
			$arr1 = array('$from_name', '$link');
			$arr2 = array($from_name, $link);
			$replace = str_replace($arr1, $arr2, WISHLIST_EMAIL_LINK);
			$message = tep_db_prepare_input($HTTP_POST_VARS['message']);
			$body = $message . $replace;
		} else {
			if(strlen($_POST['your_name']) < '1') {
				$error = true;
				$guest_errors .= "<div class=\"messageStackError\"><img src=\"images/icons/error.gif\" /> " . ERROR_YOUR_NAME . "</div>";
			}
			if(strlen($_POST['your_email']) < '1') {
				$error = true;
				$guest_errors .= "<div class=\"messageStackError\"><img src=\"images/icons/error.gif\" /> " .ERROR_YOUR_EMAIL . "</div>";
			} elseif(!tep_validate_email($_POST['your_email'])) {
				$error = true;
				$guest_errors .= "<div class=\"messageStackError\"><img src=\"images/icons/error.gif\" /> " . ERROR_VALID_EMAIL . "</div>";
			}

			$from_name = stripslashes($_POST['your_name']);
			$from_email = $_POST['your_email'];
			$subject = $from_name . ' ' . WISHLIST_EMAIL_SUBJECT;
			$message = stripslashes($HTTP_POST_VARS['message']);

			$z = 0;
			$prods = "";
			foreach($HTTP_POST_VARS['prod_name'] as $name) {
				$prods .= stripslashes($name) . "  " . stripslashes($HTTP_POST_VARS['prod_att'][$z]) . "\n" . $HTTP_POST_VARS['prod_link'][$z] . "\n\n";
				$z++;
			}
			$body = $message . "\n\n" . $prods . "\n\n" . WISHLIST_EMAIL_GUEST;
	  	}

		//Check each posted name => email for errors.
		$j = 0;

		if(isset($HTTP_POST_VARS['friend'])) {
		foreach($HTTP_POST_VARS['friend'] as $friendx) {
	         // secure post
	        $friendx = tep_db_prepare_input(strip_tags($friendx));

	        if($j == 0) {
	            $friend = $_POST['friend'];
                      
	            // secure posts
	           $x = 0;
	           foreach ($friend as $value) {
	              $friend[$x] = tep_db_prepare_input(strip_tags($value));
	              $x++;
	           }
                      
	           $email = $_POST['email'];
	           $x = 0;
	           foreach ($email as $value) {
	              $email[$x] = tep_db_prepare_input(strip_tags($value));
	              $x++;
	          }
				if($friend[0] == '' && $email[0] == '') {
					$error = true;
					$email_errors .= "<div class=\"messageStackError\"><img src=\"images/icons/error.gif\" /> " . ERROR_ONE_EMAIL . "</div>";
				}
			}

			if(isset($friendx) && $friendx != '') {
				if(strlen($email[$j]) < '1') {
					$error = true;
					$email_errors .= "<div class=\"messageStackError\"><img src=\"images/icons/error.gif\" /> " . ERROR_ENTER_EMAIL . "</div>";
				} elseif(!tep_validate_email($email[$j])) {
					$error = true;
					$email_errors .= "<div class=\"messageStackError\"><img src=\"images/icons/error.gif\" /> " . ERROR_VALID_EMAIL . "</div>";
				}
			}

			if(isset($email[$j]) && $email[$j] != '') {
				if(strlen($friendx) < '1') {
					$error = true;
					$email_errors .= "<div class=\"messageStackError\"><img src=\"images/icons/error.gif\" /> " . ERROR_ENTER_NAME . "</div>";
				}
			}
			$j++;
		}
		}
		if($error == false) {
			$j = 0;
			foreach($HTTP_POST_VARS['friend'] as $friendx) {
				if($friendx != '') {
					tep_mail($friendx, $email[$j], $subject, $friendx . ",\n\n" . $body, $from_name, $from_email);
				}

			//Clear Values
				$friend[$j] = "";
				$email[$j] = "";
				$message = "";

				$j++;
			}

        	$messageStack->add('wishlist', WISHLIST_SENT, 'success');
		}
  }

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_SHOPPING_CART));
?>
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_TEMPLATES . $template . $language . '/stylesheet.css';?>">
<script language="javascript" src="includes/general.js"></script>
<script type="text/javascript">
<!--
	function UpdateCartQuantity()
	{
	  document.cart_quantity.submit();
	}
function changeQuantity(i,qty)
	{
	 	document.cart_quantity['qty_'+i].value = Number(document.cart_quantity['qty_'+i].value)+Number(qty);
		UpdateCartQuantity();
	}
//-->
</script>
</head>
<body>
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<?php include('includes/body.php'); ?>
    <td width="100%" valign="top"><?php echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_SHOPPING_CART, 'action=update_product')); ?>	<table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php
			$info_box_contents = array();
			$info_box_contents[] = array('text' => HEADING_TITLE);
			new infoBoxHeading($info_box_contents, true, true);
	  ?></td>
      </tr>
	</table>

	<table border="0" width="100%" cellspacing="0" cellpadding="0" class="blrb">
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  if ($cart->count_contents() > 0) {
?>
      <tr>
        <td>
<?php
    $info_box_contents = array();
    $info_box_contents[0][] = array('align' => 'center',
                                    'params' => 'class="productListing-heading"',
                                    'text' => TABLE_HEADING_REMOVE);

    $info_box_contents[0][] = array('params' => 'class="productListing-heading"',
                                    'text' => TABLE_HEADING_PRODUCTS);

    $info_box_contents[0][] = array('align' => 'center',
                                    'params' => 'class="productListing-heading"',
                                    'text' => TABLE_HEADING_QUANTITY);

    $info_box_contents[0][] = array('align' => 'right',
                                    'params' => 'class="productListing-heading"',
                                    'text' => TABLE_HEADING_TOTAL);

/*
    $info_box_contents[0][] = array('align' => 'right',
                                    'params' => 'class="productListing-heading"',
                                    'text' => '&nbsp;');
*/
    $any_out_of_stock = 0;
    $products = $cart->get_products();

	$przechowalnia = array();
	if(is_array($wishList->wishID) && sizeof($wishList->wishID) > 0) {
		foreach($wishList->wishID as $key => $value) {
			$przechowalnia[] = $key;
		}
	}

	$koszykowe = array();

    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
	  $koszykowe[] = $products[$i]['id'];
// Push all attributes information in an array
      if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
        while (list($option, $value) = each($products[$i]['attributes'])) {
          echo tep_draw_hidden_field('id[' . $products[$i]['id'] . '][' . $option . ']', $value);
          $attributes = tep_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix
                                      from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                      where pa.products_id = '" . (int)$products[$i]['id'] . "'
                                       and pa.options_id = '" . (int)$option . "'
                                       and pa.options_id = popt.products_options_id
                                       and pa.options_values_id = '" . (int)$value . "'
                                       and pa.options_values_id = poval.products_options_values_id
                                       and popt.language_id = '" . (int)$languages_id . "'
                                       and poval.language_id = '" . (int)$languages_id . "'");
          $attributes_values = tep_db_fetch_array($attributes);

          $products[$i][$option]['products_options_name'] = $attributes_values['products_options_name'];
          $products[$i][$option]['options_values_id'] = $value;
          $products[$i][$option]['products_options_values_name'] = $attributes_values['products_options_values_name'];
          $products[$i][$option]['options_values_price'] = $attributes_values['options_values_price'];
          $products[$i][$option]['price_prefix'] = $attributes_values['price_prefix'];
        }
      }
    }

    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
      if (($i/2) == floor($i/2)) {
        $info_box_contents[] = array('params' => 'class="productListing-even"');
      } else {
        $info_box_contents[] = array('params' => 'class="productListing-odd"');
      }

      $cur_row = sizeof($info_box_contents) - 1;

      $info_box_contents[$cur_row][] = array('align' => 'center',
                                             'params' => 'class="productListing-data" valign="top"',
	  // zmiana sposobu kasowania towarow
	  //    'text' => tep_draw_checkbox_field('cart_delete[]', $products[$i]['id'], true,'onFocus="this.form.submit();"'));
											'text' => '<a href="' . tep_href_link(FILENAME_SHOPPING_CART, 'action=remove_product&amp;products_id='.$products[$i]['id'].'', 'NONSSL').'">' . tep_image_t('gfx/kosz.gif', 'Usuñ z koszyka') . '</a>');

      $products_name = '<table border="0" cellspacing="2" cellpadding="2">' .
                       '  <tr>' .
                       '    <td class="productListing-data" align="center"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']) . '">' . tep_image_micro(DIR_WS_IMAGES . $products[$i]['image'], $products[$i]['name'], (int)(SMALL_IMAGE_WIDTH/2), (int)(SMALL_IMAGE_HEIGHT/2)) . '</a></td>' .
                       '    <td class="productListing-data" valign="top"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']) . '"><b>' . $products[$i]['name'] . '</b></a>';

      if (STOCK_CHECK == 'true') {
        $stock_check = tep_check_stock($products[$i]['id'], $products[$i]['quantity']);
        if (tep_not_null($stock_check)) {
          $any_out_of_stock = 1;

          $products_name .= $stock_check;
        }
      }

      if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
        reset($products[$i]['attributes']);
        while (list($option, $value) = each($products[$i]['attributes'])) {
          $products_name .= '<br><small><i> - ' . $products[$i][$option]['products_options_name'] . ' ' . $products[$i][$option]['products_options_values_name'] . '</i></small>';
        }
      }

      $products_name .= '    </td>' .
                        '  </tr>' .
                        '</table>';

      $info_box_contents[$cur_row][] = array('params' => 'class="productListing-data"',
                                             'text' => $products_name);

      $info_box_contents[$cur_row][] = array('align' => 'center',
                                             'params' => 'class="productListing-data" valign="top" NOWRAP',
                                             'text' => '<a href="javascript:changeQuantity(&quot;'.$products[$i]['id'].'&quot;,-1)">'.tep_image_t('gfx/pminus.gif','-1','style="margin-bottom:-3px; margin-right:3px;"').'</a>'.tep_draw_input_field('cart_quantity[]', $products[$i]['quantity'], 'size="1" style="width: 25px;" onChange="UpdateCartQuantity();" id="qty_'.$products[$i]['id'].'"').'<a href="javascript:changeQuantity(&quot;'.$products[$i]['id'].'&quot;,1)">'.tep_image_t('gfx/pplus.gif','+1','style="margin-bottom:-3px;margin-left:3px;"').'</a>'. tep_draw_hidden_field('products_id[]', $products[$i]['id']));
		// zmiana sposobu dodawania produktow
		// 'text' => tep_draw_input_field('cart_quantity[]', $products[$i]['quantity'], 'size="4"') . tep_draw_hidden_field('products_id[]', $products[$i]['id']));

//TotalB2B start
      $info_box_contents[$cur_row][] = array('align' => 'right',
                                             'params' => 'class="productListing-data" valign="top"',
                                             'text' => '<b>' . $currencies->display_price_nodiscount($products[$i]['final_price'], tep_get_tax_rate($products[$i]['tax_class_id']), $products[$i]['quantity']) . '</b>');
/*
      $info_box_contents[$cur_row][] = array('align' => 'right',
                                             'params' => 'class="productListing-data" valign="top"',
                                             'text' => ((!in_array($products[$i]['id'],$przechowalnia))? '<a href="' . tep_href_link(FILENAME_SHOPPING_CART, 'action=move_wishlist&products_id='.(int)$products[$i]['id'].'', 'NONSSL').'">' . tep_image_button('button_wishlist_small.gif', 'Dodaj do schowka') . '</a>':tep_image_button('button_wishlist_off.gif', 'Produkt w schowku')));
*/

      $info_box_contents[$cur_row+1][] = array('align' => 'right',
                                             'params' => 'colspan="4" valign="top"',
                                             'text' => '<div class="catSep"></div>');


//TotalB2B end
    }

    new productListingBox($info_box_contents);
?>
        </td>
      </tr>
      <tr>
        <td align="right" class="bigger"><b><?php echo TEXT_RAZEM; ?>
<?php 
//TotalB2B start
          global $customer_id;
          $query_price_to_guest = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " WHERE configuration_key = 'ALLOW_GUEST_TO_SEE_PRICES'");
          $query_price_to_guest_result = tep_db_fetch_array($query_price_to_guest);
          if ((($query_price_to_guest_result['configuration_value']=='true') && !(tep_session_is_registered('customer_id'))) || ((tep_session_is_registered('customer_id')))) {
             echo $currencies->format($cart->show_total()); 
          } else {
             echo PRICES_LOGGED_IN_TEXT;
          }
//TotalB2B end

?>
		</b></td>
      </tr>
<?php
    if ($any_out_of_stock == 1) {
      if (STOCK_ALLOW_CHECKOUT == 'true') {
?>
      <tr>
        <td class="stockWarning" align="center"><br><?php echo OUT_OF_STOCK_CAN_CHECKOUT; ?></td>
      </tr>
<?php
      } else {
?>
      <tr>
        <td class="stockWarning" align="center"><br><?php echo OUT_OF_STOCK_CANT_CHECKOUT; ?></td>
      </tr>
<?php
      }
    }

    if ($cart->show_total() <= MIN_ORDER_AMOUNT) {
?>
      <tr>
        <td class="stockWarning" align="center"><br><?php echo sprintf(TEXT_ORDER_UNDER_MIN_AMOUNT, $currencies->format(MIN_ORDER_AMOUNT)); ?></td>
      </tr>
<?php
    }
?>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
<?php
    $back = sizeof($navigation->path)-2;
    if (isset($navigation->path[$back])) {
?>
                <td class="buttons"><?php echo '<a href="' . tep_href_link($navigation->path[$back]['page'], tep_array_to_string($navigation->path[$back]['get'], array('action')), $navigation->path[$back]['mode']) . '">' . tep_image_button('button_continue_shopping.gif', IMAGE_BUTTON_CONTINUE_SHOPPING) . '</a>'; ?></td>
<?php
    }
    if ($cart->show_total() > MIN_ORDER_AMOUNT) {
?>
                <td align="right" class="buttons"><?php echo '<a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . '">' . tep_image_button('button_checkout.gif', IMAGE_BUTTON_CHECKOUT) . '</a>'; ?></td>
<?php 
	}
?>
          </tr>
        </table></td>
      </tr>
<?php
  } else {
?>
      <tr>
        <td align="center" class="main"><?php echo TEXT_CART_EMPTY; ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="buttons" align="right"><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
      </tr>
<?php
  }
?>
    </table></form>
	
	
	
<!-- shopping_cart_eof //-->

<br>



<?php echo tep_draw_form('wishlist_form', tep_href_link(FILENAME_SHOPPING_CART)); ?>
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php
			$info_box_contents = array();
			$info_box_contents[] = array('text' => HEADING_TITLE2);
			new infoBoxHeadingO($info_box_contents, true, true);
	  ?></td>
      </tr>
	</table>

	<table border="0" width="100%" cellspacing="0" cellpadding="0" class="blrb">

<?php
  if ($messageStack->size('wishlist') > 0) {
?>
      <tr>
        <td><?php echo $messageStack->output('wishlist'); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  }


if (is_array($wishList->wishID) && !empty($wishList->wishID)) {
	reset($wishList->wishID);

?>

<?php echo tep_draw_form('wishlist_form', tep_href_link(FILENAME_SHOPPING_CART)); ?>


	  <tr>
		<td>
		<table border="0" width="100%" cellspacing="0" cellpadding="3" class="productListing">
		  <tr>
				<td class="productListing-heading" align="center"><?php echo TABLE_HEADING_REMOVE; ?></td>
				<td class="productListing-heading"><?php echo '&nbsp;'; ?></td>
				<td class="productListing-heading"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
				<td class="productListing-heading"><?php echo BOX_TEXT_PRICE; ?></td>
				<td class="productListing-heading"><?php echo '&nbsp;'; ?></td>
		  </tr>

<?php
		$i = 0;
		while (list($wishlist_id, ) = each($wishList->wishID)) {

			$product_id = tep_get_prid($wishlist_id);
		
		    $products_query = tep_db_query("select pd.products_id, pd.products_name, pd.products_description, p.products_image, p.products_status, p.products_price, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price, p.products_date_available as date_available from " . TABLE_PRODUCTS . " p LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd ON p.products_id = pd.products_id LEFT JOIN " . TABLE_SPECIALS . " s on p.products_id = s.products_id WHERE pd.products_id = '" . (int)$product_id . "' and pd.language_id = '" . (int)$languages_id . "' order by products_name");
## MOD: RECUR
			if(tep_db_num_rows($products_query) == 0) continue;
##
			$products = tep_db_fetch_array($products_query);

		      if (($i/2) == floor($i/2)) {
		        $class = "productListing-even";
		      } else {
		        $class = "productListing-odd";
		      }

			  if($products['date_available'] > date('Y-m-d H:m:s')) {
				$ZAPOWIEDZ = '<BR><span style="color: #999;"><small>Premiera: '.substr($products['date_available'],0,strpos($products['date_available'],' ')).'</small></span>';
			  } else {
				$ZAPOWIEDZ = '';
			  }

?>
				  <tr class="<?php echo $class; ?>">
					<td valign="top" class="productListing-data" align="center">
<?php

/*******************************************************************
* PREVENT THE ITEM FROM BEING ADDED TO CART IF NO LONGER AVAILABLE *
*******************************************************************/

			if($products['products_status'] != 0) {
//				echo tep_draw_checkbox_field('add_wishprod[]',$wishlist_id);
				echo '<a href="' . tep_href_link(FILENAME_SHOPPING_CART, 'action=remove_wishlist&products_id='.tep_db_prepare_input($wishlist_id).'', 'NONSSL').'">' . tep_image_t('gfx/kosz.gif', 'Usuñ ze schowka') . '</a>';
			}
?>
					</td>
					<td valign="top" class="productListing-data" align="left"><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$wishlist_id, 'NONSSL'); ?>"><?php echo tep_image_micro(DIR_WS_IMAGES . $products['products_image'], $products['products_name'], (int)(SMALL_IMAGE_WIDTH/2), (int)(SMALL_IMAGE_HEIGHT/2)); ?></a></td>
					<td valign="top" class="productListing-data" align="left" class="main" width="80%"><b><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$wishlist_id, 'NONSSL'); ?>"><?php echo $products['products_name'] .'</a></b>'. $ZAPOWIEDZ; ?>
					<input type="hidden" name="prod_link[]" value="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$wishlist_id, 'NONSSL'); ?>" />
					<input type="hidden" name="prod_name[]" value="<?php echo $products['products_name']; ?>" />
<?php



/*******************************************************************
******** THIS IS THE WISHLIST CODE FOR PRODUCT ATTRIBUTES  *********
*******************************************************************/

                  $attributes_addon_price = 0;

                  // Now get and populate product attributes
					$att_name = "";
					if (isset($wishList->wishID[$wishlist_id]['attributes'])) {
						while (list($option, $value) = each($wishList->wishID[$wishlist_id]['attributes'])) {
                      		echo tep_draw_hidden_field('id[' . $wishlist_id . '][' . $option . ']', $value);

         					$attributes = tep_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix
                                      from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                      where pa.products_id = '" . (int)$wishlist_id . "'
                                       and pa.options_id = '" . (int)$option . "'
                                       and pa.options_id = popt.products_options_id
                                       and pa.options_values_id = '" . (int)$value . "'
                                       and pa.options_values_id = poval.products_options_values_id
                                       and popt.language_id = '" . (int)$languages_id . "'
                                       and poval.language_id = '" . (int)$languages_id . "'");
							$attributes_values = tep_db_fetch_array($attributes);

                       		if ($attributes_values['price_prefix'] == '+') {
								$attributes_addon_price += $attributes_values['options_values_price'];
                       		} else if($attributes_values['price_prefix'] == '-') {
                         		$attributes_addon_price -= $attributes_values['options_values_price'];
							}
							$att_name .= " (" . $attributes_values['products_options_name'] . ": " . $attributes_values['products_options_values_name'] . ") ";
                       		echo '<br><small><i> ' . $attributes_values['products_options_name'] . ': ' . $attributes_values['products_options_values_name'] . '</i></small>';
                    	} // end while attributes for product

					}

					echo '<input type="hidden" name="prod_att[]" value="' . $att_name . '" />';

                   	if (tep_not_null($products['specials_new_products_price'])) {
                   		$products_price = '<s>' . $currencies->display_price($products['products_id'], $products['products_price']+$attributes_addon_price, tep_get_tax_rate($products['products_tax_class_id'])) . '</s> <span class="productSpecialPrice">' . $currencies->display_price($products['products_id'], $products['specials_new_products_price']+$attributes_addon_price, tep_get_tax_rate($products['products_tax_class_id'])) . '</span>';
                   	} else {
                       	$products_price = $currencies->display_price($products['products_id'], $products['products_price']+$attributes_addon_price, tep_get_tax_rate($products['products_tax_class_id']));
                    }

/*******************************************************************
******* CHECK TO SEE IF PRODUCT HAS BEEN ADDED TO THEIR CART *******
*******************************************************************/

			if($cart->in_cart($wishlist_id)) {
//				echo '<br><font color="#FF0000">' . TEXT_ITEM_IN_CART . '</font>';
			}

/*******************************************************************
********** CHECK TO SEE IF PRODUCT IS NO LONGER AVAILABLE **********
*******************************************************************/

   			if($products['products_status'] == 0) {
   				echo '<br><font color="#FF0000"><b>' . TEXT_ITEM_NOT_AVAILABLE . '</b></font>';
  			}
	
			$i++;
?>
			</td>
			<td valign="top" class="productListing-data"><b><?php echo $products_price; ?></b></td>
			<td valign="top" class="productListing-data" NOWRAP><?php 
				if (!$cart->in_cart($wishlist_id)) {
//					echo tep_draw_checkbox_field('add_wishprod[]',$wishlist_id);
					echo tep_draw_hidden_field('add_wishprod[]','','id="wishlist_'.$wishlist_id.'"');
					echo tep_image_submit('button_in_carts.gif', 'Dodaj do koszyka','onClick="document.getElementById(\'wishlist_'.$wishlist_id.'\').value=\''.$wishlist_id.'\';"');
				} else {
					echo tep_image_button('button_in_cartoff.gif', 'Produkt w koszyku');
				}
			?></td>
		  </tr>

		  <tr>
			<td valign="middle" align="center" colspan="4"><div class="catSep"></div></td>
		  </tr>

<?php
		}
?>
		</table>
		</td>
	  </tr>
	</table>
<?php

/*******************************************************************
*********** CODE TO SPECIFY HOW MANY EMAILS TO DISPLAY *************
*******************************************************************/


	if(!tep_session_is_registered('customer_id')) {

?>
	<table border="0" width="100%" cellspacing="0" cellpadding="2" class="blrb">
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
	  <tr>
		<td class="main"><?php echo WISHLIST_EMAIL_TEXT_GUEST; ?></td>
	  </tr>
      <tr>
        <td align="right"><?php echo tep_image_button('button_continue.gif','Dalej',' id="b_show" onClick="pokazFormularz(\'przechowalnia_mail\'); cursor: hand;"'); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
	  <tr>
        <td align="center"><div style="display: none;" id="przechowalnia_mail">
			<table border="0" width="400px" cellspacing="0" cellpadding="2">
			  <tr>
				<td class="main" colspan="2"><table cellpadding="2" cellspacing="0">
				  <tr>
					<td colspan="2"><?php echo $guest_errors; ?></td>
				  </tr>
				  <tr>
					<td class="main"><?php echo TEXT_YOUR_NAME; ?></td>
					<td class="main"><?php echo tep_draw_input_field('your_name', $your_name); ?></td>
			  	  </tr>
			  	  <tr>
					<td class="main"><?php echo TEXT_YOUR_EMAIL; ?></td>
					<td class="main"><?php echo tep_draw_input_field('your_email', $your_email); ?></td>
			  	  </tr>
				</table></td>
			  </tr>
		      <tr>
		        <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
		      </tr>
		      <tr>
		        <td colspan="2"><?php echo tep_draw_separator('pixel_black.gif', '100%', '1'); ?></td>
		      </tr>
		      <tr>
		        <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
		      </tr>
<?php 

	} else {

?>

	<table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
	  <tr>
		<td class="main"><?php echo WISHLIST_EMAIL_TEXT; ?></td>
	  </tr>
      <tr>
        <td class="blr"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
	  <tr>
        <td align="center">
			<table border="0" width="400px" cellspacing="0" cellpadding="2">
<?php
	}

?>
			  <tr>
				<td colspan="2"><?php echo $email_errors; ?></td>
			  </tr>
<?php

	$email_counter = 0;
	while($email_counter < DISPLAY_WISHLIST_EMAILS) {
?>
			  <tr>
				<td class="main"><?php echo TEXT_NAME; ?>&nbsp;&nbsp;<?php echo tep_draw_input_field('friend[]', $friend[$email_counter]); ?></td>
				<td class="main"><?php echo TEXT_EMAIL; ?>&nbsp;&nbsp;<?php echo tep_draw_input_field('email[]', $email[$email_counter]); ?></td>
			  </tr>
<?php
	$email_counter++;
	}
?>
			  <tr>
				<td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
			  </tr>
			  <tr>
				<td colspan="2"><?php echo $message_error; ?></td>
			  </tr>
			  <tr>
				<td colspan="2" class="main"><?php echo TEXT_MESSAGE .  tep_draw_textarea_field('message', 'soft', 45, 5); ?></td>
			  </tr>
			  <tr>
				<td colspan="2" align="right"><?php echo tep_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE, 'name="email_prod" value="email_prod"'); ?></td>
			  </tr>
			</table>
		</div>
		</td>
	  </tr>
	</table>
	</form>
<?php

} else { // Nothing in the customers wishlist

?>
  <tr>
	<td>
	<table border="0" width="100%" cellspacing="0" cellpadding="2">
	  <tr>
		<td><table border="0" width="100%" cellspacing="0" cellpadding="0">
		  <tr>
			<td class="main" align="center"><?php echo BOX_TEXT_NO_ITEMS;?></td>
		  </tr>
		</table>
		</td>
	  </tr>
	</table>
	</td>
  </tr>
</table>
</form>

<?php 
}
?>
<!-- customer_wishlist_eof //-->



	
	</td>



<!-- body_text_eof //-->
<?php include('includes/footer_0.php'); ?>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>