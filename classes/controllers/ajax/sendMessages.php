<?php
if(isset($_SESSION['name']) && isset($_POST['receiver']) && isset($_POST['message'])) {
    //$notifications = User::getNotifications($_SESSION['name']);
    echo "inserting user";
    $data = $dbh->prepare("INSERT INTO Bericht (Message, Verzender, Ontvanger) VALUES (:message, :sender, :receiver)");
    $data->execute(array(":message"=>$_POST['message'], ":sender"=>$_SESSION['name'], ":receiver"=>$_POST['receiver']));
}
?>