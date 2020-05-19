<?php
if (isset($_POST['item']) && !empty($_POST['item'])) {
    if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
        User::insertFavorites($_SESSION['name'], $_POST['item']);
    }
    $_GET['id'] = $_POST['item'];
}
