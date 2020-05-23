<?php
// get amount of notifications
if(isset($_SESSION['name'])) {
    $notifications = User::getNotifications($_SESSION['name']);
    if (!empty($notifications)) {
        echo $notifications;
    }
}