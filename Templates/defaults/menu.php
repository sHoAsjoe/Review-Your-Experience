<?php
$url = $_SERVER['REQUEST_URI'];
$params = explode("/", $url);
$section = $params[1];

$roleMessage = "<a class='nav-link text-white' href='/login'>Inloggen</a>";
$homeAc = "";
$filmAc = "";
$serieAc = "";
$contactAc = "";
$categoryAc = "";
$logAc = "";

if ($section == 'category') {
    $categoryAc = "active";
} elseif ($section == 'movies') {
    $filmAc = "active";
} elseif ($section == 'films') {
    $filmAc = "active";
} elseif ($section == 'serie') {
    $serieAc = "active";
} elseif ($section == 'series') {
    $serieAc = "active";
} elseif ($section == 'contact') {
    $contactAc = "active";
} elseif ($section == 'login') {
    $logAc = "active";
}
elseif ($section == 'register') {
    $logAc = "active";
}
elseif ($section == 'member') {
    $logAc = "active";
}
elseif ($section == 'admin') {
    $logAc = "active";
}
else {
    $homeAc = "active";
}

$memberRole = isMember();
$adminRole = isAdmin();

if ($memberRole) {
    $roleMessage = "<div class='dropdown'>
  <button class='btn text-white dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false' style='margin-top: 1px;'>
    Mijn Account
  </button>
  <ul class='dropdown-menu'>
    <li><a class='dropdown-item' href='/member/edit'>Profiel Aanpassen</a></li>
    <li><a class='dropdown-item' href='/logout'>Uitloggen</a></li>
  </ul>
</div>";
//    $roleMessage = $_SESSION['user']['first_name'];
}
if ($adminRole) {
    $roleMessage = "<div class='dropdown'>
  <button class='btn text-white dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false' style='margin-top: 1px;'>
    Admin Account
  </button>
  <ul class='dropdown-menu'>
    <li><a class='dropdown-item' href='/admin/panel'>Admin Panel</a></li>
     <li><a class='dropdown-item' href='/admin/edit'>Profiel Aanpassen</a></li>
    <li><a class='dropdown-item' href='/logout'>Uitloggen</a></li>
  </ul>";
  }
function displayCategories() {
    global $db;
    $query = $db->prepare("SELECT id, name FROM categorie");
    $query->execute();
    $category = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($category as $data) {
        echo "<li><a class='dropdown-item' href='/category/{$data['id']}'>{$data['name']}</a></li>";
    }

    if (isset($_GET['searchBtn'])) {
        $userInput = $_GET['search'];
        if (empty($userInput) || $userInput == " ") {
            echo "<script>document.querySelector('.trigger-modal').click();</script>";
        } else {
            session_start();
            $_SESSION['search'] = $userInput;
            echo "<script>document.querySelector('.click').click();</script>";
        }

    }
}
?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Ingrid+Darling&family=Open+Sans:wght@700&display=swap');

    .c-font {
        color: #F18F01;
        font-family: 'Ingrid Darling', cursive;
        font-size: 45px;
    }
</style>
<div class='modal fade' id="modal404" tabindex='-1'>
    <div class='modal-dialog modal-dialog-centered'>
        <div class='modal-content bg-dark'>
            <div class='modal-header'>
                <h5 class='modal-title'>#error401 | Ongeldige Input</h5>
                <button type='button' class='btn-close bg-warning' data-bs-dismiss='modal' aria-label='Close'></button>
            </div>
            <div class='modal-body'>
                <p>Voer een geldige input</p>
                <p class="fs-6">Bijvoorbeeld:</p>
                <ul>
                    <li>Als je Burning Betrayel wil kijken. Je hoeft alleen de keywords in te typen bijvoorbeeld: Betrayel of Burning.</li><br>
                    <li>Als je een film of serie niet vind betekent dat het niet bestaat of dat de naam/keywoord niet goed is ingevoerd.</li>
                </ul>
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Sluiten</button>
                <button type='button' class='btn btn-warning' data-bs-dismiss='modal'>Capiche?</button>
            </div>
        </div>
    </div>
</div>
<a class="click" href="/search" hidden></a>
<button type="button" class="btn btn-primary trigger-modal" data-bs-toggle="modal" data-bs-target="#modal404"
        hidden></button>
<nav class="navbar navbar-expand-md bg-nav" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="/home">
            <img src="/img/logo_project-review.png" alt="Logo" height="100px" class="d-block m-0 p-0">
        </a>
        <button class="navbar-toggler d-lg-none border border-2 border-white" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
            aria-label="Toggle navigation">
            <div class="navbar-toggler-custom-icon">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </div>
        </button>
        <span class="c-font d-none d-md-block">MovieStatic</span>
        <div class="collapse navbar-collapse flex-md-row-reverse" id="collapsibleNavId">
            <form method="get" class="d-flex" role="search">
                <input class="form-control ms-2 me-2 bg-dark text-white border border-warning" type="search" placeholder="Zoeken" aria-label="Search" name="search">
                <button class="btn btn-outline-warning" type="submit" name="searchBtn"><i class="bi bi-search"></i></button>
            </form>
            <menu class="text-center text-md-start p-0">
                <ul class='navbar-nav nav'>
                    <li class='nav-item <?=$homeAc?>'>
                        <a class='nav-link text-white' href='/home'>Home</a>
                    </li>
                    <li class='nav-item <?=$filmAc?>'>
                        <a class='nav-link text-white' href='/films'>Films</a>
                    </li>
                    <li class='nav-item <?=$serieAc?>'>
                        <a class='nav-link text-white' href='/serie'>Series</a>
                    </li>
                    <li class='nav-item <?=$contactAc?>'>
                        <a class='nav-link text-white' href='/contact'>Contact</a>
                    </li>
                    <li class='nav-item dropdown <?=$categoryAc?>' style='margin-top: 1px;'>
                        <button class='btn text-white dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'>
                            Categorie&euml;n
                        </button>
                        <ul class='dropdown-menu dropdown-menu-dark'>
                            <?=displayCategories()?>
                        </ul>
                    </li>
                    <li class='nav-item <?=$logAc?>'>
                        <?=$roleMessage?>
                    </li>
                </ul>
            </menu>
        </div>
    </div>
</nav>
