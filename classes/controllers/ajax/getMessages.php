<?php
if(isset($_SESSION['name']) && isset($_POST['responder'])) {
    $html = "";
    $previousTime = "00:00:00";
    $previousDate = "2019-06-03";
    foreach(getConversation() as $message){
        $date = explode( ".",$message['Tijdstip'])[0];
        $time = explode( " ", $date)[1];
        $datum = explode( " ", $date)[0];
        if($message['Ontvanger'] == $previousReceiver) {

        } else {
            $html .= "</div>";
            if ($message['Ontvanger'] == $_SESSION['name']) {
                $html .= "<div class='container-left'>";
            } else {
                $html .= "<div class='container-right'>";
            }
        }
        if($datum != $previousDate){
            $html .= "<p style='text-align: center;'>$datum</p>";
        }
        $html .= "<div class='messageBox'><p>". $message['Message'] . "</p>";
        $date1 = new DateTime($previousTime);
        $date2 = $date1->diff(new DateTime($time));
        if($date2->i > 2){
            $html .= "<span class='timeMessage'>" . $time . "</span></div>";
        } else {
            $html .= "</div>";
        }
        $previousDate = $datum;
        $previousTime = $time;
        $previousReceiver = $message['Ontvanger'];
    }
    $html .= '</div>';
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