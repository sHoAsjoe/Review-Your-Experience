<?php
    if (!isAdmin()) {
        logout();
        header ("location:/home");
    } else {
        global $db;
        global $params;
        $id = $params[5];

        try {
            // Deleting child records
            $deleteChildQuery = $db->prepare("SELECT * FROM review WHERE user_id = :id");
            $deleteChildQuery->bindParam(':id', $id);
            $deleteChildQuery->execute();
            $result = $deleteChildQuery->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $data) {
                // Delete child records from related tables first
                $deleteChildQueryFilmReview = $db->prepare("DELETE FROM film_review_relation WHERE review_id = :review_id");
                $deleteChildQueryFilmReview->bindParam(':review_id', $data['id']);
                $deleteChildQueryFilmReview->execute();

                $deleteChildQuerySerieReview = $db->prepare("DELETE FROM review_serie_relation WHERE review_id = :review_id");
                $deleteChildQuerySerieReview->bindParam(':review_id', $data['id']);
                $deleteChildQuerySerieReview->execute();
            }

            $deleteQuery = $db->prepare("DELETE FROM review WHERE user_id = :id");
            $deleteQuery->bindParam(':id', $id);
            $deleteQuery->execute();

            // Now delete the user
            $query = $db->prepare("DELETE FROM user WHERE id = :id");
            $query->bindParam(':id', $id);
            $query->execute();

            header("Location: /admin/panel/userspanel");
            echo "<a href='/admin/panel/userspanel' class='location' hidden>Terug naar gebruikers paneel</a>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

    }
?>

<?php echo "<script>document.querySelector('.location').click()</script>"?>
