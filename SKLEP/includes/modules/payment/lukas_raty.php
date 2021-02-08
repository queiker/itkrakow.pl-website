<?php
/*
  $Id: lukas_raty.php,v 1.10 2003/01/29 19:57:14 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  class lukas_raty {
    var $code, $title, $description, $enabled;

// class constructor
    function lukas_raty() {
      global $order;

      $this->code = 'lukas_raty';
      $this->title = MODULE_PAYMENT_LUKAS_RATY_TEXT_TITLE;
      $this->description = MODULE_PAYMENT_LUKAS_RATY_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_LUKAS_RATY_SORT_ORDER;
	  $wysylka = substr($GLOBALS['shipping']['id'], 0, strpos($GLOBALS['shipping']['id'], '_'));
##      $this->enabled = ((MODULE_PAYMENT_LUKAS_RATY_STATUS == 'True') ? (( $wysylka != 'pp' && $wysylka != 'pp2' && $wysylka != 'dp4' )?true:false) : false);
      $this->enabled = ((MODULE_PAYMENT_LUKAS_RATY_STATUS == 'True') ? true:false);

      if ((int)MODULE_PAYMENT_LUKAS_RATY_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_LUKAS_RATY_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();
    
      $this->email_footer = MODULE_PAYMENT_LUKAS_RATY_TEXT_EMAIL_FOOTER;
    }

// class methods
    function update_status() {
      global $order;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_LUKAS_RATY_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_LUKAS_RATY_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
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
      return array('title' => MODULE_PAYMENT_LUKAS_RATY_TEXT_DESCRIPTION);
    }

    function process_button() {
      return false;
    }

    function before_process() {
      return false;
    }

    function after_process() {
      return false;
    }

    function get_error() {
      return false;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_LUKAS_RATY_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('W³aczyæ p³atno¶ci ratalne', 'MODULE_PAYMENT_LUKAS_RATY_STATUS', 'True', '', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now());");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Kolejno¶æ Wy¶wietlania', 'MODULE_PAYMENT_LUKAS_RATY_SORT_ORDER', '0', '', '6', '0', now())");

      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Strefa P³atno¶ci', 'MODULE_PAYMENT_LUKAS_RATY_ZONE', '0', 'Je¿eli wybrano strefê ten rodzaj p³atno¶ci bêdzie aktywny tylko dla niej.', '6', '2', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Ustaw Status Zamówienia', 'MODULE_PAYMENT_LUKAS_RATY_ORDER_STATUS_ID', '0', 'Ustaw domy¶lny status zamówieñ dokonanych przy pomocy tej p³atno¶ci.', '6', '0', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_PAYMENT_LUKAS_RATY_STATUS', 'MODULE_PAYMENT_LUKAS_RATY_ZONE', 'MODULE_PAYMENT_LUKAS_RATY_ORDER_STATUS_ID', 'MODULE_PAYMENT_LUKAS_RATY_SORT_ORDER');
    }
  }
?>
