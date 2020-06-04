<?php
if (isset($_SESSION['name'])) {
    User::toggleDarkmode(User::getSettings($_SESSION['name'])['darkmode'],$_SESSION['name']);
}
?>

