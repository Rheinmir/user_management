<?php
/*
try{
    $__HOST = '127.0.0.1';
    $__DB = 'web';
    $__USER = 'root';
    $__PASS = 'mysql';
    $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', //Set utf8
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //Create exception notice when error occurs
    ]; //SYNTAX, modifying them will cause error
    $con = new PDO('mysql:dbname='.$__DB.';host='.$__HOST, $__USER, $__PASS, $options);   
}catch (Exception $e){
    $err = $e->getMessage();
    die()
}
mysqli
*/

//connection info

try {
    if (class_exists('PDO')) {
        $dsn = 'mysql:dbname=' . _DB . ';host=' . _HOST; //SYNTAX, modifying them will cause error

        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', //Set utf8
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //Create exception notice when error occurs
        ]; //SYNTAX, modifying them will cause error

        $conn = new PDO($dsn, _USER, _PASS);
        // var_dump($conn); //if it returns value like "object(PDO)#1 (0) { }", meaning connection succeeded
        if ($conn) {
            echo 'Connection succeeded </br>';
        }
    }
} catch (Exception $exception) {
    echo '<div style="color:red; padding:5px 15px; border: 3px solid red;">';
    echo $exception->getMessage() . "<br>";
    echo '</div>';
    die(); //its very dangerous if keep connecting to database when error occurs, so codes should be kill immediately
}
