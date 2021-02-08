<?php
/*
  $Id: wishlist.php,v 3.0  2005/08/24 Dennis Blake
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Released under the GNU General Public License
*/

  class wishlist {
	var $wishID;


	function wishlist() {
      	$this->reset();
	}

	function restore_wishlist() {
	global $customer_id;

		if (!tep_session_is_registered('customer_id')) return false;

	// merge current wishlist items in database
		if (is_array($this->wishID)) {
        	reset($this->wishID);

			while (list($wishlist_id, ) = each($this->wishID)) {
				$wishlist_query = tep_db_query("select products_id from " . TABLE_WISHLIST . " where customers_id = '" . (int)$customer_id . "' and products_id = '" . tep_db_prepare_input(tep_db_input($wishlist_id)) . "'");
				if (!tep_db_num_rows($wishlist_query)) {
		   			tep_db_query("insert into " . TABLE_WISHLIST . " (customers_id, products_id) values ('" . (int)$customer_id . "', '" . tep_db_prepare_input(tep_db_input($wishlist_id)) . "')");
					if (isset($this->wishID[$wishlist_id]['attributes'])) {
	              		reset($this->wishID[$wishlist_id]['attributes']);
						while (list($option, $value) = each($this->wishID[$wishlist_id]['attributes'])) {
					    		tep_db_query("insert into " . TABLE_WISHLIST_ATTRIBUTES . " (customers_id, products_id, products_options_id , products_options_value_id) values ('" . (int)$customer_id . "', '" . tep_db_prepare_input(tep_db_input($wishlist_id)) . "', '" . (int)$option . "', '" . (int)$value . "' )");
			    		}
					}
				}
			}
		}

		// reset session contents
		unset($this->wishID);

		$wishlist_session = tep_db_query("select products_id from " . TABLE_WISHLIST . " where customers_id = '" . (int)$customer_id . "'");
		while($wishlist = tep_db_fetch_array($wishlist_session)) {
			$this->wishID[$wishlist['products_id']] = array($wishlist['products_id']);
		// attributes
       		$attributes_query = tep_db_query("select products_options_id, products_options_value_id from " . TABLE_WISHLIST_ATTRIBUTES . " where customers_id = '" . (int)$customer_id . "' and products_id = '" . (int)$wishlist['products_id'] . "'");
       		while ($attributes = tep_db_fetch_array($attributes_query)) {
     			$this->wishID[$wishlist['products_id']]['attributes'][$attributes['products_options_id']] = $attributes['products_options_value_id'];
       		}
		}
	}

	function add_wishlist($wishlist_id, $attributes_id) {
      global $customer_id;


		if(!$this->in_wishlist($wishlist_id)) {

			$wishlist_id = tep_get_uprid($wishlist_id, $attributes_id);
			// Insert into session
			$this->wishID[$wishlist_id] = array($wishlist_id);

			if (tep_session_is_registered('customer_id')) {
			// Insert into database
	   			tep_db_query("insert into " . TABLE_WISHLIST . " (customers_id, products_id) values ('" . (int)$customer_id . "', '" . tep_db_prepare_input(tep_db_input($wishlist_id)) . "')");
			}
			
	   		// Read array of options and values for attributes in id[]
			if (is_array($attributes_id)) {
				reset($attributes_id);
				while (list($option, $value) = each($attributes_id)) {
			    	$this->wishID[$wishlist_id]['attributes'][$option] = $value;
		   			// Add to customers_wishlist_attributes table
					if (tep_session_is_registered('customer_id')) {
			    		tep_db_query("insert into " . TABLE_WISHLIST_ATTRIBUTES . " (customers_id, products_id, products_options_id , products_options_value_id) values ('" . (int)$customer_id . "', '" . (int)$wishlist_id . "', '" . (int)$option . "', '" . (int)$value . "' )");
					}
	    		}
				tep_session_unregister('attributes_id');
		  	}

			if ($new_price = tep_get_products_special_price((int)$wishlist_id)) {
				$cena = $new_price;
			} else {
			    $cena = tep_xppp_getproductprice((int)$wishlist_id);
			}

			if (is_array($attributes_id)) {
				reset($attributes_id);
				$cena += $this->attributes_price($wishlist_id);
			}

			$podatek = tep_get_products_tax((int)$wishlist_id);
			$this->wishID[$wishlist_id]['cena'] = array('value' => $cena, 'tax' => $podatek);

		} else {
// juz mamy
		}
	}

    function attributes_price($wishlist_id) {
      $attributes_price = 0;

      if (isset($this->wishID[$wishlist_id]['attributes'])) {
        reset($this->wishID[$wishlist_id]['attributes']);
        while (list($option, $value) = each($this->wishID[$wishlist_id]['attributes'])) {
          $attribute_price_query = tep_db_query("select options_values_price, price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int)$wishlist_id . "' and options_id = '" . (int)$option . "' and options_values_id = '" . (int)$value . "'");
          $attribute_price = tep_db_fetch_array($attribute_price_query);
          if ($attribute_price['price_prefix'] == '+') {
            $attributes_price += $attribute_price['options_values_price'];
          } else {
            $attributes_price -= $attribute_price['options_values_price'];
          }
        }
      }

      return $attributes_price;
    }

	function remove($wishlist_id) {
	global $customer_id;

		// Remove from session
		unset($this->wishID[$wishlist_id]);

		//remove from database
		if (tep_session_is_registered('customer_id')) {
			tep_db_query("delete from " . TABLE_WISHLIST . " where products_id = '" . tep_db_prepare_input(tep_db_input($wishlist_id)) . "' and customers_id = '" . (int)$customer_id . "'");
			tep_db_query("delete from " . TABLE_WISHLIST_ATTRIBUTES . " where products_id = '" . tep_db_prepare_input(tep_db_input($wishlist_id)) . "' and customers_id = '" . (int)$customer_id . "'");
		}
	}


	function clear() {
	global $customer_id;

		// Remove all from database
  		if (tep_session_is_registered('customer_id')) {
 	  		$wishlist_products_query = tep_db_query("select products_id from " . TABLE_CUSTOMERS_BASKET . " where customers_id = '" . (int)$customer_id . "'");
	  		while($wishlist_products = tep_db_fetch_array($wishlist_products_query)) {
				tep_db_query("delete from " . TABLE_WISHLIST . " where products_id = '" . tep_db_prepare_input(tep_db_input($wishlist_products[products_id])) . "' and customers_id = '" . (int)$customer_id . "'");
				tep_db_query("delete from " . TABLE_WISHLIST_ATTRIBUTES . " where products_id = '" . tep_db_prepare_input(tep_db_input($wishlist_products[products_id])) . "' and customers_id = '" . (int)$customer_id . "'");
	  		}
		}
	}

	function reset($reset_database = false) {
      global $customer_id;

		// Remove all from database
		if (tep_session_is_registered('customer_id') && ($reset_database == true)) {
        	tep_db_query("delete from " . TABLE_WISHLIST . " where customers_id = '" . (int)$customer_id . "'");
        	tep_db_query("delete from " . TABLE_WISHLIST_ATTRIBUTES . " where customers_id = '" . (int)$customer_id . "'");
      	}

		// reset session contents
		unset($this->wishID);		
    }

	function in_wishlist($wishlist_id) {
	global $customer_id;

		if (isset($this->wishID[$wishlist_id])) {
        	return true;
      	} else {
        	return false;
      	}
	}


	function get_att($wishlist_id) {
    	$pieces = explode('{', $wishlist_id);

	    return $pieces[0];
	}

    function count_wishlist() {  // get total number of items in wishlist 
      $total_items = 0;
      if (is_array($this->wishID)) {
        reset($this->wishID);
        while (list($wishlist_id, ) = each($this->wishID)) {
          $total_items++;
        }
      }

      return $total_items;
    }

    function calculate_wishlist() {  // get total number of items in wishlist 
      $total_price = 0;
      if (is_array($this->wishID)) {
        reset($this->wishID);
        foreach($this->wishID as $k => $v) {
          $total_price += tep_add_tax($v['cena']['value'], tep_get_tax_rate($v['cena']['tax']));
        }
      }

      return $total_price;
    }

  }

?>
