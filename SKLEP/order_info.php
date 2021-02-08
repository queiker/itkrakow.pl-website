<?php
/*
  $Id: create_account.php,v 1.65 2003/06/09 23:03:54 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

// Includes Country-State Selector (http://www.oscommerce.com/community/contributions,2028) and
// Purchase Without Account 0.90 (http://www.oscommerce.com/community/contributions,355)
// 

  require('includes/application_top.php');
  define('ENTRY_STREET_ADDRESS_DOM_MIN_LENGTH',1);

// needs to be included earlier to set the success message in the messageStack
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CREATE_ACCOUNT);
	
  $process = false;
  // +Country-State Selector
  $refresh = false;
  if (isset($HTTP_POST_VARS['action']) && (($HTTP_POST_VARS['action'] == 'process') || ($HTTP_POST_VARS['action'] == 'refresh'))) {
    if ($HTTP_POST_VARS['action'] == 'process')  $process = true;
	if ($HTTP_POST_VARS['action'] == 'refresh') $refresh = true;
	}
  // -Country-State Selector

    if (ACCOUNT_GENDER == 'true') {
      if (isset($HTTP_POST_VARS['gender'])) {
        $gender = tep_db_prepare_input($HTTP_POST_VARS['gender']);
      } else {
        $gender = false;
      }
    }
    $firstname = tep_db_prepare_input($HTTP_POST_VARS['firstname']);
    $lastname = tep_db_prepare_input($HTTP_POST_VARS['lastname']);
    if (ACCOUNT_DOB == 'true') $dob = tep_db_prepare_input($HTTP_POST_VARS['dob']);
    $email_address = tep_db_prepare_input($HTTP_POST_VARS['email_address']);
    if (ACCOUNT_COMPANY == 'true') $company = tep_db_prepare_input($HTTP_POST_VARS['company']);
    $street_address = tep_db_prepare_input($HTTP_POST_VARS['street_address']);
	$nip = tep_db_prepare_input($HTTP_POST_VARS['nip']);
	$street_address_dom = tep_db_prepare_input($HTTP_POST_VARS['street_address_dom']);
	$street_address_mieszkanie = tep_db_prepare_input($HTTP_POST_VARS['street_address_mieszkanie']);
    if (ACCOUNT_SUBURB == 'true') $suburb = tep_db_prepare_input($HTTP_POST_VARS['suburb']);
    $postcode = tep_db_prepare_input($HTTP_POST_VARS['postcode']);
    $city = tep_db_prepare_input($HTTP_POST_VARS['city']);
    if (ACCOUNT_STATE == 'true') {
      $state = tep_db_prepare_input($HTTP_POST_VARS['state']);
      if (isset($HTTP_POST_VARS['zone_id'])) {
        $zone_id = tep_db_prepare_input($HTTP_POST_VARS['zone_id']);
      } else {
        $zone_id = false;
      }
    }
    $country = tep_db_prepare_input($HTTP_POST_VARS['country']);
    $telephone = tep_db_prepare_input($HTTP_POST_VARS['telephone']);
    $fax = tep_db_prepare_input($HTTP_POST_VARS['fax']);
    if (isset($HTTP_POST_VARS['newsletter'])) {
      $newsletter = tep_db_prepare_input($HTTP_POST_VARS['newsletter']);
    } else {
      $newsletter = false;
    }
	$password = '';

    // +Country-State Selector
	if ($process) {
		// -Country-State Selector
		$error = false;
		
		if (ACCOUNT_GENDER == 'true') {
			if ( ($gender != 'm') && ($gender != 'f') ) {
			$error = true;
		
			$messageStack->add('create_account', ENTRY_GENDER_ERROR);
			}
		}

		if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
		  $error = true;
	
		  $messageStack->add('create_account', ENTRY_FIRST_NAME_ERROR);
		}
	
		if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
		  $error = true;
	
		  $messageStack->add('create_account', ENTRY_LAST_NAME_ERROR);
		}
	
		if (ACCOUNT_DOB == 'true') {
		  if (checkdate(substr(tep_date_raw($dob), 4, 2), substr(tep_date_raw($dob), 6, 2), substr(tep_date_raw($dob), 0, 4)) == false) {
			$error = true;
	
			$messageStack->add('create_account', ENTRY_DATE_OF_BIRTH_ERROR);
		  }
		}
	
		if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
		  $error = true;
	
		  $messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR);
		} elseif (tep_validate_email($email_address) == false) {
		  $error = true;
	
		  $messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
		} else {
		  $check_email_query = tep_db_query("select count(*) as total from " . TABLE_CUSTOMERS . " where customers_email_address = '" . tep_db_input($email_address) . "'");
		  $check_email = tep_db_fetch_array($check_email_query);
		  if ($check_email['total'] > 0) {
			$error = true;
	
			$messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);
		  }
		}
	
		if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
		  $error = true;
	
		  $messageStack->add('create_account', ENTRY_STREET_ADDRESS_ERROR);
		}
		if (strlen($street_address) < ENTRY_STREET_ADDRESS_DOM_MIN_LENGTH) {
		  $error = true;
	
		  $messageStack->add('create_account', 'Podaj numer domu');
		}
	
		if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
		  $error = true;
	
		  $messageStack->add('create_account', ENTRY_POST_CODE_ERROR);
		}
	
		if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
		  $error = true;
	
		  $messageStack->add('create_account', ENTRY_CITY_ERROR);
		}
	
		if (is_numeric($country) == false) {
		  $error = true;
	
		  $messageStack->add('create_account', ENTRY_COUNTRY_ERROR);
		}
	
		if (ACCOUNT_STATE == 'true') {
		  // +Country-State Selector
		  if ($zone_id == 0) {
		  // -Country-State Selector
	
			if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
			  $error = true;
	
			  $messageStack->add('create_account', ENTRY_STATE_ERROR);
			}
		  }
		}
	
		if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
		  $error = true;
	
		  $messageStack->add('create_account', ENTRY_TELEPHONE_NUMBER_ERROR);
		}
		
		if ($error == false) {
	
			// PWA 0.70 : SELECT using new method of determining a customer has purchased without account:
			$check_customer_query = tep_db_query("select customers_id, purchased_without_account, 
				customers_firstname, customers_password, customers_email_address,
				customers_default_address_id from " . TABLE_CUSTOMERS . "
				where upper(customers_email_address) = '" . strtoupper($HTTP_POST_VARS['email_address']) . "' and
				upper(customers_firstname) = '" . strtoupper($HTTP_POST_VARS['firstname']) . "' and
				upper(customers_lastname) = '" . strtoupper($HTTP_POST_VARS['lastname']) . "'");
	   
			// if password is EMPTY (null) and e-mail address is same then we just load up their account information.
			// could be security flaw -- might want to setup password = somestring and have it recheck here (during the first initial
			// creation
	
			$check_customer = tep_db_fetch_array($check_customer_query);
			
			if (tep_db_num_rows($check_customer_query)) {
					
				// PWA 0.70 added this for backwards compatibility with older versions of PWA
				// that made a blank password, causing logins to fail:
				if(!$check_customer['purchased_without_account']) {
					list($md5hash, $salt) = explode(':',$check_customer['customers_password']);
					if(md5($salt) == $md5hash) {
						// password was blank; customer purchased without account using a previous version of PWA code
						$check_customer['purchased_without_account'] = 1;
					}
				}
			
				if ($check_customer['purchased_without_account'] != 1) {
					// Customer found and has account - make them log in.
					tep_redirect(tep_href_link(FILENAME_LOGIN, 
						'login=fail&reason=' . urlencode(
						str_replace('{EMAIL_ADDRESS}',$check_customer['customers_email_address'],PWA_FAIL_ACCOUNT_EXISTS)), 'SSL'));
	
				} else {
					// Customer found but no account - fetch their details.
					
					$customer_id = $check_customer['customers_id'];
					// now get latest address book entry:
					$get_default_address = tep_db_query("select address_book_id, entry_country_id, entry_zone_id from " . TABLE_ADDRESS_BOOK . "
						where customers_id = '" . $customer_id . "' ORDER BY address_book_id DESC LIMIT 1");
					$default_address = tep_db_fetch_array($get_default_address);
					$customer_default_address_id = $default_address['address_book_id'];
					$customer_first_name = $check_customer['customers_firstname'];
					$customer_country_id = $default_address['entry_country_id'];
					$customer_zone_id = $default_address['entry_zone_id'];
					tep_session_register('customer_id');
					tep_session_register('customer_default_address_id');
					tep_session_register('customer_first_name');
					tep_session_register('customer_country_id');
					tep_session_register('customer_zone_id');
					// PWA 0.71 update returning customer's address book:
					$customer_update = array('customers_firstname' => $firstname,
						'customers_lastname' => $lastname,
						'customers_telephone' => $telephone,
						'customers_fax' => $fax);
					if (ACCOUNT_GENDER == 'true') $customer_update['customers_gender'] = $gender;
					tep_db_perform(TABLE_CUSTOMERS, $customer_update, 'update', "customers_id = '".$customer_id."'");
	   
					$address_book_update = array('customers_id' => $customer_id,
						'entry_firstname' => $firstname,
						'entry_lastname' => $lastname,
						'entry_street_address' => $street_address,
						'entry_postcode' => $postcode,
						'entry_city' => $city,
						'entry_country_id' => $country);
					if (ACCOUNT_GENDER == 'true') $address_book_update['entry_gender'] = $gender;
					if (ACCOUNT_COMPANY == 'true') $address_book_update['entry_company'] = $company;
					if (ACCOUNT_SUBURB == 'true') $address_book_update['entry_suburb'] = $suburb;
					if (ACCOUNT_STATE == 'true') {
						if ($zone_id > 0) {
							$address_book_update['entry_zone_id'] = $zone_id;
							$address_book_update['entry_state'] = '';
						} else {
							$address_book_update['entry_zone_id'] = '0';
							$address_book_update['entry_state'] = $state;
						}
					}
					
					tep_db_perform(TABLE_ADDRESS_BOOK, $address_book_update, 'update', "address_book_id = '".$customer_default_address_id."'");
				} // if-else $pass_ok
		
				if ($HTTP_POST_VARS['setcookie'] == '1') {
					setcookie('email_address', $HTTP_POST_VARS['email_address'], time()+2592000);
					setcookie('password', $HTTP_POST_VARS['password'], time()+2592000);
					setcookie('first_name', $customer_first_name, time()+2592000);
				} elseif ( ($HTTP_COOKIE_VARS['email_address']) && ($HTTP_COOKIE_VARS['password']) ) {
					setcookie('email_address', '');
					setcookie('password', '');
					setcookie('first_name', '');
				} // if cookies
	
				$date_now = date('Ymd');
				tep_db_query("update " . TABLE_CUSTOMERS_INFO . " set customers_info_date_of_last_logon = now(),
					customers_info_number_of_logons = customers_info_number_of_logons+1 where customers_info_id = '" . $customer_id . "'");
		
			} else {
				// if customer_exist = NO
		
				// PWA 0.70 : new way of determining a customer purchased without an account : just say so!
				$sql_data_array = array('purchased_without_account' => 1,
									'customers_firstname' => $firstname,
									'customers_lastname' => $lastname,
									'customers_email_address' => $email_address,
									'customers_telephone' => $telephone,
									'customers_fax' => $fax,
									'customers_newsletter' => $newsletter,
									'customers_password' => tep_encrypt_password($password));
		//                            'customers_default_address_id' => 1);
		
				if (ACCOUNT_GENDER == 'true') $sql_data_array['customers_gender'] = $gender;
				if (ACCOUNT_DOB == 'true') $sql_data_array['customers_dob'] = tep_date_raw($dob);
		
				tep_db_perform(TABLE_CUSTOMERS, $sql_data_array);
		
				$customer_id = tep_db_insert_id();
		
				$sql_data_array = array('customers_id' => $customer_id,
									'address_book_id' => $address_id,
									'entry_firstname' => $firstname,
									'entry_lastname' => $lastname,
									'entry_street_address' => $street_address,
									'entry_postcode' => $postcode,
									'entry_city' => $city,
									'entry_country_id' => $country,
		                            'entry_street_address_dom' => $street_address_dom,
		                            'entry_street_address_mieszkanie' => $street_address_mieszkanie);
		
				if (ACCOUNT_GENDER == 'true') $sql_data_array['entry_gender'] = $gender;
				if (ACCOUNT_COMPANY == 'true') $sql_data_array['entry_company'] = $company;
			    if (ACCOUNT_NIP == 'true') $sql_data_array['entry_nip'] = $nip;
				if (ACCOUNT_SUBURB == 'true') $sql_data_array['entry_suburb'] = $suburb;
				if (ACCOUNT_STATE == 'true') {
					if ($zone_id > 0) {
						$sql_data_array['entry_zone_id'] = $zone_id;
						$sql_data_array['entry_state'] = '';
					} else {
						$sql_data_array['entry_zone_id'] = '0';
						$sql_data_array['entry_state'] = $state;
					}
				}
		
				tep_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);
				
				$address_id = tep_db_insert_id();
				  
				tep_db_query("update " . TABLE_CUSTOMERS . " set customers_default_address_id = '" . (int)$address_id . "' where customers_id = '" . (int)$customer_id . "'");
			
				tep_db_query("insert into " . TABLE_CUSTOMERS_INFO . " (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('" . (int)$customer_id . "', '0', now())");	
			
				$customer_first_name = $firstname;
				$customer_default_address_id = $address_id;
				$customer_country_id = $country;
				$customer_zone_id = $zone_id;
				tep_session_register('customer_id');
				tep_session_register('customer_first_name');
				tep_session_register('customer_default_address_id');
				tep_session_register('customer_country_id');
				tep_session_register('customer_zone_id');
			
			}  // end of check for whether customer exists.
		
			// restore cart contents
			$cart->restore_contents();
			
			tep_session_register('noaccount');
			$noaccount = 1;
			tep_redirect(tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
		} // if ($error = false)
	
	// +Country-State Selector 
	} // if ($process)
if ($HTTP_POST_VARS['action'] == 'refresh') {$state = '';}
if (!isset($country)){$country = DEFAULT_COUNTRY;}
// -Country-State Selector

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'));
?>
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_TEMPLATES . $template . $language . '/stylesheet.css';?>">
<?php require('includes/form_check.js.php'); ?>
</head>
<body>
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<?php include('includes/body.php'); ?>
    <td width="100%" valign="top"><?php echo tep_draw_form('create_account', tep_href_link(FILENAME_ORDER_INFO, '', 'SSL'), 'post', 'onSubmit="return check_form(create_account);"') . tep_draw_hidden_field('action', 'process'); ?>

	<table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php
			$info_box_contents = array();
			$info_box_contents[] = array('text' => HEADING_TITLE_NO_ACCOUNT);
			new infoBoxHeading($info_box_contents, true, true);
	  ?></td>
      </tr>
	</table>

	<table border="0" width="100%" cellspacing="0" cellpadding="0" class="blrb">
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="smallText"><br><?php echo sprintf(TEXT_ORIGIN_LOGIN, tep_href_link(FILENAME_LOGIN, tep_get_all_get_params(), 'SSL')); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  if ($messageStack->size('create_account') > 0) {
?>
      <tr>
        <td><?php echo $messageStack->output('create_account'); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  }
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><b><?php echo CATEGORY_PERSONAL; ?></b></td>
           <td class="inputRequirement" align="right"><?php echo FORM_REQUIRED_INFORMATION; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" cellspacing="2" cellpadding="2">
<?php
  if (ACCOUNT_GENDER == 'true') {
?>
              <tr>
                <td class="main"><?php echo ENTRY_GENDER; ?></td>
                <td class="main"><?php echo tep_draw_radio_field('gender', 'm') . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . tep_draw_radio_field('gender', 'f') . '&nbsp;&nbsp;' . FEMALE . '&nbsp;' . (tep_not_null(ENTRY_GENDER_TEXT) ? '<span class="inputRequirement">' . ENTRY_GENDER_TEXT . '</span>': ''); ?></td>
              </tr>
<?php
  }
?>
              <tr>
                <td class="main"><?php echo ENTRY_FIRST_NAME; ?></td>
                <td class="main"><?php echo tep_draw_input_field('firstname') . '&nbsp;' . (tep_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>': ''); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo ENTRY_LAST_NAME; ?></td>
                <td class="main"><?php echo tep_draw_input_field('lastname') . '&nbsp;' . (tep_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_LAST_NAME_TEXT . '</span>': ''); ?></td>
              </tr>
<?php
  if (ACCOUNT_DOB == 'true') {
?>
              <tr>
                <td class="main"><?php echo ENTRY_DATE_OF_BIRTH; ?></td>
                <td class="main"><?php echo tep_draw_input_field('dob') . '&nbsp;' . (tep_not_null(ENTRY_DATE_OF_BIRTH_TEXT) ? '<span class="inputRequirement">' . ENTRY_DATE_OF_BIRTH_TEXT . '</span>': ''); ?></td>
              </tr>
<?php
  }
?>
              <tr>
                <td class="main"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
                <td class="main"><?php echo tep_draw_input_field('email_address') . '&nbsp;' . (tep_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
<?php
  if (ACCOUNT_COMPANY == 'true') {
?>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo CATEGORY_COMPANY; ?></b></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td class="main"><?php echo ENTRY_COMPANY; ?></td>
                <td class="main"><?php echo tep_draw_input_field('company') . '&nbsp;' . (tep_not_null(ENTRY_COMPANY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COMPANY_TEXT . '</span>': ''); ?></td>
              </tr>
<!-- Insert by Pazio pazio@sitenet.pl start -->
<?php
  if (ACCOUNT_NIP == 'true') {
?>  
          <tr>
            <td class="main"><?php echo ENTRY_NIP; ?></td>
            <td class="main"><?php echo tep_draw_input_field('nip') . '&nbsp;' . (tep_not_null(ENTRY_NIP_TEXT) ? '<span class="inputRequirement">' . ENTRY_NIP_TEXT . '</span>': ''); ?></td>
          </tr>
<?php
  }
?>
<!-- Insert by Pazio pazio@sitenet.pl end -->
            </table></td>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>

      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo CATEGORY_ADDRESS; ?></b></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td class="main"><?php echo ENTRY_STREET_ADDRESS; ?></td>
                <td class="main"><?php echo tep_draw_input_field('street_address') . '&nbsp;' . (tep_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': ''); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo ENTRY_STREET_ADDRESS_DOM; ?></td>
                <td class="main"><?php echo tep_draw_input_field('street_address_dom','',' size="3"') . '&nbsp;' . (tep_not_null(ENTRY_STREET_ADDRESS_DOM_TEXT) ? '<span class="inputRequirement">' . ENTRY_STREET_ADDRESS_DOM_TEXT . '</span>': ''); ?> <?php echo ENTRY_STREET_ADDRESS_MIESZKANIE; ?> <?php echo tep_draw_input_field('street_address_mieszkanie','',' size="3"') . '&nbsp;' . (tep_not_null(ENTRY_STREET_ADDRESS_MIESZKANIE_TEXT) ? '<span class="inputRequirement">' . ENTRY_STREET_ADDRESS_MIESZKANIE_TEXT . '</span>': ''); ?></td>
              </tr>
<?php
  if (ACCOUNT_SUBURB == 'true') {
?>
              <tr>
                <td class="main"><?php echo ENTRY_SUBURB; ?></td>
                <td class="main"><?php echo tep_draw_input_field('suburb') . '&nbsp;' . (tep_not_null(ENTRY_SUBURB_TEXT) ? '<span class="inputRequirement">' . ENTRY_SUBURB_TEXT . '</span>': ''); ?></td>
              </tr>
<?php
  }
?>
              <tr>
                <td class="main"><?php echo ENTRY_POST_CODE; ?></td>
                <td class="main"><?php echo tep_draw_input_field('postcode') . '&nbsp;' . (tep_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement">' . ENTRY_POST_CODE_TEXT . '</span>': ''); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo ENTRY_CITY; ?></td>
                <td class="main"><?php echo tep_draw_input_field('city') . '&nbsp;' . (tep_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">' . ENTRY_CITY_TEXT . '</span>': ''); ?></td>
              </tr>
<?php
  if (ACCOUNT_STATE == 'true') {
?>
              <tr>
                <td class="main"><?php echo ENTRY_STATE; ?></td>
                <td class="main">
<?php
// +Country-State Selector
        $zones_array = array();
         $zones_query = tep_db_query("select zone_id, zone_name from " . TABLE_ZONES . " where zone_country_id = " . (int)$country . " order by zone_name");
        while ($zones_values = tep_db_fetch_array($zones_query)) {
          $zones_array[] = array('id' => $zones_values['zone_id'], 'text' => $zones_values['zone_name']);
        }
		if (count($zones_array) > 0) {
          echo tep_draw_pull_down_menu('zone_id', $zones_array);
		} else {
		  echo tep_draw_input_field('state');
		}
// -Country-State Selector
    if (tep_not_null(ENTRY_STATE_TEXT)) echo '&nbsp;<span class="inputRequirement">' . ENTRY_STATE_TEXT;
	
?>
                </td>
              </tr>
<?php
  }
?>
              <tr>
                <td class="main"><?php echo ENTRY_COUNTRY; ?></td>
				<?php // +Country-State Selector ?>
                <td class="main"><?php echo tep_get_country_list('country',$country,'onChange="return refresh_form(create_account);"') . '&nbsp;' . (tep_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COUNTRY_TEXT . '</span>': ''); ?></td>
				<?php // -Country-State Selector ?>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo CATEGORY_CONTACT; ?></b></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td class="main"><?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
                <td class="main"><?php echo tep_draw_input_field('telephone') . '&nbsp;' . (tep_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_TELEPHONE_NUMBER_TEXT . '</span>': ''); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo ENTRY_FAX_NUMBER; ?></td>
                <td class="main"><?php echo tep_draw_input_field('fax') . '&nbsp;' . (tep_not_null(ENTRY_FAX_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_FAX_NUMBER_TEXT . '</span>': ''); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
	  <?php echo tep_draw_hidden_field("password","DummyForPWA") . tep_draw_hidden_field("confirmation","DummyForPWA"); ?>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td><?php echo tep_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></form></td>
<!-- body_text_eof //-->
<?php include('includes/footer_0.php'); ?>
<!-- body_eof //-->

<!-- footer //-->
<?php include(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>