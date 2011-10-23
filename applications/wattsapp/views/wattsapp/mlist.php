<?php if (!defined('APPLICATION')) exit();

if ($this->OkToRender) {
  if ($this->DeliveryType() == DELIVERY_TYPE_ALL) {
    //FOR THE BROWSER
    //echo '[{"id": 1, "name": "toaster", "status": "active", "type": "kitchen device","access":1, "collector":"collector 1","values": [{"begin": 1313416361, "end": 1318686761, "value": 13.123}]},{"id": 2, "name":"fridge", "status": "active", "type": "kitchen device","access":2, "collector":"collector 2","values": [{"begin": 1313416361, "end": 1318686761, "value": 13.354}]},{"id": 3, "name": "oven", "status": "active", "type": "kitchen device", "access":1,"collector":"collector 3","values": [{"begin": 1313416361, "end": 1318686761, "value": 5.3234}]}]';
    echo $this->res;    
  } elseif ($this->DeliveryType() == DELIVERY_TYPE_VIEW) {
    //THIS IS FOR THE MOBILE APP
    //echo '[{"id": 1, "name": "toaster", "status": "active", "type": "kitchen device","access":1, "collector":"collector 1","values": [{"begin": 1313416361, "end": 1318686761, "value": 13.123}]},{"id": 2, "name":"fridge", "status": "active", "type": "kitchen device","access":2, "collector":"collector 2","values": [{"begin": 1313416361, "end": 1318686761, "value": 13.354}]},{"id": 3, "name": "oven", "status": "active", "type": "kitchen device", "access":1,"collector":"collector 3","values": [{"begin": 1313416361, "end": 1318686761, "value": 5.3234}]}]';
    echo $this->res;
  }
} else {
  echo '[{"error":"You are not authorized to view such information. Please signup on https://wattsapp.net first"}]';
}