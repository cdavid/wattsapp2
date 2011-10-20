<?php if (!defined('APPLICATION')) exit();

class UserServerModel extends Gdn_Model {
  public function __construct() {
    parent::__construct('UserServer');
  }
  
  public function UserServerQuery() {
    $this->SQL
      ->Select('a.UserServerID')
      ->Select('a.ServerID')
      ->Select('a.UserID')
      ->Select('a.PermissionType')
      ->From('UserServer a');
  }
  
  public function GetID ($UserServerID) {
    $this->UserServerQuery();
    return $this->SQL->Where('a.UserServerID', $UserServerID)->Get()->FirstRow();
  }
  
  /**
   * Get all servers and permissions for a certain user
   * 
   * @param unknown_type $UserID
   */
  public function GetByUserID ($UserID) {
    $this->UserServerQuery();
    return $this->SQL->Where('a.UserID', $UserID)->Get();
  }
  
  /**
   * Get all users and their permissions for a certain server
   * 
   * @param unknown_type $ServerID
   */
  public function GetByServerID ($ServerID) {
    $this->UserServerQuery();
    return $this->SQL->Where('a.ServerID', $ServerID)->Get();
  }
}