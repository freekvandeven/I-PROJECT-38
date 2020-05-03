<?php
require_once('database.php');
checkVisitor();
startAutoLoader();
#var_dump(User::getUser($_SESSION['name']));

function checkLogin()
{
    if (!isset($_SESSION['loggedin'])) {
        header('Location: login.php');
        exit();
    }
}

function checkVisitor(){
    logPageVisitor();
    checkIP();
}

function startAutoLoader(){
    #this function loads all classes in classes/models/ whenever they are called in our program.
    spl_autoload_register(function ($class_name) {
        include 'classes/models/' . $class_name . '.php';
    });
}

function logPageVisitor(){
    $currentPage = basename($_SERVER['PHP_SELF']);
    if(checkPage($currentPage)){
        #increase page count
        increasePage($currentPage);
    } else {
        #insert page
        insertPage($currentPage);
    }
    // insert IP
    insertVisitorIP($_SERVER["REMOTE_ADDR"]);
}

function checkIP(){
    if(checkBlacklist($_SERVER["REMOTE_ADDR"])){
        header("Location: 404.php");
    }
}


function checkAdminLogin()
{
    if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
        header('Location: index.php');
        exit();
    }
}

function createSession($user)
{
    session_regenerate_id();
    $_SESSION['loggedin'] = TRUE;
    $_SESSION['name'] = $user['Gebruikersnaam'];
    $_SESSION['admin'] = $user['Action'];
}

function setupDatabase()
{
    global $dbh;
    $sql = file_get_contents('includes/Testscript.sql');
    $data = $dbh->exec($sql);
}

function storeImg($id)
{
    $target_dir = "uploads/items/";
    move_uploaded_file($_FILES['img']['tmp_name'], $target_dir . $id .'.png');
}

