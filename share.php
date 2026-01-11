<?php
require 'config.php';

if(empty($_SESSION['id'])) {
    header('Location: login.php');
}

$user_id = $_SESSION['id'];

$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($post_id == 0) {
    header('Location: index.php');
    exit();
}

$stmt = mysqli_prepare($conn, "SELECT image_path, description FROM posts WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $post_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$post = mysqli_fetch_assoc($result);
$original_image = $post['image_path'];
$original_description = $post['description'];
mysqli_stmt_close($stmt);

if (isset($_POST["submit"])) {
    $description = $_POST["description"];
    
    $insert_stmt = mysqli_prepare($conn, "INSERT INTO posts (creator_id, image_path, description) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($insert_stmt, "iss", $user_id, $original_image, $description);
    
    if(mysqli_stmt_execute($insert_stmt)) {
        header('Location: index.php');
    } else {
        echo "<script>alert('Image not uploaded');</script>";
    }
    mysqli_stmt_close($insert_stmt);
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
                    <a>REUPLOAD D'IMAGES</a> 
                </center>
            <hr>
            </div>
            <div class="upload-elements" id="PostDescription">
                <input placeholder="Ajouter une description" type="text" name="description">
            </div>
            <div class="upload-elements">
                <input type="submit" value="Re-uploader l'image" name="submit"></input>
            </div>
        </form>
    </div>
</body>
</html>