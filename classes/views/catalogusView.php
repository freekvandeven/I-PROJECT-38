<main>
    <div class="productsList">
        <h3>Bekijk hier alle producten</h3>
        <div  class="filtermenu">
            <!-- select eerste 25/50/100 frontend name = aantalItems return post -->
            <!-- select rubriek, zoekwoord minder prioriteit dan bovenste-->
        </div>
        <?php
        if(isset($_POST['aantalItems'])) $aantalItems = $_POST['aantalItems'];
        else $aantalItems = "25";
        $items = selectFromCatalog(array(":limit"=>$aantalItems)); // select 8 products from catalog
        $counter =0;
        foreach($items as $card):
            if($counter==0){
                echo "<div class='row'>";
            }
            ?>
            <div class='col-lg-3'>
                <div class='card'>
                    <a href='item.php?id=<?=$card['Voorwerpnummer']?>'>
                        <img src='upload/items/<?=$card['Voorwerpnummer']?>.png' class='card-img-top' alt='Productnaam'>
                    </a>
                    <div class='card-body'>
                        <h5 class='card-title'><?=$card['Titel']?></h5>
                        <p class='card-text'><?=$card['Beschrijving']?></p>
                        <a href='item.php?id=<?=$card['Voorwerpnummer']?>' class='card-link'>Meer informatie</a>
                    </div>
                    <div class='card-footer'>
                        <small class='text-muted'>Nog: 4min beschikbaar.</small>
                    </div>
                </div>
            </div>
            <?php
            $counter++;
            if ($counter>3) {
                echo "</div>";
                $counter = 0;
            }
        endforeach;
        ?>
    </div>
</main>