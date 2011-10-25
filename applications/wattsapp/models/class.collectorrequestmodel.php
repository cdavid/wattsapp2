<?php if (!defined('APPLICATION')) exit();

class CollectorRequestModel extends Gdn_Model {
  public function __construct() {
    parent::__construct('CollectorRequest');
  }
  
  public function RequestQuery() {
    $this->SQL
      ->Select('a.CollectorRequest')
      ->Select('a.UserID')
      ->Select('a.CollectorID')
      ->Select('a.Date')
      ->Select('a.Justification')
      ->Select('a.Status')
      ->From('CollectorRequest a');
  }
  
  public function AddRequest ($UserID, $CollectorID, $Justification, $Status) {
    return $this->Insert(array('UserID' => "$UserID", 'CollectorID' => "$CollectorID", "Justification" => $Justification, 'Status' => "$Status"));
  }

  public function GetByUserID ($UserID) {
    $this->RequestQuery();
    return $this->SQL->Where('a.UserID', $UserID)->Get();
  }
  
  public function GetByCollector ($CollectorID) {
    $this->RequestQuery();
    return $this->SQL->Where('a.CollectorID', $CollectorID)->Get();
  }
  
  public function GetCollectorUserNum ($UserID, $CollectorID) {
    $this->RequestQuery();
    return $this->SQL
        ->Where('a.CollectorID', $CollectorID)
        ->Where('a.UserID', $UserID)
        ->Get()
        ->NumRows();
  }
}