<?php
/*
  $Id: cop.php,v 1.28 2003/02/14 05:51:31 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce
  Contributed by Support Datahjelp
  http://www.support-datahjelp.no
  Released under the GNU General Public License
*/

  class cop {
    var $code, $title, $description, $enabled;

// class constructor
    function cop() {
      global $order, $method;

      $this->code = 'cop';
      $this->title = MODULE_PAYMENT_COP_TEXT_TITLE;
      $this->description = MODULE_PAYMENT_COP_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_COP_SORT_ORDER;
	  $wysylka = substr($GLOBALS['shipping']['id'], 0, strpos($GLOBALS['shipping']['id'], '_'));
##    $this->enabled = ((MODULE_PAYMENT_COP_STATUS == 'True') ? (( $wysylka == 'intown2')?true:false) : false);
      $this->enabled = ((MODULE_PAYMENT_COP_STATUS == 'True') ? true:false);

      if ((int)MODULE_PAYMENT_COP_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_COP_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();
    }

// class methods
    function update_status() {
      global $order;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_COP_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_COP_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
        while ($check = tep_db_fetch_array($check_query)) {
          if ($check['zone_id'] < 1) {
            $check_flag = true;
            break;
          } elseif ($check['zone_id'] == $order->delivery['zone_id']) {
            $check_flag = true;
            break;
          }
        }

        if ($check_flag == false) {
          $this->enabled = false;
        }
      }

// disable the module if the order only contains virtual products
      if ($this->enabled == true) {
        if ($order->content_type == 'virtual') {
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
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_COP_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('W³±czyæ p³atno¶æ przy odbiorze osobistym towaru', 'MODULE_PAYMENT_COP_STATUS', 'True', 'Do you want to accept Cash On Pickup payments?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Strefa p³atno¶ci', 'MODULE_PAYMENT_COP_ZONE', '0', 'Je¿eli wybrano strefê ten rodzaj p³atno¶ci bêdzie aktywny tylko dla niej.', '6', '2', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Kolejno¶æ wy¶wietlania', 'MODULE_PAYMENT_COP_SORT_ORDER', '0', 'Kolejno¶æ wy¶wietlania. Najni¿sze wy¶wietlane s± na pocz±tku.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Ustaw Status Zamówienia', 'MODULE_PAYMENT_COP_ORDER_STATUS_ID', '0', 'Ustaw status zamówieñ realizowanych t± form± p³atno¶ci', '6', '0', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");
   }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_PAYMENT_COP_STATUS', 'MODULE_PAYMENT_COP_ZONE', 'MODULE_PAYMENT_COP_ORDER_STATUS_ID', 'MODULE_PAYMENT_COP_SORT_ORDER');
    }
  }
?>
