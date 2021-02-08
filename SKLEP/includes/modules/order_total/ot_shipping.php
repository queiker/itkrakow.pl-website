<?php
/*
  $Id: ot_shipping.php,v 1.15 2003/02/07 22:01:57 dgw_ Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  class ot_shipping {
    var $title, $output;

    function ot_shipping() {
      $this->code = 'ot_shipping';
      $this->title = MODULE_ORDER_TOTAL_SHIPPING_TITLE;
      $this->description = MODULE_ORDER_TOTAL_SHIPPING_DESCRIPTION;
      $this->enabled = ((MODULE_ORDER_TOTAL_SHIPPING_STATUS == 'true') ? true : false);
      $this->sort_order = MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER;

      $this->output = array();
    }

    function process() {
      global $order, $currencies;

      if (MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING == 'tak') {
        switch (MODULE_ORDER_TOTAL_SHIPPING_DESTINATION) {
          case 'krajowe':
            if ($order->delivery['country_id'] == STORE_COUNTRY) $pass = true; break;
          case 'miedzynarodowe':
            if ($order->delivery['country_id'] != STORE_COUNTRY) $pass = true; break;
          case 'wszystkie':
            $pass = true; break;
          default:
            $pass = false; break;
        }

        if ( ($pass == true) && ( ($order->info['total'] - $order->info['shipping_cost']) >= MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER) ) {
          $order->info['shipping_method'] = $this->title;
          $order->info['total'] -= $order->info['shipping_cost'];
          $order->info['shipping_cost'] = 0;
        }
      }

      $module = substr($GLOBALS['shipping']['id'], 0, strpos($GLOBALS['shipping']['id'], '_'));

      if (tep_not_null($order->info['shipping_method'])) {
        if ($GLOBALS[$module]->tax_class > 0) {
          $shipping_tax = tep_get_tax_rate($GLOBALS[$module]->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
          $shipping_tax_description = tep_get_tax_description($GLOBALS[$module]->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);

          $order->info['tax'] += tep_calculate_tax($order->info['shipping_cost'], $shipping_tax);
          $order->info['tax_groups']["$shipping_tax_description"] += tep_calculate_tax($order->info['shipping_cost'], $shipping_tax);
          $order->info['total'] += tep_calculate_tax($order->info['shipping_cost'], $shipping_tax);

          if (DISPLAY_PRICE_WITH_TAX == 'true') $order->info['shipping_cost'] += tep_calculate_tax($order->info['shipping_cost'], $shipping_tax);
        }

        $this->output[] = array('title' => $order->info['shipping_method'] . ':',
                                'text' => $currencies->format($order->info['shipping_cost'], true, $order->info['currency'], $order->info['currency_value']),
                                'value' => $order->info['shipping_cost']);
      }
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_SHIPPING_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }

      return $this->_check;
    }

    function keys() {
      return array('MODULE_ORDER_TOTAL_SHIPPING_STATUS', 'MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER', 'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING', 'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER', 'MODULE_ORDER_TOTAL_SHIPPING_DESTINATION');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Wysy³ka', 'MODULE_ORDER_TOTAL_SHIPPING_STATUS', 'true', 'Pokazuje (true) lub nie (false) koszt przesy³ki przy zamówieniu', '6', '1','tep_cfg_select_option(array(\'true\', \'false\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sposób wy¶wietlania', 'MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER', '2', 'Na którym miejscu pokazaæ?', '6', '2', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Darmowa przesy³ka', 'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING', 'nie', 'Pozwala lub nie na darmow± przesy³kê', '6', '3', 'tep_cfg_select_option(array(\'tak\', \'nie\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, date_added) values ('Minimalna wielko¶æ zamówienia dla darmowej przesy³ki', 'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER', '50', 'Dla klientów zamawiaj±cych za kwotê wiêksz± ni¿ wpisana tutaj, nie bêdzie doliczony koszt przesy³ki .', '6', '4', 'currencies->format', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Darmowa przesy³ka dla zamówieñ z wybranego rejonu', 'MODULE_ORDER_TOTAL_SHIPPING_DESTINATION', 'krajowe', 'Umo¿liwia darmow± przesy³kê dla klientów z wybranego rejonu (województwa).', '6', '5', 'tep_cfg_select_option(array(\'krajowe\', \'miedzynarodowe\', \'wszystkie\'), ', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }
  }
?>
