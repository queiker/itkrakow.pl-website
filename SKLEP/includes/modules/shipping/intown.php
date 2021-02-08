<?php
/*
  $Id: intown.php, 2004/01/12  by morph $
  Wysylka module v.1.0.
  http://www.galeriart.prov.pl/oscommerce/

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  class intown {
    var $code, $title, $description, $icon, $enabled;

// class constructor
    function intown() {
      global $order;

      $this->code = 'intown';
      $this->title = MODULE_SHIPPING_INTOWN_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_INTOWN_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_INTOWN_SORT_ORDER;
      $this->icon = '';
      $this->tax_class = MODULE_SHIPPING_INTOWN_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_INTOWN_STATUS == 'True') ? true : false);

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_INTOWN_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_INTOWN_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
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
    }

// class methods
    function quote($method = '') {
      global $order;

      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_INTOWN_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => MODULE_SHIPPING_INTOWN_TEXT_WAY,
                                                     'cost' => MODULE_SHIPPING_INTOWN_COST)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = tep_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (tep_not_null($this->icon)) $this->quotes['icon'] = tep_image($this->icon, $this->title);

      return $this->quotes;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_INTOWN_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Dostawa na terenie miasta', 'MODULE_SHIPPING_INTOWN_STATUS', 'True', 'Czy chcesz oferwowaæ dostawê na terenie miasta ?', '6', '0', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Koszt dostawy', 'MODULE_SHIPPING_INTOWN_COST', '5.00', '', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Stawka podatkowa', 'MODULE_SHIPPING_INTOWN_TAX_CLASS', '0', '', '6', '0', 'tep_get_tax_class_title', 'tep_cfg_pull_down_tax_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Strefa Dostawy', 'MODULE_SHIPPING_INTOWN_ZONE', '0', 'Je¿eli wybrano strefê ten rodzaj dostawy bêdzie aktywny tylko dla niej.', '6', '0', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Kolejno¶æ wy¶wietlania', 'MODULE_SHIPPING_INTOWN_SORT_ORDER', '0', 'Kolejno¶æ wy¶wietlania. Najni¿sze wy¶wietlane s± na pocz±tku.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_SHIPPING_INTOWN_STATUS', 'MODULE_SHIPPING_INTOWN_COST', 'MODULE_SHIPPING_INTOWN_TAX_CLASS', 'MODULE_SHIPPING_INTOWN_ZONE', 'MODULE_SHIPPING_INTOWN_SORT_ORDER');
    }
  }
?>
