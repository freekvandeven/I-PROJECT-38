<main class="catalogusPagina">
    <h2 class="text-center col-xl-12 col-md-12 col-12">Aangeboden veilingen</h2>
    <div class="geheleCatalogusPagina row">
        <div class="linkerkant col-2">
            <div class="categorieen">
                <h4 class="font-weight-normal text-center">Prijs</h4>
                <div class="price-slider">
                    <form class="catalogusForm" method="post" onchange="regenerateCatalog()">
                        &euro;<input type="number" value="1" min="1" max="100000000" name="minimum" class="filter"/>
                        tot &euro;<input type="number" value="100000000" min="1" max="100000000" name="maximum" class="filter"/>
                        <input value="1" min="1" max="100000000" step="10" type="range"/>
                        <input value="100000000" min="1" max="100000000" step="10" type="range"/>
                        <svg width="100%" height="12">
                            <line x1="4" y1="0" x2="300" y2="0" stroke="#212121" stroke-width="12" stroke-dasharray="1 28"></line>
                        </svg>
                    </form>
                </div>
                <script>testJava(".price-slider")</script>
            </div>

            <div class="categorieen">
                <h4 class="font-weight-normal text-center">Postcode</h4>
                <label for="postalCode">Zoek op afstand</label>
                <form class="catalogusForm" action="" method="post" onkeyup="regenerateCatalog()">
                    <input class="form-control normalInput" id="postalCode" name="postalCode" type="text"
                           placeholder="Postcode">
                </form>
                <div class="distance-slider">
                    <form class="catalogusForm" method="post" onchange="regenerateCatalog()">
                            <span>Van
                                <input type="number" value="0" min="0" max="800" name="minimumDistance" class="filter"/>km tot
                                <input type="number" value="800" min="0" max="800" name="maximumDistance" class="filter"/>km
                            </span>
                        <input value="0" min="0" max="800" step="1" type="range"/>
                        <input value="800" min="0" max="800" step="1" type="range"/>
                    </form>
                    <svg width="100%" height="12">
                        <line x1="4" y1="0" x2="300" y2="0" stroke="#212121" stroke-width="12"
                              stroke-dasharray="1 28"></line>
                    </svg>
                </div>
                <script>testJava(".distance-slider")</script>
            </div>

            <div class="categorieen">
                <h4 class="font-weight-normal text-center">Categorieën</h4>
                <ul class="list-unstyled">
                    <li>
                        <p>Geselecteerde Categorie:</p>
                        <form class="catalogusForm" action="" method="post">
                            <p id="categoryFilterName"><?= $categoryNames[$_GET['rubriek']] ?></p>
                            <input class="form-control" id="categoryFilter" type="hidden" name="rubriek"
                                   value="<?= $_GET['rubriek'] ?>" readonly>
                        </form>
                    </li>
                    <li>
                        <p>Zoek op categorieen</p>
                        <form class="categorySearchForm" action="" method="post">
                            <input type="hidden" name="token" value="<?= $token ?>">
                            <input class="form-control normalInput" id="zoekcategory" type="text" placeholder="Zoek op categorieën"
                                   name="search" autocomplete="off" onkeyup="showCategory(this.value)">
                        </form>
                    </li>
                    <li>
                        <ul id="searchResult">
                        </ul>
                    </li>

                    <script type="text/javascript">
                        $("#searchResult").bind("click", function (e) {
                            //$(e.target).closest("li").toggleClass("highlight");
                            $("#categoryFilterName").text($(e.target).text());
                            $("#categoryFilter").val($(e.target).attr('class'));
                            //$("#selectedCategories").append("<li>" + $(event.target).text() + "<li/>");
                            showCategory("");
                            regenerateCatalog();
                        });
                        $("#categoryFilterName").bind("click", function (e) {
                            $("#categoryFilter").val('');
                            $("#categoryFilterName").text("");
                            regenerateCatalog();
                        });
                    </script>
                </ul>
            </div>
        </div>

        <div class="container col-md-8 offset-md-0 col-10 offset-1">
            <form class="catalogusForm" action="catalogus.php" method="post" onkeyup="regenerateCatalog()"
                  onchange="regenerateCatalog()">
                <input type="hidden" name="token" value="<?= $token ?>">
                <div class="form-group text-center">
                    <label for="zoekbalk">Zoeken</label>
                </div>

                <div class="row">
                    <div class="form-group col-12">
                        <input class="form-control" id="zoekbalk" type="text" placeholder="Zoek in Catalogus" name="search">
                    </div>
                </div> <!-- einde row -->

                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-4">
                        <label for="price">Volgorde</label>
                        <select class="custom-select" id="price" name="order">
                            <option value="">Kies Volgorde</option>
                            <option <?php if ($_POST['order'] == "High") echo "selected " ?>value="High">Duurste
                                Eerst
                            </option>
                            <option <?php if ($_POST['order'] == "Low") echo "selected " ?>value="Low">Goedkoopste
                                Eerst
                            </option>
                            <option <?php if ($_POST['order'] == "New") echo "selected " ?>value="New">Nieuwste
                                Eerst
                            </option>
                            <option <?php if ($_POST['order'] == "Old") echo "selected " ?>value="Old">Oudste Eerst
                            </option>
                            <option <?php if ($_POST['order'] == "Dis") echo "selected" ?> value="Dis">
                                Dichtstbijzijnde Eerst
                            </option>
                        </select>
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-4">
                        <label for="numberOfItems">Aantal</label>
                        <select class="custom-select" id="numberOfItems" name="numberOfItems">
                            <option <?php if ($_POST['numberOfItems'] == 24) echo "selected " ?>value=24>24</option>
                            <option <?php if ($_POST['numberOfItems'] == 48) echo "selected " ?>value=48>48</option>
                            <option <?php if ($_POST['numberOfItems'] == 96) echo "selected " ?>value=96>96
                            </option>
                            <option <?php if ($_POST['numberOfItems'] == 100) echo "selected " ?>value=10000>TEST
                            </option>
                        </select>
                    </div>
                </div> <!-- einde row -->
            </form>


            <?php
            $items = selectFromCatalog(evalSelectPOST()); ?>
            <div class="productsList" id="productsList">
                <?php generateCatalog($items);
                $timerDates = array_column($items, 'LooptijdEindeTijdstip');
                for ($i = 0; $i < count($timerDates); $i++) {
                    $timerDates[$i] = explode(".", $timerDates[$i])[0];
                }
                ?>

                <script type="text/javascript">
                    var timerDates = <?php echo json_encode($timerDates); ?>;
                    initializeCountdownDates(timerDates);
                    if (!countdown) { // if countdown hasn't been started
                        setupCountdownTimers();
                    }
                </script>
            </div>
        </div>
    </div>
</main>

<script type="text/javascript">
    function regenerateCatalog() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("productsList").innerHTML = this.responseText;

                // evaluate the javascript returned inside the ajax response
                $("#productsList").find("script").each(function () {
                    eval($(this).text());
                });
            }
        };
        xmlhttp.open("POST", "ajax.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = $('.catalogusForm').serialize();
        xmlhttp.send(data.concat('&request=getCatalogus'));
    }
</script>
