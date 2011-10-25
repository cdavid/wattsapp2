<?php if (!defined('APPLICATION')) exit();

class CollectorModel extends Gdn_Model {
  public function __construct() {
    parent::__construct('Collector');
  }
  
  public function CollectorQuery() {
    $this->SQL
      ->Select('a.CollectorID')
      ->Select('a.Name')
      ->Select('a.Address')      
      ->SelecT('a.Port')
      ->From('Collector a')      
      ->Where('a.Visible', '1');
  }
  
  public function CollectorQueryUserID ($UserID) {
    return $this->SQL
      ->Select('a.CollectorID')
      ->Select('a.Name')
      ->Select('a.Address')
      ->Select('a.Port')
      ->Select('s.PermissionType')
      ->From('Collector a')
      ->Join('UserCollector s', 's.CollectorID = a.CollectorID')
      ->Join('User u', 's.UserID = u.UserID')
      ->Where('a.Visible', '1')
      ->Where('u.UserID', $UserID)
      ->Get();      
  }
  
  public function GetID ($CollectorID) {
    $this->CollectorQuery();    
    return $this->SQL->Where('a.CollectorID', $CollectorID)->Get()->FirstRow();
  }
  
  public function GetName ($CollectorName) {
    $this->CollectorQuery();    
    return $this->SQL->Where('a.Name', $CollectorName)->Get()->FirstRow();
  }
  
  public function GetAll () {
    return $this->SQL
        ->Select('a.CollectorID')
        ->Select('a.Name')
        ->Select('a.Address')
        ->From('Collector a')
        ->Get();
  }
  
  public function GetByAddressPort ($Address, $Port) {
    $this->CollectorQuery();
    $this->SQL
      ->Where('a.Address', $Address)
      ->Where('a.Port', $Port)
      ->Get()
      ->FirstRow();
  }
  
  public function Save($FormPostValues) {
    $Session = Gdn::Session();
    $this->FormPostValues = $FormPostValues;
    $this->DefineSchema();
    $this->FireEvent('BeforeCollectorValidate');
    
    $CollectorID = ArrayValue('CollectorID', $FormPostValues, '');
    $Insert = $CollectorID == '' ? TRUE : FALSE;
    
    if ($Insert) {
      unset($FormPostValues['CollectorID']);
      $this->AddInsertFields($FormPostValues);
    }
    
    $this->AddUpdateFields($FormPostValues);
    if ($this->Validate($FormPostValues, $Insert)) {
      $Fields = $this->Validation->SchemaValidationFields();
      $CollectorID = intval(ArrayValue('CollectorID', $Fields, 0));
      $Fields = RemoveKeyFromArray($Fields, 'CollectorID');
      $Collector = FALSE;
      $Activity = 'EditCollector';

      $this->EventArguments['FormPostValues'] = $FormPostValues;
      $this->EventArguments['Fields'] = $Fields;
      $this->EventArguments['CollectorID'] = $CollectorID;
      
      if ($CollectorID > 0) {
        $this->SQL->Put($this->Name, $Fields, array($this->PrimaryKey => $CollectorID));
        $this->FireEvent('AfterCollectorEdit');
      } else {
        $CollectorID = $this->SQL->Insert($this->Name, $Fields);
        $Activity = 'AddCollector';
        $this->EventArguments['CollectorID'] = $CollectorID;
        $this->FireEvent('AfterCollectorAdd');
      }
      
      if ($CollectorID > 0) {
        $Collector = $this->GetID($CollectorID);
        AddActivity($Session->UserID, $Activity, '', '', '/Collector/'.$Collector->CollectorID.'/'.Gdn_Format::Url($Collector->Name));
      }
      
      $this->FireEvent('AfterSaveCollector');
    }
    if (!is_numeric($CollectorID)) {
      $CollectorID = FALSE;
    }
    
    return count($this->ValidationResults()) > 0 ? FALSE : $CollectorID;
  }
  
  public function SetProperty($CollectorID, $Property, $ForceValue = FALSE) {
    if ($ForceValue !== FALSE) {
      $Value = $ForceValue;
    } else {
      $Value = '1';
      $Collector = $this->GetID($CollectorID);
      $Value = ($Collector->$Property == '1' ? '0' : '1');
    }
    
    $this->SQL
      ->Update('Collector')
      ->Set($Property, $Value)
      ->Where('CollectorID', $CollectorID)
      ->Put();
    return $Value;
  }
}