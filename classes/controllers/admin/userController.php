<?php

# code for controlling users

if (isset($_POST['deleteUser'])) {
    User::deleteUser($_POST['deleteUser']);
}
$_GET['category'] = $_POST['category'];