<?php
if (isset($_SESSION['loggedin'])) {
    $loginstatus = 'Profiel';
    $loggedin = true;
    $loginlink = 'profile.php';
} else {
    $loginstatus = 'Login';
    $loggedin = false;
    $loginlink = 'login.php';
}

$categories = generateCategoryArray();
$categoryNumbers = $categories[0];
$categoryNames = $categories[1];

function compareArrays($a, $b)
{
    if(count($a) == count($b)){
        return 0;
    }
    return (count($a) > count($b)) ? -1 : 1;
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.5/lib/darkmode-js.min.js"></script>
    <!-- custom stylesheet -->
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-jvectormap-2.0.5.css">
    <link rel="shortcut icon" type="image/x-icon" href="images/icon.svg" id="favicon"/>
    <script src="js/script.js"></script>
    <script src="js/range.js"></script>
    <script src="js/zoomImage.js"></script>
    <script src="js/darkMode.js"></script>
    <script src="js/jquery-jvectormap-2.0.5.min.js"></script>
    <script src="js/jquery-jvectormap-nl-mill.js"></script>
    <script src="js/jquery-jvectormap-europe-mill.js"></script>
    <script src="js/jquery-jvectormap-world-mill.js"></script>

    <title><?= $title ?></title>

    <!-- jquerry to make bootstrap dropdown a clickable link-->
    <script>
        jQuery(function ($) {
            $('.dropdown > a').click(function () {
                location.href = this.href;
            });
        });
        $(document).ready(function() {
             darkmode = new Darkmode(options);
            if(darkmode.isActivated()!=<?=json_encode(User::getSettings($_SESSION['name'])['darkmode'])?>){
                darkmode.toggle();
            }
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
                <!-- Example split danger button -->
                <div class="btn-group" onmouseleave="openMainCategory(event, 'leeg')">
                    <a class="catalogus catalogusButton" href="catalogus.php" role="button">Catalogus</a>
                    <button type="button" class="catalogus pijltje dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="categorieenlijst dropdown-menu">
                        <div class="tab">
                            <?php foreach ($categoryNumbers as $key => $value): ?>
                                <a class="categoryLink dropdown-item" href="catalogus.php?rubriek=<?= $key ?>"
                                   onmouseover="openMainCategory(event, '<?= $key ?>')"><?= $categoryNames[$key] ?></a>
                            <?php endforeach; ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <?php
                    foreach ($categoryNumbers as $mainCategory => $subCategories):
                    //uksort($subCategories, function ($a, $b){ return count($b) - count($a);});
                    //usort($subCategories, build_sorter($mainCategory));
                    uasort($subCategories, "compareArrays");
                    //var_dump($subCategories)
                    //array_multisort(array_map('count', $subCategories), SORT_DESC, $subCategories);
                    ?>
                    <div class="tabcontent" id="<?= $mainCategory ?>">
                        <?php $index = 0;
                        foreach ($subCategories as $subCategory => $subsubCategories):
                        if ($index == 0):?>
                        <div class="subtabcontentRow row"> <?php endif;
                            if ($index == 5):?>
                            <div class="subtabcontent subtabcontentNoBorder col-xl-2 col-lg-4"> <?php
                                else:?>
                                <div class="subtabcontent col-xl-2 col-lg-4"> <?php endif; ?>
                                    <a href="catalogus.php?rubriek=<?=$subCategory?>"><h5><?= $categoryNames[$subCategory] ?></h5></a>
                                    <ul>
                                        <?php foreach ($subsubCategories as $subsubCategory => $subsubsubCategories): ?>
                                            <li class="subsubcategories"><a href="catalogus.php?rubriek=<?=$subsubCategory?>"><?= $categoryNames[$subsubCategory] ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <?php
                                $index++;
                                if ($index >= 6) {
                                    echo '</div>';
                                    $index = 0;
                                }
                                endforeach;
                                if($index != 0) echo '</div>';
                                ?>
                    </div>
                    <?php endforeach;?>
                </div>
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
                <input class="zoekBalk form-control mr-md-2" type="search" placeholder="Zoeken op veilingen"
                       aria-label="Search"
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
                <a class="dropdown-item" href="profile.php?action=notifications">Notificaties <span
                            id="notificationsDropdown" class="badge badge-danger">4</span></a>
                <a class="dropdown-item" href="profile.php?action=item">Mijn Veilingen <span id="veilingenDropdown" class="badge badge-info"><?=User::getAuctions($_SESSION['name'])?></span></a>
                <a class="dropdown-item" href="profile.php?action=favorite">Mijn Favorieten <span id="favoriteDropdown" class="badge badge-info"><?=User::getFavorites($_SESSION['name'])?></span></a>
                <a class="dropdown-item" href="addProduct.php">Verkoop product</a>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="darkmodeValue" onchange="toggleDarkmodeSetting()"
                           name="darkmodeValue" <?php if (User::getSettings($_SESSION['name'])['darkmode']) echo "checked"; ?>>
                    <label class="custom-control-label" for="darkmodeValue">Darkmode</label>
                </div>
                <a class="dropdown-item" href="logout.php">Log Out</a>
            <?php else: ?>
                <a class="dropdown-item" href="login.php">Login</a>
                <a class="dropdown-item" href="register.php">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

