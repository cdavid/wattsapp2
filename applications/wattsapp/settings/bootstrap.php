<?php if (!defined('APPLICATION')) exit();

// Application's bootstrap stuff can go here. Define global functions, mess with the Factory, Config modifications.

function logger($msg) {
    $myFile = "/tmp/vanilla.txt";
    $fh = fopen($myFile, 'a') or die("can't open file");
    fwrite($fh, $msg . "\n");
    fclose($fh);
}