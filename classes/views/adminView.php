<?php

$bootstrapGrid = 'col-xl-4 col-md-6 col-sm-6';

$categories = ['auction', 'user', 'seller', 'statistics', 'addRubriek', 'reset', 'query'];
$titles = ['Website', 'Database'];
$websiteCategoriesAmount = 5;
$databaseCategoriesAmount = 2;
$cardTitles = ['Bekijk alle veilingen', 'Bekijk alle gebruikers', 'Bekijk alle verkopers', 'Bekijk website statistieken', 'Voeg een rubriek toe', 'Reset uw database', 'MS SQL Server Query Editor'];
$cardText = ['Hier is een overzicht te vinden van alle veilingen die ooit hebben bestaan.',
            'Hier is een overzicht te vinden van alle gebruikers.',
            'Hier is een overzicht te vinden van alle verkopers.',
            'Hier zijn de statistieken van uw website te vinden.',
            'Op deze pagina is het mogelijk om een rubriek toe te voegen.',
            'Op deze pagina is het mogelijk om de database te resetten.',
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