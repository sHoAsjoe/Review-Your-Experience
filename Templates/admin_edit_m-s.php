<?php
global $params;
include ('../Modules/edit_movie.php');
include ('../Modules/edit_serie.php');
if ($params[2] == 'editmovie') {
    $result = edit_movie();
    global $db;
    $id = $params[3];
    $query = $db->prepare("SELECT * FROM categories_relation WHERE film_id = :id");
    $query->bindParam(':id', $id);
    $query->execute();
    $resultCat = $query->fetchAll(PDO::FETCH_ASSOC);

    $name = $result['name'];
    $actors = $result['actors'];
    $date = $result['date'];
    $genre = $result['genre'];
    $image = $result['image'];
    $type = $result['type'];
    $description = $result['summary'];
    $trailer = $result['trailer_url'];
    $video = $result['video_url'];

    function displaymovieorserie($result, $db)
    {
        $countArray = [];

        // Step 1: Collect selected category IDs
        foreach ($result as $data) {
            $query = $db->prepare("SELECT * FROM categorie WHERE id = :id");
            $query->bindParam(':id', $data['categorie_id']);
            $query->execute();
            $resultC = $query->fetch(PDO::FETCH_ASSOC);
            array_push($countArray, $resultC['id']);

            echo "<div class='form-check'>
                  <input class='form-check-input' type='checkbox' value='{$resultC['id']}' id='{$resultC['id']}' name='genre[]' checked>
                  <label class='form-check-label' for='{$resultC['id']}'>
                    {$resultC['name']}
                  </label>
                </div>";
        }

        // Step 2: Display checkboxes for the remaining categories
        $restofquery = $db->prepare("SELECT * FROM categorie");
        $restofquery->execute();
        $restofresult = $restofquery->fetchAll(PDO::FETCH_ASSOC);

        foreach ($restofresult as $category) {
            // Check if the category ID is not in the selected IDs
            if (!in_array($category['id'], $countArray)) {
                echo "<div class='form-check'>
                  <input class='form-check-input' type='checkbox' value='{$category['id']}' name='genre[]' id='{$category['id']}'>
                  <label class='form-check-label' for='{$category['id']}'>
                    {$category['name']}
                  </label>
                </div>";
            }
        }
    }
}

function displayType($type) {
    if ($type == 'movies') {
        echo "<option value='movies' selected>Film</option>
              <option value='series'>Serie</option>";
    } elseif ($type == 'series') {
        echo "<option value='movies'>Film</option>
              <option value='series' selected>Serie</option>";
    } else {
        echo "
              <option value=''>Kies een type</option>
              <option value='movies'>Film</option>
              <option value='series'>Serie</option>";
    }
}
    if ($params[2] == 'editserie') {
        $result = edit_serie();
        global $db;
        $id = $params[3];
        $query = $db->prepare("SELECT * FROM categorie_serie_relationship WHERE serie_id = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        $resultCat = $query->fetchAll(PDO::FETCH_ASSOC);

        $name = $result['name'];
        $actors = $result['actors'];
        $date = $result['date'];
        $genre = $result['genre'];
        $image = $result['image'];
        $type = $result['type'];
        $description = $result['summary'];
        $trailer = $result['trailer_url'];
        $video = $result['video_url'];

        function displaymovieorserie($result, $db)
        {
            $countArray = [];

            // Step 1: Collect selected category IDs
            foreach ($result as $data) {
                $query = $db->prepare("SELECT * FROM categorie WHERE id = :id");
                $query->bindParam(':id', $data['categorie_id']);
                $query->execute();
                $resultC = $query->fetch(PDO::FETCH_ASSOC);
                array_push($countArray, $resultC['id']);

                echo "<div class='form-check'>
                  <input class='form-check-input' type='checkbox' value='{$resultC['id']}' id='{$resultC['id']}' name='genre[]' checked>
                  <label class='form-check-label' for='{$resultC['id']}'>
                    {$resultC['name']}
                  </label>
                </div>";
            }

            // Step 2: Display checkboxes for the remaining categories
            $restofquery = $db->prepare("SELECT * FROM categorie");
            $restofquery->execute();
            $restofresult = $restofquery->fetchAll(PDO::FETCH_ASSOC);

            foreach ($restofresult as $category) {
                // Check if the category ID is not in the selected IDs
                if (!in_array($category['id'], $countArray)) {
                    echo "<div class='form-check'>
                  <input class='form-check-input' type='checkbox' value='{$category['id']}' name='genre[]' id='{$category['id']}'>
                  <label class='form-check-label' for='{$category['id']}'>
                    {$category['name']}
                  </label>
                </div>";
                }
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
    <div class="container-fluid">
    <h1 class="text-center">Movie/Serie aanpassen</h1>
        <a href="/admin/panel" class="text-warning"><i class="bi bi-arrow-return-left"></i>Terug gaan naar paneel</a><br><br>
        <form method="post">
        <div class="mb-3">
            <label for="name">Naam</label>
            <input type="text" class="form-control bg-dark text-white" placeholder="Naam van film/serie" id="name" name="name" value="<?=$name?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Beschrijving</label>
            <textarea class="form-control bg-dark text-white" id="exampleFormControlTextarea1" rows="3" name="summary" placeholder="beschrijving van het film/serie"><?=$description?></textarea>
        </div>
        <div class="mb-3">
            <label for="date">Datum</label>
            <input type="date" class="form-control bg-dark text-white" placeholder="Datum van film/serie" id="date" name="date" value="<?=$date?>">
        </div>
        <div class="mb-3">
        <div class="row">
            <div class="col-md-10 col-12 mt-md-0 mt-3">
                <label for="image">Afbeelding(Alleen url's)</label>
                <input type="text" class="form-control bg-dark text-white" placeholder="Afbeelding van film/serie" id="image" name="imgInput" value="<?=$image?>">
            </div>
            <div class="col-md-2 col-12 mt-md-0 mt-3">
                <img class="img-fluid rounded imgMS" src="<?=$image?>" alt="">
            </div>
        </div>
        </div>
        <div class="mb-3">
            <label for="actors">Acteurs</label>
            <input type="text" class="form-control bg-dark text-white" placeholder="Acteurs van film/serie" id="actors" name="actorsInput" value="<?=$actors?>">
        </div>
        <div class="mb-3">
        <label for="type">Type</label>
        <select class="form-select bg-dark text-white" aria-label="Default select example" name="type">
            <?=displayType($type)?>
        </select>
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-md-9 col-12 mt-md-0 mt-3">
                    <label for="trailer">Trailer(Alleen url's/ gebruikt youtube embed)</label>
                    <textarea class="form-control bg-dark text-white trailerMS" placeholder="Trailer van film/serie" name="trailerInput" id="trailer" rows="3"><?=$trailer?></textarea>
                </div>
                <div class="col-md-3 col-12 mt-md-0 mt-3">
                    <div class="trailer"><?=$trailer?></div>
                    <div class="changedtrailer"></div>
                </div>
            </div>
            <p class="fs-6">Plak deze template zo kan de trailer netjes op de site komen. Bij src set je de url.</p>
            <textarea class="form-control bg-gradient" disabled placeholder="Trailer van film/serie" id="trailer" rows="2">&lt;iframe class="img-fluid h-100 w-100" src="Jouw url" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe&gt;</textarea>
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-md-9 col-12 mt-md-0 mt-3">
                    <label for="videoInput">Video(Alleen url's/ gebruikt vidsrc api)</label>
                    <textarea class="form-control bg-dark text-white videoMS" placeholder="Video van film/serie" id="videoInput" name="videoInput" rows="4"><?=$video?></textarea><br>
                </div>
                <div class="col-md-3 col-12 mt-md-0 mb-md-0 mb-5">
                    <div class="video"><?=$video?></div>
                    <div class="changedvideo"></div>
                </div>
            </div>
            <p class="fs-6">Plak deze template zo kan de video netjes op de site komen. Bij src set je de url.</p>
            <textarea class="form-control bg-gradient" disabled placeholder="Video van film/serie" id="video" rows="2">&lt;div class="ratio ratio-16x9"> <iframe class="img-fluid h-100 w-100" src="Jouw url" referrerpolicy="origin" allow="web-share" allowfullscreen></iframe></div&gt;</textarea>
        </div>
        <p class="fs-5">Genre:</p>
        <?=displaymovieorserie($resultCat, $db)?>
        <br>
        <button type="submit" class="btn btn-warning" name="submit">Aanpassen</button>
        </form>
    </div>

    <script type="application/javascript" src="/js/update_input_admin_edit.js"></script>
</body>
</html>
