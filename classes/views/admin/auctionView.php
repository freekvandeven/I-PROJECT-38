<?php
$items = Items::getItems();
$displayedItems = array("Titel", "Startprijs", "Betalingswijze", "Betalingsinstructie", "Plaatsnaam", "Land", "Looptijd", "VeilingGesloten");
?>
<main class="adminPagina">
    <div class="jumbotron">
        <h2 class="display-5">Welkom master op de Adminpagina</h2>
        <p>Op deze pagina heeft u een aantal opties waar alleen u toegang tot heeft.</p>
    </div>
    <h2 class="text-center">Bekijk alle  veilingen:</h2>
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
                if($item['VeilingGesloten'] == "Wel "){
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

    <div class="form-group text-center col-lg-12">
        <p class="gaTerugKnop" style="margin-bottom: 60px;"><a href="admin.php">Ga terug</a></p>
    </div>
</main>