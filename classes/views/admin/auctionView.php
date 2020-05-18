<?php
$items = Items::getItems();
$displayedItems = array("Titel", "Startprijs", "Betalingswijze", "Betalingsinstructie", "Plaatsnaam", "Land", "Looptijd", "VeilingGesloten");
?>
<main class="adminPaginaSub">
    <div class="jumbotron">
        <h2 class="display-5">Welkom op de veilingenpagina</h2>
        <p>Op deze pagina kunt u alle veilingen inzien.</p>
    </div>
    <div class="container col-xl-10 col-lg-11 col-md-11 col-sm-11 col-11">
        <h2 class="text-center">Bekijk alle veilingen:</h2>
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
                        <tr class="table-success">
                            <td>Veiling is nog niet afgelopen.</td>
                        </tr>

                        <tr class="table-danger">
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
                        <th scope="col">Item</th>
                        <th>Verkoper</th>
                        <?php foreach($displayedItems as $key){
                            echo "<th>$key</th>";
                        } ?>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($items as $item):
                    if($item['VeilingGesloten'] == "Wel ") {
                        $label = "table-danger";
                    } else {
                        $label = "table-success";
                    }
                    ?>
                    <tr class="<?=$label?>">
                        <td><a href="item.php?id=<?=$item['Voorwerpnummer']?>">Voorwerp <?=$item["Voorwerpnummer"]?></a></td>
                        <td><a href="profile.php?id=<?=$item['Verkoper']?>"><?=$item['Verkoper']?></a></td>
                        <?php foreach($displayedItems as $itemDetail): ?>
                            <td><?=$item[$itemDetail]?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center col-lg-12">
        <p class="gaTerugKnop"><a href="admin.php">Ga terug</a></p>
    </div>
</main>