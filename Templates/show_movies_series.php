<?php

    global $db;
    global $params;

    if (isset($_POST['submit'])) {
        $search = $_POST['search'];
        $mquery = $db->prepare("SELECT * FROM film WHERE name LIKE '%$search%'");
        $mquery->execute();
        $mresult = $mquery->fetchAll(PDO::FETCH_ASSOC);

        $squery = $db->prepare("SELECT * FROM series WHERE name LIKE '%$search%'");
        $squery->execute();
        $sresult = $squery->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $mquery = $db->prepare("SELECT * FROM film order by id desc");
        $mquery->execute();
        $mresult = $mquery->fetchAll(PDO::FETCH_ASSOC);

        $squery = $db->prepare("SELECT * FROM series order by id desc");
        $squery->execute();
        $sresult = $squery->fetchAll(PDO::FETCH_ASSOC);
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
<br><br>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <h1 class="text-center">Movies & Series Paneel</h1>
        </div>
        <div class="col-md-3">
            <form method="post" class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Zoeken" aria-label="Search" name="search">
                <button class="btn btn-outline-warning" type="submit" name="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>
</div>
<div style="overflow-x:auto;">
    <a href="/admin/addms/" class='text-warning'><i class="bi bi-plus"></i>Voeg een film/serie toe</a>
<table class="table text-white">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Naam</th>
        <th scope="col">Genre</th>
        <th scope="col">Acteurs</th>
        <th scope="col">Datum</th>
        <th scope="col">Type</th>
        <th scope="col">Afbeelding</th>
        <th scope="col">Aanpassen</th>
        <th scope="col">Verwijderen</th>
    </tr>
    </thead>
    <tbody>
        <?php
        foreach ($mresult as $data) {
            $id = $data['id'];
            $name = $data['name'];
            $actor = $data['actors'];
            $date = $data['date'];
            $genre = $data['genre'];
            $image = $data['image'];
            $type = $data['type'];
            echo "<tr>
            <th scope='row'>{$id}</th>
            <td>{$name}</td>
            <td>{$genre}</td>
            <td>{$actor}</td>
            <td>{$date}</td>
            <td>{$type}</td>
            <td><img class='img-fluid rounded' src='{$image}'></td>
            <td><a href='/admin/editmovie/{$id}' class='btn btn-warning text-white w-100'><i class='bi bi-pencil-square fs-5 text-dark m-auto'></i></a></td>
            <td><a href='/admin/panel/m-spanel/deletemovie/{$id}' class='btn btn-danger text-white w-100'><i class='bi bi-trash fs-5 text-dark m-auto'></i></a></td>
        </tr>
   ";}
        foreach($sresult as $data) {
            $id = $data['id'];
            $name = $data['name'];
            $actor = $data['actors'];
            $date = $data['date'];
            $genre = $data['genre'];
            $image = $data['image'];
            $type = $data['type'];
            echo "<tr>
            <th scope='row'>{$id}</th>
            <td>{$name}</td>
            <td>{$genre}</td>
            <td>{$actor}</td>
            <td>{$date}</td>
            <td>{$type}</td>
            <td><img class='img-fluid rounded' src='{$image}'></td>
            <td><a href='/admin/editserie/{$id}' class='btn btn-warning text-white w-100'><i class='bi bi-pencil-square fs-5 text-dark m-auto'></i></a></td>
            <td><a href='/admin/panel/m-spanel/deleteserie/{$id}' class='btn btn-danger text-white w-100'><i class='bi bi-trash fs-5 text-dark m-auto'></i></a></td>
            </tr>";
        }?>
    </tbody>
</table>
</div>
</body>
<?php
include_once ('defaults/footer.php');
?>
</html>

