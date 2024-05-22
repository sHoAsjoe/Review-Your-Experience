<?php
function checkLogin()
{
    if (isset($_POST['send'])) {
        global $db;
        $email = $_POST['email'];
        $password = $_POST['password'];
        $query = $db->prepare("SELECT * FROM user WHERE email = :email");
        $query->bindParam(':email', $email);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            if (password_verify($password, $result['password'])) {
                $_SESSION['user'] = $result;
                header("Location: home");
                return "<div class='alert alert-success' role='alert'>U bent ingelogd!</div>";
            } else {
                return "<div class='alert alert-danger' role='alert'>email of wachtwoord is onjuist!</div>";
            }
        } else {
            return "<div class='alert alert-danger' role='alert'>email of wachtwoord is onjuist!</div>";
        }
    }

}

function isAdmin():bool
{
    //controleer of er ingelogd is en de user de rol admin heeft
    if(isset($_SESSION['user'])&&!empty($_SESSION['user']))
    {
        $user=$_SESSION['user'];
        if ($user['role'] == "admin")
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    return false;
}

function isMember():bool
{
    //controleer of er ingelogd is en de user de rol admin heeft
    if(isset($_SESSION['user'])&&!empty($_SESSION['user']))
    {
        $user=$_SESSION['user'];
        if ($user['role'] === "member")
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    return false;
}

function makeRegistration()
{
    global $db;
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $password = $_POST['password'];
//    $profileImage = $_POST['file'];
    $role = 'member';
    $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
    $validateEmail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if ($validateEmail && !empty($password) && !empty($fname) && !empty($lname)) {
        $checkQuery = $db->prepare("SELECT * FROM user WHERE email = :email");
        $checkQuery->bindParam(':email', $validateEmail);
        $checkQuery->execute();
        $checkResult = $checkQuery->fetch(PDO::FETCH_ASSOC);
        if ($checkResult) {
            return 'EXIST';
        } else {
            if (isset($_FILES["file"]["name"]) && !empty($_FILES["file"]["name"])){
                $targetDirectory = "uploads/";  // Directory where you want to store the uploaded files
                $targetFile = $targetDirectory . basename($_FILES["file"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // Check file size (you can adjust the size limit as needed)
                if ($_FILES["file"]["size"] > 500000) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }

                // Allow only certain file formats (you can customize this list)
                $allowedFormats = array("jpg", "jpeg", "png", "gif");
                if (!in_array($imageFileType, $allowedFormats)) {
                    echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                } else {
                    // Move the file to the specified directory
                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
                        // File uploaded successfully, now store the file information in the database
                        $query = $db->prepare("INSERT INTO user (first_name, last_name, email, password, profile_pic, role) VALUES (:fname, :lname, :email, :password, :pimg, :role)");
                        $query->bindParam(':fname', $fname);
                        $query->bindParam(':lname', $lname);
                        $query->bindParam(':email', $validateEmail);
                        $query->bindParam(':password', $passwordHashed);
                        $query->bindParam(':pimg', $targetFile);
                        $query->bindParam(':role', $role);
                        $query->execute();
                        header("Location: login");
                        return 'SUCCESS';
                        echo "The file " . htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded and stored in the database.";
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            } else {
                $defaultPic = "uploads/default.jpg";
                $query = $db->prepare("INSERT INTO user (first_name, last_name, email, password, profile_pic, role) VALUES (:fname, :lname, :email, :password, :pimg, :role)");
                $query->bindParam(':fname', $fname);
                $query->bindParam(':lname', $lname);
                $query->bindParam(':email', $validateEmail);
                $query->bindParam(':password', $passwordHashed);
                $query->bindParam(':pimg', $defaultPic);
                $query->bindParam(':role', $role);
                $query->execute();
                header("Location: login");
            }
        }
    } else {
        return 'INCOMPLETE';
    }
}
