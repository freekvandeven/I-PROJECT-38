<?php
if (isset($_POST['voorwerp']) && !empty($_POST['voorwerp'])) {
    if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
        User::insertFavorites($_SESSION['name'], $_POST['voorwerp']);
    }
}
