<?php
/*
  $Id: dp.php,v 1.36 2003/03/09 02:14:35 harley_vb Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 - 2003 osCommerce

  Released under the GNU General Public License
*/

  class dp4 {
    var $code, $title, $description, $icon, $enabled, $num_dp;

// class constructor
    function dp4() {
      global $order;

      $this->code = 'dp4';
      $this->title = MODULE_SHIPPING_DP4_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_DP4_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_DP4_SORT_ORDER;
      $this->icon = DIR_WS_ICONS . 'shipping_dp.gif';
      $this->tax_class = MODULE_SHIPPING_DP4_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_DP4_STATUS == 'True') ? true : false);

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_DP4_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_DP4_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
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

      // CUSTOMIZE THIS SETTING FOR THE NUMBER OF ZONES NEEDED
      $this->num_dp = 1;
    }

// class methods
    function quote($method = '') {
      global $HTTP_POST_VARS, $order, $shipping_weight, $shipping_num_boxes;

      $dest_country = $order->delivery['country']['iso_code_2'];
      $dest_zone = 0;
      $error = false;

      for ($i=1; $i<=$this->num_dp; $i++) {
        $countries_table = constant('MODULE_SHIPPING_DP4_COUNTRIES_' . $i);
        $country_zones = split("[,]", $countries_table);
        if (in_array($dest_country, $country_zones)) {
          $dest_zone = $i;
          break;
        }
      }

      if ($dest_zone == 0) {
        $error = true;
      } else {
        $shipping = -1;
        $dp_cost = constant('MODULE_SHIPPING_DP4_COST_' . $i);

        $dp_table = split("[:,]" , $dp_cost);
        for ($i=0; $i<sizeof($dp_table); $i+=2) {
          if ($shipping_weight <= $dp_table[$i]) {
            $shipping = $dp_table[$i+1];
            $shipping_method = MODULE_SHIPPING_DP4_TEXT_WAY . ' ';
            break;
          }
        }

        if ($shipping == -1) {
          $shipping_cost = 0;
          $shipping_method = MODULE_SHIPPING_DP4_UNDEFINED_RATE;
        } else {
          $shipping_cost = ($shipping + MODULE_SHIPPING_DP4_HANDLING);
        }
      }

      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_DP4_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' =>$shipping_method . $shipping_num_boxes . ' x ' . round($shipping_weight,2) . ' ' . MODULE_SHIPPING_DP4_TEXT_UNITS .'',
                                                     'cost' => $shipping_cost * $shipping_num_boxes)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = tep_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (tep_not_null($this->icon)) $this->quotes['icon'] = tep_image($this->icon, $this->title);

      if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_DP4_INVALID_ZONE;

      return $this->quotes;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_DP4_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Przesy³ka kurierska', 'MODULE_SHIPPING_DP4_STATUS', 'True', 'Czy chcesz oferowaæ wysy³kê za po¶rednictwem firmy kurierskiej?', '6', '0', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Koszt pakowania', 'MODULE_SHIPPING_DP4_HANDLING', '0', '', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Stawka podatkowa', 'MODULE_SHIPPING_DP4_TAX_CLASS', '0', '', '6', '0', 'tep_get_tax_class_title', 'tep_cfg_pull_down_tax_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Z jakiego kraju wysy³ka', 'MODULE_SHIPPING_DP4_ZONE', '0', '', '6', '0', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Kolejno¶æ wy¶wietlania', 'MODULE_SHIPPING_DP4_SORT_ORDER', '0', 'Kolejno¶æ wy¶wietlania. Najni¿sze wy¶wietlane s± na pocz±tku.', '6', '0', now())");

      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Kraj docelowy', 'MODULE_SHIPPING_DP4_COUNTRIES_1', 'PL', 'Oddzielana przecinkami lista kodów ISO krajów', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Stawki za poszczególne przesy³ki', 'MODULE_SHIPPING_DP4_COST_1', '5:16.50,10:20.50,20:28.50', 'Wpisz wagê oraz odpowiadaj±cy jej koszt przesy³ki, np. <b>3:8.50,5:10</b> . Do 3kg wysy³ka 8.50PLN. 3 do 5kg wysylka 10PLN', '6', '0', now())");
      }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      $keys = array('MODULE_SHIPPING_DP4_STATUS', 'MODULE_SHIPPING_DP4_HANDLING', 'MODULE_SHIPPING_DP4_TAX_CLASS', 'MODULE_SHIPPING_DP4_ZONE', 'MODULE_SHIPPING_DP4_SORT_ORDER');

      for ($i = 1; $i <= $this->num_dp; $i ++) {
        $keys[count($keys)] = 'MODULE_SHIPPING_DP4_COUNTRIES_' . $i;
        $keys[count($keys)] = 'MODULE_SHIPPING_DP4_COST_' . $i;
      }

      return $keys;
    }
  }
?>