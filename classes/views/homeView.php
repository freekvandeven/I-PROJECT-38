<main>
    <!-- Welkom tekst: -->
    <div class="jumbotron">
        <h2 class="display-5">Welkom op EenmaalAndermaal</h2>
        <p class="lead">EenmaalAndermaal is een online veilingsite waar u uw producten kunt aanbieden en kunt bieden op
            andermans producten.</p>
    </div>

    <!-- Slideshow: -->
    <div class="slideshow">
        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
            <!-- De navigatie onderaan: -->
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
            </ol>

            <!-- De items in de slideshow zelf: -->
            <div class="carousel-inner">
                <div class="carousel-item active" data-interval="5000">
                    <img src="images/foto2.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <a class="sliderLinks" href="#"><h3>Bekijk het aanbod</h3></a>
                        <p>Bied op gebruikte producten en verkoop uw gebruikte producten</p>
                    </div>
                </div>
                <div class="carousel-item" data-interval="5000">
                    <img src="images/foto3.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <a class="sliderLinks" href="#"><h3>Personaliseer</h3></a>
                        <p>Maak een account aan of log in.</p>
                    </div>
                </div>
                <div class="carousel-item" data-interval="5000">
                    <img src="images/foto1.jpg" class="d-block w-100" alt="Veiling">
                    <div class="carousel-caption d-none d-md-block">
                        <a class="sliderLinks" href="#"><h3>Over ons</h3></a>
                        <p>EenmaalAndermaal wil het beste voor haar gebruikers.</p>
                    </div>
                </div>
            </div>

            <!-- De navigatiepijltjes: -->
            <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div> <!-- Einde slideshow -->

    <!-- De snelst aflopende producten -->
    <div class="productsList">
        <h3>Bekijk hier de de meest trending producten:</h3>
        <?php
        $items = selectFromCatalog(array(":order" => "(10-DATEDIFF(day, getdate(),LooptijdEindeDag))*Views DESC", ":limit" => "8")); // orders by hotness score (10 - days left) * page views  = score,
        generateCatalog($items);
        ?>
        <script>
            var my_date;
            <?php
            $i = 0;
            foreach($items as $item){
            $datum = $item['LooptijdEindeDag'];
            $tijdstip = $item['LooptijdEindeTijdstip'];
            $time = explode(" ", $datum)[0] . " " . explode(" ", $tijdstip)[1];
            echo "my_date = '" . explode(".", $time)[0] . "';\n";
            ?>
            my_date = my_date.replace(/-/g, "/");
            setupCountDown('timer-<?=$i?>', new Date(my_date));
            <?php
            $i++;
            }
            ?>
        </script>
    </div>
</main>
