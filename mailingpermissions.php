<?php

require_once 'mailingpermissions.civix.php';
use CRM_Mailingpermissions_ExtensionUtil as E;
use CRM_Mailingpermissions_Utils as MP;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/ 
 */
function mailingpermissions_civicrm_config(&$config) {
  _mailingpermissions_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function mailingpermissions_civicrm_xmlMenu(&$files) {
  _mailingpermissions_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function mailingpermissions_civicrm_install() {
  _mailingpermissions_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function mailingpermissions_civicrm_postInstall() {
  _mailingpermissions_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function mailingpermissions_civicrm_uninstall() {
  _mailingpermissions_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function mailingpermissions_civicrm_enable() {
  _mailingpermissions_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function mailingpermissions_civicrm_disable() {
  _mailingpermissions_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function mailingpermissions_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _mailingpermissions_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function mailingpermissions_civicrm_managed(&$entities) {
  _mailingpermissions_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function mailingpermissions_civicrm_caseTypes(&$caseTypes) {
  _mailingpermissions_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function mailingpermissions_civicrm_angularModules(&$angularModules) {
  _mailingpermissions_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function mailingpermissions_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _mailingpermissions_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function mailingpermissions_civicrm_entityTypes(&$entityTypes) {
  _mailingpermissions_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_thems().
 */
function mailingpermissions_civicrm_themes(&$themes) {
  _mailingpermissions_civix_civicrm_themes($themes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 *
function mailingpermissions_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
function mailingpermissions_civicrm_navigationMenu(&$menu) {
  _mailingpermissions_civix_insert_navigation_menu($menu, 'Administer/CiviMail', array(
    'label' => E::ts('Mailing Permissions'),
    'name'  => 'mailing_permissions_settings',
    'url'   => CRM_Utils_System::url('civicrm/mailingpermissions/settings', 'reset=1'),
    'permission' => 'administer CiviCRM',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _mailingpermissions_civix_navigationMenu($menu);
}

function mailingpermissions_civicrm_selectWhereClause($entity, &$clauses) {
  $path = CRM_Utils_System::currentPath();
  if (($entity == 'Group') && ($path != 'civicrm/mailingpermissions/settings')) {
    $contactId = CRM_Core_Session::singleton()->get('userID');
    $restrictions = MP::getDataForContact($contactId);
    if (!empty($restrictions['to_groups'])) {
      $clauses['id'][] = 'IN (' . implode(',', $restrictions['to_groups']) . ')';
    }
  }
}

function mailingpermissions_civicrm_alterResourceSettings(&$event) {
  if (!empty($event['crmMailing']['fromAddress'])) {
    $contactId = CRM_Core_Session::singleton()->get('userID');
    $restrictions = MP::getDataForContact($contactId);
    if (!empty($restrictions['from_address'])) {
      foreach ($event['crmMailing']['fromAddress'] as $key => $address) {
        if (!in_array($address['value'], $restrictions['from_address'])) {
          unset($event['crmMailing']['fromAddress'][$key]);
        }
      }
    }
  }
}
