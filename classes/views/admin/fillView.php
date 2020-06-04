<main class="adminPaginaSub">
    <div class="jumbotron">
        <h2 class="display-5">Welkom master op de Adminpagina</h2>
        <p>Op deze pagina heeft u een aantal opties waar alleen u toegang tot heeft.</p>
    </div>
    <div class="container">
        <h3>Vul de database met een csv bestand:</h3>
        <h3>Let op : laat dit tablad open staan terwijl de database gevuld wordt.</h3>
        <div class="progress">
            <div id="loader" style="display:none;"></div>
            <div class="progress-bar progress-bar-striped progress-bar-animated" id="fillProgress" role="progressbar"
                 aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                0%
            </div>
        </div>
        <div class="text-center">
            <button class="voegRubriekToeButton form-control col-xl-2 offset-xl-5" id="databaseFillButton"
                    onclick="startDatabaseFill()">Start Filling
            </button>
            <div id="outputField"></div>
        </div>
    </div>
    <div class="container">
        <h3>Indexeer de database</h3>
        <h3>Let op : laat dit tablad open staan terwijl de database geindexeerd wordt.</h3>
        <div class="text-center">
            <button class="voegRubriekToeButton form-control col-xl-2 offset-xl-5" id="databaseIndexButton"
                    onclick="startDatabaseIndex()">Start Indexing
            </button>
            <div id="outputField2"></div>
        </div>
    </div>
    <div class="gaTerugKnopBox text-center">
        <button class="gaTerugKnop" href="admin.php">Ga terug</button>
    </div>
    <script type="text/javascript">
        indexStarted = false;

        function startDatabaseIndex() {
            if (!indexStarted) { // if the fill hasn't started yet
                if (confirm("Are you sure you want to index the database?(This could take atleast 15 minutes)")) {
                    indexStarted = true;
                    document.getElementById("databaseIndexButton").innerText = "Abort!";
                    sendAjaxIndex();
                }
            } else { // abort the filling
                indexAjax.abort();
                document.getElementById("databaseIndexButton").innerText = "Start Indexing!";
                indexStarted = false;
            }
        }

        function sendAjaxIndex() {
            indexAjax = new XMLHttpRequest();
            indexAjax.onreadystatechange = function () {
                if (this.status == 500) {
                    sendAjaxIndex();
                } else if (this.status == 200) {
                    if (this.responseText.includes("finished")) {
                        document.getElementById("outputField2").innerHTML = "Finished!";
                        indexAjax.abort();
                    }else{
                        sendAjaxIndex();
                    }
                }
            };
            indexAjax.open("POST", "ajax.php", true);
            indexAjax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            indexAjax.send('request=indexCatalogus');
        }
    </script>
</main>