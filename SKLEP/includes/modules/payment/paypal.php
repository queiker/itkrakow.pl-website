<?php
/*
  $Id: $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/

  class paypal {
    var $code, $title, $description, $enabled;

// class constructor
    function paypal() {
      global $order;

      $this->code = 'paypal';
      $this->title = MODULE_PAYMENT_PAYPAL_TEXT_TITLE;
      $this->description = MODULE_PAYMENT_PAYPAL_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_PAYPAL_SORT_ORDER;
	  $wysylka = substr($GLOBALS['shipping']['id'], 0, strpos($GLOBALS['shipping']['id'], '_'));
##      $this->enabled = ((MODULE_PAYMENT_PAYPAL_STATUS == 'True') ? (( $wysylka != 'pp' && $wysylka != 'pp2' && $wysylka != 'dp4' )?true:false) : false);
      $this->enabled = ((MODULE_PAYMENT_PAYPAL_STATUS == 'True') ? true:false);

      if ((int)MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();

      if (MODULE_PAYMENT_PAYPAL_TRANSACTION_SERVER == 'Live') {
        $this->form_action_url = 'https://secure.paypal.com/cgi-bin/webscr';
      } else {
        $this->form_action_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
      }
    }

// class methods
    function update_status() {
      global $order;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_PAYPAL_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_PAYPAL_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
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
      return false;
    }

    function process_button() {
      global $order, $currencies, $currency;

      if (MODULE_PAYMENT_PAYPAL_CURRENCY == 'Selected Currency') {
        $my_currency = $currency;
      } else {
        $my_currency = substr(MODULE_PAYMENT_PAYPAL_CURRENCY, 5);
      }
      if (!in_array($my_currency, array('PLN', 'CAD', 'EUR', 'GBP', 'JPY', 'USD'))) {
        $my_currency = 'USD';
      }

      $process_button_string = tep_draw_hidden_field('cmd', '_xclick') .
                               tep_draw_hidden_field('business', MODULE_PAYMENT_PAYPAL_ID) .
                               tep_draw_hidden_field('item_name', STORE_NAME) .
                               tep_draw_hidden_field('amount', number_format(($order->info['total'] - $order->info['shipping_cost']) * $currencies->get_value($my_currency), $currencies->get_decimal_places($my_currency))) .
                               tep_draw_hidden_field('shipping', number_format($order->info['shipping_cost'] * $currencies->get_value($my_currency), $currencies->get_decimal_places($my_currency))) .
                               tep_draw_hidden_field('currency_code', $my_currency) .
                               tep_draw_hidden_field('return', tep_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL')) .
                               tep_draw_hidden_field('cancel_return', tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));

      return $process_button_string;
    }

    function before_process() {
      return false;
    }

    function after_process() {
      return false;
    }

    function output_error() {
      return false;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_PAYPAL_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('W³±cz modu³ PayPal', 'MODULE_PAYMENT_PAYPAL_STATUS', 'True', 'Chcesz uruchomiæ p³atno¶ci przez PayPal?', '6', '3', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Adres e-mail', 'MODULE_PAYMENT_PAYPAL_ID', '', 'Adres e-mail u¿ywany w serwisie PayPal', '6', '4', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Waluta transakcji', 'MODULE_PAYMENT_PAYPAL_CURRENCY', 'Selected Currency', 'Waluta u¿ywana dla rozliczeñ kart kredytowych.<br><b>Selected Currency</b> - pobiera walutê z poziomu sklepu', '6', '6', 'tep_cfg_select_option(array(\'Selected Currency\',\'Only USD\',\'Only CAD\',\'Only EUR\',\'Only GBP\',\'Only JPY\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Serwer Transakcji', 'MODULE_PAYMENT_PAYPAL_TRANSACTION_SERVER', 'Live', 'Serwer u¿ywany dla transakcji.<br><b>Live</b> - rzeczywisty system transakcji;<br><b>Sandbox</b> - system testowy', '6', '3', 'tep_cfg_select_option(array(\'Live\', \'Sandbox\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Kolejno¶æ wy¶wietlania.', 'MODULE_PAYMENT_PAYPAL_SORT_ORDER', '0', 'Kolejno¶æ wy¶wietlania. Najni¿sze wy¶wietlane s± na pocz±tku.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Strefa p³atno¶ci', 'MODULE_PAYMENT_PAYPAL_ZONE', '0', 'Je¿eli wybrano strefê ten rodzaj p³atno¶ci bêdzie aktywny tylko dla niej.', '6', '2', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Ustaw Status Zamówienia', 'MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID', '0', 'Ustaw status zamówieñ realizowanych t± form± p³atno¶ci', '6', '0', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_PAYMENT_PAYPAL_STATUS', 'MODULE_PAYMENT_PAYPAL_ID', 'MODULE_PAYMENT_PAYPAL_CURRENCY', 'MODULE_PAYMENT_PAYPAL_TRANSACTION_SERVER', 'MODULE_PAYMENT_PAYPAL_ZONE', 'MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID', 'MODULE_PAYMENT_PAYPAL_SORT_ORDER');
    }
  }
?>
