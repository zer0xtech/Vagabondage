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
            $stmt = $conn->prepare("INSERT INTO posts (user_id, image_path, description) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $user_id, $folder, $description);

            if($stmt->execute()) {
                echo "<script>alert('img uploaded');</script>";
            } else {
                echo "<script>alert('img not uploaded');</script>";
            }
    } else {
        echo "<script>alert('Extension non autorisée. Formats acceptés : jpg, jpeg, png, gif, webp');</script>";
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
    <title>Document</title>
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
            <input type="search" placeholder="Miyamoto, chapitre 328..."/>
            <button>Chercher</button>
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
            <div class="form-inputs">
                <div class="AjouterFichier">
                    <input type="file" name="image"></input>
                </div>
                <div class="Description">
                    <input placeholder="Ajouter une description..." style="padding:10px" name="description"></input>
                </div>
                <div class="BoutonPublier">
                    <input type="submit" placeholder="Publier" name="submit"></input>
                </div>
            </div>
        </form>
    </div>
</body>
</html>