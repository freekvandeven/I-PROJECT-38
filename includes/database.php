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
            where VeilingGesloten = 0) as combinetable";
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
    $sql = "SELECT  * FROM (SELECT *, ISNULL(hoogstebod ,Startprijs) as prijs
            from voorwerp left join (select max(cast(bodbedrag as decimal(10,2))) as hoogstebod ,voorwerp 
            FROM bod WHERE Bodbedrag NOT LIKE '%[^0-9]%' AND Gebruiker is not null
            group by voorwerp) t2
            on voorwerpnummer = voorwerp
            where VeilingGesloten = 0) as combinetable";
    $distanceSet = false;
    $whereSet = false;
    $where = " WHERE ";
    foreach ($orders as $key => $order) {
        if (!empty($order)) {
            if (strpos($key, ":lat") !== false) {
                $distanceSet = true;
                if ($whereSet) {
                    $where = " AND ";
                }
                $whereSet = true;
                $sql = setSqlDistance($sql);
                $execute = setExecuteDistance($execute,$orders);
                $sql .= " join Gebruiker on combinetable.Verkoper = Gebruikersnaam";
                $sql .= $where . " (@geo1.STDistance(geography::Point(ISNULL(Latitude,0),ISNULL(Longitude,0), 4326)))/1000 between :min and :max ";
            } else if (strpos($key, ":search") !== false) {
                if ($whereSet) {
                    $where = " AND ";
                }
                $sql .= $where . " titel LIKE " . $key;
                $whereSet = true;
                $execute[":search"] = $order;
            } else if (strpos($key, ":val1") !== false) {
                if ($whereSet) {
                    $where = " AND ";
                }
                $sql .= $where . " ISNULL(hoogstebod ,Startprijs) BETWEEN :val1 AND :val2 ";
                $execute[':val1'] = $orders[':val1'];
                $execute[':val2'] = $orders[':val2'];
                $whereSet = true;
            } else if (strpos($key, ":and") !== false) {
                $sql .= " AND " . $key;
                $execute[":and"] = $order;
            } else if (strpos($key, ":order") !== false) {
                if ($order == "n")
                    $sql .= " ORDER BY Voorwerpnummer ASC ";
                else {
                    $sql .= " ORDER BY " . $order;
                    if (!$distanceSet&&$key==' (@geo1.STDistance(geography::Point(ISNULL(Latitude,0),ISNULL(Longitude,0), 4326)))/1000 ASC ') {
                        $sql = setSqlDistance($sql);
                        $execute = setExecuteDistance($execute,$orders);
                    }
                }
            } else if (strpos($key, ":rubriek") !== false) {
                $sql .= " AND Voorwerpnummer IN (select voorwerp from voorwerpinrubriek where RubriekOpLaagsteNiveau = :rubriek )";
                $execute[":rubriek"] = $order;
            } else if (strpos($key, ":offset") !== false) {
                if ($order != " ")
                    $sql .= " OFFSET $order";
                else $sql .= " OFFSET 0";
            } else if (strpos($key, ":limit") !== false) {
                $sql .= " ROWS FETCH NEXT " . $order . " ROWS ONLY ";
            }
        }
    }
    $data = $dbh->prepare($sql);
    $data->execute($execute);
    $result = $data->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
function setSqlDistance($sql){
    $sql = "DECLARE
                        @GEO1 GEOGRAPHY,
                        @LAT VARCHAR(10),
                        @LONG VARCHAR(10)

                        SET @LAT= :lat
                        SET @LONG= :long
                        SET @geo1= geography::Point(@LAT, @LONG, 4326)" . $sql;
    return $sql;
}
function setExecuteDistance($execute,$orders){
    $execute[":lat"] = $orders[':lat'];
    $execute[":long"] = $orders[':long'];
    $execute[":min"] = $orders[':minimumDistance'];
    $execute[":max"] = $orders[':maximumDistance'];
    return $execute;
}
