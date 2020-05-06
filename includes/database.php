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
        $sql = "SELECT *, IFNULL(cast(MAX(bodbedrag) as decimal(10,2)),Startprijs) as prijs FROM Voorwerp v LEFT JOIN Bod b on v.voorwerpnummer=b.voorwerp";
        foreach ($orders as $key => $order) {
            if (!empty($order)) {
                if (strpos($key, ":where") !== false) {
                    $sql .= " WHERE " . $key;
                    $execute[":where"] = $order;
                } else if (strpos($key, ":and") !== false) {
                    $sql .= " AND " . $key;
                    $execute[":and"] = $order;
                }
            }
        }
        $sql .= " GROUP BY Voorwerpnummer";
        foreach ($orders as $key => $order) {
            if (!empty($order)) {
                if (strpos($key, ":order") !== false) {
                    $sql .= " ORDER BY " . $order;
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
    $sql = "SELECT *, ISNULL(cast(MAX(bodbedrag) as decimal(10,2)),Startprijs) as prijs FROM Voorwerp v LEFT JOIN Bod b on v.voorwerpnummer=b.voorwerp";
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
            }
        }
    }
    $sql .= " GROUP BY [Voorwerpnummer]
      ,[Titel]
      ,[Beschrijving]
      ,[Startprijs]
      ,[Betalingswijze]
      ,[Betalingsinstructie]
      ,[Plaatsnaam]
      ,[Land]
      ,[Looptijd]
      ,[LooptijdBeginDag]
      ,[LooptijdBeginTijdstip]
      ,[Verzendkosten]
      ,[Verzendinstructies]
      ,[Verkoper]
      ,[Koper]
      ,[LooptijdEindeDag]
      ,[LooptijdEindeTijdstip]
      ,[VeilingGesloten]
      ,[Verkoopprijs]
	  ,[Voorwerp]
      ,[Bodbedrag]
      ,[Gebruiker]
      ,[BodDag]
      ,[BodTijdstip]";
    foreach ($orders as $key => $order) {
        if (!empty($order)) {
            if (strpos($key, ":order") !== false) {
                $sql .= " ORDER BY " . $order;
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

function getSiteVisits()
{
    global $dbh;
    $data = $dbh->prepare('SELECT PageName, Visits FROM Pages');
    $data->execute();
    $result = $data->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function rateSeller($seller, $rating)
{
    global $dbh;
    $data = $dbh->prepare('INSERT INTO Beoordeling (Verkoper,Rating) VALUES(:verkoper, :rating)');
    $data->execute([":verkoper" => $seller], [":rating" => $rating]);
}

function getSumRating($username)
{
    global $dbh;
    $data = $dbh->prepare('SELECT SUM(Rating) FROM Beoordeling WHERE Gebruikersnaam = :Gebruikersnaam');
    $data->execute([":Gebruikersnaam" => $username]);
    return $data;
}

function getAmountRatings($username) {
    global $dbh;
    $data = $dbh->prepare('SELECT COUNT(BeoordelingsNr) FROM Beoordeling WHERE Gebruikersnaam = :Gebruikersnaam');
    $data->execute([":Gebruikersnaam" => $username]);
    return $data;
}


