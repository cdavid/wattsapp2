<?php if (!defined('APPLICATION')) exit();
//ServerID Name PermissionType 
echo '[';
if ($this->res && $this->res->NumRows() > 0) {
  $re = $this->res->Result();
  for ($i = 0; $i < $this->res->NumRows(); $i++) {
    $r = $re[$i];
    echo '{"serverid" :' . $r->ServerID . "," .
           '"name" : "' . $r->Name . '",' .
           '"permission" : "' . $r->PermissionType . '"' .
         '}';
    if ($i < $this->res->NumRows() - 1) echo ',';
  }
}
echo ']';
