<?php
if(isset($_SESSION['loggedin'])){
    $loginstatus = 'Profile';
    $loginlink = 'profile.php';
} else {
    $loginstatus = 'Login';
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="shortcut icon" type="image/x-icon" href="images/icon.svg" id="favicon"/>
    <script src="js/script.js"></script>
    <script src="js/range.js"></script>
    <title><?=$title?></title>
    <!-- bootstrap scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


    <!-- jquerry to make bootstrap dropdown a clickable link-->
    <script>
        jQuery(function($) {
            $('.dropdown > a').click(function(){
                location.href = this.href;
            });
        });
    </script>
    <!-- favicon notifaction function-->
    <script>
        var icon = 'images/icon.svg';
        var iconNotifcation = 'images/notification.svg';
        var notified =false;
        changeFavicon();
        function changeFavicon() {
            if(notified == false){
                document.getElementById('favicon').href = iconNotifcation;
                notified = !notified;
            }else{
                document.getElementById('favicon').href = icon;
                notified = !notified;
            }
        }
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="index.php">EenmaalAndermaal</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="catalogus.php">Veilingen</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" id="navbarDropdown" href=<?=$loginlink?> data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?=$loginstatus?>
                    </a>
                    <?php if($loginstatus!='Login') :?> <!-- conditional logout only if logged in -->
                    <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                        <a class='dropdown-item' href='logout.php'>Logout</a>
                    </div>
                    <?php endif;?>
                </li>
                <?php
                if(isset($_SESSION['admin']) && $_SESSION['admin']): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="admin.php">Admin</a>
                </li>
                <?php endif;?>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
            </ul>
            <form class="navbarForm form-inline my-2 my-lg-0" action="catalogus.php" method="post">
                <input type="hidden" name="token" value="<?=$token?>">
                <input class="zoekBalk form-control mr-sm-2" type="search" placeholder="Zoeken" aria-label="Search" name="search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Zoeken</button>
            </form>
        </div>
    </nav>

