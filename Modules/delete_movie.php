<?php
    if (!isAdmin()) {
        logout();
        header ("location:/home");
    } else {
        global $db;
        global $params;
        $id = $params[5];

        $deleteChildQuery = $db->prepare("DELETE FROM categories_relation WHERE film_id = :id");
        $deleteChildQuery->bindParam(':id', $id);
        $deleteChildQuery->execute();

        $deleteChildQueryReview = $db->prepare("DELETE FROM film_review_relation WHERE film_id = :id");
        $deleteChildQueryReview->bindParam(':id', $id);
        $deleteChildQueryReview->execute();

        $query = $db->prepare("DELETE FROM film WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        echo "<a href='/admin/panel/m-spanel' class='location' hidden></a>";
    }
?>

<?php echo "<script>document.querySelector('.location').click()</script>"?>