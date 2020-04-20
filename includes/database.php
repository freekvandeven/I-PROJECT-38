<?php
require_once('db-config.php');
$dbh = connectToDatabase();
function connectToDatabase(){
    global $host;
    global $dbname;
    global $username;
    global $password;
    global $options;
    global $serverType;
    try {
        $dbh = new PDO("$serverType:host=$host;dbname=$dbname", $username, $password, $options);
        return $dbh;
    }catch(PDOException $e){
        echo $e->getMessage();
        return null;
    }
}
