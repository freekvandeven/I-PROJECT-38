<?php
if(isset($_SESSION['name']) && isset($_POST['receiver']) && isset($_POST['message'])) {
    //$notifications = User::getNotifications($_SESSION['name']);
    $message = preg_replace('/\s+/', ' ',$_POST['message']);
    $message = trim($message);
    if ($message) {
        echo "inserting user";
        $data = $dbh->prepare("INSERT INTO Bericht (Message, Verzender, Ontvanger) VALUES (:message, :sender, :receiver)");
        $data->execute(array(":message" => $message, ":sender" => $_SESSION['name'], ":receiver" => $_POST['receiver']));
    }
}
?>