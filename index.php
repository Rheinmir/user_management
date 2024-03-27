<?php
session_start();
require_once('config.php');

echo _CODE;

$module = _MODULE;
$action = _ACTION;



// Check if 'module' parameter in GET request is not empty and of type string.
if(!empty($_GET['module'])){
    if(is_string($_GET['module'])){
        $module = trim($_GET['module']);
    }
}
if(!empty($_GET['action'])){
    if(is_string($_GET['action'])){
        $action = trim($_GET['action']);
    }
}


// echo $module.'</br>';
// echo $action.'</br>';

// Checks if a file exists and requires it if so, otherwise requires a 404 error file.
$path = 'modules/'. $module. '/'.$action.'.php';

if (file_exists($path)) {
    require_once($path);
}else {
    require_once 'modules/errors/404.php';
}
// require("counter.php");

?>