<?php
// get amount of notifications
if(isset($_SESSION['name'])) {
    if(User::getSettings($_SESSION['name'])['notifications']) {
        $notifications = User::getNotifications($_SESSION['name']);
        if (!empty($notifications)) {
            echo count($notifications);
        }
    }
}