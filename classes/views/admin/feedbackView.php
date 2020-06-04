<?php
$allFeedback = Admin::getWebsiteFeedback($_GET['search']);
$displayedItems = array("Voornaam", "Achternaam", "Commentaar", "Datum");
?>
<main class="adminPaginaSub">
    <div class="jumbotron">
        <h2 class="display-5">Welkom op de feedbackpagina</h2>
        <p>Op deze pagina kunt u alle feedback inzien.</p>
    </div>

    <h2 class="text-center">Bekijk alle feedback:</h2>

    <div class="container col-xl-10 col-lg-11 col-md-11 col-sm-11 col-11">
        <form class="categorySearchForm" action="" method="get">
            <input type="hidden" name="category" value="feedback">
            <input class="form-control" id="zoekcategory" type="text" placeholder="Zoek op feedback"
                   value="<?= $_GET['search'] ?>"
                   name="search" autocomplete="off">
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Email</th>
                    <?php foreach ($displayedItems as $key) echo "<th>$key</th>"; ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($allFeedback as $feedback): ?>
                    <tr class="greenBackground">
                        <?php
                        $feedback["Datum"] = explode(".", $feedback["Datum"])[0];
                        echo "<td><a href='mailto:" . $feedback['Mailbox'] . "'>" . $feedback['Mailbox'] . "</a></td>";
                        foreach ($displayedItems as $itemDetail):
                            echo (isset($feedback[$itemDetail])) ? "<td>" . $feedback[$itemDetail] . "</td>" : "<td>-</td>";
                        endforeach;
                        ?>

                        <form method="post"
                              onsubmit="return confirm('Weet u zeker dat u deze feedback wilt verwijderen?');">
                            <input type="hidden" name="token" value="<?= $token ?>">
                            <input type="hidden" name="category" value="feedback">
                            <input type="hidden" name="email" value="<?= $feedback['Mailbox'] ?>">
                            <td class="verwijderButton">
                                <button type="submit" value="<?= $feedback['Commentaar'] ?>" name="deleteFeedback">
                                    <img src="images/adminimages/delete.png" alt="Delete">
                                </button>
                            </td>
                        </form>

                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>

    <div class="gaTerugKnopBox text-center">
        <button class="gaTerugKnop" href="admin.php">Ga terug</button>
    </div>
</main>
