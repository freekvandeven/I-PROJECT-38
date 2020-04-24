<?php
require_once('database.php');
function checkLogin()
{
    if (!isset($_SESSION['loggedin'])) {
        header('Location: login.php');
        exit();
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

