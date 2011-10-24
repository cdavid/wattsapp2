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
  public $Uses = array('Form', 'CollectorModel', 'UserCollectorModel', 'UserModel');
   
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

  static public function _verifyFacebookLogin($ClientID, $Token) {
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

  static public function _getCollector ($CollectorAddress, $CollectorPort, $CollectorMethod, $Args) {
    //TODO:improve code quality

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$CollectorAddress:$CollectorPort/$CollectorMethod?$Args");
    curl_setopt($ch, CURLOPT_CAINFO, "/home/cdavid/lisa.pem"); // C('WattsApp.CAINFO');
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, '1');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, '1');
    curl_setopt($ch, CURLOPT_SSLCERT, "/home/cdavid/certificate.pem"); // C('WattsApp.SSLCERT');
    curl_setopt($ch, CURLOPT_SSLKEY, "/home/cdavid/privatekey");       // C('WattsApp.SSLKEY');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
  }

  static public function _getCollectors($Method, $OkToRender, $Args = '') {
    $CollectorModel = new CollectorModel();
    $UserModel = new UserModel();
    $Collectors = $CollectorModel->CollectorQueryUserID($UserModel->GetByEmail($OkToRender)->UserID);
    if ($Collectors && $Collectors->NumRows() > 0) {
      //for all collectors
      $res = array();
      foreach ($Collectors->Result() as $Collector) {
        $CollectorName = $Collector->Name;
        $CollectorAddress = $Collector->Address;
        $CollectorPort = $Collector->Port;
        $res_nojson = json_decode(self::_getCollector($CollectorAddress, $CollectorPort, $Method, $Args));
        
        $obj->collectorid = $Collector->CollectorID;
        $obj->collectorname = $CollectorName;
        $obj->access = $Collector->PermissionType == "view" ? "1" :
                       $Collector->PermissionType == "admin" ? "2" : "0";
        $obj->motelist = $res_nojson;
        
        $res[] = $obj;
      }
    }
    return $res;
  }

  public function CollectorList ($ClientID, $Token) {
    if ($ClientID && is_numeric($ClientID)) {
      $this->OkToRender = self::_verifyFacebookLogin($ClientID, $Token);
      if ($this->OkToRender) {
        //FETCH the data from the database
        $this->res = $this->CollectorModel->CollectorQueryUserID($this->UserModel->GetByEmail($this->OkToRender)->UserID);

      }
    }
    $this->DeliveryType(DELIVERY_TYPE_VIEW);
    $this->DeliveryMethod(DELIVERY_METHOD_JSON);
    $this->Render();
  }

  public function MoteList ($ClientID, $Token, $CollectorID) {
    if ($ClientID && $Token && is_numeric($ClientID)) {
      $this->OkToRender = self::_verifyFacebookLogin($ClientID, $Token);
      if ($this->OkToRender) {
        $UserID = $this->UserModel->GetByEmail($this->OkToRender)->UserID;
        $CollectorPermission = $this->UserCollectorModel->GetPermission($UserID, $CollectorID);

        if ($CollectorPermission){
          //if the user has permission to see this collector
          //FETCH THE DATA from the collector
          $CollectorData = $this->CollectorModel->GetID($CollectorPermission->CollectorID);
          $CollectorAddress = $CollectorData->Address;
          $CollectorPort = $CollectorData->Port;

          $res_json = self::_getCollector($CollectorAddress, $CollectorPort, 'list', '');
          $res_no = json_decode($res_json);
          foreach ($res_no as $r) {
            $r->access = $CollectorPermission->PermissionType == "view" ? "1" :
            $CollectorPermission->PermissionType == "admin" ? "2" : "0";
          }
          $this->res = json_encode($res_no);
        }
      }
    }
    $this->DeliveryType(DELIVERY_TYPE_VIEW);
    $this->DeliveryMethod(DELIVERY_METHOD_JSON);
    $this->Render();
  }



  public function mList ($ClientID, $Token) {
    if ($ClientID && $Token && is_numeric($ClientID)) {
      $this->OkToRender = self::_verifyFacebookLogin($ClientID, $Token);
      if ($this->OkToRender) {
        //get all collectors the user has access to
        $this->res = json_encode(self::_getCollectors("list", $this->OkToRender));
      }
    }
    $this->DeliveryType(DELIVERY_TYPE_VIEW);
    $this->DeliveryMethod(DELIVERY_METHOD_JSON);

    $this->Render();
  }

  public function _SumDetails ($Method, $ClientID, $Token, $SensorList, $Times) {
    if ($ClientID && $Token && is_numeric($ClientID)) {
      $this->OkToRender = self::_verifyFacebookLogin($ClientID, $Token);
      if ($this->OkToRender) {
        //$SensorList might be:
        // 1. * -- which means all collectors and all sensors the user has access to
        // 2a. a list of (Collector,*) -- which means all motes for a certain collector
        // 2b. a list of (Collector,MoteList) -- which means only these motes from this collector
        // The separators are as following:
        // -- between two (CollectorList,MoteList)  ;
        // -- between two items in the MoteList  :
        // -- between CollectorList and MoteList  ,

        //$Times might be:
        // 1. *
        // 2. t1:
        // 3. :t2
        // 4. t1:t2
        $res = array();
        $UserID = $this->UserModel->GetByEmail($this->OkToRender)->UserID;

        //TODO: check for well-formedness
        //TODO: Optimize the CollectionPermission retrieval to be done just once, not for every collector
        if ($SensorList == '*') {
          $this->res = json_encode(self::_getCollectors($Method, $this->OkToRender, "time=" . $Times == '*' ? '' : $Times));
        } else {
          //case 2 from above
          //separate by ;
          $sList = explode(';',  $SensorList);
          //now we have (Collector,MoteList)
          foreach ($sList as $sItem) {
            if (!$sItem || $sItem[0] != '(' || $sItem[strlen($sItem) - 1] != ')') continue;
            $sItem = substr($sItem, 1, -1); // remove ()
            $a = explode(',', $sItem);
            $CollectorID = ''; if ($a[0]) $CollectorID = $a[0];
            $MoteStr = ''; if ($a[1]) $MoteStr = $a[1];
            if ($MoteStr == '*') {
              $MoteList = "*";
            } else {
              $MoteList = explode(':', $MoteStr);
            }
            $pRes = "";

            //if the user has permission for the collector
            $CollectorPermission = $this->UserCollectorModel->GetPermission($UserID, $CollectorID);
            if ($CollectorPermission){
              $CollectorData = $this->CollectorModel->GetID($CollectorPermission->CollectorID);
              $CollectorAddress = $CollectorData->Address;
              $CollectorPort = $CollectorData->Port;
              $args = $MoteList == "*" ? '' : 'sensors=' . implode(',', $MoteList);
              $args = $args . "&time=" . $Times;
              $pRes = self::_getCollector($CollectorAddress, $CollectorPort, $Method, $args);
              $obj->collectorid = $CollectorData->CollectorID;
              $obj->collectorname = $CollectorData->Name;
              $obj->data = json_decode($pRes);
              $res[] = $obj;
            }
          }
        }
        $this->res = json_encode($res);
      }
    }
  }

  public function Sum ($ClientID, $Token, $SensorList = '', $Times = '') {
    self::_SumDetails('sum', $ClientID, $Token, $SensorList, $Times);
    $this->DeliveryType(DELIVERY_TYPE_VIEW);
    $this->DeliveryMethod(DELIVERY_METHOD_JSON);
    $this->View = 'sumdetail';
    $this->Render();
  }

  public function Details ($ClientID, $Token, $SensorList = '', $Times = '') {
    self::_SumDetails('details', $ClientID, $Token, $SensorList, $Times);
    $this->DeliveryType(DELIVERY_TYPE_VIEW);
    $this->DeliveryMethod(DELIVERY_METHOD_JSON);
    $this->View = 'sumdetail';
    $this->Render();
  }
}
