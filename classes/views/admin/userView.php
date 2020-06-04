<?php
    $users = User::getUsersLimit(100, $_GET['search']);
    $displayedItems = array("Voornaam", "Achternaam", "Adresregel_1", "Postcode", "Land", "Mailbox");
?>

<main class="adminPaginaSub">
    <div class="jumbotron">
        <h2 class="display-5">Welkom op de gebruikerspagina</h2>
        <p>Op deze pagina kunt u alle gebruikers inzien.</p>
    </div>

    <div class="container col-xl-10 col-lg-11 col-md-11 col-sm-11 col-11">
        <h2 class="text-center">Bekijk alle  gebruikers:</h2>
        <form class="categorySearchForm" action="" method="get">
            <input type="hidden" name="category" value="user">
            <input class="form-control" id="zoekcategory" type="text" placeholder="Zoek op gebruikersnaam" value="<?=$_GET['search']?>"
                   name="search" autocomplete="off">
        </form>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Gebruikersnaam</th>
                        <?php foreach($displayedItems as $key){
                            echo "<th>$key</th>";
                        } ?>
                    </tr>
                </thead>
                <tbody>
                <?php
                $teller = 0;
                foreach($users as $user):
                    if($teller % 2 == 0) $tableClass = "lightBackground";
                    else $tableClass = "darkBackground";
                    ?>
                    <tr class="<?=$tableClass?>">
                        <td><a href="profile.php?id=<?=$user['Gebruikersnaam']?>"><?=$user["Gebruikersnaam"]?></a></td>
                        <?php

                        foreach($displayedItems as $userDetail):
                            echo "<td>".$user[$userDetail]."</td>";
                        endforeach;
                        $teller++; ?>
                        <form method="POST" onsubmit="return confirm('Weet u zeker dat u deze gebruiker wilt verwijderen?');">
                            <input type="hidden" name="token" value="<?= $token ?>">
                            <input type="hidden" name="category" value="user">
                            <td class="verwijderButton">
                                <button type="submit" value="<?=$user['Gebruikersnaam']?>" name="deleteUser">
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
        <button class="gaTerugKnop" href="admin.php">Ga terug</button>
    </div>
</main>