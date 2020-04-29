<?php
$input = $_POST['queryString'];
$data = $dbh->query($_POST['queryString'], PDO::FETCH_ASSOC);
$result = "";
foreach($data as $row){
    foreach($row as $item){
        $result = $result . $item . "&emsp;";
    }
    $result = $result . "<br>";
}
