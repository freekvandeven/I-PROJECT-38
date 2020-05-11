<?php
    $users = User::getUsers();
    $displayedItems = array("Voornaam", "Achternaam", "Adresregel_1", "Postcode", "Land", "Mailbox");
?>
<main class="adminPaginaSub">
    <div class="jumbotron">
        <h2 class="display-5">Welkom op de gebruikerspagina</h2>
        <p>Op deze pagina kunt u alle gebruikers inzien.</p>
    </div>

    <div class="container col-xl-10 col-lg-11 col-md-11 col-sm-11 col-11">
        <h2 class="text-center">Bekijk alle  gebruikers:</h2>
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
                <?php foreach($users as $user): ?>
                    <tr>
                        <td><a href="profile.php?id=<?=$user['Gebruikersnaam']?>"><?=$user["Gebruikersnaam"]?></a></td>
                        <?php foreach($displayedItems as $userDetail): ?>
                            <td><?=$user[$userDetail]?></td>
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