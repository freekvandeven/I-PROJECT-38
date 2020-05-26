<?php
$updates = [];
foreach ($_POST as $post => $value) {
    if (strpos($post, "Setting")) {
        $updates[substr($post, 0, -7)] = $value == 'on' ? true : false;
    }
}
$settings = ['recommendations'=>0,'darkmode'=>0,'notifications'=>0,'superTracking'=>0,'emails'=>0];
foreach ($updates as $update => $value) {
    $settings[$update]= $value;
}
User::updateSettings($settings, $_SESSION['name']);



