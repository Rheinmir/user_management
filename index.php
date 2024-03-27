<?php
session_start();
require_once('config.php');

$module = _MODULE;
$action = _ACTION;


echo '<i class="fa-solid fa-house"></i>';
// Check if 'module' parameter in GET request is not empty and of type string.

if(!empty($_GET['module'])){
    if(is_string($_GET['module'])){
        $module = trim($_GET['module'],'/');
    }
    if(empty($module)){
        $module = _MODULE;
    }
}
if(!empty($_GET['action'])){
    if(is_string($_GET['action'])){
        $action = trim($_GET['action'],'/');
    }
    if(empty($action)){
        $action = _ACTION;
    }
}



echo $module.'</br>';
echo $action.'</br>';

// Checks if a file exists and includes it, if not includes a 404 error page.

$path = 'modules/'. $module. '/'.$action.'.php';

echo $path;

if(file_exists($path)) {
    require_once($path);
}else{
    require_once 'modules/errors/404.php';
}

?>