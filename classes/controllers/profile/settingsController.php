<?php
$updates = [];
if (isset($_POST['settings'])) {
    if ($_POST['settings'] == 'add') {
        if (isset($_POST['zoekwoord']) && !empty($_POST['zoekwoord'])) {
            Buyer::addSearchTrigger($_SESSION['name'], $_POST['zoekwoord']);
            $toast = "zoekwoord toegevoegd";
        }
    } else if ($_POST['settings'] == 'update') {
        foreach ($_POST as $post => $value) {
            if (strpos($post, "Setting")) {
                $updates[substr($post, 0, -7)] = $value == 'on' ? true : false;
            }
        }
        $settings = ['recommendations' => 0, 'darkmode' => 0, 'notifications' => 0, 'superTracking' => 0, 'emails' => 0];
        foreach ($updates as $update => $value) {
            $settings[$update] = $value;
        }
        User::updateSettings($settings, $_SESSION['name']);
        $toast = "instellingen gewijzigd";
    } else {
        Buyer::deleteSearchTrigger($_SESSION['name'], $_POST['settings']);
        $toast = "zoekwoord verwijderd";
    }
}

