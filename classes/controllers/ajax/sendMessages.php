<?php
if(isset($_SESSION['name']) && isset($_POST['receiver']) && isset($_POST['message'])) {
    //$notifications = User::getNotifications($_SESSION['name']);
    if (!empty($_POST['message'])) {
        echo "inserting user";
        $message = preg_replace('/\s+/', ' ',$_POST['message']);
        $data = $dbh->prepare("INSERT INTO Bericht (Message, Verzender, Ontvanger) VALUES (:message, :sender, :receiver)");
        $data->execute(array(":message" => $message, ":sender" => $_SESSION['name'], ":receiver" => $_POST['receiver']));
    }
}
?>