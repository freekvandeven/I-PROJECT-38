<?php
function checkLogin() // check if user is logged in
{
    if (!isset($_SESSION['loggedin'])) {
        header('Location: login.php');
        exit();
    }
}

function checkAdminLogin() //check if person is admin
{
    if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
        header('Location: login.php');
        exit();
    }
}

function checkVisitor(){
    logPageVisitor();
    checkIP();
}

function logPageVisitor(){
    $currentPage = basename($_SERVER['PHP_SELF']);
    if(checkPage($currentPage)){
        #increase page count
        increasePage($currentPage);
    } else {
        #insert page
        insertPage($currentPage);
    }
    // insert IP
    if(searchIPVisits($_SERVER["REMOTE_ADDR"])){
        increaseIPVisits($_SERVER["REMOTE_ADDR"]);
    } else {
        insertVisitorIP($_SERVER["REMOTE_ADDR"]);
    }
}

function checkIP()
{
    if ($_SERVER["REMOTE_ADDR"] != '::1') {
        if (checkBlackList($_SERVER["REMOTE_ADDR"])) {
            header("Location: includes/denied.php");
        }
        if (!checkWhiteList($_SERVER["REMOTE_ADDR"])) {
            header("Location: includes/denied.php");
        }
    }
}

function calculateLocation($location){
    $apiKey = 'AIzaSyBt6UzzpaNgxMJPT62WvvWp5Q7DKuR9GL8';
    $formattedAddrFrom = str_replace(' ', '+', $location);

    $geocodeLoc= file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$apiKey);
    $outputLoc = json_decode($geocodeLoc);
    if(!empty($outputLoc->error_message)){
        return $outputLoc->error_message;
    }
    return array("latitude"=> $outputLoc->results[0]->geometry->location->lat,"longitude"=>$outputLoc->results[0]->geometry->location->lng);
}
?>