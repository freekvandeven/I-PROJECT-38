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

function getUser($username){
    global $dbh;
    $data = $dbh->prepare("SELECT * FROM Gebruiker WHERE gebruikersnaam = :username");
    $data->execute([":username"=>$username]);
    $user = $data->fetch(PDO::FETCH_ASSOC);
    return $user;
}
