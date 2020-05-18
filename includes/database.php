<?php
require_once('db-config.php');
$dbh = Database::connectToDatabase();


function selectFromCatalog($orders)
{
    global $serverType;
    if ($serverType != "mysql") {
        return selectFromCatalogsMSSQL($orders);
    } else {
        global $dbh;
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $execute = array();
        $sql = "SELECT * FROM (SELECT *, IFNULL(hoogstebod ,Startprijs) as prijs
            from voorwerp left join (select max(cast(bodbedrag as decimal(10,2))) as hoogstebod ,voorwerp 
            FROM bod WHERE Bodbedrag NOT LIKE '%[^0-9]%' AND Gebruiker is not null
            group by voorwerp) t2
            on voorwerpnummer = voorwerp
            where VeilingGesloten = 'Nee') as combinetable";
        foreach ($orders as $key => $order) {
            if (!empty($order)) {
                if (strpos($key, ":where") !== false) {
                    $sql .= " WHERE titel LIKE " . $key;
                    $execute[":where"] = $order;
                } else if (strpos($key, ":and") !== false) {
                    $sql .= " AND " . $key;
                    $execute[":and"] = $order;
                } else if (strpos($key, ":order") !== false) {
                    $sql .= " ORDER BY " . $order;
                } else if (strpos($key, ":rubriek") !== false) {
                    $sql .= " AND Voorwerpnummer IN (select voorwerp from voorwerpinrubriek where RubriekOpLaagsteNiveau = :rubriek )";
                    $execute[":rubriek"] = $order;
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
    $sql = "SELECT * FROM (SELECT *, ISNULL(hoogstebod ,Startprijs) as prijs
            from voorwerp left join (select max(cast(bodbedrag as decimal(10,2))) as hoogstebod ,voorwerp 
            FROM bod WHERE Bodbedrag NOT LIKE '%[^0-9]%' AND Gebruiker is not null
            group by voorwerp) t2
            on voorwerpnummer = voorwerp
            where VeilingGesloten = 'Nee') as combinetable";
    $limited = false;
    $limit = 0;
    foreach ($orders as $key => $order) {
        if (!empty($order)) {
            if (strpos($key, ":where") !== false) {
                $sql .= " WHERE titel LIKE " . $key;
                $execute[":where"] = $order;
            } else if (strpos($key, ":and") !== false) {
                $sql .= " AND " . $key;
                $execute[":and"] = $order;
            } else if (strpos($key, ":order") !== false) {
                $sql .= " ORDER BY " . $order;
            } else if (strpos($key, ":rubriek") !== false) {
                $sql .= " AND Voorwerpnummer IN (select voorwerp from voorwerpinrubriek where RubriekOpLaagsteNiveau = :rubriek )";
                $execute[":rubriek"] = $order;
            } else if (strpos($key, "limit") !== false) {
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

function checkPage($currentPage)
{
    global $dbh;
    $data = $dbh->prepare('SELECT * FROM Pages WHERE PageName=:page');
    $data->execute([":page" => $currentPage]);
    $result = $data->fetchAll();
    return $result;
}

function searchIPVisits($visitor)
{
    global $dbh;
    $data = $dbh->prepare('SELECT * FROM Visitors WHERE IP = :ip');
    $data->execute([":ip" => $visitor]);
    $result = $data->fetchColumn();
    return $result;
}
function increaseIPVisits($visitor){
    global $dbh;
    $data = $dbh->prepare('UPDATE Visitors SET TotalVisits = TotalVisits + 1 WHERE IP = :ip');
    $data->execute([":ip" => $visitor]);
}
function increasePage($currentPage)
{
    global $dbh;
    $data = $dbh->prepare('UPDATE Pages SET Visits = Visits + 1 WHERE PageName = :page');
    $data->execute([":page" => $currentPage]);
}

function insertPage($currentPage)
{
    global $dbh;
    $data = $dbh->prepare('INSERT INTO Pages (PageName, Visits) VALUES (:page, 1)');
    $data->execute([":page" => $currentPage]);
}

function insertVisitorIP($visitorIP)
{
    global $dbh;
    $data = $dbh->prepare('INSERT INTO Visitors (IP, TotalVisits) VALUES (:ip, 1)');
    $data->execute([":ip" => $visitorIP]);
}

function checkBlacklist($visitorIP)
{
    global $dbh;
    $data = $dbh->prepare('SELECT * FROM Blacklist WHERE IP=:ip');
    $data->execute([":ip" => $visitorIP]);
    $result = $data->fetchAll();
    return $result;
}

function checkWhiteList($visitorIP)
{
    global $dbh;
    $data = $dbh->prepare('SELECT * FROM Whitelist WHERE IP=:ip');
    $data->execute([":ip" => $visitorIP]);
    $result = $data->fetchColumn();
    return $result;
}

function getSiteVisits()
{
    global $dbh;
    $data = $dbh->prepare('SELECT PageName, Visits FROM Pages');
    $data->execute();
    $result = $data->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
