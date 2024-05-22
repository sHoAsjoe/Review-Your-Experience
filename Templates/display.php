<?php
    $request = $_SERVER['REQUEST_URI'];
    $params = explode("/", $request);
    $type = $params[1];
    $id = $params[2];
    $season = '';
    $errorMSG = '';

    if (isset($_POST['submit'])) {
        $message = $_POST['message'];
        $user = $_SESSION['user']['id'];
        global $db;
        if (!empty($_POST['star-radio'])) {
            $stars = $_POST['star-radio'];
            if ($type == 'movies') {
                $query = $db->prepare("INSERT INTO review (user_id, stars, message) VALUES (:user, :stars, :message)");
                $query->bindParam(':user', $user);
                $query->bindParam(':stars', $stars);
                $query->bindParam(':message', $message);
                $query->execute();
                $reviewId = $db->lastInsertId();
                $query2 = $db->prepare("INSERT INTO film_review_relation (film_id, review_id) VALUES (:film, :review)");
                $query2->bindParam(':film', $id);
                $query2->bindParam(':review', $reviewId);
                $query2->execute();
            }
            if ($type == 'series') {
                $query = $db->prepare("INSERT INTO review (user_id, stars, message) VALUES (:user, :stars, :message)");
                $query->bindParam(':user', $user);
                $query->bindParam(':stars', $stars);
                $query->bindParam(':message', $message);
                $query->execute();
                $reviewId = $db->lastInsertId();
                $query2 = $db->prepare("INSERT INTO review_serie_relation (serie_id, review_id) VALUES (:serie, :review)");
                $query2->bindParam(':serie', $id);
                $query2->bindParam(':review', $reviewId);
                $query2->execute();
            }
        } else {
            $errorMSG = "<p class='alert alert-danger fs-6'>Er is een fout opgetreden: Kies een aantal sterren!!</p>";
        }
    }

    if ($type == 'movies') {
        function displayMovie($id)
        {
            global $db;
            $query = $db->prepare("SELECT * FROM film where id = :movie");
            $query->bindParam(':movie', $id);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $data) {
                echo "<h1>{$data['name']}</h1>";
                echo "<p class='fs-6'><b>{$data['date']}&nbsp;|&nbsp;<span class='text-warning'>{$data['genre']}</span></b></p>";
                echo "<div class='row'>
                <div class='col-md-5 col-12 mb-5 mb-md-0'>
                   <img src='{$data['image']}' class='h-auto rounded w-100' alt='movie'>
                </div>
                <div class='col-md-7 col-12'>
                    {$data['trailer_url']}
                </div>
                </div> <br><br>";
                echo "<h3 class='text-warning'><b>Acteurs:</b></h3><p class='fs-6'>{$data['actors']}</p><br><br>";
                echo "<h3 class='text-warning'><b>Genre:</b></h3>";
                echo "<p class='fs-6 mb-5'>{$data['genre']}</p><br>";
                echo "<h3 class='text-warning'><b>Beschrijving:</b></h3><p class='fs-6'>{$data['summary']}</p><br><br>";
                echo $data['video_url'];
            }
        }
        function displayReviews() {
            global $db;
            global $id;
            $query = $db->prepare("SELECT * FROM film_review_relation where film_id = :id");
            $query->bindParam(':id', $id);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $data) {
                $query2 = $db->prepare("SELECT * FROM review where id = :id");
                $query2->bindParam(':id', $data['review_id']);
                $query2->execute();
                $result2 = $query2->fetch(PDO::FETCH_ASSOC);

                $queryU = $db->prepare("SELECT * FROM user where id = :id");
                $queryU->bindParam(':id', $result2['user_id']);
                $queryU->execute();
                $resultU = $queryU->fetch(PDO::FETCH_ASSOC);

                if (isMember() || isAdmin() && $result2['user_id'] == $_SESSION['user']['id']) {
                    echo "<div class='card text-white bg-dark border border-warning col-md-4 col-12 mb-4'>
            <div class='card-body'>
                <img src='/{$resultU['profile_pic']}' alt='' style='height: 29px; border-radius: 25px; float: left;'>
                <a href='/deletereview/{$result2['id']}' class='text-danger'><i class='float-end bi bi-trash' role='button'></i></a>
                  <a href='/editreview/{$result2['id']}' class='text-warning'><i class='float-end bi bi-pencil-square' role='button'></i></a>

                <h5 class='card-title'>&nbsp;~{$resultU['first_name']}&nbsp;{$resultU['last_name']}</h5>
                <div class='rating float-start mb-3 mt-3'>";
                    for ($i = 1; $i <= $result2['stars']; $i++) {
                        echo "<input type='radio' id='star-{$i}' name='star-radio' value='{$i}' disabled>
                    <label for='star-{$i}'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path pathLength='360' fill='#ffc107' d='M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21'></path></svg></label>";
                    }
                    echo "
                </div>
<br><br><br>
                <p class='card-text fs-6 float-start w-100'>{$result2['message']}</p>
            </div>
        </div>";
                } else {
                    echo "<div class='card text-white bg-dark border border-warning col-md-4 col-12 mb-4'>
            <div class='card-body'>
                <img src='/{$resultU['profile_pic']}' alt='' style='height: 29px; border-radius: 25px; float: left;'>
                <h5 class='card-title'>&nbsp;~{$resultU['first_name']}&nbsp;{$resultU['last_name']}</h5>
                <div class='rating float-start mb-3 mt-3'>";
                    for ($i = 1; $i <= $result2['stars']; $i++) {
                        echo "<input type='radio' id='star-{$i}' name='star-radio' value='{$i}' disabled>
                    <label for='star-{$i}'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path pathLength='360' fill='#ffc107' d='M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21'></path></svg></label>";
                    }
                    echo "
                </div>
<br><br><br>
                <p class='card-text fs-6 float-start w-100'>{$result2['message']}</p>
            </div>
        </div>";
                }
            }
        }
    }

    if ($type == 'series' && $id <= 2) {
        function displayMovie($id)
        {
            global $db;
            $query = $db->prepare("SELECT * FROM series where id = :serie");
            $query->bindParam(':serie', $id);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $data) {
                echo "<h1>{$data['name']}</h1>";
                echo "<p class='fs-6'><b>{$data['date']}&nbsp;|&nbsp;<span class='text-warning'>{$data['genre']}</span></b></p>";
                echo "<div class='row'>
                <div class='col-md-5 col-12 mb-5 mb-md-0'>
                   <img src='{$data['image']}' class='h-auto rounded w-100' alt='movie'>
                </div>
                <div class='col-md-7 col-12'>
                    {$data['trailer_url']}
                </div>
                </div> <br><br>";
                echo "<h3 class='text-warning'><b>Acteurs:</b></h3><p class='fs-6'>{$data['actors']}</p><br><br>";
                echo "<h3 class='text-warning'><b>Genre:</b></h3>";
                echo "<p class='fs-6 mb-5'>{$data['genre']}</p><br>";
                echo "<h3 class='text-warning'><b>Beschrijving:</b></h3><p class='fs-6'>{$data['summary']}</p><br><br>";
                global $season;
                $season = "<button class='btn btn-secondary dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                Seasons
            </button>";
            }
        }
        function displayReviews() {
            global $db;
            global $id;
            $query = $db->prepare("SELECT * FROM review_serie_relation where serie_id = :id");
            $query->bindParam(':id', $id);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $data) {
                $query2 = $db->prepare("SELECT * FROM review where id = :id");
                $query2->bindParam(':id', $data['review_id']);
                $query2->execute();
                $result2 = $query2->fetch(PDO::FETCH_ASSOC);

                $queryU = $db->prepare("SELECT * FROM user where id = :id");
                $queryU->bindParam(':id', $result2['user_id']);
                $queryU->execute();
                $resultU = $queryU->fetch(PDO::FETCH_ASSOC);

                if (isMember() || isAdmin() && $result2['user_id'] == $_SESSION['user']['id']) {
                    echo "<div class='card text-white bg-dark border border-warning col-md-4 col-12 mb-4'>
            <div class='card-body'>
                <img src='/{$resultU['profile_pic']}' alt='' style='height: 29px; border-radius: 25px; float: left;'>
                <a href='/deletereview/{$result2['id']}' class='text-danger'><i class='float-end bi bi-trash' role='button'></i></a>
                <a href='/editreview/{$result2['id']}' class='text-warning'><i class='float-end bi bi-pencil-square' role='button'></i></a>
                <h5 class='card-title'>&nbsp;~{$resultU['first_name']}&nbsp;{$resultU['last_name']}</h5>
                <div class='rating float-start mb-3 mt-3'>";
                    for ($i = 1; $i <= $result2['stars']; $i++) {
                        echo "<input type='radio' id='star-{$i}' name='star-radio' value='{$i}' disabled>
                    <label for='star-{$i}'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path pathLength='360' fill='#ffc107' d='M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21'></path></svg></label>";
                    }
                    echo "
                </div>
<br><br><br>
                <p class='card-text fs-6 float-start w-100'>{$result2['message']}</p>
            </div>
        </div>";
                } else {

                    echo "<div class='card text-white bg-dark border border-warning col-md-4 col-12 mb-4'>
            <div class='card-body'>
                <img src='/{$resultU['profile_pic']}' alt='' style='height: 29px; border-radius: 25px; float: left;'>
                <h5 class='card-title'>&nbsp;~{$resultU['first_name']}&nbsp;{$resultU['last_name']}</h5>
                <div class='rating float-start mb-3 mt-3'>";
                    for ($i = 1; $i <= $result2['stars']; $i++) {
                        echo "<input type='radio' id='star-{$i}' name='star-radio' value='{$i}' disabled>
                    <label for='star-{$i}'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path pathLength='360' fill='#ffc107' d='M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21'></path></svg></label>";
                    }
                    echo "
                </div>
                <br><br><br>
                <p class='card-text fs-6 float-start w-100'>{$result2['message']}</p>
            </div>
        </div>";
                }
            }
        }
    }
    if ($type == 'series' && $id > 2) {
        function displayMovie($id)
        {
            global $db;
            $query = $db->prepare("SELECT * FROM series where id = :serie");
            $query->bindParam(':serie', $id);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $data) {
                echo "<h1>{$data['name']}</h1>";
                echo "<p class='fs-6'><b>{$data['date']}&nbsp;|&nbsp;<span class='text-warning'>{$data['genre']}</span></b></p>";
                echo "<div class='row'>
                        <div class='col-md-5 col-12 mb-5 mb-md-0'>
                           <img src='{$data['image']}' class='h-auto rounded w-100' alt='movie'>
                        </div>
                        <div class='col-md-7 col-12'>
                            {$data['trailer_url']}
                        </div>
                        </div> <br><br>";
                echo "<h3 class='text-warning'><b>Acteurs:</b></h3><p class='fs-6'>{$data['actors']}</p><br><br>";
                echo "<h3 class='text-warning'><b>Genre:</b></h3>";
                echo "<p class='fs-6 mb-5'>{$data['genre']}</p><br>";
                echo "<h3 class='text-warning'><b>Beschrijving:</b></h3><p class='fs-6'>{$data['summary']}</p><br><br>";
                echo $data['video_url'];
            }
        }
        function displayReviews() {
            global $db;
            global $id;
            $query = $db->prepare("SELECT * FROM review_serie_relation where serie_id = :id");
            $query->bindParam(':id', $id);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $data) {
                $query2 = $db->prepare("SELECT * FROM review where id = :id");
                $query2->bindParam(':id', $data['review_id']);
                $query2->execute();
                $result2 = $query2->fetch(PDO::FETCH_ASSOC);

                $queryU = $db->prepare("SELECT * FROM user where id = :id");
                $queryU->bindParam(':id', $result2['user_id']);
                $queryU->execute();
                $resultU = $queryU->fetch(PDO::FETCH_ASSOC);

                if (isMember() || isAdmin() && $result2['user_id'] == $_SESSION['user']['id']) {
                    echo "<div class='card text-white bg-dark border border-warning col-md-4 col-12 mb-4'>
            <div class='card-body'>
                <img src='/{$resultU['profile_pic']}' alt='' style='height: 29px; border-radius: 25px; float: left;'>
                  <a href='/deletereview/{$result2['id']}' class='text-danger'><i class='float-end bi bi-trash' role='button'></i></a>
                  <a href='/editreview/{$result2['id']}' class='text-warning'><i class='float-end bi bi-pencil-square' role='button'></i></a>
                <h5 class='card-title'>&nbsp;~{$resultU['first_name']}&nbsp;{$resultU['last_name']}</h5>
                <div class='rating float-start mb-3 mt-3'>";
                    for ($i = 1; $i <= $result2['stars']; $i++) {
                        echo "<input type='radio' id='star-{$i}' name='star-radio' value='{$i}' disabled>
                    <label for='star-{$i}'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path pathLength='360' fill='#ffc107' d='M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21'></path></svg></label>";
                    }
                    echo "
                </div>
<br><br><br>
                <p class='card-text fs-6 float-start w-100'>{$result2['message']}</p>
            </div>
        </div>";
                } else {
                    echo "<div class='card text-white bg-dark border border-warning col-md-4 col-12 mb-4'>
            <div class='card-body'>
                <img src='/{$resultU['profile_pic']}' alt='' style='height: 29px; border-radius: 25px; float: left;'>
                <h5 class='card-title'>&nbsp;~{$resultU['first_name']}&nbsp;{$resultU['last_name']}</h5>
                <div class='rating float-start mb-3 mt-3'>";
                    for ($i = 1; $i <= $result2['stars']; $i++) {
                        echo "<input type='radio' id='star-{$i}' name='star-radio' value='star-{$i}' disabled>
                    <label for='star-{$i}'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path pathLength='360' fill='#ffc107' d='M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21'></path></svg></label>";
                    }
                    echo "
                </div>
                <br><br><br>
                <p class='card-text fs-6 float-start w-100'>{$result2['message']}</p>
            </div>
        </div>";
                }
            }
        }
    }
    function displayEpisodes() {
        global $db;
        global $id;
        $query = $db->prepare("SELECT * FROM season where serie_id = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $data) {
            echo "<li><a class='dropdown-item' href='/series/{$id}/{$data['id']}#ep'>{$data['season_name']}</a></li>";
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
    <div class="container-fluid p-5">
        <?php
        if ($type == 'series' && isAdmin()) {
            echo "<a href='/admin/editserie/{$id}' class='btn btn-outline-warning float-end'>Aanpassen</a>";
        } elseif ($type == 'movies' && isAdmin()){
            echo "<a href='/admin/editmovie/{$id}' class='btn btn-outline-warning float-end'>Aanpassen</a>";
        }
        ?>
        <?=$errorMSG?>
        <?=displayMovie($id)?>

        <div class='dropdown'>
          <?=$season?>
            <ul class='dropdown-menu'>
                <?=displayEpisodes()?>
            </ul>
            <br><br>
            <div class='list-group' id="ep">
            <?php if (isset($params[3]) && $type == 'series') {

                global $db;
                $season = $params[3];
                $queryEpisode = $db->prepare("SELECT * FROM episode where season_id = :season");
                $queryEpisode->bindParam(':season', $season);
                $queryEpisode->execute();
                $resultEpisode = $queryEpisode->fetchAll(PDO::FETCH_ASSOC);

                foreach ($resultEpisode as $data) {
                    echo "
                  <a href='/series/{$id}/{$params[3]}/{$data['id']}#video' class='list-group-item list-group-item-action list-group-item-dark'>{$data['name']}</a>
                ";
                }
                if (isset($params[4]) && $type == 'series') {
                    $episode = $params[4];
                    $queryEpisode = $db->prepare("SELECT * FROM episode where id = :episode");
                    $queryEpisode->bindParam(':episode', $episode);
                    $queryEpisode->execute();
                    $resultEpisode = $queryEpisode->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($resultEpisode as $data) {
                        echo "<br><br><div id='video'>{$data['video_url']}</div>";
                    }
                }
            } ?>
            </div>
        </div>
        <?php if (isAdmin() || isMember()) {
            echo "<form method='post'>
        <div class='card text-white bg-dark border border-warning col-md-4 col-12 mb-4'>
            <div class='card-body'>
                <img src='/{$_SESSION['user']['profile_pic']}' alt='' style='height: 29px; border-radius: 25px; float: left;'>
                <h5 class='card-title'>&nbsp;~{$_SESSION['user']['first_name']}&nbsp;{$_SESSION['user']['last_name']}</h5>
                <div class='rating float-start mb-3 mt-3'>
       
                  <input type='radio' id='1' name='star-radio' value='5'>
                    <label for='1'>
                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path pathLength='360' d='M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z'></path></svg>
                   </label>
                 <input type='radio' id='2' name='star-radio' value='4'>
                    <label for='2'>
                         <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path pathLength='360' d='M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z'></path></svg>
                    </label>
                 <input type='radio' id='3' name='star-radio' value='3'>
                  <label for='3'>
                    <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path pathLength='360' d='M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z'></path></svg>
                  </label>
                  <input type='radio' id='4' name='star-radio' value='2'>
                  <label for='4'>
                    <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path pathLength='360' d='M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z'></path></svg>
                  </label>
                  <input type='radio' id='5' name='star-radio' value='1'>
                  <label for='5'>
                    <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path pathLength='360' d='M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z'></path></svg>
                  </label>

                </div>
                <br><br><br>
                <label for='message'>Bericht(Optioneel):</label>
                <textarea type='text' name='message' class='form-control' id='message' placeholder='Voer jouw bericht toe'></textarea><br>
                <button type='submit' name='submit' class='btn btn-outline-warning'>Recensie Toevoegen</button>
            </div>
        </div>
        </form>";
        }?>
        <?=$errorMSG?>
        <?=displayReviews()?>
    </div>
</body>
<?php
include_once ('defaults/footer.php');
?>
</html>
