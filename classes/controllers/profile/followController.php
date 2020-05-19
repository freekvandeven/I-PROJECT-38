<?php
if (isset($_POST['item']) && !empty($_POST['item']) && $_SESSION['name'] != $_POST['item']) {
    if (isset($_POST['favoriet']) && !empty($_POST['favoriet'])) {
        User::insertFavorites($_POST['item'], $_POST['favoriet']);
    }
    $_GET['id'] = $_POST['item'];
}
