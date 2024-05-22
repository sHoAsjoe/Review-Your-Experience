<?php

    global $db;
    if (isset($_POST['submit'])) {
        $search = $_POST['search'];
        $query = $db->prepare("SELECT * FROM user WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR email LIKE '%$search%'");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
    } else {
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
<br><br>
<div class="container-fluid p-3">
    <div class="row">
        <div class="col-md-9">
            <h1 class="text-center">Gebruikers Paneel</h1>
        </div>
        <div class="col-md-3">
            <form method="post" class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Zoeken" aria-label="Search" name="search">
                <button class="btn btn-outline-warning" type="submit" name="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>
        <div class="col-12" style="overflow-x:auto;">
            <h1 class="text-center"></h1>
            <table class="table table-dark table-striped">
                <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Voornaam</th>
                    <th scope="col">Achternaam</th>
                    <th scope="col">Email</th>
                    <th scope="col">Rol</th>
                    <th scope="col">Aanpassen</th>
                    <th scope="col">Verwijderen</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($result as $data) {
                    echo "<tr>
                    <th scope='row'>{$data['id']}</th>
                    <td>{$data['first_name']}</td>
                    <td>{$data['last_name']}</td>
                    <td>{$data['email']}</td>
                    <td>{$data['role']}</td>
                    <td><a href='/admin/edituser/{$data['id']}' class='btn btn-warning text-white w-100'><i class='bi bi-pencil-square fs-5 text-dark m-auto'></i></a></td>
                    <td><a href='/admin/panel/userspanel/deleteuser/{$data['id']}' class='btn btn-danger text-white w-100'><i class='bi bi-trash fs-5 text-dark m-auto'></i></a></td>
                    </tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<?php
include_once ('defaults/footer.php');
?>
</html>
