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
        $dbh = new PDO("$serverType:Server=$host;Database=$dbname", $username, $password, $options);
        return $dbh;
    }catch(PDOException $e){
        echo $e->getMessage();
        return null;
    }
}

function getUser($username){
    global $dbh;
    $data = $dbh->prepare('SELECT Gebruikersnaam, Wachtwoord FROM gebruiker WHERE Gebruikersnaam = :username');
    $data->execute(array( ":username"=>$username));
    $user = $data->fetch(PDO::FETCH_ASSOC);
    return $user;
}
