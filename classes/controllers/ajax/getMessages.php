<?php
if(isset($_SESSION['name']) && isset($_POST['responder'])) {
    $html = "";
    foreach(getConversation() as $message){
        $date = explode( ".",$message['Tijdstip'])[0];
        $time = explode( " ", $date)[1];
        $datum = explode( " ", $date)[0];
        if($message['Ontvanger'] == $_SESSION['name']){
            $html .= "<div class='container-left d-flex justify-content-start mb-12'>";
        } else {
            $html .= "<div class='container-right d-flex justify-content-end' style='width:100%;'>";
        }
        $html .= "<p>". $message['Message'] . "</p>
            <span class='timeMessage'>" . $time . "</span></div>";
    }
    echo $html;

}

function getConversation(){
    global $dbh;
    $data = $dbh->prepare("SELECT * FROM Bericht WHERE (Ontvanger=:user AND Verzender=:responder) OR (Verzender=:user2 AND Ontvanger=:responder2) ORDER BY Tijdstip");
    $data->execute(array(":user"=>$_SESSION['name'], ":user2"=>$_SESSION['name'], ":responder"=>$_POST['responder'], ":responder2"=>$_POST['responder']));
    $result = $data->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
?>