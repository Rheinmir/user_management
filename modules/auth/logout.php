<?php
if(isLogin()){
    $token = getSession('loginToken');
    delete('logintoken', "token='$token'");
    removeSession('loginToken');
    redirect('?module=auth&action=login');
}
?>