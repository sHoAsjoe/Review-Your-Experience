<?php

global $params;
$id = $params[5];
global $db;

if (isMember() || isAdmin()) {
    if ($params[1] == 'deletereview') {
        $id = $params[2];
    }
} else {
    logout();
    header("location:/home");
}

try {
    // Begin a transaction
    $db->beginTransaction();

    // Delete related records from film_review_relation
    $queryChildFilm = $db->prepare("DELETE FROM film_review_relation WHERE review_id = :id");
    $queryChildFilm->bindParam(":id", $id);
    $queryChildFilm->execute();

    // Delete related records from series_review_relation
    $queryChildSeries = $db->prepare("DELETE FROM review_serie_relation WHERE review_id = :id");
    $queryChildSeries->bindParam(":id", $id);
    $queryChildSeries->execute();

    // Delete the main review record
    $query = $db->prepare("DELETE FROM review WHERE id = :id");
    $query->bindParam(":id", $id);
    $query->execute();

    // Commit the transaction
    $db->commit();

    // Redirect after successful deletion
    if ($params[1] == 'deletereview') {
        echo "<a href='/home' class='location' hidden></a>";
    } else {
        echo "<a href='/admin/panel/reviewpanel/' class='location' hidden></a>";
    }

    echo "<script>document.querySelector('.location').click()</script>";
    exit();
} catch (PDOException $e) {
    // An error occurred, rollback the transaction
    $db->rollBack();

    // You might want to handle the error in a way that suits your application
    echo "Error: " . $e->getMessage();
    // or redirect to an error page
    // header("Location: /admin/error-page");
    // exit();
}

?>


