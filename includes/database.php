<?php
function query($sql, $data = [], $check =false)
{
    global $conn;
    // Prepare an SQL statement, bind data (if provided), and execute it.
    try {
        $statement = $conn->prepare($sql); //increase data security
        $result = false;
        if (!empty($data)) {
            $result = $statement->execute($data);
        } else {
            $result = $statement->execute();
        }
    } catch (Exception $exception) {
        echo $exception->getMessage() . '<br>';
        echo 'File: ' . $exception->getFile() . '<br>';
        echo 'Line:' . $exception->getLine() . '<br>';
        die();
    };
    if($check){
        return $statement;
    }
    return $result;
}



// Insert data into a table using SQL and placeholders for dynamic field values.
function insert($table, $data)
{
    $key = array_keys($data);
    $field = implode(',', $key);
    $valueTb = ':' . implode(',:', $key);

    // $sql = 'INSERT INTO' . $table .'('.$field.')'. 'VALUES('. $valueTb .')';
    $sql = 'INSERT INTO ' . $table . ' (' . $field . ') VALUES (' . $valueTb . ')';
    // echo  $sql;
    $result = query($sql, $data);
    return $result;
}
// Updates a database table with provided data, optionally with a condition.
function update($table, $data, $condition = '')
{
    $update = '';
    foreach ($data as $key => $value) {
        $update .= $key . '= :' . $key . ',';
    }
    $update = trim($update, ',');

    if (!empty($condition)) {
        $sql = 'UPDATE ' . $table . ' SET ' . $update . ' WHERE ' . $condition;
    } else {
        $sql = 'UPDATE ' . $table . ' SET ' . $update;
    }
    $result = query($sql, $data);
    return $result;
}

function delete($table,$condition=''){
    if(empty($condition)){
        $sql = 'DELETE FROM ' .$table;
    }else{
        $sql = 'DELETE FROM ' .$table . ' WHERE ' . $condition ;
    }
    $result = query($sql);
    return $result;
}

// Function to execute a raw SQL query and return the result as an associative array.
function getRaw($sql){
    $result = query($sql,'',true);
    if(is_object($result)){
        $dataFetch = $result -> fetchAll(PDO::FETCH_ASSOC);
    }
    return $dataFetch;
}

// Executes a SQL query and returns the first row as an associative array.
function getOneRaw($sql){
    $result = query($sql,'',true);
    if(is_object($result)){
        $dataFetch = $result -> fetch(PDO::FETCH_ASSOC);
    }
    return $dataFetch;
}

// Function returns the number of rows affected by an SQL query.
function getRow($sql){
    $result = query($sql,'',true);
    if(!empty($result)){
        return $result -> rowCount();
    }
}