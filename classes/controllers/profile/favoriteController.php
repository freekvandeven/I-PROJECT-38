<?php
if (isset($_POST['deleteFollow'])  && !empty($_POST['deleteFollow'])) {
        //User::insertFavorites($_SESSION['name'], $_POST['voorwerp']);
    Buyer::unFollowItem($_SESSION['name'], $_POST['deleteFollow']);
}
$_GET['action'] = $_POST['action'];
