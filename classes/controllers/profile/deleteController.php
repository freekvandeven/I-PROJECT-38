<?php
if(User::deleteUser($_SESSION['name']))
    require_once ("logout.php");