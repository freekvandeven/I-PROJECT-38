<main class="notificatiesPagina">
    <div class="jumbotron">
        <h2 class="display-5">Uw notificaties</h2>
        <p>Op deze pagina kunt u uw notificaties zien.</p>
    </div>

    <div class="container">
        <?php if (isset($err)) { ?>
            <div class="errorMessage">
                <span><?=$err?></span>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-xl-3 col-md-4 col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title text-center">Alle notifications</div>
                        <div class="notificaties list-group">
                            <?php $notifications = User::getNotifications($_SESSION['name']);
                            echo displayInformation($notifications, 1); ?> <!-- Als de lijst met users moet worden geprint, wordt er een 1 mee gestuurd. -->
                        </div>

                        <?php if(!sizeof($notifications) == 0) { ?>
                        <form method="post" action="" class="text-center">
                            <input type="hidden" name="token" value="<?= $token ?>">
                            <input type="hidden" name="action" value="notifications">
                            <button class="verwijderNotificatiesButton" type="submit" name="option" value="clear">Verwijder notificaties</button>
                        </form> <?php } ?>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-4 col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title text-center">Selecteer gebruiker</div>
                        <form class="gebruikerSelecterenForm" method="get" action="">
                            <input type="hidden" name="action" value="notifications">
                            <div class="card-text">Verkopers</div>
                            <div class="list-group">
                                <?= displayInformation(Buyer::getBoughtFrom($_SESSION['name']), 0); ?>
                            </div>
                            <div class="card-text">Kopers</div>
                            <div class="list-group">
                                <?= displayInformation(Seller::getSoldTo($_SESSION['name']), 0); ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-md-8 col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <?php if(isset($_GET['user'])):?>
                            <div class="card-title text-center">Chat met <?=$_GET['user']?></div>
                            <form onsubmit="sendChatMessage('<?=$_GET['user']?>');this.reset();return false" class="berichtForm">
                                <textarea type="text" name="chat" id="chatMessage" placeholder="Type your message"></textarea>
                                <input type="submit" value="Verstuur">
                            </form>
                            <div class="card-text" id="chatWindow"></div>
                            <script>startChat('<?=$_GET['user']?>');</script>
                        <?php else: ?>
                            <div class="card-title text-center">Chat met gebruiker</div>
                            <div class="card-text">Selecteer een gebruiker om mee te chatten.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>