<?php if (!defined('APPLICATION')) exit();

class UserCollectorModel extends Gdn_Model {
  public function __construct() {
    parent::__construct('UserCollector');
  }
  
  public function UserCollectorQuery() {
    $this->SQL
      ->Select('a.UserCollectorID')
      ->Select('a.CollectorID')
      ->Select('a.UserID')
      ->Select('a.PermissionType')
      ->From('UserCollector a');
  }
  
  public function GetID ($UserCollectorID) {
    $this->UserCollectorQuery();
    return $this->SQL->Where('a.UserCollectorID', $UserCollectorID)->Get()->FirstRow();
  }
  
  /**
   * Get all Collectors and permissions for a certain user
   * 
   * @param unknown_type $UserID
   */
  public function GetByUserID ($UserID) {
    $this->UserCollectorQuery();
    return $this->SQL->Where('a.UserID', $UserID)->Get();
  }
  
  /**
   * Get all users and their permissions for a certain Collector
   * 
   * @param unknown_type $CollectorID
   */
  public function GetByCollectorID ($CollectorID) {
    $this->UserCollectorQuery();
    return $this->SQL->Where('a.CollectorID', $CollectorID)->Get();
  }
  
  public function GetPermission ($UserID, $CollectorID) {
    $this->UserCollectorQuery();
    return $this->SQL
      ->Where('a.CollectorID', $CollectorID)
      ->Where('a.UserID', $UserID)
      ->Get()->FirstRow();    
  }
}