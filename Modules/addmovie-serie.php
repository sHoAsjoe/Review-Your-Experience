<?php
function addMovieSerie() {

    if (isset($_POST['submit'])) {
        global $db;

        $name = $_POST['name'];
        $genre = $_POST['genre'];
        $actors = $_POST['actorsInput'];
        $date = $_POST['date'];
        $image = $_POST['imgInput'];
        $description = $_POST['summary'];
        $trailer = $_POST['trailerInput'];
        $video = $_POST['videoInput'];
        $type = $_POST['type'];
        $genreArray = [];

        foreach ($genre as $gen) {
            $query = $db->prepare("SELECT * FROM categorie WHERE id = :id");
            $query->bindParam(':id', $gen);
            $query->execute();
            $resultC = $query->fetch(PDO::FETCH_ASSOC);
            array_push($genreArray, $resultC['name']);
        }
        if ($type == 'movies') {
            $stringGenre = implode(', ', $genreArray);
            $query = $db->prepare("INSERT INTO film (name, genre, actors, date, image, summary, type, trailer_url, video_url) VALUES (:name, :genre, :actors, :date, :image, :description, :type, :trailer, :video)");
            $query->bindParam(':name', $name);
            $query->bindParam(':genre', $stringGenre);
            $query->bindParam(':actors', $actors);
            $query->bindParam(':date', $date);
            $query->bindParam(':image', $image);
            $query->bindParam(':description', $description);
            $query->bindParam(':type', $type);
            $query->bindParam(':trailer', $trailer);
            $query->bindParam(':video', $video);
            $query->execute();

            $id = $db->lastInsertId();
            foreach ($genre as $gen) {
                $insertQuery = $db->prepare("INSERT INTO categories_relation (film_id, categorie_id) VALUES (:film_id, :categorie_id)");
                $insertQuery->bindParam(':film_id', $id);
                $insertQuery->bindParam(':categorie_id', $gen);
                $insertQuery->execute();
            }
        } else if ($type == 'series') {
            $stringGenre = implode(', ', $genreArray);
            $query = $db->prepare("INSERT INTO series (name, genre, actors, date, image, summary, type, trailer_url, video_url) VALUES (:name, :genre, :actors, :date, :image, :description, :type, :trailer, :video)");
            $query->bindParam(':name', $name);
            $query->bindParam(':genre', $stringGenre);
            $query->bindParam(':actors', $actors);
            $query->bindParam(':date', $date);
            $query->bindParam(':image', $image);
            $query->bindParam(':description', $description);
            $query->bindParam(':type', $type);
            $query->bindParam(':trailer', $trailer);
            $query->bindParam(':video', $video);
            $query->execute();

            $id = $db->lastInsertId();
            foreach ($genre as $gen) {
                $insertQuery = $db->prepare("INSERT INTO categorie_serie_relationship (serie_id, categorie_id) VALUES (:serie_id, :categorie_id)");
                $insertQuery->bindParam(':serie_id', $id);
                $insertQuery->bindParam(':categorie_id', $gen);
                $insertQuery->execute();
            }
        } else {
            echo "Error";
        }

        header("Location: /admin/panel/m-spanel");

    }
}
