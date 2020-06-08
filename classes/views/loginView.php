<main class="loginPagina">
    <div id="login">
        <div class="container">
            <?php if (isset($_GET['succes'])) { ?>
                <div class="succesMessage">
                    <span><?=$_GET['succes']?></span>
                </div>
            <?php } ?>
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="loginForm" action="" method="post">
                            <!-- Titel -->
                            <h2 class="text-center">Inloggen</h2>
                            <?php if(isset($err))echo $err;?>
                            <input type="hidden" name="token" value="<?=$token?>">
                            <!-- Gebruikersnaam -->
                            <div class="form-group" style="margin-top: 25px;">
                                <label for="username">Gebruikersnaam:</label><br>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Uw gebruikersnaam" autofocus required value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES) : ''; ?>">
                            </div>
                            <!-- Wachtwoord -->
                            <div class="form-group">
                                <label for="password">Wachtwoord:</label><br>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Uw wachtwoord" required value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password'], ENT_QUOTES) : ''; ?>">
                            </div>
                            <!-- "Wachtwoord vergeten?" -->
                            <div class="form-group text-left">
                                <a href="forgotPassword.php">Wachtwoord vergeten?</a>
                            </div>
                            <!-- "Nog geen account?" -->
                            <div class="form-group text-left">
                                <a href="register.php">Nog geen account?</a>
                            </div>
                            <!-- Inlog-knop -->
                            <div class="form-group text-center">
                                <button class="inlogButton" type="submit" name="submit" value="login">Inloggen</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
