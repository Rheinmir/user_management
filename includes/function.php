
<?php
    // Function that loads a layout template file from a given path.
function layouts($layoutName='header', $data =[]){
        if(file_exists(_WEB_PATH_TEMPLATES.'/layout/'.$layoutName.'.php')){
            require_once _WEB_PATH_TEMPLATES.'/layout/'.$layoutName.'.php';
        };
    }
?>