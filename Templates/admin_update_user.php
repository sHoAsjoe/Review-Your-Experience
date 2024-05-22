<?php
    include ('../Modules/edit_user.php');
    $user = edit_user();
?>

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
    <br>
        <div class="container-fluid">
            <h1 class="text-center">Gebruiker aanpassen</h1>
            <a href="/admin/panel" class="text-warning"><i class="bi bi-arrow-return-left"></i>Terug gaan naar paneel</a>
            <br><br>
            <form method="post">
                <label for="first_name">First name</label>
                <input type="text" class="form-control" name="first_name" value="<?php echo $user['first_name'] ?>" required>
                <br>
                <label for="last_name">Last name</label>
                <input type="text" class="form-control" name="last_name" value="<?php echo $user['last_name'] ?>" required>
                <br>
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo $user['email'] ?>" required>
                <br>
                <label for="role">Role</label>
                <select class="form-select" name="role" required>
                    <option value="member" <?php if ($user['role'] == 'member') echo 'selected' ?>>Member</option>
                    <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected' ?>>Admin</option>
                </select>
                <br><br>
                <button type="submit" class="btn btn-warning" name="submit">Aanpassen</button>
            </form>
        </div>
    </body>
<?php include_once ('defaults/footer.php') ?>
</html>
