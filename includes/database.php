<?php
function query($sql,$data=[]){
    global $conn;
    try {
        $statement = $conn->prepare($sql); //increase data security
        $result = false;
        if(!empty($data)){
            $result = $statement -> execute($data);
        }
        else{
            $result = $statement -> execute();
        }
    
    }catch (Exception $exception) {
        echo $exception->getMessage() . '<br>';
        echo 'File: ' . $exception->getFile() . '<br>';
        echo 'Line:' . $exception->getLine() . '<br>';
        die();
    };
    return $result;
}