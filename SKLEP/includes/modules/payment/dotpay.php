<?php
/*
  $Id: dotpay.php,v 6.0.3 2008/01/14 11:57:15 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce
  Copyright (c) 2008 Dotpay.pl

  Released under the GNU General Public License
  Autor: Dotpay.pl
  http://www.dotpay.pl
*/

  class dotpay {
    var $code, $title, $description, $enabled;

// class constructor
    function dotpay() {
      global $order;

      $this->code = 'dotpay';
      $this->title = MODULE_PAYMENT_DOTPAY_TEXT_TITLE;
      $this->description = MODULE_PAYMENT_DOTPAY_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_DOTPAY_SORT_ORDER;
      $this->enabled = ((MODULE_PAYMENT_DOTPAY_STATUS == 'True') ? true : false);

      if ((int)MODULE_PAYMENT_DOTPAY_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_DOTPAY_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();

      $this->form_action_url = 'https://ssl.dotpay.pl/';
    }

// class methods
    function update_status() {
      global $order;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_DOTPAY_ZONE > 0) ) {
        $check_flag = false;
		$check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_DOTPAY_ZONE .
						"' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
        while ($check = tep_db_fetch_array($check_query)) {
          if ($check['zone_id'] < 1) {
            $check_flag = true;
            break;
          } elseif ($check['zone_id'] == $order->billing['zone_id']) {
            $check_flag = true;
            break;
          }
        }

        if ($check_flag == false) {
          $this->enabled = false;
        }
      }
    }

    function javascript_validation() {
      return false;
    }

    function selection() {
      return array('id' => $this->code,
                   'module' => $this->title);
    }

    function pre_confirmation_check() {
      return false;
    }

    function confirmation() {
	return array('title' => MODULE_PAYMENT_DOTPAY_TEXT_CONFIRMATION
                 );
    }

    function process_button() {
      global $order, $currencies, $currency, $languages_id, $customer_id, $osCsid, $_SID,$SID;

	$my_order = STORE_NAME . " - " . $customer_id."\n";
        if (is_array($order->products)) {
          foreach ($order->products as $pr => $ar) {
            if (is_array($ar)) { $my_order .= $ar['qty']."x - ".$ar['name']." => ".$ar['model'].": ".$ar['final_price']." ".$order->info['currency']."\n"; }
          }
          $my_order .= "+".$order->info['shipping_method'].": ".$order->info['shipping_cost']." ".$order->info['currency']."\n";
        }
	    $delivery_name = $order->delivery['firstname']." ".$order->delivery['lastname'];
	    $delivery_addr = "";
        if ($order->delivery['company']) $delivery_addr = $order->delivery['company']."\n";#ap
        $delivery_addr .= $order->delivery['street_address']." ";
		if($order->delivery['street_address_dom']) $delivery_addr .= $order->delivery['street_address_dom'];
		if($order->delivery['street_address_mieszkanie']) $delivery_addr .= ' m. ' . $order->delivery['street_address_mieszkanie'];
		
//		if($order->billing['street_address_dom']) $delivery_addr .= $order->delivery['street_address_dom'];
//		if($order->billing['street_address_mieszkanie']) $delivery_addr .= ' m. ' . $order->delivery['street_address_mieszkanie'];

		$delivery_addr .= "  ".$order->delivery['suburb']."\n".
                          $order->delivery['city'].", ".$order->delivery['postcode']." ".$order->delivery['state']."\n".
                          $order->delivery['country']['title'];

      $mini_control = "AP".MODULE_PAYMENT_DOTPAY_ID;
		$_SESSION['AP_CONTROL'] = $mini_control;
		$kwota = round($order->info['total']*$order->info['currency_value'], 2);
		$_SESSION['dotpay_amount'] = $kwota;

      $my_lang = tep_db_fetch_array(tep_db_query("select code from " . TABLE_LANGUAGES . " where languages_id = '" . (int)$languages_id . "'"));
      if ($my_lang['code'] == "pl") $mytitle = "Zamowienie";
      else $mytitle = "Order";

      $ADRES = $order->billing['street_address'];
	  if($order->billing['street_address_dom']) $ADRES .= ' '.$order->billing['street_address_dom'];
	  if($order->billing['street_address_mieszkanie']) $ADRES .= ' m. ' . $order->billing['street_address_mieszkanie'];
		if(!tep_not_null($osCsid)) $osCsid = session_id();
      $process_button_string = tep_draw_hidden_field('session_id', $osCsid) .
                               tep_draw_hidden_field('lang', strtolower($my_lang['code'])) .
                               tep_draw_hidden_field('pay', 'yes') .
                               tep_draw_hidden_field('waluta', $order->info['currency']) .
                               tep_draw_hidden_field('osC', '1') .
                               tep_draw_hidden_field('id', MODULE_PAYMENT_DOTPAY_ID) .
                               tep_draw_hidden_field('kanal', '0') .
                               tep_draw_hidden_field('kwota', $kwota) .
                               tep_draw_hidden_field('opis', STORE_NAME." - ".$mytitle.' ' . $customer_id . '-' . date('Ymdhis') ) .
                               tep_draw_hidden_field('forename', $order->billing['firstname']) .
                               tep_draw_hidden_field('surname', $order->billing['lastname']) .
                               tep_draw_hidden_field('oscdesc', $my_order) .
                               tep_draw_hidden_field('oscname', $delivery_name) .
                               tep_draw_hidden_field('deladdr', $delivery_addr) .
                               tep_draw_hidden_field('street', $ADRES) .
                               tep_draw_hidden_field('street_n1', $order->billing['suburb']) .
                               tep_draw_hidden_field('city', $order->billing['city']) .
                               tep_draw_hidden_field('bill_state', $order->billing['state']) .
                               tep_draw_hidden_field('postcode', $order->billing['postcode']) .
                               tep_draw_hidden_field('country', $order->billing['country']['title']) .
                               tep_draw_hidden_field('comments', $order->info['comments']) .
                               tep_draw_hidden_field('phone', $order->customer['telephone']) .
                               tep_draw_hidden_field('email', $order->customer['email_address']) .
                               tep_draw_hidden_field('control', $mini_control) .
                               tep_draw_hidden_field('vmodule', '6.0.3') .
			       			   tep_draw_hidden_field('URLC', tep_href_link('dotpay.php','','SSL')) .
                               tep_draw_hidden_field('return_url', tep_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL')) .
							   tep_draw_hidden_field('cancel_return_url', tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
      return $process_button_string;

    }

    function before_process() {
      return false;
    }

    function after_process() {
        global $insert_id, $aptid;
        $myoid=tep_db_fetch_array(tep_db_query("select orders_status_history_id from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_id='".(int)$insert_id."' limit 1"));
        $updqry=tep_db_query("update " . TABLE_ORDERS_STATUS_HISTORY . " set comments=concat(comments,'\n" .$aptid . "') where orders_status_history_id='".(int)$myoid['orders_status_history_id']."' limit 1");
      return true;
    }

    function output_error() {
      return false;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_DOTPAY_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
		global $languages_id;
		$my_lang = tep_db_fetch_array(tep_db_query("select code from " . TABLE_LANGUAGES . " where languages_id = '" . (int)$languages_id . "'"));
		switch ($my_lang['code']) {
			case "pl":
				define('MODULE_PAYMENT_DOTPAY_INSTALL_TEXT_0_DOTPAYEN','Wlacz modul Dotpay');
				define('MODULE_PAYMENT_DOTPAY_INSTALL_TEXT_1_DOTPAYENINFO','Czy chcesz przyjmowac platnosci za pomoca serwisu Dotpay?');
				define('MODULE_PAYMENT_DOTPAY_INSTALL_TEXT_2_DOTPAYID','Numer ID w Dotpay.pl');
				define('MODULE_PAYMENT_DOTPAY_INSTALL_TEXT_3_DOTPAYINFO','Podaj swoj numer ID w serwisie Dotpay:');
				define('MODULE_PAYMENT_DOTPAY_INSTALL_TEXT_4_URLCPIN','Potwierdzenia URLC - PIN');
				define('MODULE_PAYMENT_DOTPAY_INSTALL_TEXT_5_URLCPININFO','Wprowadz swoj numer PIN do potwierdzen URLC.');
				break;
			default:
				define('MODULE_PAYMENT_DOTPAY_INSTALL_TEXT_0_DOTPAYEN','Enable Dotpay Module');
				define('MODULE_PAYMENT_DOTPAY_INSTALL_TEXT_1_DOTPAYENINFO','Do you want to accept Dotpay payments?');
				define('MODULE_PAYMENT_DOTPAY_INSTALL_TEXT_2_DOTPAYID','Dotpay ID number');
				define('MODULE_PAYMENT_DOTPAY_INSTALL_TEXT_3_DOTPAYINFO','Your Dotpay ID number:');
				define('MODULE_PAYMENT_DOTPAY_INSTALL_TEXT_4_URLCPIN','URLC PIN value');
				define('MODULE_PAYMENT_DOTPAY_INSTALL_TEXT_5_URLCPININFO',
							"Put your PIN value for Dotpay URLC confirmation service. Empty value means you are not using URLC PIN.");
				break;
		}

		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, " .
						"configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_PAYMENT_DOTPAY_INSTALL_TEXT_0_DOTPAYEN .
						"', 'MODULE_PAYMENT_DOTPAY_STATUS', 'True', '" . MODULE_PAYMENT_DOTPAY_INSTALL_TEXT_1_DOTPAYENINFO .
						"', '6', '3', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, " .
						"configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_DOTPAY_INSTALL_TEXT_2_DOTPAYID .
						"', 'MODULE_PAYMENT_DOTPAY_ID', '00000', '" . MODULE_PAYMENT_DOTPAY_INSTALL_TEXT_3_DOTPAYINFO .
						"', '6', '4', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, " .
						"configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_DOTPAY_INSTALL_TEXT_4_URLCPIN .
						"', 'MODULE_PAYMENT_DOTPAY_URLCPIN', '', '" . MODULE_PAYMENT_DOTPAY_INSTALL_TEXT_5_URLCPININFO .
						"', '6', '1', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, " .
						"configuration_group_id, sort_order, date_added) values ('Sort order of display.', 'MODULE_PAYMENT_DOTPAY_SORT_ORDER', '0', " .
						"'Sort order of display. Lowest is displayed first.', '6', '0', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, " .
						"configuration_group_id, sort_order, use_function, set_function, date_added) values ('Payment Zone', " .
						"'MODULE_PAYMENT_DOTPAY_ZONE', '0', 'If a zone is selected, only enable this payment method for that zone.', '6', '2', " .
						"'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, " .
						"configuration_group_id, sort_order, set_function, use_function, date_added) values ('Set Order Status', " .
						"'MODULE_PAYMENT_DOTPAY_ORDER_STATUS_ID', '0', 'Set the status of orders made with this payment module to this value', '6', '0', " .
						"'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");
    }// install

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }// remove

    function keys() {
      return array('MODULE_PAYMENT_DOTPAY_STATUS', 'MODULE_PAYMENT_DOTPAY_ID', 'MODULE_PAYMENT_DOTPAY_URLCPIN', 'MODULE_PAYMENT_DOTPAY_ZONE', 'MODULE_PAYMENT_DOTPAY_ORDER_STATUS_ID', 'MODULE_PAYMENT_DOTPAY_SORT_ORDER');
    }// keys
  }
?>
