<?php
session_start();

$title = "catalogusproducten";

require_once('includes/database.php');
require_once('includes/functions.php');
require_once('includes/header.php');

//ophalen van producten: $producten = getItems();

foreach($producten as $item) : ?>
<h2>Titel</h2>
<p>Prijs</p>
<?php if(file_exists('upload\items\ '. $item['afbeelding'])) : ?>
    <img src='upload\items\' . <?=$item['afbeelding']?> alt="Foto van product">
    <?php else: ?>
    <img src='upload\items\defaultAfbeelding.png' alt='Default foto'>
<?php endif; ?>
<?php endforeach; 

require_once('includes/footer.php');?>

