<?php if (!defined('APPLICATION')) exit();
$Session = Gdn::Session();

if ($this->DeliveryType() == DELIVERY_TYPE_ALL) {
  if ($this->DeliveryMethod() == DELIVERY_METHOD_JSON) {
    echo "asdafs";
  }
  echo "<div class='Legal'> Welcome to WattsApp!!! </div>";
  echo "<div class='Legal'><a href='". Gdn_Url::WebRoot(true) ."/index.php?p=/wattsapp/collector/'>Collector List</div>";
}
