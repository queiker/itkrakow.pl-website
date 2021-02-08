<?php
/*
  $Id: create_order_details.php,v 1.2 2005/09/04 04:42:56 loic Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

 tep_draw_hidden_field($account['customers_id']);    
?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
    <td class="formAreaTitle"><?php echo CATEGORY_CORRECT; ?></td>
  </tr>
  <tr>
    <td class="main"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="formArea">
      <tr>
        <td class="main"><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_CUSTOMERS_ID; ?></td>
            <td class="main">&nbsp;<?php echo tep_draw_input_field('customers_id', $account['customers_id']) . '&nbsp;' . ENTRY_CUSTOMERS_ID_TEXT; ?> </td>
          </tr>
		  <tr>
            <td class="main">&nbsp;<?php echo ENTRY_FIRST_NAME; ?></td>
            <td class="main">&nbsp;<?php echo tep_draw_input_field('firstname', $account['customers_firstname']) . '&nbsp;' . ENTRY_FIRST_NAME_TEXT; ?> </td>
          </tr>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_LAST_NAME; ?></td>
            <td class="main">&nbsp;<?php echo tep_draw_input_field('lastname', $account['customers_lastname']) . '&nbsp;' . ENTRY_LAST_NAME_TEXT; ?> </td>
          </tr>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_EMAIL_ADDRESS; ?></td>
            <td class="main">&nbsp;<?php echo tep_draw_input_field('email_address', $account['customers_email_address']) . '&nbsp;' . ENTRY_EMAIL_ADDRESS_TEXT; ?></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  
<?php if (ACCOUNT_COMPANY == 'true') { ?>  
  <tr>
    <td class="formAreaTitle"><br><?php echo CATEGORY_COMPANY; ?></td>
  </tr>
  <tr>
    <td class="main"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="formArea">
      <tr>
        <td class="main"><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_COMPANY; ?></td>
            <td class="main">&nbsp;<?php echo tep_draw_input_field('company', $address['entry_company']) . '&nbsp;' . ENTRY_COMPANY_TEXT;?></td>
          </tr>
		  <tr>
            <td class="main">&nbsp;<?php echo ENTRY_NIP; ?></td>
            <td class="main">&nbsp;<?php echo tep_draw_input_field('nip', $address['entry_nip']) . '&nbsp;';?></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
<?php } ?>
  <tr>
    <td class="formAreaTitle"><br><?php echo CATEGORY_ADDRESS; ?></td>
  </tr>
  <tr>
    <td class="main"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="formArea">
      <tr>
        <td class="main"><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_STREET_ADDRESS; ?></td>
            <td class="main">&nbsp;<?php echo tep_draw_input_field('street_address', $address['entry_street_address']) . '&nbsp;' . ENTRY_STREET_ADDRESS_TEXT; ?></td>
          </tr>
		  <tr>
            <td class="main">&nbsp;<?php echo ENTRY_STREET_ADDRESS_DOM; ?></td>
            <td class="main">&nbsp;<?php echo tep_draw_input_field('street_address_dom', $address['entry_street_address_dom']) . '&nbsp;' . ENTRY_STREET_ADDRESS_DOM_TEXT; ?></td>
          </tr>
		  <tr>
            <td class="main">&nbsp;<?php echo ENTRY_STREET_ADDRESS_MIESZKANIE; ?></td>
            <td class="main">&nbsp;<?php echo tep_draw_input_field('street_address_mieszkanie', $address['entry_street_address_mieszkanie']) . '&nbsp;' . ENTRY_STREET_ADDRESS_MIESZKANIE_TEXT; ?></td>
          </tr>
        <?php if (ACCOUNT_SUBURB == 'true') { ?>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_SUBURB; ?></td>
            <td class="main">&nbsp;<?php echo tep_draw_input_field('suburb', $address['entry_suburb']) . '&nbsp;' . ENTRY_SUBURB_TEXT; ?></td>
          </tr>
        <?php } ?>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_POST_CODE; ?></td>
            <td class="main">&nbsp;<?php echo tep_draw_input_field('postcode', $address['entry_postcode']) . '&nbsp;' . ENTRY_POST_CODE_TEXT; ?></td>
          </tr>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_CITY; ?></td>
            <td class="main">&nbsp;<?php echo tep_draw_input_field('city', $address['entry_city']) . '&nbsp;' . ENTRY_CITY_TEXT;?></td>
          </tr>
        <?php if (ACCOUNT_STATE == 'true') { ?>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_STATE; ?></td>
            <td class="main">&nbsp;
            <?php
              $zone_query = tep_db_query("select zone_name from " . TABLE_ZONES . " where zone_country_id = '" . $address['entry_country_id'] . "' and zone_id = '" . $address['entry_zone_id'] . "'");
              if (tep_db_num_rows($zone_query)) {
                $zone = tep_db_fetch_array($zone_query);
                $state = $zone['zone_name'];
              }else{
                $state = $default_zone;
              }
              echo tep_draw_input_field('state', $state) . '&nbsp;' . ENTRY_STATE_TEXT;
            ?>
            </td>
          </tr>
        <?php } ?>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_COUNTRY; ?></td>
            <td class="main">&nbsp;
              <?php
                if ($address['entry_country_id']){
                  echo tep_draw_pull_down_menu('country', tep_get_countries(), $address['entry_country_id']);
                }else{
                  echo tep_draw_pull_down_menu('country', tep_get_countries(), STORE_COUNTRY);
                }
                tep_draw_hidden_field('step', '3');
              ?>
            </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="formAreaTitle"><br><?php echo CATEGORY_CONTACT; ?></td>
  </tr>
  <tr>
    <td class="main"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="formArea">
      <tr>
        <td class="main"><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
            <td class="main">&nbsp;<?php echo tep_draw_input_field('telephone', $account['customers_telephone']) . '&nbsp;' . ENTRY_TELEPHONE_NUMBER_TEXT; ?> </td>
          </tr>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_FAX_NUMBER; ?></td>
            <td class="main">&nbsp;<?php echo tep_draw_input_field('fax', $account['customers_fax']) . '&nbsp;' . ENTRY_FAX_NUMBER_TEXT; ?></td>
          </tr>
		  <tr>
            <td class="main">&nbsp;<?php echo ENTRY_CELL_NUMBER; ?></td>
            <td class="main">&nbsp;<?php echo tep_draw_input_field('cell', $account['customers_cell']) . '&nbsp;' . ENTRY_CELL_NUMBER_TEXT; ?></td>
          </tr>
        </table></td>
      </tr>
	  </table>
      <tr>
        <td class="formAreaTitle"><br> <?php echo TEXT_SELECT_CURRENCY; ?></td>
      </tr>
      <tr>
        <td class="main"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="formArea">
            <tr>
              <td class="main"><table border="0" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="main">&nbsp;<?php echo ENTRY_CURRENCY; ?></td>
                    <td class="main">&nbsp;<?php echo $SelectCurrencyBox ?></td>
                  </tr>
                </table></td>
            </tr>
          </table></td>
      </tr>
            <tr>
        <td class="formAreaTitle"><br> <?php echo TEXT_CS; ?></td>
      </tr>
      <tr>
        <td class="main"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="formArea">
            <tr>
              <td class="main"><table border="0" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="main">&nbsp;<?php echo ENTRY_ADMIN; ?></td>
                    <?php 
                      if (isset($admin['id'])){
                        $cs_id=$admin['id'].'-'. $admin['username'];
                      }else{
                         $cs_id = $_SERVER['REMOTE_USER']; 
                      }
                    ?>
                    <td class="main">&nbsp;<?php echo tep_draw_input_field('cust_service', $cs_id) ?> </td>
                  </tr>
                </table></td>
            </tr>
          </table></td>
      </tr>

    </table>