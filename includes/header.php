<?php
if (isset($_SESSION['loggedin'])) {
    $loginstatus = 'Profile';
    $loggedin = true;
    $loginlink = 'profile.php';
} else {
    $loginstatus = 'Login';
    $loggedin = false;
    $loginlink = 'login.php';
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="description"
          content="Dit is de website van EenmaalAndermaal waar producten worden verkocht en gekocht">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- bootstrap scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.5/lib/darkmode-js.min.js"></script>
    <!-- custom stylesheet -->
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="shortcut icon" type="image/x-icon" href="images/icon.svg" id="favicon"/>
    <script src="js/script.js"></script>
    <script src="js/range.js"></script>
    <script src="js/zoomImage.js"></script>
    <script src="js/darkMode.js"></script>
    <title><?=$title?></title>

    <!-- jquerry to make bootstrap dropdown a clickable link-->
    <script>
        jQuery(function ($) {
            $('.dropdown > a').click(function () {
                location.href = this.href;
            });
        });
    </script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="index.php">EenmaalAndermaal</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="catalogus.php">Veilingen</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href=<?= $loginlink ?>>
                    <?= $loginstatus ?>
                </a>
            </li>
            <?php
            if (isset($_SESSION['admin']) && $_SESSION['admin']): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="admin.php">Admin</a>
                </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link" href="contact.php">Contact</a>
            </li>
        </ul>

        <form class="navbarForm form-inline ml-md-5" action="catalogus.php" method="post">
            <input type="hidden" name="token" value="<?= $token ?>">
            <div class="text-center">
                <input class="zoekBalk form-control mr-md-2" type="search" placeholder="Zoeken" aria-label="Search"
                       name="search">
            </div>
            <button class="btn btn-outline-success" type="submit">Zoeken</button>
        </form>
    </div>

    <div class="profielDropdown dropdown">
        <a class="nav-link dropdown-toggle" href="profile.php" id="navbarDropdownMenuLink" role="button"
           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="<?= getProfileImage($_SESSION['name']); ?>" width="30" height="30" class="rounded-circle"
                 alt="profielfoto">
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <?php if ($loggedin): ?>
                <a class="dropdown-item" href="profile.php?action=update">Edit Profiel</a>
                <a class="dropdown-item" id="notificationsDropdown" href="profile.php?action=notifications">Notificaties
                    (2)</a>
                <a class="dropdown-item" href="profile.php?action=item">Mijn Veilingen</a>
                <a class="dropdown-item" href="profile.php?action=favorite">Mijn Favorieten</a>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="darkmodeSettingHeader"
                           name="darkmodeSettingHeader" <?php if ($settings['darkmode']) echo "checked"; ?>>
                    <label class="custom-control-label" for="darkmodeSettingHeader">Darkmode</label>
                </div>
                <a class="item">
                    <div class="ui slider checkbox">
                        <input type="checkbox" name="darkmode" id="darkmode">
                        <label for="darkmode">Darkmode</label>
                    </div>
                </a>
                <a class="dropdown-item" href="logout.php">Log Out</a>
            <?php else: ?>
                <a class="dropdown-item" href="login.php">Login</a>
                <a class="dropdown-item" href="register.php">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

