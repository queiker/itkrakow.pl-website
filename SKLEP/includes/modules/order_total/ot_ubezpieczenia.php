<?php
/*
  $Id:ot_ubezpieczenia.php, v 1.0 2005/02/01 hOl 09:11:03

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.pl

  Copyright (c) 2005 osCommerce.PL Team

  Released under the GNU General Public License
  Prepared for Polish Post Office Packages

*/


  class ot_ubezpieczenia {
    var $title, $output;

    function ot_ubezpieczenia() {
      $this->code = 'ot_ubezpieczenia';
      $this->title = MODULE_PAYMENT_UBEZPIECZENIA_TITLE;
      $this->description = MODULE_PAYMENT_UBEZPIECZENIA_DESCRIPTION;
      $this->enabled = (( defined('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING') && (MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING == 'tak')) ? 'nie' : MODULE_PAYMENT_UBEZPIECZENIA_STATUS); 
      $this->sort_order = MODULE_PAYMENT_UBEZPIECZENIA_SORT_ORDER;
      $this->minimum = MODULE_PAYMENT_UBEZPIECZENIA_MINIMUM;
      $this->include_tax = MODULE_PAYMENT_UBEZPIECZENIA_INC_TAX;
      $this->howto = MODULE_PAYMENT_UBEZPIECZENIA_HOWTO;
      $this->calculate_tax = MODULE_PAYMENT_UBEZPIECZENIA_CALC_TAX;
//      $this->credit_class = true;
      $this->output = array();
    }

    function process() {
     global $order, $currencies;

      $od_amount = $this->calculate_fee($this->get_order_total());
      if ($od_amount>0) {
      $this->addition = $od_amount;
      $this->output[] = array('title' => $this->title . ':',
                              'text' => '<b>' . $currencies->format($od_amount) . '</b>',
                              'value' => $od_amount);
    $order->info['total'] = $order->info['total'] + $od_amount;
}
}


function calculate_fee($amount) {
    global $order, $customer_id, $payment, $method;
    $do = false;
    
    if ($amount > $this->minimum) {
    $table = split("[,]" , MODULE_PAYMENT_UBEZPIECZENIA_TYPE);
    for ($i = 0; $i < count($table); $i++) {
          if ($payment == $table[$i]) $do = true;
    }
   
    $ship2ot_table = split("[,]", MODULE_PAYMENT_UBEZPIECZENIA_S_TYPE);
    for ($i = 0; $i < count($ship2ot_table); $i++) {
	$ship2ot_table[$i] = trim($ship2ot_table[$i]);
	$ship2ot_table[$i] = $ship2ot_table[$i] . '_' .$ship2ot_table[$i];
    	if ($GLOBALS['shipping']['id'] == $ship2ot_table[$i]) $doo = true;
    } 
    
 
//      if (in_array($GLOBALS['shipping']['id'], $ship2ot_table)) $do = false;    

    
    if ($do && $doo) {
// Calculate tax reduction if necessary
    if($this->calculate_tax == 'tak') {
// Calculate main tax reduction
      $tod_amount = round($order->info['tax']*10)/10*$od_pc/100;
      $order->info['tax'] = $order->info['tax'] + $tod_amount;
// Calculate tax group deductions
      reset($order->info['tax_groups']);
      while (list($key, $value) = each($order->info['tax_groups'])) {
        $god_amount = round($value*10)/10*$od_pc/100;
        $order->info['tax_groups'][$key] = $order->info['tax_groups'][$key] + $god_amount;
      }
	  }
	$od_amount = ceil($amount/50); // wyliczenie oplaty dla kazdeych rozpoczetych 50pln
	$od_amount = $od_amount + $tod_amount;
	}
	}
	return $od_amount;
}
	
	
function get_order_total() {
    global  $order, $cart;
    $order_total = $order->info['total'];
// Check if gift voucher is in cart and adjust total
    $products = $cart->get_products();
    for ($i=0; $i<sizeof($products); $i++) {
      $t_prid = tep_get_prid($products[$i]['id']);
      $gv_query = tep_db_query("select products_price, products_tax_class_id, products_model from " . TABLE_PRODUCTS . " where products_id = '" . $t_prid . "'");
      $gv_result = tep_db_fetch_array($gv_query);
      if (ereg('^GIFT', addslashes($gv_result['products_model']))) {
        $qty = $cart->get_quantity($t_prid);
        $products_tax = tep_get_tax_rate($gv_result['products_tax_class_id']);
        if ($this->include_tax =='nie') {
           $gv_amount = $gv_result['products_price'] * $qty;
        } else {
          $gv_amount = ($gv_result['products_price'] + tep_calculate_tax($gv_result['products_price'],$products_tax)) * $qty;
        }
        $order_total=$order_total - $gv_amount;
      }
    }
    if ($this->include_tax == 'nie') $order_total=$order_total-$order->info['tax'];
   
	$order_total=$order_total-$order->info['shipping_cost'];
    return $order_total;
  }


    function check() {
      if (!isset($this->check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_UBEZPIECZENIA_STATUS'");
        $this->check = tep_db_num_rows($check_query);
      }

      return $this->check;
    }

    function keys() {
      return array('MODULE_PAYMENT_UBEZPIECZENIA_STATUS', 'MODULE_PAYMENT_UBEZPIECZENIA_SORT_ORDER','MODULE_PAYMENT_UBEZPIECZENIA_HOWTO','MODULE_PAYMENT_UBEZPIECZENIA_MINIMUM', 'MODULE_PAYMENT_UBEZPIECZENIA_TYPE', 'MODULE_PAYMENT_UBEZPIECZENIA_INC_TAX', 'MODULE_PAYMENT_UBEZPIECZENIA_S_TYPE', 'MODULE_PAYMENT_UBEZPIECZENIA_CALC_TAX');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Pokazuj', 'MODULE_PAYMENT_UBEZPIECZENIA_STATUS', 'tak', 'Czy chcesz wlaczyc oplate za ubezpiecznie?', '6', '1','tep_cfg_select_option(array(\'tak\', \'nie\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Kolejno¶æ wy¶wietlania', 'MODULE_PAYMENT_UBEZPIECZENIA_SORT_ORDER', '112', 'Porz±dek sortowania.', '6', '2', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function ,date_added) values ('Rodzaj ubezpieczenia', 'MODULE_PAYMENT_UBEZPIECZENIA_HOWTO', 'paczka o podanej wartosci', 'Standardowo ubezpieczenie naliczane jest dla warto¶ci paczki', '6', '5', 'tep_cfg_select_option(array(\'paczka o podanej wartosci\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function ,date_added) values ('Wliczaæ Podatek', 'MODULE_PAYMENT_UBEZPIECZENIA_INC_TAX', 'tak', 'Wlicz podatek do przeliczeñ.', '6', '6','tep_cfg_select_option(array(\'tak\', \'nie\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function ,date_added) values ('Przelicz podatek', 'MODULE_PAYMENT_UBEZPIECZENIA_CALC_TAX', 'nie', 'Przelicz podatek dla zmienionej op³aty.', '6', '5','tep_cfg_select_option(array(\'tak\', \'nie\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Minimalna warto¶æ', 'MODULE_PAYMENT_UBEZPIECZENIA_MINIMUM', '', 'Minimalna warto¶æ zamówienia dla naliczania op³aty', '6', '2', now())");
    tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('W³±cz ubezpieczanie dla p³atno¶ci', 'MODULE_PAYMENT_UBEZPIECZENIA_TYPE', 'cod', 'Rodzaj p³atnosci dla naliczania op³aty', '6', '7', now())");
    tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('W³±cz ubezpieczanie dla wysy³ki', 'MODULE_PAYMENT_UBEZPIECZENIA_S_TYPE', 'flat', 'Rodzaj wysy³ki, dla której naliczana jest op³ata', '6', '8', now())");
    }

    function remove() {
      $keys = '';
      $keys_array = $this->keys();
      for ($i=0; $i<sizeof($keys_array); $i++) {
        $keys .= "'" . $keys_array[$i] . "',";
      }
      $keys = substr($keys, 0, -1);

      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in (" . $keys . ")");
    }
  }
?>
