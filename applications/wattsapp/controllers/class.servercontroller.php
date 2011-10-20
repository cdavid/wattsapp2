<?php if (!defined('APPLICATION')) exit();

class ServerController extends Gdn_Controller {
  public $Uses = array('Form', 'ServerModel');

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
    logger("asd");
    $this->View = 'serv';
    $this->Render();
  }
}
