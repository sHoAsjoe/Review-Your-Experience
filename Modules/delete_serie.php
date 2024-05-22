<?php
if (!isAdmin()) {
    logout();
    header ("location:/home");
} else {
    global $db;
    global $params;
    $id = $params[5];
// Deleting child records
    $deleteChildQuery = $db->prepare("DELETE FROM categorie_serie_relationship WHERE serie_id = :id");
    $deleteChildQuery->bindParam(':id', $id);
    $deleteChildQuery->execute();

    $deleteChildQueryReview = $db->prepare("DELETE FROM review_serie_relation WHERE serie_id = :id");
    $deleteChildQueryReview->bindParam(':id', $id);
    $deleteChildQueryReview->execute();

    $query = $db->prepare("DELETE FROM series WHERE id = :id");
    $query->bindParam(':id', $id);
    $query->execute();
    echo "<a href='/admin/panel/m-spanel' class='location' hidden></a>";
}
?>

<?php echo "<script>document.querySelector('.location').click()</script>"?>
