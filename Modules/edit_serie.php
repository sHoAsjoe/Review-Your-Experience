<?php
function edit_serie()
{
    global $db;
    global $params;
    $id = $params[3];
    $query = $db->prepare("SELECT * FROM series WHERE id = :id");
    $query->bindParam(':id', $id);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $actors = $_POST['actorsInput'];
        $date = $_POST['date'];

        $genre = $_POST['genre'];
        $genreArray = [];
        $deleteQuery = $db->prepare("DELETE FROM categorie_serie_relationship WHERE serie_id = :serie_id");
        $deleteQuery->bindParam(':serie_id', $id);
        $deleteQuery->execute();

        foreach ($genre as $gen) {
            $insertQuery = $db->prepare("INSERT INTO categorie_serie_relationship (serie_id, categorie_id) VALUES (:serie_id, :categorie_id)");
            $insertQuery->bindParam(':serie_id', $id);
            $insertQuery->bindParam(':categorie_id', $gen);
            $insertQuery->execute();
        }
        foreach ($genre as $gen) {
            $query = $db->prepare("SELECT * FROM categorie WHERE id = :id");
            $query->bindParam(':id', $gen);
            $query->execute();
            $resultC = $query->fetch(PDO::FETCH_ASSOC);
            array_push($genreArray, $resultC['name']);
        }
        $image = $_POST['imgInput'];
        if ($_POST['type'] == 'movies') {
            $type = 'movies';
        } elseif ($_POST['type'] == 'series') {
            $type = 'series';
        }

        $description = $_POST['summary'];
        $trailer = $_POST['trailerInput'];
        $video = $_POST['videoInput'];
        $stringArray = implode(', ', $genreArray);

        echo $stringArray;
        $query = $db->prepare("UPDATE series SET name = :name, actors = :actors, date = :date, genre = :genre, image = :image, type = :type, summary = :summary, trailer_url = :trailer, video_url = :video WHERE id = :id");
        $query->bindParam(':name', $name);
        $query->bindParam(':actors', $actors);
        $query->bindParam(':date', $date);
        $query->bindParam(':genre', $stringArray);
        $query->bindParam(':image', $image);
        $query->bindParam(':type', $type);
        $query->bindParam(':summary', $description);
        $query->bindParam(':trailer', $trailer);
        $query->bindParam(':video', $video);
        $query->bindParam(':id', $id);
        $query->execute();
        header("Location: /admin/panel/m-spanel");
    } else {
        return $result;
    }
}
?>
