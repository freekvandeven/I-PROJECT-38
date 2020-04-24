<?php
session_start();
require_once('includes/functions.php');

$title = "catalogusproducten";
require_once('includes/header.php');

#ophalen van producten:
$producten = getItems();

foreach($producten as $item) : ?>
    <h2>Titel</h2>
    <p>Prijs</p>
    <?php if(file_exists('upload\items\ '. $item['Voorwerpnummer'] . '.png')) : ?>
        <img src="upload\items\<?=$item['Voorwerpnummer']?>.png" alt="Foto van product">
        <?php else: ?>
        <img src='upload\items\defaultAfbeelding.png' alt='Default foto'>
    <?php endif;
endforeach;
require_once('includes/footer.php');?>

