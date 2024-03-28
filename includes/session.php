<?php
// Sets a value in the PHP session with the given key.
function setSession($key, $value){
    return $_SESSION[$key] = $value;
}
// Function to retrieve a specific session variable or the entire session array.
function getSession($key){
    if(empty($key)){
        return $_SESSION;
    }else{
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }
    }
}
// Function to remove a session variable or all session variables.
function removeSession($key=''){
    if(empty($key)){
        session_destroy();
        return $_SESSION;
    }else{
        if(isset($_SESSION[$key])){
            unset($_SESSION[$key]);
            return true;
        }
    }
}

function setFlashData($key, $value){
    $key = 'flash_' .$key;
    return setSession($key, $value);
}
function getFlashData($key){
    $key = 'flash_' .$key;
    $data = getSession($key);
    removeSession($key);
    return $data;
}