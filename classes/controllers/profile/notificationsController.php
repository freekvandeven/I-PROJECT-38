<?php
if(isset($_POST['option']) && $_POST['option'] == 'clear') {
    User::clearNotifications($_SESSION['name']);
    $toast = "notificaties verwijderd";
}

$_GET['action'] = $_POST['action'];