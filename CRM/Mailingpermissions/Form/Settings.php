<?php

use CRM_Mailingpermissions_ExtensionUtil as E;
use CRM_Mailingpermissions_Utils as MP;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Mailingpermissions_Form_Settings extends CRM_Core_Form {

  /**
   * Build all the data structures needed to build the form.
   */
  public function preProcess() {
    $this->assign('rowCount', MP::NO_OF_ROWS + 1);

    CRM_Core_Resources::singleton()->addStyleFile('uk.co.mountev.mailingpermissions',  'css/spin.css', 10, 'html-header');
    CRM_Core_Resources::singleton()->addScriptFile('uk.co.mountev.mailingpermissions', 'js/modernizr.js', 20, 'html-header', FALSE);
    CRM_Core_Resources::singleton()->addScriptFile('uk.co.mountev.mailingpermissions', 'js/spinner.js', 500, 'html-header', FALSE);
  }

  public function buildQuickForm() {
    $group = ['' => ts('- select group -')] + CRM_Core_PseudoConstant::nestedGroup();
    $fromAddress = civicrm_api3('OptionValue', 'get', [
      'option_group_id' => "from_email_address",
      'domain_id' => CRM_Core_Config::domainID(),
      'options' => ['limit' => 0],
    ]);
    $fromAddressList = [];
    if (!empty($fromAddress['values'])) {
      foreach ($fromAddress['values'] as $address) {
        $fromAddressList[$address['value']] = htmlspecialchars($address['label']);
      }
    }

    for ($i = 1; $i <= MP::NO_OF_ROWS; $i++) { 
      $this->add('select', "user_group[$i]", ts('Logged In User Groups'), $group, FALSE, ['class' => 'crm-select2 huge']);
      $this->add('select', "from_address[$i]", ts('Mailing From Address'), $fromAddressList, FALSE, ['class' => 'crm-select2 huge', 'multiple' => TRUE]);
      $this->add('select', "to_groups[$i]", ts('Mailing Recipients Groups'), $group, FALSE, ['class' => 'crm-select2 huge', 'multiple' => TRUE]);
    }

    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => E::ts('Save'),
        'isDefault' => TRUE,
      ),
    ));
    parent::buildQuickForm();
  }

  /**
   * Set default values.
   *
   * @return array
   */
  public function setDefaultValues() {
    return MP::getData();
  }

  public function postProcess() {
    $values = $this->exportValues();
    if (MP::store($values)) {
      CRM_Core_Session::setStatus(ts('Mailing permissions have been saved.'), ts('Success'), 'success');
    }
    parent::postProcess();
  }

}
