<?php
// get amount of notifications
$data = $dbh->prepare("SELECT COUNT(*) FROM Notificaties WHERE Ontvanger = :user");
$data->execute([":user"=>$_SESSION['name']]);
$result = $data->fetchColumn();
if(!empty($result)){
    echo $result;
}