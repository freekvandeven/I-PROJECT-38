<?php
if(isset($_SESSION['name']) && isset($_POST['responder'])) {
    $html = "";
    $oldMyTurn = 2;
    foreach(getConversation() as $message){
        if(!empty($message['Message'])) {
            $date = explode(".", $message['Tijdstip'])[0];
            $time = explode(" ", $date)[1];
            $datum = explode(" ", $date)[0];

            if ($message['Ontvanger'] == $_SESSION['name']) {
                if ($oldMyTurn == 1) $html .= "</div><div class='container-left d-flex'>";
                else if ($oldMyTurn == 2) $html .= "<div class='container-left d-flex'>";
                $html .= "<div class='messageBox'><p>" . $message['Message'] . "</p>
                <span class='timeMessage'>" . $time . "</span></div>";
                $oldMyTurn = 0;
            } else {
                if ($oldMyTurn == 0) $html .= "</div><div class='container-right d-flex'>";
                else if ($oldMyTurn == 2) $html .= "<div class='container-right d-flex'>";
                $html .= "<div class='messageBox'><span class='timeMessage'>" . $time . "</span>
                    <p>" . $message['Message'] . "</p></div>";
                $oldMyTurn = 1;
            }
        }
    }
    echo $html;

}

function getConversation(){
    global $dbh;
    $data = $dbh->prepare("SELECT * FROM Bericht WHERE (Ontvanger=:user AND Verzender=:responder) OR (Verzender=:user2 AND Ontvanger=:responder2) ORDER BY Tijdstip DESC");
    $data->execute(array(":user"=>$_SESSION['name'], ":user2"=>$_SESSION['name'], ":responder"=>$_POST['responder'], ":responder2"=>$_POST['responder']));
    $result = $data->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
?>