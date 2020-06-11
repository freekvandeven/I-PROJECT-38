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
            from voorwerp left join (select max(bodbedrag) as hoogstebod ,voorwerp 
            FROM bod WHERE  Gebruiker is not null
            group by voorwerp) t2
            on voorwerpnummer = voorwerp
            where VeilingGesloten = 0) as combinetable"; // base select
    $where = " WHERE ";
    $distance = " (@geo1.STDistance(geography::Point(ISNULL(Latitude,0),ISNULL(Longitude,0), 4326)))/1000 "; // returns distance in km
    if (isset($orders[':order']) && $orders[':order'] == "Dis") {
        $sql .= " join Gebruiker on combinetable.Verkoper = Gebruikersnaam";
        $sql = setSqlDistance($sql);                                            // prepare sql for ordering by distance
        $execute = setExecuteDistance($execute, $orders, false  );
    }
    if(!empty($orders[':rubriek'])){
        $sql = setRubriekTree($sql);
    }
    foreach ($orders as $key => $order) {
        if (!empty($order)) {
            if (strpos($key, ":maximumDistance") !== false) {
                if (isset($orders[':order']) && $orders[':order'] != "Dis") { // only prepare sql if distance isn't set already
                    $sql .= " join Gebruiker on combinetable.Verkoper = Gebruikersnaam";
                    $sql = setSqlDistance($sql);
                }
                $execute = setExecuteDistance($execute, $orders, true);
                $sql .= $where . " $distance between :min and :max ";
                    $where = " AND ";
            } else if (strpos($key, ":search") !== false) {
                $preselect = $dbh->prepare("Select VoorwerpNummer from KeywordsLink KL  
								 join Keywords K on K.KeyWordNummer=KL.KeyWordNummer
								 WHERE keyword =  :where");
                $sql .= $where . " Voorwerpnummer in(Select VoorwerpNummer from KeywordsLink KL
								 join Keywords K on K.KeyWordNummer=KL.KeyWordNummer
								 WHERE ";
                $foundKeywords =0;
                for ($i = 0; $i < sizeof($order); $i++) { // handle all keywords in the search order
                    if (!$i == 0) $sql .= " OR ";
                    $sql .= " Keyword = :where" . $i;
                    $execute[":where" . $i] = $order[$i];
                    $preselect->execute([":where"=>$order[$i]]);
                    if($preselect->fetch(PDO::FETCH_COLUMN))
                        $foundKeywords++;
                }
                $sql .= " group by voorwerpnummer
								 having count(voorwerpnummer)>$foundKeywords-1    
								 ) ";
                $where = " AND ";
            } else if (strpos($key, ":val1") !== false) {
                $sql .= $where . " ISNULL(hoogstebod ,Startprijs) BETWEEN :val1 AND :val2 ";
                $execute[':val1'] = $orders[':val1'];
                $execute[':val2'] = $orders[':val2'];
                $where = " AND ";
            } else if (strpos($key, ":order") !== false) {
                if ($order == "n")
                    $sql .= " ORDER BY Voorwerpnummer ASC ";
                else if ($order != "Dis") {
                    $sql .= " ORDER BY " . $order;
                } else {
                    $sql .= " ORDER BY $distance";
                }
            } else if (strpos($key, ":rubriek") !== false) {
                $sql .= $where . "voorwerpnummer in (SELECT voorwerp from tree t join VoorwerpInRubriek on RubriekOpLaagsteNiveau = rubrieknummer)"; //checks if in column tree
                $where = " AND ";
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


function setSqlDistance($sql)
{
    $sql = "DECLARE
                        @GEO1 GEOGRAPHY,
                        @LAT VARCHAR(10),
                        @LONG VARCHAR(10)

                        SET @LAT= :lat
                        SET @LONG= :long
                        SET @geo1= geography::Point(@LAT, @LONG, 4326)" . $sql;
    return $sql;
}

function setRubriekTree($sql){
    $sql = " WITH
        tree (rubrieknummer, rubrieknaam, rubriek)
        AS
        (
        SELECT rubrieknummer, rubrieknaam, rubriek
        FROM Rubriek
        WHERE rubrieknummer = :rubriek

        UNION ALL

        SELECT r.rubrieknummer, r.rubrieknaam, r.rubriek
        FROM Rubriek r
            INNER JOIN tree t
            ON r.rubriek = t.rubrieknummer
        ) ".$sql;
    return $sql;
}

function setExecuteDistance($execute, $orders, $limit)
{
    $execute[":lat"] = $orders[':lat'];
    $execute[":long"] = $orders[':long'];
    if ($limit) {
        $execute[":min"] = $orders[':minimumDistance'];
        $execute[":max"] = $orders[':maximumDistance'];
    }
    return $execute;
}
