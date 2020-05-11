<?php
$sellers = Seller::getSellers();
$displayedItems = array("Bank", "Bankrekening", "ControleOptie", "Creditcard");
?>
<main class="adminPaginaSub">
    <div class="jumbotron">
        <h2 class="display-5">Welkom op de verkoperspagina</h2>
        <p>Op deze pagina kunt u alle verkopers inzien.</p>
    </div>
    <div class="container col-xl-10 col-lg-11 col-md-11 col-sm-11 col-11">
        <h2 class="text-center">Bekijk alle verkopers:</h2>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">Gebruikersnaam</th>
                    <?php foreach($displayedItems as $key){
                        echo "<th>$key</th>";
                    } ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach($sellers as $seller): ?>
                    <tr>
                        <td><a href="profile.php?id=<?=$seller['Gebruiker']?>"><?=$seller["Gebruiker"]?></a></td>
                        <?php foreach($displayedItems as $sellerDetail): ?>
                            <td><?=$seller[$sellerDetail]?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="form-group text-center col-lg-12">
        <p class="gaTerugKnop"><a href="admin.php">Ga terug</a></p>
    </div>
</main>