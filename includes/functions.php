<?php

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

