<?php
require 'config.php';

if(empty($_SESSION['id'])) {
    header('Location: login.php');
}

$user_id = $_SESSION['id'];

if (isset($_POST["submit"])) {
    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $description = $_POST["description"];

    $folder = 'images/'.$image_name;
    $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

    $allowed_extensions = array('jpg', 'jpeg', 'png', 'webp');

    if(in_array($image_ext, $allowed_extensions)) {
        if(move_uploaded_file($image_tmp, $folder)) {
            $stmt = mysqli_prepare($conn, "INSERT INTO posts (creator_id, image_path, description) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "iss", $user_id, $folder, $description);

            if(mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Image uploaded');</script>";
            } else {
                echo "<script>alert('Image not uploaded');</script>";
            }
    } else {
        echo "<script>alert('Format d'image incorrect.');</script>";
    }
} else {
    echo "<script>alert('Veuillez sélectionner une image');</script>";
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="upload.css">
    <title>Upload d'images</title>
</head>
<body>
    <div class="barrenav">
        <div class="SiteLogo">
            <a id="LienLogo" href="index.php"><img src="images\VagabondLogo.jpg" style="width: 100px; min-width: 33px;"></a>
        </div>
        <div>
            <a href="index.php">Accueil</a>
        </div>
        <div class ="BoutonRecherche">
            <form action="search.php" method="GET">
                <input type="search" name="search_space" placeholder="Rechercher un utilisateur..." required>
                <button type="submit">Chercher</button>
            </form>
        </div>
        <div>
            <a href="#">Créer</a>
        </div>
        <div class="BoutonProfil">
            <?php
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if (isset($_SESSION['id'])) {
                echo '<a href="profile.php?id=' . $_SESSION['id'] . '">Profil</a>';
            } else {
                echo '<a href="login.php">Se connecter</a>';
            }
            ?>
        </div>
    </div>
    <div class="upload-form">
        <form action ="" method="POST" enctype="multipart/form-data">
            <div class="Username">
                <center>
                    <a>UPLOAD D'IMAGES</a> 
                </center>
            <hr>
            </div>
            <div class="upload-elements">
                <input type="file" name="image"></input>
            </div>
            <div class="upload-elements" id="PostDescription">
                <input placeholder="Ajouter une description" type="text" name="description">
            </div>
            <div class="upload-elements">
                <input type="submit" value="Uploader l'image" name="submit"></input>
            </div>
        </form>
    </div>
</body>
</html>