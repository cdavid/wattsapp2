<?php if (!defined('APPLICATION')) exit();

class CollectorController extends Gdn_Controller {
  public $Uses = array('Form', 'CollectorModel', 'UserCollectorModel', 'CollectorRequestModel');

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
   
  public function Index($CollectorID = '') {
    if ($CollectorID != '') {
      $Session = Gdn::Session();
      $UserID = $Session->UserID;
      $Permission = $this->UserCollectorModel->GetPermission($UserID, $CollectorID);      
      if ($Permission || $Session->User->Admin == '1') { //admins are cool :)
        $this->Collector = $this->CollectorModel->GetID($CollectorID);
        if (!is_object($this->Collector)) {
          $this->View = 'NotFound';
        } else {
          $this->AddJsFile('collector.js');
          //here we have one collector 
          //$this->Collector contains the important, relevant information
          
          //also need to get the users that have access to this collector
          $this->CollectorUsers = $this->UserCollectorModel->GetOrderedCollectorID($CollectorID);
                    
          //and also the requests made for access to this collector
          $this->CollectorReq = $this->CollectorRequestModel->GetByCollector($CollectorID);
          
        }
      } else {
        //user does not have permission
      }

    } else {
      $this->View = 'browse';
      $this->Browse();
      return;
    }
    $this->View = 'collector';
    //TODO: also load the side menu module
    $this->Render();
  }
  
  public function Browse() {
    //get all the collectors the user has access to or all collectors if user is admin
    $this->Render();
  }
}
