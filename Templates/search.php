<?php
if (isset($_SESSION['search'])) {
    global $db;
    $search = $_SESSION['search'];
    $searchMovieQuery = $db->prepare("SELECT * FROM film WHERE name LIKE '%$search%'");
    $searchMovieQuery->execute();
    $resultMovie = $searchMovieQuery->fetchAll(PDO::FETCH_ASSOC);

    $searchSerieQuery = $db->prepare("SELECT * FROM series WHERE name LIKE '%$search%'");
    $searchSerieQuery->execute();
    $resultSerie = $searchSerieQuery->fetchAll(PDO::FETCH_ASSOC);

    function displaySearch()
    {
        global $resultMovie, $resultSerie;
        if ($resultMovie) {
            foreach ($resultMovie as $data) {
                echo "<div class='col-md-3 col-12 col-sm-6 mt-4 mt-md-0 d-flex d-md-block justify-content-center justify-content-md-start'>
                    <div class='card' style='width: 18rem;'>
                  <img src='{$data['image']}' class='card-img-top' alt='...'>
                  <div class='card-body bg-dark'>
                    <h4 class='card-title'><b>{$data['name']}</b></h4>
                    <p style='font-size: 11px'>{$data['summary']}<br><br>{$data['date']} | <span class='text-warning'>{$data['genre']}</span></p>
                    <a href='../{$data['type']}/{$data['id']}' class='btn btn-warning text-white'>Watch now</a>
                    </div>
                    </div>
                    </div>";
            }
        }
        if ($resultSerie) {
            foreach ($resultSerie as $data) {
                echo "<div class='col-md-3 col-12 col-sm-6 mt-4 mt-md-0 d-flex d-md-block justify-content-center justify-content-md-start'>
                    <div class='card' style='width: 18rem;'>
                  <img src='{$data['image']}' class='card-img-top' alt='...'>
                  <div class='card-body bg-dark'>
                    <h4 class='card-title'><b>{$data['name']}</b></h4>
                    <p style='font-size: 11px'>{$data['summary']}<br><br>{$data['date']} | <span class='text-warning'>{$data['genre']}</span></p>
                    <a href='../{$data['type']}/{$data['id']}#ep' class='btn btn-warning text-white'>Watch now</a>
                    </div>
                    </div>
                    </div>";
            }
        }
        if (!$resultMovie && !$resultSerie) {
            echo "<p class='fs-6'>Geen resultaat gevonden</p>";
        }
    }
}
?>

<!doctype html>
<html>
<?php
include_once('defaults/head.php');
?>
<?php
include_once ('defaults/header.php');
include_once ('defaults/menu.php');
include_once ('defaults/pictures.php');
?>
<body>
<div class="container-fluid p-3">
    <h2 class="text-white text-center">Opzoek naar: <span class="text-warning"><?=$search?></span></h2>
    <div class="row">
    <?=displaySearch()?>
    </div>
</div>
</body>
<?php
include_once ('defaults/footer.php');
?>
</html>
