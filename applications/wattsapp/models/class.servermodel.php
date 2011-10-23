<?php if (!defined('APPLICATION')) exit();

class ServerModel extends Gdn_Model {
  public function __construct() {
    parent::__construct('Server');
  }
  
  public function ServerQuery() {
    $this->SQL
      ->Select('a.ServerID')
      ->Select('a.Name')
      ->Select('a.Address')      
      ->SelecT('a.Port')
      ->From('Server a')      
      ->Where('a.Visible', '1');
  }
  
  public function ServerQueryUserID ($UserID) {
    return $this->SQL
      ->Select('a.ServerID')
      ->Select('a.Name')
      ->Select('a.Address')
      ->Select('a.Port')
      ->Select('s.PermissionType')
      ->From('Server a')
      ->Join('UserServer s', 's.ServerID = a.ServerID')
      ->Join('User u', 's.UserID = u.UserID')
      ->Where('a.Visible', '1')
      ->Where('u.UserID', $UserID)
      ->Get();      
  }
  
  public function GetID ($ServerID) {
    $this->ServerQuery();    
    return $this->SQL->Where('a.ServerID', $ServerID)->Get()->FirstRow();
  }
  
  public function GetName ($ServerName) {
    $this->ServerQuery();    
    return $this->SQL->Where('a.Name', $ServerName)->Get()->FirstRow();
  }
  
  public function GetAll () {
    return $this->SQL
        ->Select('a.ServerID')
        ->Select('a.Name')
        ->Select('a.Address')
        ->From('Server a')
        ->Get();
  }
  
  
  
  public function Save($FormPostValues) {
    $Session = Gdn::Session();
    $this->FormPostValues = $FormPostValues;
    $this->DefineSchema();
    $this->FireEvent('BeforeServerValidate');
    
    $ServerID = ArrayValue('ServerID', $FormPostValues, '');
    $Insert = $ServerID == '' ? TRUE : FALSE;
    
    if ($Insert) {
      unset($FormPostValues['ServerID']);
      $this->AddInsertFields($FormPostValues);
    }
    
    $this->AddUpdateFields($FormPostValues);
    if ($this->Validate($FormPostValues, $Insert)) {
      $Fields = $this->Validation->SchemaValidationFields();
      $ServerID = intval(ArrayValue('ServerID', $Fields, 0));
      $Fields = RemoveKeyFromArray($Fields, 'ServerID');
      $Server = FALSE;
      $Activity = 'EditServer';

      $this->EventArguments['FormPostValues'] = $FormPostValues;
      $this->EventArguments['Fields'] = $Fields;
      $this->EventArguments['ServerID'] = $ServerID;
      
      if ($ServerID > 0) {
        $this->SQL->Put($this->Name, $Fields, array($this->PrimaryKey => $ServerID));
        $this->FireEvent('AfterServerEdit');
      } else {
        $ServerID = $this->SQL->Insert($this->Name, $Fields);
        $Activity = 'AddServer';
        $this->EventArguments['ServerID'] = $ServerID;
        $this->FireEvent('AfterServerAdd');
      }
      
      if ($ServerID > 0) {
        $Server = $this->GetID($ServerID);
        AddActivity($Session->UserID, $Activity, '', '', '/server/'.$Server->ServerID.'/'.Gdn_Format::Url($Server->Name));
      }
      
      $this->FireEvent('AfterSaveServer');
    }
    if (!is_numeric($ServerID)) {
      $ServerID = FALSE;
    }
    
    return count($this->ValidationResults()) > 0 ? FALSE : $ServerID;
  }
  
  public function SetProperty($ServerID, $Property, $ForceValue = FALSE) {
    if ($ForceValue !== FALSE) {
      $Value = $ForceValue;
    } else {
      $Value = '1';
      $Server = $this->GetID($ServerID);
      $Value = ($Server->$Property == '1' ? '0' : '1');
    }
    
    $this->SQL
      ->Update('Server')
      ->Set($Property, $Value)
      ->Where('ServerID', $ServerID)
      ->Put();
    return $Value;
  }
}