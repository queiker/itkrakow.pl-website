<?php
/*
*/

  class zones {
    var $code, $title, $description, $enabled, $num_zones;

// class constructor
    function zones() {
	  global $cart, $order;
      $this->code = 'zones';
      $this->title = MODULE_SHIPPING_ZONES_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_ZONES_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_ZONES_SORT_ORDER;
      $this->icon = '';
      $this->tax_class = MODULE_SHIPPING_ZONES_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_ZONES_STATUS == 'True') ? true : false);


		if(isset($cart)) {
		    $products = $cart->get_products();
		    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
				if(isset($products[$i]['products_extra']) && $products[$i]['products_extra'] == 'list') {
			      $list ++; 
				} else {
			      $paczka++;
				}
			}
			if ($paczka > 0) $this->enabled = ((MODULE_SHIPPING_ZONES_STATUS == 'True') ? true : false);
		}

// wylaczenia dla Polski
	  if (isset($order)) {
		  if ($order->delivery['country']['iso_code_2'] == 'PL') $this->enabled = false; 
	  }
//

      // CUSTOMIZE THIS SETTING FOR THE NUMBER OF ZONES NEEDED
      $this->num_zones = 7;
    }

// class methods
    function quote($method = '') {
      global $order, $shipping_weight, $shipping_num_boxes;

      $dest_country = $order->delivery['country']['iso_code_2'];
      $dest_zone = 0;
      $error = false;

      for ($i=1; $i<=$this->num_zones; $i++) {
        $countries_table = constant('MODULE_SHIPPING_ZONES_COUNTRIES_' . $i);
        $country_zones = split("[,]", $countries_table);
        if (in_array($dest_country, $country_zones)) {
          $dest_zone = $i;
          break;
        }
		if ($countries_table == 'SWIAT') {
          $dest_zone = $i;
          break;
        }
      }

      if ($dest_zone == 0) {
        $error = true;
      } else {
        $shipping = -1;
        $zones_cost = constant('MODULE_SHIPPING_ZONES_COST_' . $dest_zone);

        $zones_table = split("[:,]" , $zones_cost);
        $size = sizeof($zones_table);
        for ($i=0; $i<$size; $i+=2) {
          if ($shipping_weight <= $zones_table[$i]) {
            $shipping = $zones_table[$i+1];
            $shipping_method = MODULE_SHIPPING_ZONES_TEXT_WAY . ' ' . $dest_country . ' : ' . $shipping_weight . ' ' . MODULE_SHIPPING_ZONES_TEXT_UNITS;
            break;
          }
        }

        if ($shipping == -1) {
          $shipping_cost = 0;
          $shipping_method = MODULE_SHIPPING_ZONES_UNDEFINED_RATE;
        } else {
          $shipping_cost = ($shipping * $shipping_num_boxes) + constant('MODULE_SHIPPING_ZONES_HANDLING_' . $dest_zone);
        }
      }

      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_ZONES_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => $shipping_method,
                                                     'cost' => $shipping_cost)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = tep_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (tep_not_null($this->icon)) $this->quotes['icon'] = tep_image($this->icon, $this->title);

      if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_ZONES_INVALID_ZONE;
      return $this->quotes;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_ZONES_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
$kraje = array (
"",
"AT,BG,CH,DK,EE,FO,HR,HU,LI,LT,LU,LV,NL,SI,UA,VA",
"AD,AL,BE,CY,DE,ES,FI,FR,FX,GI,GR,IE,IL,IS,IT,MC,MD,MK,MT,NO,RO,SE,SM,TR",
"GB,PT,RU",
"CZ,SK",
"BY",
"AO,BF,BI,BJ,BM,BW,CA,CF,CG,CM,CV,DJ,DZ,EG,ER,GA,GH,GM,GN,GQ,GW,KE,KM,LR,LS,MA,MG,ML,MR,MU,MW,MX,MZ,NA,NE,NG,RE,RW,SC,SD,SH,SL,SN,SO,ST,TD,TG,TN,TZ,UG,US,ZA,ZM,ZW",
"AE,AF,AG,AI,AM,AN,AR,AW,AZ,BB,BD,BH,BN,BO,BR,BS,BT,BZ,CC,CI,CK,CL,CN,CO,CR,CU,CX,DM,DO,EC,EH,FM,GD,GE,GF,GL,GP,GS,GT,GU,GY,HK,HM,HN,HT,ID,IN,IO,IQ,IR,JM,JO,JP,KG,KH,KN,KP,KR,KW,KY,KZ,LA,LB,LC,LK,LY,MH,MM,MN,MO,MP,MQ,MS,MV,MY,NF,NI,NP,NU,OM,PA,PE,PF,PH,PK,PM,PN,PR,PW,PY,QA,SA,SB,SG,SJ,SR,SV,SY,SZ,TC,TF,TH,TJ,TK,TM,TO,TP,TT,TV,TW,UM,UY,UZ,VC,VE,VG,VI,VN,WF,WS,YE,YT,YU,ZR",
"AQ,AS,AU,BV,FJ,KI,NC,NR,NZ,PG,VU",
"SWIAT",
"Inna"
);
$stawki = array (
"",
"1:60,2:72,3:80,4:92,5:102,6:105,7:110,8:117,9:125,10:133,11:139,12:145,13:155,14:162,15:171,16:179,17:187,18:196,19:202,20:211",
"1:70,2:82,3:98,4:102,5:114,6:117,7:124,8:131,9:139,10:145,11:151,12:160,13:166,14:172,15:179,16:187,17:196,18:204,19:211,20:221",
"1:70,2:82,3:98,4:102,5:114,6:117,7:124,8:131,9:139,10:145,11:158,12:167,13:176,14:185,15:194,16:212,17:221,18:230,19:239,20:249",
"1:24,2:27,3:29,4:31,5:32,6:40,7:42,8:43,9:44,10:45,11:52,12:53,13:54,14:56,15:57,16:67,17:69,18:70,19:71,20:73",
"1:28,2:36,3:43,4:49,5:55,6:68,7:74,8:80,9:86,10:92,11:103,12:109,13:115,14:121,15:126,16:141,17:147,18:153,19:159,20:165",
"1:81,2:102,3:126,4:146,5:172,6:184,7:203,8:222,9:240,10:258,11:276,12:297,13:318,14:339,15:360,16:390,17:411,18:433,19:454,20:475",
"1:89,2:116,3:140,4:170,5:205,6:225,7:254,8:283,9:311,10:336,11:363,12:386,13:416,14:448,15:466,16:500,17:514,18:538,19:561,20:586",
"1:103,2:145,3:188,4:231,5:272,6:312,7:354,8:398,9:439,10:481,11:524,12:566,13:608,14:650,15:692,16:723,17:755,18:772,19:807,20:840",
"1:103,2:145,3:188,4:231,5:272,6:312,7:354,8:398,9:439,10:481,11:524,12:566,13:608,14:650,15:692,16:723,17:755,18:772,19:807,20:840",
"10:2000"
); 
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('W³±cz wysy³kê zagraniczn± wg tabeli', 'MODULE_SHIPPING_ZONES_STATUS', 'True', 'Czy oferowaæ wysy³kê zagraniczn±?', '6', '0', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Klasa Podatkowa', 'MODULE_SHIPPING_ZONES_TAX_CLASS', '0', 'Jakiej klasy podatkowej u¿yæ dla tej wysy³ki.', '6', '0', 'tep_get_tax_class_title', 'tep_cfg_pull_down_tax_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Kolejno¶æ wy¶weitlania', 'MODULE_SHIPPING_ZONES_SORT_ORDER', '0', 'Sort order of display.', '6', '0', now())");
      for ($i = 1; $i <= $this->num_zones; $i++) {
        $default_countries = 'SWIAT';
        if ($i == 1) {
          $default_countries = 'PL';
        }
        tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Kraje Strefy " . $i ."', 'MODULE_SHIPPING_ZONES_COUNTRIES_" . $i ."', '" . $kraje[$i] . "', 'Lista krajow w strefie " . $i . ".', '6', '0', now())");
        tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Strefa " . $i ." Tabela Cen', 'MODULE_SHIPPING_ZONES_COST_" . $i ."', '" . $stawki[$i] . "', 'Stawki dostawy dla strefy " . $i . " na bazie maksymalnej wagi. Strefa  " . $i . " destinations.', '6', '0', now())");
        tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Op³ata za obs³ugê dla strefy " . $i ." ', 'MODULE_SHIPPING_ZONES_HANDLING_" . $i."', '0', 'Oplata za obsluge paczki dla tej strefy', '6', '0', now())");
      }
    }


    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      $keys = array('MODULE_SHIPPING_ZONES_STATUS', 'MODULE_SHIPPING_ZONES_TAX_CLASS', 'MODULE_SHIPPING_ZONES_SORT_ORDER');

      for ($i=1; $i<=$this->num_zones; $i++) {
        $keys[] = 'MODULE_SHIPPING_ZONES_COUNTRIES_' . $i;
        $keys[] = 'MODULE_SHIPPING_ZONES_COST_' . $i;
        $keys[] = 'MODULE_SHIPPING_ZONES_HANDLING_' . $i;
      }

      return $keys;
    }
  }
?>
