<?php

$bootstrapGrid = 'col-xl-4 col-md-6 col-sm-6 col-6';

$categories = ["auction", "user", "seller", "statistics", "activity", "addRubriek", "feedback", "footerpages", "settings", "reset", "fill", "query"];
$titles = ['Website', 'Database'];
$websiteCategoriesAmount = 8;
$databaseCategoriesAmount = 4;
$cardTitles = ['Bekijk alle veilingen', 'Bekijk alle gebruikers', 'Bekijk alle verkopers', 'Bekijk website statistieken', 'Bekijk gebruikers statistieken',
    'Voeg een rubriek toe', "Bekijk alle feedback", "Footer pagina's", 'Server Settings', 'Reset uw database', 'Vul uw database', 'MS SQL Server Query Editor'];
$cardText = ['Hier is een overzicht te vinden van alle veilingen die ooit hebben bestaan.',
            'Hier is een overzicht te vinden van alle gebruikers.',
            'Hier is een overzicht te vinden van alle verkopers.',
            'Hier zijn de statistieken van uw website te vinden.',
            'Hier zijn de statistieken van uw gebruikers te vinden.',
            'Op deze pagina is het mogelijk om een rubriek toe te voegen.',
            'Hier is een overzicht te vinden van alle feedback',
            "Op deze pagina kan je alle footer pagina's aanpassen",
            'Op deze pagina is het mogelijk om de server instellingen te wijzigen',
            'Op deze pagina is het mogelijk om de database te resetten.',
            'Op deze pagina kan je de database vullen met data.',
            'Bekijk hier het resultaat van uw MS SQL Server query'];

?>

<main class="adminPagina">
    <div class="jumbotron">
        <h2 class="display-5">Welkom admin op de Adminpagina</h2>
        <p>Op deze pagina heeft u een aantal opties waar alleen u toegang tot heeft.</p>
    </div>

    <div class="container">
    <?php foreach($titles as $title) { // Per categorie (website/database)
        echo '
        <h2>'.$title.'</h2>
        <div class="row">';

        // Bepaalt welke categorie aan de beurt is: Website / Database
        if($title == 'Website') { // Zet startwaarden goed voor de for-loop hierbeneden.
            $amount = $websiteCategoriesAmount;
            $startValue = 0;
        } else {
            $amount = $websiteCategoriesAmount+$databaseCategoriesAmount;
            $startValue = $websiteCategoriesAmount;
        }

        for($i = $startValue; $i < $amount; $i++) {
            echo '
            <div class="'.$bootstrapGrid.'">
                <a href="admin.php?category='.$categories[$i].'">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">'.$cardTitles[$i].'</h4>
                            <img src="images/adminimages/'.$categories[$i].'.png" alt="'.$cardTitles[$i].'" class="card-img">
                            <p>'.$cardText[$i].'</p>
                        </div>
                    </div>
                </a>
            </div>';
        }
        echo '
        </div> ';
        } ?>
    </div>
</main>