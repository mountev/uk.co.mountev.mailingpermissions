<?php

/**
 * Mailingpermissions Utils Class
 *
 */
class CRM_Mailingpermissions_Utils {

  const NO_OF_ROWS = 120;

  public static function getData($userGroups = array()) {
    $defaults = [];
    $whereClause = '';
    if (!empty($userGroups)) {
      CRM_Utils_Type::escapeAll($userGroups, 'Positive');
      $whereClause = "WHERE user_group IN (" . implode(',', $userGroups) . ")";
    }
    $query = "SELECT * FROM civicrm_mailing_permissions {$whereClause} ORDER BY id";
    $dao   = CRM_Core_DAO::executeQuery($query);
    $i = 0;
    while ($dao->fetch()) {
      $i++;
      foreach (array('user_group', 'from_address', 'to_groups') as $field) {
        if (!empty($dao->$field)) {
          $defaults[$field][$i] = ($field == 'user_group') ? $dao->$field : unserialize($dao->$field); 
        }
      }
    }
    return $defaults;
  }

  public static function store($data) {
    $rowValues = [];
    for ($i = 1; $i <= self::NO_OF_ROWS; $i++) { 
      if (!empty($data['user_group'][$i])) {
        foreach (array('user_group', 'from_address', 'to_groups') as $field) {
          if (!empty($data[$field][$i])) {
            $data[$field][$i] = ($field == 'user_group') ? 
              CRM_Utils_Type::escape($data[$field][$i], 'Positive') : 
              CRM_Utils_Type::escapeAll($data[$field][$i], 'Positive');
          }
        }
        $rowValues[] = "({$data['user_group'][$i]}, '" . serialize($data['from_address'][$i]) . "', '" . serialize($data['to_groups'][$i]) . "')";
      }
    }
    if (!empty($rowValues)) {
      CRM_Core_DAO::executeQuery("TRUNCATE TABLE civicrm_mailing_permissions");
      $query = "INSERT INTO civicrm_mailing_permissions (`user_group`, `from_address`, `to_groups`) VALUES " . implode(',', $rowValues);
      CRM_Core_DAO::executeQuery($query);
      return TRUE;
    }
    return FALSE;
  }

  public static function getDataForContact($contactId) {
    static $result = [];
    $groupIds = [];
    $to_groups = [];
    $from_address = [];

    if ($contactId && !array_key_exists($contactId, $result)) {
      $result[$contactId] = [];
      $groups = CRM_Contact_BAO_GroupContact::getContactGroup($contactId, 'Added', NULL, FALSE, TRUE, FALSE, TRUE, NULL, TRUE);
      if (!empty($groups)) {
        foreach ($groups as $key => $detail) {
          $groupIds[] = $detail['group_id'];
        }
      }
      if (!empty($groupIds)) {
        $data = self::getData($groupIds);
        foreach (array('from_address', 'to_groups') as $field) {
          if (!empty($data[$field])) {
            foreach ($data[$field] as $key => $val) {
              $$field = array_merge($$field, $val);
            }
          }
        }
      }
      $result[$contactId]['from_address'] = $from_address;
      $result[$contactId]['to_groups'] = $to_groups;
    }
    return $result[$contactId];
  }
}
