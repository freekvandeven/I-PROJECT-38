<?php

$producten = array(2, 3, 5, 6 , 7 );

$index = 0;

foreach($producten as $item){
    $producten[$index] = "<h2>" . $item['titel'] . "</h2> <br>";
    $producten[$index] .= "<p>" . $item['prijs'] . "</p> <br>";
    if(file_exists('C:\xampp\htdocs\images\afbeelding')){
        $producten[$index] .= "<img src='" . $item['afbeelding'] . ".png' alt='Foto van product'";
    } else {
        $producten[$index] .= "<img src='" . $item['afbeelding'] . ".png' alt='Foto van product'";
    }
    $index++;
}

$max = $index;

?>

<!Doctype HTML>
<html lang="nl">
    <head>
        <title>Amos Middelkoop</title>
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel="stylesheet" href="CSS/styles.css">
    </head>
    <body>
    <?php 
    for($index = 0;  $index < $max; $index++){
        echo $producten[$index];
    }
    ?>
    </body>
