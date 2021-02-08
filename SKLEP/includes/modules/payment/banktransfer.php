<?php

  class banktransfer {
    var $code, $title, $description, $enabled;

// class constructor
    function banktransfer() {
      $this->code = 'banktransfer';
      $this->title = MODULE_PAYMENT_BANKTRANSFER_TEXT_TITLE;
      $this->description = MODULE_PAYMENT_BANKTRANSFER_TEXT_DESCRIPTION;
      $this->email_footer = MODULE_PAYMENT_BANKTRANSFER_TEXT_EMAIL_FOOTER;
	  $wysylka = substr($GLOBALS['shipping']['id'], 0, strpos($GLOBALS['shipping']['id'], '_'));
##      $this->enabled = ((MODULE_PAYMENT_BANKTRANSFER_STATUS == 'True') ? (( $wysylka != 'pp' && $wysylka != 'pp2' && $wysylka != 'dp4' )?true:false) : false);
      $this->enabled = ((MODULE_PAYMENT_BANKTRANSFER_STATUS == 'True') ? true:false);
	  $this->sort_order = MODULE_PAYMENT_BANKTRANSFER_SORT_ORDER;
    }
// class methods
    function javascript_validation() {
      return false;
    }

      function selection() {
     return array('id' => $this->code, 'module' => $this->title);
    } 
//    function selection() {
//      return false;
//    }

    function pre_confirmation_check() {
      return false;
    }

// I take no credit for this, I just hunted down variables, the actual code was stolen from the 2checkout
// module.  About 20 minutes of trouble shooting and poof, here it is. -- Thomas Keats
    function confirmation() {
      global $HTTP_POST_VARS;

      $confirmation = array('title' => $this->title . ': ' . $this->check,
                'fields' => array(array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_DESCRIPTION)));

      return $confirmation;
    }

// Below is the original pre-November snapshot code.  I have left it souly for the less technical minded might
// be able to compare what some of the more indepth changes consisted of.  Perhaps it will facilitate more preNov
// Snapshots to being modified to postNov snapshot compatibility -- Thomas Keats

//    function confirmation() {
//      $confirmation_string = '          <tr>' . "\n" .
//                             '            <td class="main">&nbsp;' . MODULE_PAYMENT_BANKTRANSFER_TEXT_DESCRIPTION . $
//                             '          </tr>' . "\n";
//      return $confirmation_string;
//    }

    function process_button() {
      return false;
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
      if (!isset($this->check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_BANKTRANSFER_STATUS'");
        $this->check = tep_db_num_rows($check_query);
      }
      return $this->check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Pokazuj przelew bankowy', 'MODULE_PAYMENT_BANKTRANSFER_STATUS', 'True', 'Czy chcesz w³±czyæ p³atno¶æ przelewem bankowym?', '6', '1','tep_cfg_select_option(array(\'True\', \'False\'), ', now());");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Kod banku', 'MODULE_PAYMENT_BANKTRANSFER_SORTCODE', '00-00-00', 'Kod banku jest w formacie 00-00-00', '6', '1', now());");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Numer narunku bankowego', 'MODULE_PAYMENT_BANKTRANSFER_ACCNUM', '123456789012345678901234', 'Numer rachunku bankowego', '6', '1', now());");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Nazwa konta bankowego', 'MODULE_PAYMENT_BANKTRANSFER_ACCNAM', 'Fredy Kruger', 'Nazwa rachunku bankowego', '6', '1', now());");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Nazwa Banku', 'MODULE_PAYMENT_BANKTRANSFER_BANKNAM', 'Twoj Bank', 'Nazwa banku', '6', '1', now());");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values
      ('Kolejno¶æ wy¶wietlania.', 'MODULE_PAYMENT_BANKTRANSFER_SORT_ORDER', '0', 'Kolejno¶æ wy¶wietlania. Najni¿sze wy¶wietlane s± na pocz±tku.', '6', '0', now())");
   }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_BANKTRANSFER_STATUS'");
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_BANKTRANSFER_SORTCODE'");
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_BANKTRANSFER_ACCNUM'");
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_BANKTRANSFER_ACCNAM'");
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_BANKTRANSFER_BANKNAM'");
	  tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_BANKTRANSFER_SORT_ORDER'");
    }

    function keys() {
      $keys = array('MODULE_PAYMENT_BANKTRANSFER_STATUS', 'MODULE_PAYMENT_BANKTRANSFER_SORTCODE', 'MODULE_PAYMENT_BANKTRANSFER_ACCNUM', 'MODULE_PAYMENT_BANKTRANSFER_ACCNAM', 'MODULE_PAYMENT_BANKTRANSFER_BANKNAM', 'MODULE_PAYMENT_BANKTRANSFER_SORT_ORDER');

      return $keys;
    }
  }
?>