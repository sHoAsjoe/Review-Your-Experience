<?php
    $url = $_SERVER['REQUEST_URI'];
    $params = explode("/", $url);
    $id = $params[2];
    global $db;
    $query = $db->prepare("SELECT * FROM categories_relation where categorie_id = :category");
    $query->bindParam(':category', $id);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    $query1 = $db->prepare("SELECT * FROM categorie_serie_relationship where categorie_id = :c");
    $query1->bindParam(':c', $id);
    $query1->execute();
    $result1 = $query1->fetchAll(PDO::FETCH_ASSOC);

    $query2 = $db->prepare("SELECT * FROM categorie where id = :categoryname");
    $query2->bindParam(':categoryname', $id);
    $query2->execute();
    $result2 = $query2->fetchAll(PDO::FETCH_CLASS);
    $category = $result2[0]->name;

function displayS($r){
    global $db;
    foreach ($r as $data) {
        $query1 = $db->prepare("SELECT * FROM series where id = :serie");
        $query1->bindParam(':serie', $data['serie_id']);
        $query1->execute();
        $result1 = $query1->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result1 as $d) {
            echo "<div class='swiper-slide'>";
            echo "<a href='../series/{$d['id']}#ep'>";
            echo "<img src='{$d['image']}' alt='Serie'>";
            echo "</a>";
            echo "<p class='text-center fs-5'>{$d['name']}</p>";
            echo "</div>";
        }
    }
}
function displayM($r)
{
    global $db;
    foreach ($r as $data) {
        $query1 = $db->prepare("SELECT * FROM film where id = :movie");
        $query1->bindParam(':movie', $data['film_id']);
        $query1->execute();
        $result1 = $query1->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result1 as $d) {
            echo "<div class='swiper-slide'>";
            echo "<a href='../movies/{$d['id']}#ep'>";
            echo "<img src='{$d['image']}' alt='Movie'>";
            echo "</a>";
            echo "<p class='text-center fs-5'>{$d['name']}</p>";
            echo "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<?php
// Adds the head for the page.
include_once('defaults/head.php');
?>
<?php
//adds the rest of the default files.
include_once('defaults/header.php');
include_once('defaults/menu.php');
include_once('defaults/pictures.php');
?>
<body>
<h1 class="text-center">Alle Movies en Series met genre: <span class="text-warning"><?=$category?></span></h1>
<br><br>

<div class="container-fluid">
<div class="swiper-container">
    <h2 class="position-relative">Movies</h2>
    <div class="swiper-wrapper">
        <?=displayM($result)?>
    </div>
</div>
<br><br><br>
<div class="swiper-container">
    <h2>Series</h2>
    <div class="swiper-wrapper">
        <?=displayS($result1)?>
    </div>
</div>
</div>
<br><br>
    <?php
    include_once('defaults/footer.php');

    ?>

<script type="application/javascript" src="/js/video.js"></script>
</body>
</html>

