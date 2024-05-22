<?php

if (!isAdmin()) {
    logout();
    header ("location:/home");
} else {
    function edit_user()
    {
        global $db;
        global $params;
        $id = $params[3];
        $query = $db->prepare("SELECT * FROM user WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if (isset($_POST['submit'])) {
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            $query = $db->prepare("UPDATE user SET first_name = :first_name, last_name = :last_name, email = :email, role = :role WHERE id = :id");
            $query->bindParam(':first_name', $first_name);
            $query->bindParam(':last_name', $last_name);
            $query->bindParam(':email', $email);
            $query->bindParam(':role', $role);
            $query->bindParam(':id', $id);
            $query->execute();
            header("Location: /admin/panel/userspanel");
        }
        return $result;
    }
}
?>
