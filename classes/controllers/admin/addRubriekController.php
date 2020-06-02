<?php
if(isset($_POST['rubriek'])) {//check if a category is selected
    if ($_POST['action'] == 'delete') {
        Category::deleteCategory($_POST['rubriek']);
        $toast = 'Rubriek deleted';
    }
    if ($_POST['action'] == 'change') {
        Category::changeCategoryName($_POST['rubriek'],$_POST['rubriekNaam']);
        $toast = 'Rubriek updated';
    }
    if ($_POST['action'] == 'add') {
        Category::addCategory($_POST['rubriekNieuw'], $_POST['rubriek']);
        $toast = 'Rubriek added';
    }
}
/*
$input = $_POST['newRubriek'];
$data = $dbh->prepare('INSERT INTO Rubriek (Rubrieknaam, Rubriek, Volgnr) VALUES (:Rubrieknaam , 5, 5)');
$data->execute([":Rubrieknaam"=>$_POST['newRubriek']]);
*/
