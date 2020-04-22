<?php
require_once('database.php');
function checkLogin(){
    if (!isset($_SESSION['loggedin'])) {
        header('Location: login.php');
        exit();
    }
}


function checkAdminLogin(){
    if(!isset($_SESSION['admin'])){
        header('Location: index.php');
        exit();
    }
}

function createSession($user){
    session_regenerate_id();
    $_SESSION['loggedin'] = TRUE;
    #$_SESSION['userid'] = $user['id'];
    $_SESSION['name'] = $user['Gebruikersnaam'];
    $_SESSION['admin'] = $user['Action'];
}

function setupDatabase(){
    global $dbh;
    $sql = file_get_contents('Testscript.sql');
    $data = $dbh->exec($sql);
}
