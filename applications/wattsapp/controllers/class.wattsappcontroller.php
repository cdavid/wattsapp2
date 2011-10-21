<?php if (!defined('APPLICATION')) exit();
/**
 * Skeleton Controller for new applications.
 *
 * Repace 'Skeleton' with your app's short name wherever you see it.
 *
 * @package Skeleton
 */

/**
 * A brief description of the controller.
 *
 * Your app will automatically be able to find any models from your app when you instantiate them.
 * You can also access the UserModel and RoleModel (in Dashboard) from anywhere in the framework.
 *
 * @since 1.0
 * @package Skeleton
 */
class WattsAppController extends Gdn_Controller {
  /** @var array List of objects to prep. They will be available as $this->$Name. */
  public $Uses = array('Form', 'ServerModel', 'UserServerModel', 'UserModel');
   
  /**
   * If you use a constructor, always call parent.
   * Delete this if you don't need it.
   *
   * @access public
   */
  public function __construct() {
    parent::__construct();
  }
   
  /**
   * This is a good place to include JS, CSS, and modules used by all methods of this controller.
   *
   * Always called by dispatcher before controller's requested method.
   *
   * @since 1.0
   * @access public
   */
  public function Initialize() {
    // There are 4 delivery types used by Render().
    // DELIVERY_TYPE_ALL is the default and indicates an entire page view.
    if ($this->DeliveryType() == DELIVERY_TYPE_ALL) {
      $this->Head = new HeadModule($this);
    }

    // Call Gdn_Controller's Initialize() as well.
    parent::Initialize();

    if ($this->Head) {
      $this->AddCssFile('style.css');
      $this->AddJsFile('jquery.js');
      $this->AddJsFile('jquery.livequery.js');
      $this->AddJsFile('jquery.form.js');
      $this->AddJsFile('jquery.popup.js');
      $this->AddJsFile('jquery.gardenhandleajaxform.js');
      $this->AddJsFile('global.js');
    }
  }
   
  public function NotFound() {
    $this->Render();
  }
   
  public function Index() {
    $this->View = 'watt';
    $this->Render();
  }

  static public function verifyFacebookLogin($ClientID, $Token) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/me?access_token=".$Token);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);

//    $output = file_get_contents("https://graph.facebook.com/me?access_token=".$Token);
    //Now parse the $output and get the id from the
    $d = json_decode($output);
    if ($d->id == $ClientID) {
      return $d->email;
    }
    return false;
  }

  public function CollectorList ($ClientID, $Token) {
    if ($ClientID && is_numeric($ClientID)) {
      $this->OkToRender = self::verifyFacebookLogin($ClientID, $Token);
      if ($this->OkToRender) {
        //FETCH the data from the database
        $this->res = $this->ServerModel->ServerQueryUserID($this->UserModel->GetByEmail($this->OkToRender)->UserID);

      }
    }
    $this->DeliveryType(DELIVERY_TYPE_VIEW);
    $this->DeliveryMethod(DELIVERY_METHOD_JSON);
    $this->Render();
  }

  public function MoteList ($ClientID, $Token, $CollectorID) {    
    if ($ClientID && is_numeric($ClientID)) {
      $this->OkToRender = self::verifyFacebookLogin($ClientID, $Token);      
      if ($this->OkToRender) {
        $UserID = $this->UserModel->GetByEmail($this->OkToRender)->UserID;
        $CollectorPermission = $this->UserServerModel->GetPermission($UserID, $CollectorID); 
        if ($CollectorPermission){
          //if the user has permission to see this collector
          //FETCH THE DATA from the collector
          $CollectorData = $this->ServerModel->GetID($CollectorPermission->ServerID);
          $CollectorAddress = $CollectorData->Address;
          $CollectorPort = $CollectorData->Port;
          logger("asd");
          logger($CollectorAddress);
          logger($CollectorPort);
          logger("asd");
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, "$CollectorAddress:$CollectorPort");
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          $output = curl_exec($ch);
          curl_close($ch);
          logger($output);
        }        
      }
    }

    $this->DeliveryType(DELIVERY_TYPE_VIEW);
    $this->DeliveryMethod(DELIVERY_METHOD_JSON);


    $this->Render();
  }

  public function mList ($ClientID, $Token) {
    //TODO: this should query all collectors for their motes and return the result
    $this->DeliveryType(DELIVERY_TYPE_VIEW);
    $this->DeliveryMethod(DELIVERY_METHOD_JSON);

    $this->Render();
  }

  public function Details ($ClientID, $Token, $SensorList = '', $Times = '') {
    if ($ClientID && is_numeric($ClientID)) {
      $this->OkToRender = self::verifyFacebookLogin($ClientID, $Token);
      if ($this->OkToRender) {
        if ($SensorList && $Times) {

          //validate the times
          $t = array_slice(explode(':', $Times), 0, 2, true);
          if (!$t[0]) $t[0] = 0;
          if (!$t[1]) $t[1] = time();

          $ids = $SensorList == 'all' ? 'all' : explode(',', $SensorList);

          //fetch the data from the server

          $this->LogData = $this->eLogModel->GetByMotesTimes($ids, $t[0], $t[1]);
          $this->OkToRender = 1;
        } else {
          //TODO: GET ALL DATA???
        }
      }
    }
  }
}
