<?php if (!defined('APPLICATION')) exit();

class eLogModel extends Gdn_Model {
  public function __construct () {
    parent::__construct('eLog');
  }

  public function eLogQuery () {
    $this->SQL
    ->Select('a.eLogID')
    ->Select('a.MoteID')
    ->Select('a.BeginT')
    ->Select('a.EndT')
    ->Select('a.Value')
    ->From('eLog a');
  }

  public function GetID ($eLogID) {
    $this->eLogQuery();
    return $this->SQL->Where('a.eLogID', $eLogID)->Get()->FirstRow();
  }

  public function GetCount ($Wheres = '') {
    if (!is_array($Wheres)) {
      $Wheres = array();
    }

    return $this->SQL
    ->Select('a.eLogID','count','CounteLog')
    ->From('eLog a')
    ->Where($Wheres)
    ->Get()
    ->FirstRow()
    ->CounteLog;
  }

  /**
   * All the logs for a mote
   *
   * @param unknown_type $MoteID
   */
  public function GetByMote ($MoteID, $Wheres = '') {
    $this->eLogQuery();
    if (is_array($Wheres)) {
      $this->SQL->Where($Wheres);
    }
    return $this->SQL->Where('a.MoteID', $MoteID)->Get();
  }
  
  public function GetByMotesTimes ($MoteList, $BeginT = '0', $EndT = '', $Wheres = '') {
    if (!$EndT) {
      $EndT = time();
    } 
    $this->eLogQuery();
    if (is_array($Wheres)) {
      $this->SQL->Where($Wheres);
    }
    if (is_array($MoteList)) {
      $this->SQL->WhereIn('a.MoteID', $MoteList);
    }//TODO: handle else case
    $this->SQL->Where('BeginT >', $BeginT)->Where('EndT <',$EndT)->Get();
    return $this->SQL->Get();
  }

  public function GetByTime ($BeginT, $EndT, $Wheres = '') {
    $this->eLogQuery();
    if (is_array($Wheres)) {
      $this->SQL->Where($Wheres);
    }
    return $this->SQL->Where('BeginT >', $BeginT)->Where('EndT <',$EndT)->Get();
  }
}
