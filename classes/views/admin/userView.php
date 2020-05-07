<?php
    $users = User::getUsers();
    $displayedItems = array("Voornaam", "Achternaam", "Adresregel_1", "Postcode", "Land", "Mailbox");
?>
<main class="adminPagina">
    <div class="jumbotron">
        <h2 class="display-5">Welkom master op de Adminpagina</h2>
        <p>Op deze pagina heeft u een aantal opties waar alleen u toegang tot heeft.</p>
    </div>
    <h2 class="text-center">Bekijk alle  gebruikers:</h2>
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

    <div class="form-group text-center col-lg-12">
        <p class="gaTerugKnop" style="margin-bottom: 60px;"><a href="admin.php">Ga terug</a></p>
    </div>
</main>