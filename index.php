<?php
require('config.php');

if (isset($_COOKIE['page2'])) {
    unset($_COOKIE['page2']);
    setcookie('page2', '', time() - 3600, '/');
}
setcookie("page1", 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    $session_connecte = true;
}

$user_id = $_SESSION['id'] ?? null;

// ajoute les commentaires a la db
if (isset($_POST["submit_comment"])) {
    $comment = $_POST["comment"];
    $post_id = $_POST["post_id"];
    $user_id = $_SESSION['id'];
    
    $insert_comment = mysqli_prepare($conn, "INSERT INTO comments (comment, post_id, user_id) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($insert_comment, "sii", $comment, $post_id, $user_id);
    mysqli_stmt_execute($insert_comment);
    mysqli_stmt_close($insert_comment);
    
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel= "stylesheet" href="index.css">
    <title>Menu</title>
</head>

<body>
    <div class="barrenav">
        <div class="SiteLogo">
            <a id="LienLogo" href="#"><img src="images\VagabondLogo.jpg" style="width: 100px; min-width: 33px;"></a>
        </div>
        <div>
            <a href="#">Accueil</a>
        </div>
        <div class ="BoutonRecherche">
            <form action="search.php" method="GET">
                <input type="search" name="search_space" placeholder="Rechercher un utilisateur..." required>
                <button type="submit">Chercher</button>
            </form>
        </div>
        <div>
            <?php
            if (!$session_connecte = true) {
                echo '<a href="upload.php">Créer</a>';
            }
            ?>
        </div>
        <div class="BoutonProfil">
            <?php
            if (isset($_SESSION['id'])) {
                echo '<a href="profile.php?id=' . $_SESSION['id'] . '">Profil</a>';
            } else {
                echo '<a href="login.php">Connexion</a>';
            }
            ?>
        </div>
        <div>
            <?php
            if ($session_connecte = true) {
                echo '<a href="logout.php">Déconnexion</a>';
            }
            ?>
        </div>
    </div>

    <div class="gallery">
        <?php
            $load_posts = mysqli_prepare($conn,"SELECT posts.id AS post_id, posts.creator_id, posts.image_path, posts.description
             FROM posts 
             ORDER BY posts.id DESC");

            mysqli_stmt_execute($load_posts);
            $result_posts = mysqli_stmt_get_result($load_posts);

            // affiche les posts
            if (mysqli_num_rows($result_posts) > 0) {
                while ($row = mysqli_fetch_assoc($result_posts)) {
                    $post_id = $row['post_id'];
                    $creator_id = $row['creator_id'];
                    $image_path = htmlspecialchars($row['image_path'], ENT_QUOTES, 'UTF-8');
                    $description_post = $row['description'] ? htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8') : '';

                    // recupere l'utilisateur
                    $get_user = mysqli_prepare($conn, "SELECT username FROM users WHERE id = ?");
                    mysqli_stmt_bind_param($get_user, "i", $creator_id);
                    mysqli_stmt_execute($get_user);
                    $user_result = mysqli_stmt_get_result($get_user);
                    $user_row = mysqli_fetch_assoc($user_result);
                    $username = htmlspecialchars($user_row['username'], ENT_QUOTES, 'UTF-8');
                    mysqli_stmt_close($get_user);
                    
                    echo '<div class="publications">';
                    echo '    <div class="Username">';
                    echo '          <a href="profile.php?id=' . $creator_id . '">' . $username . '</a>';           
                    echo '    </div>';
                    echo '    <div class="Images">';
                    echo '        <a href="content.php?id=' . $post_id . '">';
                    echo '          <img src="' . $image_path . '" width="350" height="350" style="object-fit: cover;">';
                    echo '        </a>'; 
                    echo '    </div>';
                    echo '    <div class="BoutonsPosts">';
                    echo '        <a href="like_content.php?id=' . $post_id . '"><button>AIMER &#129655;</button></a>';
                    echo '        <a href="share.php?id=' . $post_id . '"><button>PARTAGER &#128227;</button></a>';
                    echo '    </div>';
                    echo '    <div class="Likes">';

                    // recupere les likes
                    $get_likes = mysqli_prepare($conn, "SELECT DISTINCT users.username FROM likes JOIN users ON users.id = likes.user_id WHERE likes.post_id = ? LIMIT 10");
                    mysqli_stmt_bind_param($get_likes, "i", $post_id);
                    mysqli_stmt_execute($get_likes);
                    $result_likes = mysqli_stmt_get_result($get_likes);

                    if (mysqli_num_rows($result_likes) > 0) {
                        $likers = [];
                        while ($like_row = mysqli_fetch_assoc($result_likes)) {
                            $likers[] = '@' . htmlspecialchars($like_row['username'], ENT_QUOTES, 'UTF-8');
                        }
                        
                        // affiche les likes
                        if (count($likers) > 0) {
                            echo '<p><strong>Aimé par : </strong>' . implode(', ', $likers);
                            
                            $count_likes = mysqli_prepare($conn, "SELECT COUNT(*) as total FROM likes WHERE post_id = ?");
                            mysqli_stmt_bind_param($count_likes, "i", $post_id);
                            mysqli_stmt_execute($count_likes);
                            $count_result = mysqli_stmt_get_result($count_likes);
                            $count_row = mysqli_fetch_assoc($count_result);
                            
                            // si ya plus de 10 likes on ecrit 'et n/a autres'
                            if ($count_row['total'] > 10) {
                                echo ' et ' . ($count_row['total'] - 10) . ' autres';
                            }
                            echo '</p>';
                            mysqli_stmt_close($count_likes);
                        }
                    } else {
                        echo '<p><strong>Aucun like pour le moment</strong></p>';
                    }
                    mysqli_stmt_close($get_likes);

                    echo '    </div>';
                    echo '    <div class="Description">';
                    echo '        <p>Description : ' . $description_post . '</p>';
                    echo '    </div>';
                    echo '    <div class="Commentaires">';
                    echo '        <form action="" method="POST">';
                    echo '            <input type="hidden" name="post_id" value="' . $post_id . '">';
                    echo '            <input type="search" placeholder="Publier un commentaire :" name="comment" required/>';
                    echo '            <button id="BoutonCommentaire" name="submit_comment">POSTER</button>';
                    echo '        </form>';
                    echo '    </div>';
                    echo '    <div class="EspaceCommentaires">';
                    
                    // charge les commentaires
                    $get_comments = mysqli_prepare($conn, "SELECT comments.comment, users.username FROM comments JOIN users ON users.id = comments.user_id WHERE comments.post_id = ?");
                    mysqli_stmt_bind_param($get_comments, "i", $post_id);
                    mysqli_stmt_execute($get_comments);
                    $result_comments = mysqli_stmt_get_result($get_comments);
                    
                    // affiche les commentaires
                    if (mysqli_num_rows($result_comments) > 0) {
                        while ($comment_row = mysqli_fetch_assoc($result_comments)) {
                            echo '<div class="Commentaire">';
                            echo '<p><strong>' . $comment_row['username'] . '</strong> : ' . htmlspecialchars($comment_row['comment']) . '</p>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>Aucun commentaire pour le moment.</p>';
                    }
                    mysqli_stmt_close($get_comments);
                    
                    echo '    </div>';
                    echo '</div>';
                }
            } else {
                echo "<label>Error loading the images</label>";
            }
            mysqli_stmt_close($load_posts);
        ?>
    </div>
</body>
</html>