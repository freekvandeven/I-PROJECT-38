<?php
require_once('db-config.php');
$dbh = Database::connectToDatabase();

function selectFromCatalog($orders)
{
    global $serverType;
    if($serverType!="mysql"){
        return selectFromCatalogsMSSQL($orders);
    }else {
        global $dbh;
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $execute = array();
        $sql = "SELECT * FROM Voorwerp ";

        foreach ($orders as $key => $order) {
            if (!empty($order)) {
                if (strpos($key, ":where") !== false) {
                    $sql .= " WHERE " . $key;
                    $execute[":where"] = $order;
                } else if (strpos($key, ":and") !== false) {
                    $sql .= " AND " . $key;
                    $execute[":and"] = $order;
                } else if (strpos($key, ":order") !== false) {
                    $sql .= " ORDER BY " . $key;
                    $execute[":order"] = $order;
                } else if (strpos($key, ":limit") !== false) {
                    $sql .= " LIMIT " . $key;
                    $execute["limit"] = $order;
                }
            }
        }
        $data = $dbh->prepare($sql);
        $data->execute($execute);
        return $data->fetchAll(PDO::FETCH_ASSOC);
    }
}

function selectFromCatalogsMSSQL($orders)
{
    global $dbh;
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $execute = array();
    $sql = "SELECT * FROM Voorwerp ";
    $limited = false;
    $limit = 0;
    foreach ($orders as $key => $order) {
        if (!empty($order)) {
            if (strpos($key, ":where") !== false) {
                $sql .= " WHERE " . $key;
                $execute[":where"] = $order;
            } else if (strpos($key, ":and") !== false) {
                $sql .= " AND " . $key;
                $execute[":and"] = $order;
            } else if (strpos($key, ":order") !== false) {
                $sql .= " ORDER BY " . $key;
                $execute[":order"] = $order;
            } else if (strpos($key, "limit") !== false){
                $limited = true;
                $limit = $order;
            }
        }
    }
    $data = $dbh->prepare($sql);
    $data->execute($execute);
    $result = $data->fetchAll(PDO::FETCH_ASSOC);
    if ($limited) {
        $result = array_splice($result, 0, $limit);
    }
    return $result;
}

function getQuestion($nummer)
{
    global $dbh;
    $data = $dbh->prepare('SELECT TekstVraag FROM Vraag WHERE Vraagnummer=:question');
    $data->execute([":question" => $nummer]);
    $result = $data->fetch(PDO::FETCH_NUM);
    return $result[0];
}

function getQuestions()
{
    global $dbh;
    $data = $dbh->prepare('SELECT Vraagnummer, TekstVraag FROM Vraag');
    $data->execute();
    $result = $data->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function checkPage($currentPage){
    global $dbh;
    $data = $dbh->prepare('SELECT * FROM Pages WHERE PageName=:page');
    $data->execute([":page"=>$currentPage]);
    $result = $data->fetchAll();
    return $result;
}

function increasePage($currentPage){
    global $dbh;
    $data = $dbh->prepare('UPDATE Pages SET Visits = Visits + 1 WHERE PageName = :page');
    $data->execute([":page"=>$currentPage]);
}

function insertPage($currentPage){
    global $dbh;
    $data = $dbh->prepare('INSERT INTO Pages (PageName, Visits) VALUES (:page, 1)');
    $data->execute([":page"=>$currentPage]);
}

function insertVisitorIP($visitorIP){
    global $dbh;
    $data = $dbh->prepare('INSERT INTO Visitors (IP, TotalVisits) VALUES (:ip, 1)');
    $data->execute([":ip"=>$visitorIP]);
    #var_dump($dbh->lastInsertId());
    /*
INSERT INTO `user_earnings` (`user_id`, `earning`) VALUES(25, 0) ON DUPLICATE KEY UPDATE
`earning`=VALUES(`earning` + 100) */
}

function checkBlacklist($visitorIP){
    global $dbh;
    $data = $dbh->prepare('SELECT * FROM Blacklist WHERE IP=:ip');
    $data->execute([":ip"=>$visitorIP]);
    $result = $data->fetchAll();
    return $result;
}

function getSiteVisits(){
    global $dbh;
    $data = $dbh->prepare('SELECT PageName, Visits FROM Pages');
    $data->execute();
    $result = $data->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function checkRegisterUser($username){
    global $dbh;
    $data = $dbh->prepare('SELECT Bevestiging FROM Gebruiker WHERE Gebruikersnaam =:username');
    $data->execute([":username" => $username]);
    return $data;
}

function makeUser($username){
    global $dbh;
    $stmt = $dbh->prepare('INSERT INTO Gebruiker (Bevestiging) VALUES(1) WHERE Gebruikersnaam =:username  ');
    $stmt->execute([":username" => $username]);
}
