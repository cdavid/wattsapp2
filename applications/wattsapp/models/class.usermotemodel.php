<?php if (!defined('APPLICATION')) exit();

class UserMoteModel extends Gdn_Model {
  public function __construct() {
    parent::__construct('UserMote');
  }

  public function UserMoteQuery() {
    $this->SQL
    ->Select('a.UserMoteID')
    ->Select('a.MoteID')
    ->Select('a.UserID')
    ->Select('a.PermissionType')
    ->From('UserMote a');
  }

  public function GetID ($UserMoteID) {
    $this->UserMoteQuery();
    return $this->SQL->Where('a.UserMoteID', $UserMoteID)->Get()->FirstRow();
  }

  /**
   * Get all servers and permissions for a certain user
   *
   * @param unknown_type $UserID
   */
  public function GetByUserID ($UserID) {
    $this->UserMoteQuery();
    return $this->SQL->Where('a.UserID', $UserID)->Get();
  }

  /**
   * Get all users and their permissions for a certain server
   *
   * @param unknown_type $MoteID
   */
  public function GetByMoteID ($MoteID) {
    $this->UserMoteQuery();
    return $this->SQL->Where('a.MoteID', $MoteID)->Get();
  }
}