<?php
/*
  $Id: customers_improved.php, v1.3b 2005/08/23 03:54:44 kremit Exp $

  Customers Improved v1.3b

  Copyright (c) 2005 Wesley Haines
  <kremit AT wrpn.net>, http://wrpn.net/
  http://www.oscommerce.pl

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  require(DIR_WS_CLASSES . 'currencies.php');




function tep_check_cart_registered($customer_id) {
	$query = tep_db_query("SELECT * FROM ".TABLE_CUSTOMERS_BASKET." WHERE customers_id = '".(int)$customer_id."'");
	
	$i=0;
	$koszyk = '<hr>';

	while($results = tep_db_fetch_array($query)) {
		$pid = explode('{',$results['products_id']);

		$query2 = tep_db_query("SELECT products_name FROM ".TABLE_PRODUCTS_DESCRIPTION." WHERE products_id = '".(int)$pid[0]."' AND language_id = '4'");
		$result = tep_db_fetch_array($query2);
		$towary[$i]['nazwa'] = $results['products_name'];
		$koszyk .= $results['customers_basket_date_added'] .' -> '. $results['customers_basket_quantity'] . ' x ' . '['.$results['products_id'].'] '.$result['products_name'].'<br /><hr>';
	}

	return $koszyk;
}

function tep_check_cart($which, $customer_id, $session_id) {
  global $cart, $status_active_cart, $status_inactive_cart, $status_active_nocart, $status_inactive_nocart, $status_inactive_bot, $status_active_bot, $active_time;

	  // Pull Session data from the correct source.
    if (STORE_SESSIONS == 'mysql') {
      $session_data = tep_db_query("select value from " . TABLE_SESSIONS . " WHERE sesskey = '" . $session_id . "'");
      $session_data = tep_db_fetch_array($session_data);
      $session_data = trim($session_data['value']);
    } else {
      if ( (file_exists(tep_session_save_path() . '/sess_' . $session_id)) && (filesize(tep_session_save_path() . '/sess_' . $session_id) > 0) ) {
        $session_data = file(tep_session_save_path() . '/sess_' . $session_id);
        $session_data = trim(implode('', $session_data));
      }
    }

    if ($length = strlen($session_data)) {
      if (PHP_VERSION < 4) {
        $start_id = strpos($session_data, 'customer_id[==]s');
        $start_cart = strpos($session_data, 'cart[==]o');
        $start_currency = strpos($session_data, 'currency[==]s');
        $start_country = strpos($session_data, 'customer_country_id[==]s');
        $start_zone = strpos($session_data, 'customer_zone_id[==]s');
      } else {
        $start_id = strpos($session_data, 'customer_id|s');
        $start_cart = strpos($session_data, 'cart|O');
        $start_currency = strpos($session_data, 'currency|s');
        $start_country = strpos($session_data, 'customer_country_id|s');
        $start_zone = strpos($session_data, 'customer_zone_id|s');
      }

      for ($i=$start_cart; $i<$length; $i++) {
        if ($session_data[$i] == '{') {
          if (isset($tag)) {
            $tag++;
          } else {
            $tag = 1;
          }
        } elseif ($session_data[$i] == '}') {
          $tag--;
        } elseif ( (isset($tag)) && ($tag < 1) ) {
          break;
        }
      }

      $session_data_id = substr($session_data, $start_id, (strpos($session_data, ';', $start_id) - $start_id + 1));
      $session_data_cart = substr($session_data, $start_cart, $i);
      $session_data_currency = substr($session_data, $start_currency, (strpos($session_data, ';', $start_currency) - $start_currency + 1));
      $session_data_country = substr($session_data, $start_country, (strpos($session_data, ';', $start_country) - $start_country + 1));
      $session_data_zone = substr($session_data, $start_zone, (strpos($session_data, ';', $start_zone) - $start_zone + 1));

      session_decode($session_data_id);
      session_decode($session_data_currency);
      session_decode($session_data_country);
      session_decode($session_data_zone);
      session_decode($session_data_cart);

      if (PHP_VERSION < 4) {
        $broken_cart = $cart;
        $cart = new shoppingCart;
        $cart->unserialize($broken_cart);
      }

      if (is_object($cart)) {
        $products = $cart->get_products();
		  }
		}
		
  $which_query = $session_data;                               
  $who_data =   tep_db_query("select time_entry, time_last_click
                                 from " . TABLE_WHOS_ONLINE . "
                                 where session_id='" . $session_id . "'");
  $who_query = tep_db_fetch_array($who_data);                           
  
  // Determine if visitor active/inactive
  $xx_mins_ago_long = (time() - $active_time);

  // Determine Bot active/inactive
  if( $customer_id < 0 ) {
    // inactive 
    if ($who_query['time_last_click'] < $xx_mins_ago_long) {
      return tep_image(DIR_WS_IMAGES . $status_inactive_bot, TEXT_STATUS_INACTIVE_BOT);
    // active 
    } else {
      return tep_image(DIR_WS_IMAGES . $status_active_bot, TEXT_STATUS_ACTIVE_BOT);
    }
	}	

  // Determine active/inactive and cart/no cart status
  // no cart
  if ( sizeof($products) == 0 ) {
    // inactive 
    if ($who_query['time_last_click'] < $xx_mins_ago_long) {
      return tep_image(DIR_WS_IMAGES . $status_inactive_nocart, 'Brak koszyka');
    // active 
    } else {
      return tep_image(DIR_WS_IMAGES . $status_active_nocart, 'Brak koszyka');
    }
  // cart
	} else { 
    // inactive
    if ($who_query['time_last_click'] < $xx_mins_ago_long) {
      return tep_image(DIR_WS_IMAGES . $status_inactive_cart, TEXT_STATUS_INACTIVE_CART);
    // active
    } else {
      return tep_image(DIR_WS_IMAGES . $status_active_cart, TEXT_STATUS_ACTIVE_CART);
    }
  }
}
// WOL 1.5 EOF

/* Display the details about a visitor */
function display_details() {
   global $whos_online, $is_bot, $is_admin, $is_guest, $is_account;
	 
	// Display Name
   echo '<b>'.TEXT_NAME_.'</b> ' . $whos_online['full_name'];
   echo '<br clear="all">' . tep_draw_separator('pixel_trans.gif', '10', '4') . '<br clear="all">';
   // Display Customer ID for non-bots
   if ( !$is_bot ){
      echo '<b>'.TEXT_CUSTOMER_ID_.'</b> ' . $whos_online['customer_id'];
      echo '<br clear="all">' . tep_draw_separator('pixel_trans.gif', '10', '4') . '<br clear="all">';
   } 
	// Display IP Address
   echo '<b>'.TEXT_IP_ADDRESS.'</b> ' . $whos_online['ip_address'];
   echo '<br clear="all">' . tep_draw_separator('pixel_trans.gif', '10', '4') . '<br clear="all">';
	// Display User Agent
   echo '<b>' . TEXT_USER_AGENT . ':</b> ' . $whos_online['user_agent'];
   echo '<br clear="all">' . tep_draw_separator('pixel_trans.gif', '10', '4') . '<br clear="all">';
	// Display Session ID.  Bots with no Session ID, have it set to their IP address.  Don't display these.
   if ( $whos_online['session_id'] != $whos_online['ip_address'] ) {
      echo '<b>' . TEXT_OSCID . ':</b> ' . $whos_online['session_id'];
      echo '<br clear="all">' . tep_draw_separator('pixel_trans.gif', '10', '4') . '<br clear="all">';
   }
	// Display Referer if available
   if($whos_online['http_referer'] != "" ) {
      echo '<b>'.TEXT_REFFERER_.'</b> ' . $whos_online['http_referer']; 
      echo '<br clear="all">' . tep_draw_separator('pixel_trans.gif', '10', '4') . '<br clear="all">';
   }
}


  $currencies = new currencies();

  $action = (isset($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : '');

if(isset($HTTP_POST_VARS['orderby'])) $orderby = tep_db_prepare_input($HTTP_POST_VARS['orderby']);
if(isset($HTTP_POST_VARS['sort'])) $sort = tep_db_prepare_input($HTTP_POST_VARS['sort']);
if(!$orderby) $orderby = 'lastname';
if(!$sort) $sort = 'ASC';


  $error = false;
  $processed = false;

  if (tep_not_null($action)) {
    switch ($action) {
      case 'update':
        $customers_id = tep_db_prepare_input($HTTP_GET_VARS['cID']);
        $customers_firstname = tep_db_prepare_input($HTTP_POST_VARS['customers_firstname']);
        $customers_lastname = tep_db_prepare_input($HTTP_POST_VARS['customers_lastname']);
        $customers_email_address = tep_db_prepare_input($HTTP_POST_VARS['customers_email_address']);
        $customers_telephone = tep_db_prepare_input($HTTP_POST_VARS['customers_telephone']);
        $customers_fax = tep_db_prepare_input($HTTP_POST_VARS['customers_fax']);
        $customers_newsletter = tep_db_prepare_input($HTTP_POST_VARS['customers_newsletter']);

        $customers_gender = tep_db_prepare_input($HTTP_POST_VARS['customers_gender']);
        $customers_dob = tep_db_prepare_input($HTTP_POST_VARS['customers_dob']);
// START Admin Notes
        $customers_notes = tep_db_prepare_input($HTTP_POST_VARS['customers_notes']);
// END Admin Notes

        $default_address_id = tep_db_prepare_input($HTTP_POST_VARS['default_address_id']);
        $entry_street_address = tep_db_prepare_input($HTTP_POST_VARS['entry_street_address']);
        $entry_suburb = tep_db_prepare_input($HTTP_POST_VARS['entry_suburb']);
        $entry_postcode = tep_db_prepare_input($HTTP_POST_VARS['entry_postcode']);
        $entry_city = tep_db_prepare_input($HTTP_POST_VARS['entry_city']);
        $entry_country_id = tep_db_prepare_input($HTTP_POST_VARS['entry_country_id']);

        $entry_company = tep_db_prepare_input($HTTP_POST_VARS['entry_company']);
        $entry_state = tep_db_prepare_input($HTTP_POST_VARS['entry_state']);
        if (isset($HTTP_POST_VARS['entry_zone_id'])) $entry_zone_id = tep_db_prepare_input($HTTP_POST_VARS['entry_zone_id']);

        if (strlen($customers_firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
          $error = true;
          $entry_firstname_error = true;
        } else {
          $entry_firstname_error = false;
        }

        if (strlen($customers_lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
          $error = true;
          $entry_lastname_error = true;
        } else {
          $entry_lastname_error = false;
        }

        if (ACCOUNT_DOB == 'true') {
          if (checkdate(substr(tep_date_raw($customers_dob), 4, 2), substr(tep_date_raw($customers_dob), 6, 2), substr(tep_date_raw($customers_dob), 0, 4))) {
            $entry_date_of_birth_error = false;
          } else {
            $error = true;
            $entry_date_of_birth_error = true;
          }
        }

        if (strlen($customers_email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
          $error = true;
          $entry_email_address_error = true;
        } else {
          $entry_email_address_error = false;
        }

        if (!tep_validate_email($customers_email_address)) {
          $error = true;
          $entry_email_address_check_error = true;
        } else {
          $entry_email_address_check_error = false;
        }

        if (strlen($entry_street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
          $error = true;
          $entry_street_address_error = true;
        } else {
          $entry_street_address_error = false;
        }

        if (strlen($entry_postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
          $error = true;
          $entry_post_code_error = true;
        } else {
          $entry_post_code_error = false;
        }

        if (strlen($entry_city) < ENTRY_CITY_MIN_LENGTH) {
          $error = true;
          $entry_city_error = true;
        } else {
          $entry_city_error = false;
        }

        if ($entry_country_id == false) {
          $error = true;
          $entry_country_error = true;
        } else {
          $entry_country_error = false;
        }

        if (ACCOUNT_STATE == 'true') {
          if ($entry_country_error == true) {
            $entry_state_error = true;
          } else {
            $zone_id = 0;
            $entry_state_error = false;
            $check_query = tep_db_query("select count(*) as total from " . TABLE_ZONES . " where zone_country_id = '" . (int)$entry_country_id . "'");
            $check_value = tep_db_fetch_array($check_query);
            $entry_state_has_zones = ($check_value['total'] > 0);
            if ($entry_state_has_zones == true) {
              $zone_query = tep_db_query("select zone_id from " . TABLE_ZONES . " where zone_country_id = '" . (int)$entry_country_id . "' and zone_name = '" . tep_db_input($entry_state) . "'");
              if (tep_db_num_rows($zone_query) == 1) {
                $zone_values = tep_db_fetch_array($zone_query);
                $entry_zone_id = $zone_values['zone_id'];
              } else {
                $error = true;
                $entry_state_error = true;
              }
            } else {
              if ($entry_state == false) {
                $error = true;
                $entry_state_error = true;
              }
            }
         }
      }

      if (strlen($customers_telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
        $error = true;
        $entry_telephone_error = true;
      } else {
        $entry_telephone_error = false;
      }

      $check_email = tep_db_query("select customers_email_address from " . TABLE_CUSTOMERS . " where customers_email_address = '" . tep_db_input($customers_email_address) . "' and customers_id != '" . (int)$customers_id . "'");
      if (tep_db_num_rows($check_email)) {
        $error = true;
        $entry_email_address_exists = true;
      } else {
        $entry_email_address_exists = false;
      }

      if ($error == false) {

        $sql_data_array = array('customers_firstname' => $customers_firstname,
                                'customers_lastname' => $customers_lastname,
                                'customers_email_address' => $customers_email_address,
                                'customers_telephone' => $customers_telephone,
                                'customers_fax' => $customers_fax,
                                'customers_notes' => $customers_notes, // START \ END Admin Notes
                                'customers_newsletter' => $customers_newsletter);

        if (ACCOUNT_GENDER == 'true') $sql_data_array['customers_gender'] = $customers_gender;
        if (ACCOUNT_DOB == 'true') $sql_data_array['customers_dob'] = tep_date_raw($customers_dob);

        tep_db_perform(TABLE_CUSTOMERS, $sql_data_array, 'update', "customers_id = '" . (int)$customers_id . "'");

        tep_db_query("update " . TABLE_CUSTOMERS_INFO . " set customers_info_date_account_last_modified = now() where customers_info_id = '" . (int)$customers_id . "'");

        if ($entry_zone_id > 0) $entry_state = '';

        $sql_data_array = array('entry_firstname' => $customers_firstname,
                                'entry_lastname' => $customers_lastname,
                                'entry_street_address' => $entry_street_address,
                                'entry_postcode' => $entry_postcode,
                                'entry_city' => $entry_city,
                                'entry_country_id' => $entry_country_id);

        if (ACCOUNT_COMPANY == 'true') $sql_data_array['entry_company'] = $entry_company;
        if (ACCOUNT_SUBURB == 'true') $sql_data_array['entry_suburb'] = $entry_suburb;

        if (ACCOUNT_STATE == 'true') {
          if ($entry_zone_id > 0) {
            $sql_data_array['entry_zone_id'] = $entry_zone_id;
            $sql_data_array['entry_state'] = '';
          } else {
            $sql_data_array['entry_zone_id'] = '0';
            $sql_data_array['entry_state'] = $entry_state;
          }
        }

        tep_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array, 'update', "customers_id = '" . (int)$customers_id . "' and address_book_id = '" . (int)$default_address_id . "'");

        tep_redirect(tep_href_link(FILENAME_CUSTOMERS_ADVANCED, tep_get_all_get_params(array('cID', 'action')) . 'cID=' . $customers_id));

        } else if ($error == true) {
          $cInfo = new objectInfo($HTTP_POST_VARS);
          $processed = true;
        }

        break;
      case 'deleteconfirm':
        $customers_id = tep_db_prepare_input($HTTP_GET_VARS['cID']);

        if (isset($HTTP_POST_VARS['delete_reviews']) && ($HTTP_POST_VARS['delete_reviews'] == 'on')) {
          $reviews_query = tep_db_query("select reviews_id from " . TABLE_REVIEWS . " where customers_id = '" . (int)$customers_id . "'");
          while ($reviews = tep_db_fetch_array($reviews_query)) {
            tep_db_query("delete from " . TABLE_REVIEWS_DESCRIPTION . " where reviews_id = '" . (int)$reviews['reviews_id'] . "'");
          }

          tep_db_query("delete from " . TABLE_REVIEWS . " where customers_id = '" . (int)$customers_id . "'");
        } else {
          tep_db_query("update " . TABLE_REVIEWS . " set customers_id = null where customers_id = '" . (int)$customers_id . "'");
        }

        tep_db_query("delete from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$customers_id . "'");
        tep_db_query("delete from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$customers_id . "'");
        tep_db_query("delete from " . TABLE_CUSTOMERS_INFO . " where customers_info_id = '" . (int)$customers_id . "'");
        tep_db_query("delete from " . TABLE_CUSTOMERS_BASKET . " where customers_id = '" . (int)$customers_id . "'");
        tep_db_query("delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " where customers_id = '" . (int)$customers_id . "'");
        tep_db_query("delete from " . TABLE_WHOS_ONLINE . " where customer_id = '" . (int)$customers_id . "'");

        tep_redirect(tep_href_link(FILENAME_CUSTOMERS_ADVANCED, tep_get_all_get_params(array('cID', 'action'))));
        break;
      default:
        // START Admin Notes
        $customers_query = tep_db_query("select c.customers_id, c.customers_gender, c.customers_firstname, c.customers_lastname, c.customers_dob, c.customers_email_address, a.entry_company, a.entry_street_address, a.entry_suburb, a.entry_postcode, a.entry_city, a.entry_state, a.entry_zone_id, a.entry_country_id, c.customers_telephone, c.customers_fax, c.customers_newsletter, c.customers_default_address_id, c.customers_notes from " . TABLE_CUSTOMERS . " c left join " . TABLE_ADDRESS_BOOK . " a on c.customers_default_address_id = a.address_book_id where a.customers_id = c.customers_id and c.customers_id = '" . (int)$HTTP_GET_VARS['cID'] . "'");
// END Admin Notes
        $customers = tep_db_fetch_array($customers_query);
        $cInfo = new objectInfo($customers);
    }
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/general.js"></script>
<?php
  if ($action == 'edit' || $action == 'update') {
?>
<script language="javascript"><!--

function check_form() {
  var error = 0;
  var error_message = "<?php echo JS_ERROR; ?>";

  var customers_firstname = document.customers.customers_firstname.value;
  var customers_lastname = document.customers.customers_lastname.value;
<?php if (ACCOUNT_COMPANY == 'true') echo 'var entry_company = document.customers.entry_company.value;' . "\n"; ?>
<?php if (ACCOUNT_DOB == 'true') echo 'var customers_dob = document.customers.customers_dob.value;' . "\n"; ?>
  var customers_email_address = document.customers.customers_email_address.value;
  var entry_street_address = document.customers.entry_street_address.value;
  var entry_postcode = document.customers.entry_postcode.value;
  var entry_city = document.customers.entry_city.value;
  var customers_telephone = document.customers.customers_telephone.value;

<?php if (ACCOUNT_GENDER == 'true') { ?>
  if (document.customers.customers_gender[0].checked || document.customers.customers_gender[1].checked) {
  } else {
    error_message = error_message + "<?php echo JS_GENDER; ?>";
    error = 1;
  }
<?php } ?>

  if (customers_firstname == "" || customers_firstname.length < <?php echo ENTRY_FIRST_NAME_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo JS_FIRST_NAME; ?>";
    error = 1;
  }

  if (customers_lastname == "" || customers_lastname.length < <?php echo ENTRY_LAST_NAME_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo JS_LAST_NAME; ?>";
    error = 1;
  }

<?php if (ACCOUNT_DOB == 'true') { ?>
  if (customers_dob == "" || customers_dob.length < <?php echo ENTRY_DOB_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo JS_DOB; ?>";
    error = 1;
  }
<?php } ?>

  if (customers_email_address == "" || customers_email_address.length < <?php echo ENTRY_EMAIL_ADDRESS_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo JS_EMAIL_ADDRESS; ?>";
    error = 1;
  }

  if (entry_street_address == "" || entry_street_address.length < <?php echo ENTRY_STREET_ADDRESS_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo JS_ADDRESS; ?>";
    error = 1;
  }

  if (entry_postcode == "" || entry_postcode.length < <?php echo ENTRY_POSTCODE_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo JS_POST_CODE; ?>";
    error = 1;
  }

  if (entry_city == "" || entry_city.length < <?php echo ENTRY_CITY_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo JS_CITY; ?>";
    error = 1;
  }

<?php
  if (ACCOUNT_STATE == 'true') {
?>
  if (document.customers.elements['entry_state'].type != "hidden") {
    if (document.customers.entry_state.value == '' || document.customers.entry_state.value.length < <?php echo ENTRY_STATE_MIN_LENGTH; ?> ) {
       error_message = error_message + "<?php echo JS_STATE; ?>";
       error = 1;
    }
  }
<?php
  }
?>

  if (document.customers.elements['entry_country_id'].type != "hidden") {
    if (document.customers.entry_country_id.value == 0) {
      error_message = error_message + "<?php echo JS_COUNTRY; ?>";
      error = 1;
    }
  }

  if (customers_telephone == "" || customers_telephone.length < <?php echo ENTRY_TELEPHONE_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo JS_TELEPHONE; ?>";
    error = 1;
  }

  if (error == 1) {
    alert(error_message);
    return false;
  } else {
    return true;
  }
}
//--></script>
<?php
  }
?>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
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
<?php
  if ($action == 'edit' || $action == 'update') {
    $newsletter_array = array(array('id' => '1', 'text' => ENTRY_NEWSLETTER_YES),
                              array('id' => '0', 'text' => ENTRY_NEWSLETTER_NO));
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr><?php echo tep_draw_form('customers', FILENAME_CUSTOMERS_ADVANCED, tep_get_all_get_params(array('action')) . 'action=update', 'post', 'onSubmit="return check_form();"') . tep_draw_hidden_field('default_address_id', $cInfo->customers_default_address_id); ?>
        <td class="formAreaTitle"><?php echo CATEGORY_PERSONAL; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
<?php
    if (ACCOUNT_GENDER == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_GENDER; ?></td>
            <td class="main">
<?php
    if ($error == true) {
      if ($entry_gender_error == true) {
        echo tep_draw_radio_field('customers_gender', 'm', false, $cInfo->customers_gender) . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . tep_draw_radio_field('customers_gender', 'f', false, $cInfo->customers_gender) . '&nbsp;&nbsp;' . FEMALE . '&nbsp;' . ENTRY_GENDER_ERROR;
      } else {
        echo ($cInfo->customers_gender == 'm') ? MALE : FEMALE;
        echo tep_draw_hidden_field('customers_gender');
      }
    } else {
      echo tep_draw_radio_field('customers_gender', 'm', false, $cInfo->customers_gender) . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . tep_draw_radio_field('customers_gender', 'f', false, $cInfo->customers_gender) . '&nbsp;&nbsp;' . FEMALE;
    }
?></td>
          </tr>
<?php
    }
?>
          <tr>
            <td class="main"><?php echo ENTRY_FIRST_NAME; ?></td>
            <td class="main">
<?php
  if ($error == true) {
    if ($entry_firstname_error == true) {
      echo tep_draw_input_field('customers_firstname', $cInfo->customers_firstname, 'maxlength="32"') . '&nbsp;' . ENTRY_FIRST_NAME_ERROR;
    } else {
      echo $cInfo->customers_firstname . tep_draw_hidden_field('customers_firstname');
    }
  } else {
    echo tep_draw_input_field('customers_firstname', $cInfo->customers_firstname, 'maxlength="32"', true);
  }
?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_LAST_NAME; ?></td>
            <td class="main">
<?php
  if ($error == true) {
    if ($entry_lastname_error == true) {
      echo tep_draw_input_field('customers_lastname', $cInfo->customers_lastname, 'maxlength="32"') . '&nbsp;' . ENTRY_LAST_NAME_ERROR;
    } else {
      echo $cInfo->customers_lastname . tep_draw_hidden_field('customers_lastname');
    }
  } else {
    echo tep_draw_input_field('customers_lastname', $cInfo->customers_lastname, 'maxlength="32"', true);
  }
?></td>
          </tr>
<?php
    if (ACCOUNT_DOB == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_DATE_OF_BIRTH; ?></td>
            <td class="main">

<?php
    if ($error == true) {
      if ($entry_date_of_birth_error == true) {
        echo tep_draw_input_field('customers_dob', tep_date_short($cInfo->customers_dob), 'maxlength="10"') . '&nbsp;' . ENTRY_DATE_OF_BIRTH_ERROR;
      } else {
        echo $cInfo->customers_dob . tep_draw_hidden_field('customers_dob');
      }
    } else {
      echo tep_draw_input_field('customers_dob', tep_date_short($cInfo->customers_dob), 'maxlength="10"', true);
    }
?></td>
          </tr>
<?php
    }
?>
          <tr>
            <td class="main"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
            <td class="main">
<?php
  if ($error == true) {
    if ($entry_email_address_error == true) {
      echo tep_draw_input_field('customers_email_address', $cInfo->customers_email_address, 'maxlength="96"') . '&nbsp;' . ENTRY_EMAIL_ADDRESS_ERROR;
    } elseif ($entry_email_address_check_error == true) {
      echo tep_draw_input_field('customers_email_address', $cInfo->customers_email_address, 'maxlength="96"') . '&nbsp;' . ENTRY_EMAIL_ADDRESS_CHECK_ERROR;
    } elseif ($entry_email_address_exists == true) {
      echo tep_draw_input_field('customers_email_address', $cInfo->customers_email_address, 'maxlength="96"') . '&nbsp;' . ENTRY_EMAIL_ADDRESS_ERROR_EXISTS;
    } else {
      echo $customers_email_address . tep_draw_hidden_field('customers_email_address');
    }
  } else {
    echo tep_draw_input_field('customers_email_address', $cInfo->customers_email_address, 'maxlength="96"', true);
  }
?></td>
          </tr>
        </table></td>
      </tr>
<?php
    if (ACCOUNT_COMPANY == 'true') {
?>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_COMPANY; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_COMPANY; ?></td>
            <td class="main">
<?php
    if ($error == true) {
      if ($entry_company_error == true) {
        echo tep_draw_input_field('entry_company', $cInfo->entry_company, 'maxlength="32"') . '&nbsp;' . ENTRY_COMPANY_ERROR;
      } else {
        echo $cInfo->entry_company . tep_draw_hidden_field('entry_company');
      }
    } else {
      echo tep_draw_input_field('entry_company', $cInfo->entry_company, 'maxlength="32"');
    }
?></td>
          </tr>
        </table></td>
      </tr>
<?php
    }
?>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_ADDRESS; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_STREET_ADDRESS; ?></td>
            <td class="main">
<?php
  if ($error == true) {
    if ($entry_street_address_error == true) {
      echo tep_draw_input_field('entry_street_address', $cInfo->entry_street_address, 'maxlength="64"') . '&nbsp;' . ENTRY_STREET_ADDRESS_ERROR;
    } else {
      echo $cInfo->entry_street_address . tep_draw_hidden_field('entry_street_address');
    }
  } else {
    echo tep_draw_input_field('entry_street_address', $cInfo->entry_street_address, 'maxlength="64"', true);
  }
?></td>
          </tr>
<?php
    if (ACCOUNT_SUBURB == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_SUBURB; ?></td>
            <td class="main">
<?php
    if ($error == true) {
      if ($entry_suburb_error == true) {
        echo tep_draw_input_field('suburb', $cInfo->entry_suburb, 'maxlength="32"') . '&nbsp;' . ENTRY_SUBURB_ERROR;
      } else {
        echo $cInfo->entry_suburb . tep_draw_hidden_field('entry_suburb');
      }
    } else {
      echo tep_draw_input_field('entry_suburb', $cInfo->entry_suburb, 'maxlength="32"');
    }
?></td>
          </tr>
<?php
    }
?>
          <tr>
            <td class="main"><?php echo ENTRY_CITY; ?></td>
            <td class="main">
<?php
  if ($error == true) {
    if ($entry_city_error == true) {
      echo tep_draw_input_field('entry_city', $cInfo->entry_city, 'maxlength="32"') . '&nbsp;' . ENTRY_CITY_ERROR;
    } else {
      echo $cInfo->entry_city . tep_draw_hidden_field('entry_city');
    }
  } else {
    echo tep_draw_input_field('entry_city', $cInfo->entry_city, 'maxlength="32"', true);
  }
?></td>
          </tr>
<?php
    if (ACCOUNT_STATE == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_STATE; ?></td>
            <td class="main">
<?php
    $entry_state = tep_get_zone_name($cInfo->entry_country_id, $cInfo->entry_zone_id, $cInfo->entry_state);
    if ($error == true) {
      if ($entry_state_error == true) {
        if ($entry_state_has_zones == true) {
          $zones_array = array();
          $zones_query = tep_db_query("select zone_name from " . TABLE_ZONES . " where zone_country_id = '" . tep_db_input($cInfo->entry_country_id) . "' order by zone_name");
          while ($zones_values = tep_db_fetch_array($zones_query)) {
            $zones_array[] = array('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
          }
          echo tep_draw_pull_down_menu('entry_state', $zones_array) . '&nbsp;' . ENTRY_STATE_ERROR;
        } else {
          echo tep_draw_input_field('entry_state', tep_get_zone_name($cInfo->entry_country_id, $cInfo->entry_zone_id, $cInfo->entry_state)) . '&nbsp;' . ENTRY_STATE_ERROR;
        }
      } else {
        echo $entry_state . tep_draw_hidden_field('entry_zone_id') . tep_draw_hidden_field('entry_state');
      }
    } else {
      echo tep_draw_input_field('entry_state', tep_get_zone_name($cInfo->entry_country_id, $cInfo->entry_zone_id, $cInfo->entry_state));
    }

?></td>
         </tr>
<?php
    }
?>
          <tr>
            <td class="main"><?php echo ENTRY_POST_CODE; ?></td>
            <td class="main">
<?php
  if ($error == true) {
    if ($entry_post_code_error == true) {
      echo tep_draw_input_field('entry_postcode', $cInfo->entry_postcode, 'maxlength="8"') . '&nbsp;' . ENTRY_POST_CODE_ERROR;
    } else {
      echo $cInfo->entry_postcode . tep_draw_hidden_field('entry_postcode');
    }
  } else {
    echo tep_draw_input_field('entry_postcode', $cInfo->entry_postcode, 'maxlength="8"', true);
  }
?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_COUNTRY; ?></td>
            <td class="main">
<?php
  if ($error == true) {
    if ($entry_country_error == true) {
      echo tep_draw_pull_down_menu('entry_country_id', tep_get_countries(), $cInfo->entry_country_id) . '&nbsp;' . ENTRY_COUNTRY_ERROR;
    } else {
      echo tep_get_country_name($cInfo->entry_country_id) . tep_draw_hidden_field('entry_country_id');
    }
  } else {
    echo tep_draw_pull_down_menu('entry_country_id', tep_get_countries(), $cInfo->entry_country_id);
  }
?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_CONTACT; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
            <td class="main">
<?php
  if ($error == true) {
    if ($entry_telephone_error == true) {
      echo tep_draw_input_field('customers_telephone', $cInfo->customers_telephone, 'maxlength="32"') . '&nbsp;' . ENTRY_TELEPHONE_NUMBER_ERROR;
    } else {
      echo $cInfo->customers_telephone . tep_draw_hidden_field('customers_telephone');
    }
  } else {
    echo tep_draw_input_field('customers_telephone', $cInfo->customers_telephone, 'maxlength="32"', true);
  }
?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_FAX_NUMBER; ?></td>
            <td class="main">
<?php
  if ($processed == true) {
    echo $cInfo->customers_fax . tep_draw_hidden_field('customers_fax');
  } else {
    echo tep_draw_input_field('customers_fax', $cInfo->customers_fax, 'maxlength="32"');
  }
?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_OPTIONS; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_NEWSLETTER; ?></td>
            <td class="main">
<?php
  if ($processed == true) {
    if ($cInfo->customers_newsletter == '1') {
      echo ENTRY_NEWSLETTER_YES;
    } else {
      echo ENTRY_NEWSLETTER_NO;
    }
    echo tep_draw_hidden_field('customers_newsletter');
  } else {
    echo tep_draw_pull_down_menu('customers_newsletter', $newsletter_array, (($cInfo->customers_newsletter == '1') ? '1' : '0'));
  }
?></td>
          </tr>
<?php
// START Admin Notes
?>
          <tr>
            <td valign="top" class="main">Admin Notes:</td>
            <td class="main">
<?php
  if ($processed == true) {
	 echo $cInfo->customers_notes . tep_draw_hidden_field('customers_notes');
  } else {
	 echo tep_draw_textarea_field('customers_notes', 'soft', '75', '5', ($cInfo->customers_notes));
  }
?></td>
          </tr>
<?php
// END Admin Notes
?>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td align="right" class="main"><?php echo tep_image_submit('button_update.gif', IMAGE_UPDATE) . ' <a href="' . tep_href_link(FILENAME_CUSTOMERS_ADVANCED, tep_get_all_get_params(array('action'))) .'">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'; ?></td>
      </tr></form>
<?php
  } else {
?>
      <tr>
        <td>
		  <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
			<?php echo tep_draw_form('search', FILENAME_CUSTOMERS_ADVANCED, '', 'get'); ?>
            <td class="smallText" align="right"><?php echo HEADING_TITLE_SEARCH . ' ' . tep_draw_input_field('search').tep_hide_session_id(); ?></td>
          </form>
		                <td class="smallText" align="right">
<?php
	  $filterlist_sql= "select distinct g.customers_groups_id as id, g.customers_groups_name as name, g.customers_groups_discount as discount, g.customers_groups_price as pr_number from " . TABLE_CUSTOMERS_GROUPS . " g order by g.customers_groups_discount";
     
	  $filterlist_query = tep_db_query($filterlist_sql);
      if (tep_db_num_rows($filterlist_query) > 0) {
        echo tep_draw_form('group_filter', FILENAME_CUSTOMERS_ADVANCED, '', 'get') . TEXT_GROUP . '&nbsp;';
        if (isset($HTTP_GET_VARS['orderby']) && tep_not_null($HTTP_GET_VARS['orderby'])) {	
          echo tep_draw_hidden_field('orderby', $HTTP_GET_VARS['orderby']);
		}
        if (isset($HTTP_GET_VARS['sort']) && tep_not_null($HTTP_GET_VARS['sort'])) {	
          echo tep_draw_hidden_field('sort', $HTTP_GET_VARS['sort']);
		}
		$options = array(array('id' => '', 'text' => TEXT_ALL_GROUPS));
        while ($filterlist = tep_db_fetch_array($filterlist_query)) {
          $options[] = array('id' => $filterlist['id'], 'text' => $filterlist['name']);
        }
        echo tep_draw_pull_down_menu('group_filter', $options, (isset($HTTP_GET_VARS['group_filter']) ? $HTTP_GET_VARS['group_filter '] : ''), 'onchange="this.form.submit()"');
        echo tep_hide_session_id() .'</form>' . "\n";
      }
?>
            </td></tr>
        </table></td>
      </tr>
      
<?php

if($action == 'confirm') {
	echo '<tr><td width="100%"><div class="messageStackWarning" style="margin: 1em 0; padding: 5px;"><b>' . TEXT_INFO_HEADING_DELETE_CUSTOMER . 
	'</b><br>Are you sure you want to delete <i>' . $cInfo->customers_firstname . ' ' . $cInfo->customers_lastname . 
	'</i>\'s account? &nbsp;<a href="' . 
	tep_href_link(FILENAME_CUSTOMERS_ADVANCED, tep_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->customers_id . '&action=deleteconfirm') . 
	'">Yes, delete account</a> | <a href="' . 
	tep_href_link(FILENAME_CUSTOMERS_ADVANCED, tep_get_all_get_params(array('cID', 'action'))) . 
	'">No, go back</a></div></td></tr>';
}


/*
Function to print table headers based on current sort pattern
$name = Full name of header, usually defined in language files
$id = sort word used in URL
$current_dir = current sort direction (ASC or DESC)
*/
function print_sort( $name, $id, $default_sort ) {
	global $orderby, $sort;

	if( isset( $orderby ) && ( $orderby == $id ) ) {
		if( $sort == 'ASC' ) {
			$to_sort = 'DESC';
		} else {
			$to_sort = 'ASC';
		}
	} else {
		$to_sort = $default_sort;
	}
	$return = '<a href="' . tep_href_link(FILENAME_CUSTOMERS_ADVANCED, 'orderby=' . $id . '&amp;sort='. $to_sort) . 
	'" class="headerLink">' . $name . '</a>';
	if( $orderby == $id ) {
		$return .= '&nbsp;<img src="images/arrow_' . ( ( $to_sort == 'DESC' ) ? 'down' : 'up' ) . 
		'.png" width="10" height="13" border="0" alt="" />';
	}
	return $return;
}

?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_ACTIONS; ?></td>
                <td class="dataTableHeadingContent" nowrap><?php echo print_sort('cID', 'cID', 'ASC'); ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo 'Firma'; ?></td>
				<td class="dataTableHeadingContent" nowrap><?php echo print_sort(TABLE_HEADING_LASTNAME, 'lastname', 'ASC'); ?></td>
                <td class="dataTableHeadingContent" nowrap><?php echo print_sort(TABLE_HEADING_FIRSTNAME, 'firstname', 'ASC'); ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo print_sort(TABLE_HEADING_ACCOUNT_CREATED, 'date_created', 'DESC'); ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo print_sort(TABLE_HEADING_LAST_LOGIN, 'date_login', 'DESC'); ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo print_sort(TABLE_HEADING_NUM_LOGINS, 'num_logins', 'DESC'); ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo print_sort(TABLE_HEADING_TOTAL_ORDERS, 'ordersum', 'ASC'); ?></td>
				<td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_NUM_ORDERS; ?></td>
				<td class="dataTableHeadingContent" align="center"><?php echo print_sort(TABLE_HEADING_DISCOUNT, 'discount', 'ASC'); ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_TELEPHONE; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo print_sort(TABLE_HEADING_LOCATION, 'state', 'ASC'); ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_ADMIN_NOTES; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php

// Init variables
// $max_results = MAX_DISPLAY_SEARCH_RESULTS*2;
$search = '';

// Setup column sorting
if($orderby == 'lastname') {
	$db_orderby = 'c.customers_lastname ' . $sort . ', c.customers_firstname';
} elseif($orderby == 'firstname') { 
	$db_orderby = 'c.customers_firstname ' . $sort . ', c.customers_lastname';
} elseif($orderby == 'cID') { 
	$db_orderby = 'c.customers_id ' . $sort . ', c.customers_lastname';
} elseif($orderby == 'date_created') { 
	$db_orderby = 'date_account_created ' . $sort . ', c.customers_lastname';
} elseif($orderby == 'date_login') { 
	$db_orderby = 'last_logon ' . $sort . ', c.customers_lastname';
} elseif($orderby == 'num_logins') { 
	$db_orderby = 'num_logons ' . $sort . ', c.customers_lastname';	
} elseif($orderby == 'dob') { 
	$db_orderby = 'customers_dob ' . $sort . ', c.customers_lastname';
} elseif($orderby == 'state') {
	$db_orderby = 'country ' . $sort . ', state ' . $sort . ', city ' . $sort . ', c.customers_lastname';
} elseif($orderby == 'discount') { 
	$db_orderby = 'customers_discount ' . $sort . ', c.customers_lastname';
} elseif($orderby == 'ordersum') { 
	$db_orderby = 'ordersum ' . $sort . ', c.customers_lastname';
} else {
	$db_orderby = 'c.customers_lastname ASC, c.customers_firstname';
}
if(!$sort) $sort = 'ASC';

	$group_filter = '';
    if (isset($HTTP_GET_VARS['group_filter']) && tep_not_null($HTTP_GET_VARS['group_filter'])) {
    if (isset($HTTP_GET_VARS['search']) && tep_not_null($HTTP_GET_VARS['search'])) {
      $keywords = tep_db_input(tep_db_prepare_input($HTTP_GET_VARS['search']));
      $search = "c.customers_lastname like '%" . $keywords . "%' or c.customers_firstname like '%" . $keywords . "%' or c.customers_email_address like '%" . $keywords . "%'";
    }
	  $group_filter = tep_db_input(tep_db_prepare_input($HTTP_GET_VARS['group_filter']));
//      $group_filter = "where g.customers_lastname like '%" . $keywords . "%' or c.customers_firstname like '%" . $keywords . "%' or c.customers_email_address like '%" . $keywords . "%'";
	  
//		$customers_query_raw = "select c.customers_id, c.customers_lastname, c.customers_firstname, c.customers_status, c.customers_email_address, a.entry_country_id, c.customers_notes, c.customers_discount from " . TABLE_CUSTOMERS_GROUPS . " g left join " . TABLE_CUSTOMERS . " c on c.customers_groups_id = g.customers_groups_id left join " . TABLE_ADDRESS_BOOK . " a on c.customers_id = a.customers_id and c.customers_default_address_id = a.address_book_id where c.customers_groups_id = '" . (int)$group_filter . "'" . $search . " order by c.customers_lastname, c.customers_firstname";
	
		$customers_query_raw = 'select c.customers_id, c.customers_lastname, c.customers_firstname, c.customers_notes as notes, c.customers_email_address, c.customers_telephone, c.customers_dob, c.customers_discount, ci.customers_info_date_of_last_logon as last_logon, ci.customers_info_number_of_logons as num_logons, ci.customers_info_date_account_created as date_account_created, a.entry_city as city, z.zone_name as state, ctry.countries_iso_code_2 as country, a.entry_country_id, sum(op.products_quantity * op.final_price) as ordersum, a.entry_company from ' . TABLE_CUSTOMERS_GROUPS . ' g left join ' . TABLE_CUSTOMERS . ' c on c.customers_groups_id = g.customers_groups_id left join ' . TABLE_ORDERS . ' o on c.customers_id = o.customers_id left join ' . TABLE_ORDERS_PRODUCTS . ' op  on o.orders_id = op.orders_id left join ' . TABLE_ADDRESS_BOOK . ' a on c.customers_id = a.customers_id and c.customers_default_address_id = a.address_book_id left join ' . TABLE_CUSTOMERS_INFO . ' ci on c.customers_id = ci.customers_info_id left join ' . TABLE_COUNTRIES . ' ctry on a.entry_country_id = ctry.countries_id left join ' . TABLE_ZONES . ' z on a.entry_zone_id = z.zone_id where c.customers_groups_id = ' . (int)$group_filter . $search . ' group by c.customers_lastname, c.customers_firstname order by ' . $db_orderby . ' ' . $sort;

	} else {
    if (isset($HTTP_GET_VARS['search']) && tep_not_null($HTTP_GET_VARS['search'])) {
      $keywords = tep_db_input(tep_db_prepare_input($HTTP_GET_VARS['search']));
      $search = "where c.customers_lastname like '%" . $keywords . "%' or c.customers_firstname like '%" . $keywords . "%' or c.customers_email_address like '%" . $keywords . "%'";
    }
		$customers_query_raw = 'select c.customers_id, c.customers_lastname, c.customers_firstname, c.customers_notes as notes, c.customers_email_address, c.customers_telephone, c.customers_dob, c.customers_discount, ci.customers_info_date_of_last_logon as last_logon, ci.customers_info_number_of_logons as num_logons, ci.customers_info_date_account_created as date_account_created, a.entry_city as city, z.zone_name as state, ctry.countries_iso_code_2 as country, a.entry_country_id, sum(op.products_quantity * op.final_price) as ordersum, a.entry_company from ' . TABLE_CUSTOMERS . ' c left join ' . TABLE_ORDERS . ' o on c.customers_id = o.customers_id left join ' . TABLE_ORDERS_PRODUCTS . ' op  on o.orders_id = op.orders_id left join ' . TABLE_ADDRESS_BOOK . ' a on c.customers_id = a.customers_id and c.customers_default_address_id = a.address_book_id left join ' . TABLE_CUSTOMERS_INFO . ' ci on c.customers_id = ci.customers_info_id left join ' . TABLE_COUNTRIES . ' ctry on a.entry_country_id = ctry.countries_id left join ' . TABLE_ZONES . ' z on a.entry_zone_id = z.zone_id ' . $search . ' group by c.customers_lastname, c.customers_firstname order by ' . $db_orderby . ' ' . $sort;

//	    $customers_query_raw = 'select c.customers_id, c.customers_lastname, c.customers_firstname, c.customers_notes as notes, c.customers_email_address, c.customers_telephone, c.customers_dob, c.customers_discount, ci.customers_info_date_of_last_logon as last_logon, ci.customers_info_number_of_logons as num_logons, ci.customers_info_date_account_created as date_account_created, a.entry_city as city, z.zone_name as state, ctry.countries_iso_code_2 as country, a.entry_country_id, sum(op.products_quantity * op.final_price) as ordersum from ' . TABLE_ORDERS_PRODUCTS . ' op, ' . TABLE_ORDERS . ' o, ' . TABLE_CUSTOMERS . ' c left join ' . TABLE_ADDRESS_BOOK . ' a on c.customers_id = a.customers_id and c.customers_default_address_id = a.address_book_id left join ' . TABLE_CUSTOMERS_INFO . ' ci on c.customers_id = ci.customers_info_id left join ' . TABLE_COUNTRIES . ' ctry on a.entry_country_id = ctry.countries_id left join ' . TABLE_ZONES . ' z on a.entry_zone_id = z.zone_id where c.customers_id = o.customers_id and o.orders_id = op.orders_id ' . $search . ' group by c.customers_lastname, c.customers_firstname order by ' . $db_orderby . ' ' . $sort;	
	}


    $customers_split = new splitPageResults($HTTP_GET_VARS['page'], MAX_DISPLAY_SEARCH_RESULTS*2, $customers_query_raw, $customers_query_numrows);
    $customers_query = tep_db_query($customers_query_raw);
    while ($customers = tep_db_fetch_array($customers_query)) {
      $info_query = tep_db_query("select customers_info_date_account_created as date_account_created, customers_info_date_account_last_modified as date_account_last_modified, customers_info_date_of_last_logon as date_last_logon, customers_info_number_of_logons as number_of_logons from " . TABLE_CUSTOMERS_INFO . " where customers_info_id = '" . $customers['customers_id'] . "'");
      $info = tep_db_fetch_array($info_query);

      $zamowienia_query = tep_db_query("select o.orders_id, o.customers_id, ot.value from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on o.orders_id = ot.orders_id where o.customers_id = '" . $customers['customers_id'] . "' and ot.class = 'ot_total'");
	  $zamowienia_suma = 0; $zamowienia_ile=0;
      while ($zamowienia = tep_db_fetch_array($zamowienia_query)) {
		$zamowienia_ile++;
		$zamowienia_suma += $zamowienia['value'];
	  }

      if ((!isset($HTTP_GET_VARS['cID']) || (isset($HTTP_GET_VARS['cID']) && ($HTTP_GET_VARS['cID'] == $customers['customers_id']))) && !isset($cInfo)) {
        $country_query = tep_db_query("select countries_name from " . TABLE_COUNTRIES . " where countries_id = '" . (int)$customers['entry_country_id'] . "'");
        $country = tep_db_fetch_array($country_query);

        $reviews_query = tep_db_query("select count(*) as number_of_reviews from " . TABLE_REVIEWS . " where customers_id = '" . (int)$customers['customers_id'] . "'");
        $reviews = tep_db_fetch_array($reviews_query);

        $customer_info = array_merge($country, $info, $reviews);

        $cInfo_array = array_merge($customers, $customer_info);
        $cInfo = new objectInfo($cInfo_array);
      }

      if (isset($cInfo) && is_object($cInfo) && ($customers['customers_id'] == $cInfo->customers_id)) {
        echo '          <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_CUSTOMERS, tep_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->customers_id . '&action=edit') . '\'">' . "\n";
      } else {
        echo '          <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_CUSTOMERS_ADVANCED, tep_get_all_get_params(array('cID')) . 'cID=' . $customers['customers_id']) . '\'">' . "\n";
      }
?>
	<td class="dataTableContent" align="center"><?php echo 
	'<a href="' . tep_href_link(FILENAME_CUSTOMERS, tep_get_all_get_params(array('cID', 'action')) . 
	'cID=' . $customers['customers_id'] . '&action=edit') . '">Info/Edycja</a><br><a href="' . 
	tep_href_link(FILENAME_ORDERS, 'cID=' . $customers['customers_id']) . '">Zamówienia</a>';
	?></td>
                <td class="dataTableContent">&nbsp;<?php echo ucwords($customers['customers_id'] . '&nbsp;'); ?></td>
                <td class="dataTableContent">&nbsp;<?php echo ucwords($customers['entry_company']); ?></td>
                <td class="dataTableContent">&nbsp;<?php echo ucwords($customers['customers_lastname']); ?></td>
                <td class="dataTableContent">&nbsp;<?php echo ucwords($customers['customers_firstname']); ?></td>
                <td class="dataTableContent" align="center">&nbsp;<?php echo tep_date_short($customers['date_account_created']); ?></td>
                <td class="dataTableContent" align="center">&nbsp;<?php echo tep_date_short($info['date_last_logon']); ?></td>
                <td class="dataTableContent" align="center">&nbsp;<?php echo ($info['number_of_logons']); ?></td>
                <td class="dataTableContent" align="right">&nbsp;<?php echo (($customers['ordersum'])?'<a style="color:'.(($customers['ordersum']>=1000)?'#00C000':'#800000').';" href="'.tep_href_link(FILENAME_ORDERS,'cID='.(int)$customers['customers_id']).'"><b>':'');?><?php echo $currencies->format($customers['ordersum'], false).(($customers['ordersum'])?'</b></a>':''); ?></td>
                <td class="dataTableContent" align="center">&nbsp;<?php echo $zamowienia_ile; ?></td>
                <td class="dataTableContent" align="center" NOWRAP>&nbsp;<?php echo (($customers['customers_discount']!='-0.00')?$customers['customers_discount'].'%':'---'); ?></td>
                <td class="dataTableContent"> <?php echo $customers['customers_telephone']; ?></td>
                <td class="dataTableContent" align="center">&nbsp;<?php echo ucwords(($customers['country'] ? $customers['country'] : '<font color="#808080">---</font>') . ', ' . ($customers['state'] ? $customers['state'] : '<font color="#808080">---</font>') . ',<br>' . ($customers['city'] ? $customers['city'] : '<font color="#808080">---</font>')); ?></td>
                <td class="dataTableContent" align="center">&nbsp;<?php if (tep_not_null($customers['notes'])) {  echo '<img src="images/icons/tick.gif" width="14" height="14" border="0" alt="Yes, Has Notes">';  } ?></td>
                <td class="dataTableContent" align="right">&nbsp;<?php if (isset($cInfo) && is_object($cInfo) && ($customers['customers_id'] == $cInfo->customers_id)) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . tep_href_link(FILENAME_CUSTOMERS_ADVANCED, tep_get_all_get_params(array('cID')) . 'cID=' . $customers['customers_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }
?>
              <tr>
                <td colspan="11"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $customers_split->display_count($customers_query_numrows, MAX_DISPLAY_SEARCH_RESULTS*2, $HTTP_GET_VARS['page'], TEXT_DISPLAY_NUMBER_OF_CUSTOMERS); ?></td>
                    <td class="smallText" align="right"><?php echo $customers_split->display_links($customers_query_numrows, MAX_DISPLAY_SEARCH_RESULTS*2, MAX_DISPLAY_PAGE_LINKS, $HTTP_GET_VARS['page'], tep_get_all_get_params(array('page', 'info', 'x', 'y', 'cID'))); ?></td>
                  </tr>
<?php
    if (isset($HTTP_GET_VARS['search']) && tep_not_null($HTTP_GET_VARS['search'])) {
?>
                  <tr>
                    <td align="right" colspan="2"><?php echo '<a href="' . tep_href_link(FILENAME_CUSTOMERS_ADVANCED) . '">' . tep_image_button('button_reset.gif', IMAGE_RESET) . '</a>'; ?></td>
                  </tr>
<?php
    }
?>
                </table></td>
              </tr>
            </table></td>
<?php
  $heading = array();
  $contents = array();

  switch ($action) {
    case 'confirm':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_CUSTOMER . '</b>');

      $contents = array('form' => tep_draw_form('customers', FILENAME_CUSTOMERS_ADVANCED, tep_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->customers_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_DELETE_INTRO . '<br><br><b>' . $cInfo->customers_firstname . ' ' . $cInfo->customers_lastname . '</b>');
      if (isset($cInfo->number_of_reviews) && ($cInfo->number_of_reviews) > 0) $contents[] = array('text' => '<br>' . tep_draw_checkbox_field('delete_reviews', 'on', true) . ' ' . sprintf(TEXT_DELETE_REVIEWS, $cInfo->number_of_reviews));
      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . tep_href_link(FILENAME_CUSTOMERS_ADVANCED, tep_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->customers_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    default:
      if (isset($cInfo) && is_object($cInfo)) {
        $heading[] = array('text' => '<b>' . $cInfo->customers_firstname . ' ' . $cInfo->customers_lastname . '</b>');

	$contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_CUSTOMERS, tep_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->customers_id . '&action=edit') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a><br><a href="' . tep_href_link(FILENAME_CUSTOMERS_ADVANCED, tep_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->customers_id . '&action=confirm') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a><br><a href="' . tep_href_link(FILENAME_ORDERS, 'cID=' . $cInfo->customers_id) . '">' . tep_image_button('button_orders.gif', IMAGE_ORDERS) . '</a><br><a href="' . tep_href_link(FILENAME_MAIL, 'selected_box=tools&customer=' . $cInfo->customers_email_address) . '">' . tep_image_button('button_email.gif', IMAGE_EMAIL) . '</a>');

          $contents[] = array('text' => '<hr width="95%" size="1" color="#000000" noshade>');
          $contents[] = array('text' => '<strong>Notatki o Kliencie:</strong><br><br>' . $cInfo->notes);
          $contents[] = array('text' => '<hr><br /><strong>Koszyk:</strong><br><br>' . tep_check_cart_registered($cInfo->customers_id));

      }
      break;
  }

  if ( (tep_not_null($heading)) && (tep_not_null($contents)) ) {
    echo '            <td valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
?>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>
    </table></td>
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
