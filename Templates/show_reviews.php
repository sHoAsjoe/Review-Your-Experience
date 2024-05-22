<?php
global $db;
?>
<!DOCTYPE html>
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
    <div class="row">
        <div class="col-md-9">
            <h1 class="text-center">Recensie Paneel</h1>
        </div>
        <div class="col-md-3">
            <form method="post" class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Zoeken" aria-label="Search" name="search">
                <button class="btn btn-outline-warning" type="submit" name="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>
    </div>
    <div style="overflow-x:auto;">
    <table class="table text-white">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Gebruiker</th>
            <th scope="col">Bericht</th>
            <th scope="col">Stars</th>
            <th scope="col">Naam</th>
            <th scope="col">Afbeelding</th>
            <th scope="col">Verwijderen</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (isset($_POST['submit'])) {
            $search = $_POST['search'];
            $query = $db->prepare("SELECT * FROM review WHERE message LIKE '%$search%' OR stars LIKE '%$search%'");
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $data) {

                $id = $data['id'];
                $user = $data['user_id'];
                $message = $data['message'];
                $stars = $data['stars'];

                if ($message == "" || $message == null) {
                    $message = "<span class='text-danger'>Null</span>";
                }

                $query1 = $db->prepare("SELECT * FROM user WHERE id = :usr");
                $query1->bindParam(":usr", $user);
                $query1->execute();
                $result1 = $query1->fetch(PDO::FETCH_ASSOC);


                // Start building the HTML content for star ratings
                $starHtml = '';
                for ($i = 1; $i <= $stars; $i++) {
                    $starHtml .= "<input type='radio' id='star-{$i}' name='star-radio' value='{$i}' disabled>
                    <label for='star-{$i}'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path pathLength='360' fill='#ffc107' d='M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21'></path></svg></label>";
                }
                // Echo the table row with the HTML content for star ratings
                echo "<tr>
            <th scope='row'>{$id}</th>
            <td>{$result1['first_name']} {$result1['last_name']}</td>
            <td>{$message}</td>
            <td><div class='rating d-flex flex-row'>{$starHtml}</div></td>
            <td></td>
            <td></td>
            <td><a href='/admin/panel/reviewpanel/deletereview/{$id}' class='btn btn-danger text-white w-100'><i class='bi bi-trash fs-5 text-dark m-auto'></i></a></td>
          </tr>";
            }
        } else {
            $filmrelation = $db->prepare("SELECT * FROM film_review_relation");
            $filmrelation->execute();
            $resu = $filmrelation->fetchAll(PDO::FETCH_ASSOC);

            foreach ($resu as $data) {
                $query = $db->prepare("SELECT * FROM review where id = :id");
                $query->bindParam(":id", $data['review_id']);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_ASSOC);

                $id = $result['id'];
                $user = $result['user_id'];
                $message = $result['message'];
                $stars = $result['stars'];

                if ($message == "" || $message == null) {
                    $message = "<span class='text-danger'>Null</span>";
                }

                $query1 = $db->prepare("SELECT * FROM user WHERE id = :usr");
                $query1->bindParam(":usr", $result['user_id']);
                $query1->execute();
                $result1 = $query1->fetch(PDO::FETCH_ASSOC);

                $getmovie = $db->prepare("SELECT * FROM film where id = :film");
                $getmovie->bindParam(":film", $data['film_id']);
                $getmovie->execute();
                $movie = $getmovie->fetch(PDO::FETCH_ASSOC);

                // Start building the HTML content for star ratings
                $starHtml = '';
                for ($i = 1; $i <= $stars; $i++) {
                    $starHtml .= "<input type='radio' id='star-{$i}' name='star-radio' value='{$i}' disabled>
                    <label for='star-{$i}'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path pathLength='360' fill='#ffc107' d='M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21'></path></svg></label>";
                }
                // Echo the table row with the HTML content for star ratings
            echo "<tr>
            <th scope='row'>{$id}</th>
            <td>{$result1['first_name']} {$result1['last_name']}</td>
            <td>{$message}</td>
            <td><div class='rating d-flex flex-row'>{$starHtml}</div></td>
            <td>{$movie['name']}</td>
            <td><img class='img-fluid rounded' src='{$movie['image']}'></td>
            <td><a href='/admin/panel/reviewpanel/deletereview/{$id}' class='btn btn-danger text-white w-100'><i class='bi bi-trash fs-5 text-dark m-auto'></i></a></td>
          </tr>";
            }

            $serierelation = $db->prepare("SELECT * FROM review_serie_relation");
            $serierelation->execute();
            $resuserie = $serierelation->fetchAll(PDO::FETCH_ASSOC);

            foreach ($resuserie as $data) {
                $query = $db->prepare("SELECT * FROM review where id = :id");
                $query->bindParam(":id", $data['review_id']);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_ASSOC);

                $id = $result['id'];
                $user = $result['user_id'];
                $message = $result['message'];
                $stars = $result['stars'];

                if ($message == "" || $message == null) {
                    $message = "<span class='text-danger'>Null</span>";
                }

                $query1 = $db->prepare("SELECT * FROM user WHERE id = :usr");
                $query1->bindParam(":usr", $result['user_id']);
                $query1->execute();
                $result1 = $query1->fetch(PDO::FETCH_ASSOC);

                $getserie = $db->prepare("SELECT * FROM series where id = :serie");
                $getserie->bindParam(":serie", $data['serie_id']);
                $getserie->execute();
                $serie = $getserie->fetch(PDO::FETCH_ASSOC);

                // Start building the HTML content for star ratings
                $starHtml = '';
                for ($i = 1; $i <= $stars; $i++) {
                    $starHtml .= "<input type='radio' id='star-{$i}' name='star-radio' value='{$i}' disabled>
                    <label for='star-{$i}'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path pathLength='360' fill='#ffc107' d='M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21'></path></svg></label>";
                }
                // Echo the table row with the HTML content for star ratings
                echo "<tr>
            <th scope='row'>{$id}</th>
            <td>{$result1['first_name']} {$result1['last_name']}</td>
            <td>{$message}</td>
            <td><div class='rating d-flex flex-row'>{$starHtml}</div></td>
            <td>{$serie['name']}</td>
            <td><img class='img-fluid rounded' src='{$serie['image']}'></td>
            <td><a href='/admin/panel/reviewpanel/deletereview/{$id}' class='btn btn-danger text-white w-100'><i class='bi bi-trash fs-5 text-dark m-auto'></i></a></td>
            </tr>";
            }
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
