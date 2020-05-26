<?php
$items = Items::getItemsLimit(100);
$displayedItems = array("Titel", "Startprijs", "Betalingswijze", "Betalingsinstructie", "Plaatsnaam", "Land", "Looptijd");
?>

<main class="adminPaginaSub">
    <div class="jumbotron">
        <h2 class="display-5">Welkom op de veilingenpagina</h2>
        <p>Op deze pagina kunt u alle veilingen inzien.</p>
    </div>

    <h2 class="text-center">Bekijk alle veilingen:</h2>

    <div class="container col-xl-10 col-lg-11 col-md-11 col-sm-11 col-11">
        <div class="legendaButton text-right">
            <button type="button" class="legendaDropdownButton dropdown-toggle" data-toggle="dropdown">Legenda</button>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-item">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kleur en betekenis</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="greenBackground">
                                <td>Veiling is nog actief.</td>
                            </tr>

                            <tr class="redBackground">
                                <td>Veiling is afgelopen.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Verkoper</th>
                        <?php foreach($displayedItems as $key){
                            echo "<th>$key</th>";
                        } ?>
                        <th>Veiling gesloten</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($items as $item):
                    if($item['VeilingGesloten'] == 1) {
                        $label = "redBackground";
                    } else {
                        $label = "greenBackground";
                    }
                    ?>
                    <tr class="<?=$label?>">
                        <td><a href="item.php?id=<?=$item['Voorwerpnummer']?>">Voorwerp <?=$item["Voorwerpnummer"]?></a></td>
                        <td><a href="profile.php?id=<?=$item['Verkoper']?>"><?=$item['Verkoper']?></a></td>
                        <?php foreach($displayedItems as $itemDetail):
                            if(isset($item[$itemDetail])) {
                                echo "<td>" . $item[$itemDetail] . "</td>";
                            } else {
                                echo "<td>-</td>";
                            }
                        endforeach;

                        if(isset($item['VeilingGesloten'])) {
                            if($item['VeilingGesloten']) {
                                $veilingGeslotenTekst = "Ja";
                            } else {
                                $veilingGeslotenTekst = "Nee";
                            }
                        } else {
                            $veilingGeslotenTekst = "Niet bekend.";
                        }

                        echo "<td>".$veilingGeslotenTekst."</td>" ?>
                        <form method="post" onsubmit="return confirm('Weet u zeker dat u deze veiling wilt verwijderen?');">
                            <input type="hidden" name="token" value="<?= $token ?>">
                            <input type="hidden" name="category" value="auction">
                            <td class="verwijderButton">
                                <button type="submit" value="<?=$item['Voorwerpnummer']?>" name="deleteAuction">
                                    <img src="images/adminimages/delete.png" alt="Delete">
                                </button>
                            </td>
                        </form>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>

        </div>
    </div>

    <div class="gaTerugKnopBox text-center">
        <a class="gaTerugKnop" href="admin.php">Ga terug</a>
    </div>
</main>