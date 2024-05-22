<?php
if (!isAdmin()) {
    logout();
    header ("location:/home");
} else {
    global $db;
    $query = $db->prepare("SELECT * FROM user");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
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
<div class="container-fluid">
    <h1 class="text-center">Administratie Paneel</h1>
    <p class="fs-3 text-center">Welkom <?=$_SESSION['user']['first_name']." ".$_SESSION['user']['last_name']?></p>
    <br><br>
    <div class="row">
        <div class="col-md-4 col-12 mt-md-0 mt-4">
            <h3>Gebruikers Paneel</h3>
            <p class="fs-6">Hier staan alle gebruikers. Je kan elke gebruiker aanpassen, verwijderen of &nbsp; toevoegen</p>
            <a href="/admin/panel/userspanel" class="btn btn-warning w-100">Gebruikers paneel</a>
        </div>
        <div class="col-md-4 col-12 mt-md-0 mt-4">
            <h3>Movies & Series Paneel</h3>
            <p class="fs-6">Hier staan alle movies en series. Je kan elke movie of serie aanpassen, verwijderen of toevoegen</p>
            <a href="/admin/panel/m-spanel" class="btn btn-warning w-100">Movies & Series Paneel</a>
    </div>
        <div class="col-md-4 col-12 mt-md-0 mt-4">
            <h3>Recensies Paneel</h3>
            <p class="fs-6">Hier staan alle recensies. Je kan elke recensie van elke user aanpassen of verwijderen</p>
            <a href="/admin/panel/reviewpanel" class="btn btn-warning w-100">Recensies Paneel</a>
        </div>
</div>

</body>

</html>