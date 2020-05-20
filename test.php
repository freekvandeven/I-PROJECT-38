<?php
session_start();
require_once('includes/functions.php');


$title = 'test page';

require_once('includes/header.php');
/*
$sql = "SELECT r.Rubrieknummer as hoofdnummer, r.Rubrieknaam as hoofdnaam, t.Rubrieknummer as subnummer, t.Rubrieknaam as subnaam, y.Rubrieknummer as subsubnummer, y.Rubrieknaam as subsubnaam FROM Rubriek r left join Rubriek t on t.Rubriek = r.Rubrieknummer left join Rubriek y on y.Rubriek = t.Rubrieknummer WHERE r.Rubriek = -1 ORDER BY r.Rubrieknummer, t.Rubrieknummer, y.Rubrieknummer
";
$data = $dbh->query($sql);
$result = $data->fetchAll(PDO::FETCH_ASSOC);
$filtered = [];
foreach($result as $row){
    //$filtered[$row[0]] = $row[1];
    $filtered[$row['hoofdnaam']][$row['subnaam']][] = $row['subsubnaam'];
}
echo '<pre>' , var_dump($filtered) , '</pre>';
*/
//phpinfo();

$file = 'test.png';
$nummer = 11968;

$test = $dbh->prepare("{CALL fileInsert(?, ?)}");
$test->bindParam(1, $file, PDO::PARAM_STR);
$test->bindParam(2, $nummer, PDO::PARAM_INT);
$test->execute();
print_r($test->errorInfo());

$dirs = array_filter(glob('SQL/*'), 'is_dir');
$files = [];
foreach($dirs as $dir){
    $files = array_merge($files, preg_filter('/^/', $dir . "/",array_diff(scandir($dir,1), array('.', '..'))));
}
var_dump($files);
//echo calculateDistance(calculateLocation('6671GK'),calculateLocation('6525EC'));
//echo generateCategoryDropdown();
require_once('includes/footer.php');
