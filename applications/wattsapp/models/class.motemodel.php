<?php if (!defined('APPLICATION')) exit();

class MoteModel extends Gdn_Model {
  public function __construct() {
    parent::__construct('Mote');
  }
  
  public function MoteQuery() {
    $this->SQL
      ->Select('a.MoteID')
      ->Select('a.ServerID')
      ->Select('a.Name')
      ->Select('a.Status')
      ->Select('a.Type')
      ->Select('a.Location')
      ->From('Mote a');
  }
  
  public function GetID ($MoteID) {
    $this->MoteQuery();
    return $this->SQL->Where('a.MoteID', $MoteID)->Get()->FirstRow();  
  }
  
  /**
   * Get all motes belonging to a server
   * 
   * @param unknown_type $ServerID
   */
  public function GetAllServer ($ServerID, $Wheres = '') {
    $this->MoteQuery();
    if (is_array($Wheres))
      $this->SQL->Where($Wheres);
    return $this->SQL->Where('a.ServerID', $ServerID)->Get();
  }
  
  public function Get($Wheres = '') {
    $this->MoteQuery();
    if (is_array($Wheres))
      $this->SQL->Where($Wheres);
    return $this->SQL->Get();
  }
  
  public function GetByStatus ($Status, $Wheres = '') {
    $this->MoteQuery();
    if (is_array($Wheres))
      $this->SQL->Where($Wheres);
    return $this->SQL->Where('a.Status', $Status)->Get();
  }
  
  public function GetByType ($Type, $Wheres = '') {
    $this->MoteQuery();
    if (is_array($Wheres))
      $this->SQL->Where($Wheres);
    return $this->SQL->Where('a.Type', $Type)->Get();
  }
  
  public function GetByLocation ($Location, $Wheres = '') {
    //TODO: find an algorithm to determine if two motes are close to each other.
  }
  
  public function Save() {
    //TODO
  }
}