<?php if (!defined('APPLICATION')) exit();

if ($this->OkToRender) {
  if ($this->DeliveryType() == DELIVERY_TYPE_ALL) {
    //FOR THE BROWSER -- nothing special for now
    echo $this->res;    
  } elseif ($this->DeliveryType() == DELIVERY_TYPE_VIEW) {
    //THIS IS FOR THE MOBILE APP
    echo $this->res;
  }
} else {
  echo '[{"error":"You are not authorized to view such information. Please signup on https://wattsapp.net first"}]';
}