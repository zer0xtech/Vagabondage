<?php
require('config.php');

$pseudo = "utiliseur inconnu au bataillon";
$user_found = false;

if (isset($_GET['id'])) {
    $profil_id = intval($_GET['id']);

    $request_posts = mysqli_prepare($conn, "SELECT username FROM users WHERE id = ?");
    mysqli_stmt_bind_param($request_posts, "i", $profil_id);
    mysqli_stmt_execute($request_posts);
    $result = mysqli_stmt_get_result($request_posts);

    if (mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        $pseudo = htmlspecialchars($user_data['username']);
        $user_found = true;
    }
    else {
        header('Location: index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel= "stylesheet" href="profile.css">
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
            <form action="search.php" method="GET">
                <input type="search" name="search_space" placeholder="Rechercher un utilisateur..." required>
                <button type="submit">Chercher</button>
            </form>
        </div>
        <div>
            <?php
            if ($session_connecte = true) {
                echo '<a href="upload.php">Créer</a>';
            }
            ?>
        </div>
        <div class="BoutonProfil">
            <?php
            if (isset($_SESSION['id'])) {
                echo '<a href="profile.php?id=' . $_SESSION['id'] . '">Profil</a>';
            }
            ?>
        </div>
        <div>
            <?php
            if (!isset($_SESSION['id'])) {
                echo '<a href="register.php">Inscription</a>';
                echo '<a href="login.php">Connexion</a>';
            } else {
                echo '<a href="logout.php">Déconnexion</a>';
            }
            ?>
        </div>
    </div>

    <div class="gallery">
        <?php
        if ($user_found) {
            $posts_requests = mysqli_prepare($conn,"SELECT id, image_path, description FROM posts WHERE creator_id = ?");
            mysqli_stmt_bind_param($posts_requests, "i", $profil_id);
            mysqli_stmt_execute($posts_requests);
            $result_posts = mysqli_stmt_get_result($posts_requests);

            if (mysqli_num_rows($result_posts) > 0) {
                while ($row = mysqli_fetch_assoc($result_posts)) {
                    $image_path = $row['image_path'];
                    $post_id = $row['id'];
                    
                    echo '<div class="publications">';
                    echo '    <div class="Images">';
                    echo '        <a href="content.php?id=' . $post_id . '"><img src="' . $image_path . '" width="400" height="390" style="object-fit: cover;"></a>'; 
                    echo '    </div>';
                    echo '    <div class="BoutonsPosts">';
                    echo '        <a href="like_content.php?id=' . $post_id . '"><button>AIMER &#129655;</button></a>';
                    echo '        <a href="share.php?id=' . $post_id . '"><button>PARTAGER &#128227;</button></a>';
                    echo '    </div>';
                    echo '</div>';
                }
            } else {
                echo "<label>User has uploaded no images</label>";
            }
        } else {
            echo "<label>User does not exist</label>";
        }
        ?>
    </div>
</body>
</html>