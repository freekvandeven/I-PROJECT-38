<?php
session_start();
checkLogin();

$title = "profielpagina";

$edit = false;

require_once('includes/database.php');
require_once('includes/functions.php');

if(isset($_POST['Edit'])){
    $edit = true;
} 

if($edit === false){
    require_once('C:\xampp\htdocs/viewProfiel.php');
    if(isset($_POST['Verzenden'])){
       //update database
    }
} else {
    require_once('C:\xampp\htdocs/updateprofiel.php');
    $edit = false;
}


require_once('includes/header.php');
?>
