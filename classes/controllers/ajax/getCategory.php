<?php
$search = '%' . $_POST["search"] . '%';
$hint = "";
// get the corresponding categories
$sql = "SELECT DISTINCT TOP 50 Rubrieknaam, Rubrieknummer FROM Rubriek WHERE Rubrieknaam LIKE :search";
$data = $dbh->prepare($sql);
$data->bindValue(':search', $search, PDO::PARAM_STR);
$data->execute();
$result = $data->fetchAll(PDO::FETCH_ASSOC);


// loop over the categorie
foreach($result as $category){
    $hint.= "<li class='" . $category['Rubrieknummer'] . "'>" . $category['Rubrieknaam'] . "</li>";
}

echo $hint === "" ? "geen categorie gevonden" : $hint;