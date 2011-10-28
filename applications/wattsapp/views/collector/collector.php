<?php if (!defined('APPLICATION')) exit();

function printPermission ($obj, $type) {
  if ($obj) {
    $n = $obj->NumRows();
    $r = $obj->Results();
    $output = "<div class='CollectorHeading'> Permissions</div><div class='Tabs'><ul>";
    for ($i = 0; $i < 3; $i++) {
      $res = $r[$i];
      $output = $output . "<li><a href='/profile/". $res->UserID ."'>" 
             . $res->Name . " ( " . $res->PermissionType . ' ) </a></li>';
    }    
    if ($n > 3) {
      
    }
    $output = $output . "</ul></div>";
  }
}

//local variables:
//$this->Collector
//$this->CollectorUsers
//$this->CollectorReq

$Location = "<div class='CollectorHeading'> Location</div>" . 
    "<div class='Tabs'><ul><li><a href='#'>" . 
    $this->Collector->Address . 
    "</a></li><li><a href='#'>" . 
    $this->Collector->Port .
    "</a></li></ul></div>";

$Permissions = "";
    
$Title = '<ul class="DataList"><li class="ItemContent">' . 
          $Location . '</li><li class="ItemContent">' . 
          $Permissions . '</li><li class="ItemContent">' .
          $Requests . '</li></ul>';

?>
<div class="Tabs">
 <ul>
  <li class="Active">
  <?php
    echo "<a href='" . Gdn_Url::WebRoot() . "/index.php?p=/collector/" . $this->Collector->CollectorID . "'> Collector : " . $this->Collector->Name . "</a>"; 
  ?>   
  </li>
 </ul>
</div>
<ul class="DataList">
 <li class="Item">
  <?php
    echo "<div class='OptionButton'><a href='Edit' class='Delete'></a></div>\n"; 
  ?>
  <div class="ItemContent">
   <?php echo $Title; ?>   
   <div class="Meta">
    <span class="DateCreated"><?php echo Gdn_Format::Date($Activity->DateInserted); ?></span>    
   </div>
  </div>
 </li>
</ul>
<?php 