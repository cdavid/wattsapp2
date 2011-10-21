<?php if(!defined('APPLICATION')) exit();

if ($this->OkToRender) {
  if ($this->res) {
    echo $this->res;
  }
} else {
  echo '[{"error":"You are not authorized to view such information. Please signup on https://wattsapp.net first"}]';
}

