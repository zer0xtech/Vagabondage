<?php
require 'config.php';

if (isset($_COOKIE['page1'])) {
    unset($_COOKIE['page1']);
    setcookie('page1', '', time() - 3600, '/');
}
setcookie("page2", 2);

if(empty($_SESSION['id'])) {
    header('Location: login.php');
}

$user_id = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="content.css">
    <title>Contenu</title>
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
            <a href="upload.php">Créer</a>
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
    <div class="gallery">
        <?php
        $post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($post_id == 0) {
            header('Location: index.php');
            exit();
        }
        
        // recupere les infos des posts
        $load_post = mysqli_prepare($conn,"SELECT posts.id AS post_id, posts.creator_id, posts.image_path, posts.description FROM posts WHERE posts.id = ?");
        mysqli_stmt_bind_param($load_post, "i", $post_id);
        mysqli_stmt_execute($load_post);
        $result_post = mysqli_stmt_get_result($load_post);
        $row = mysqli_fetch_assoc($result_post);

        // def des variables
        $description_post = $row['description'];
        $creator_id = $row['creator_id'];
        $image_path = htmlspecialchars($row['image_path'], ENT_QUOTES, 'UTF-8');

        // recupere l'username
        $get_user = mysqli_prepare($conn, "SELECT username FROM users WHERE id = ?");
        mysqli_stmt_bind_param($get_user, "i", $creator_id);
        mysqli_stmt_execute($get_user);
        $user_result = mysqli_stmt_get_result($get_user);
        $user_row = mysqli_fetch_assoc($user_result);
        $username = $user_row['username'];
        mysqli_stmt_close($get_user);
        ?>
        <div class="publications">
            <div class="Images">
                <img src="<?php echo $image_path; ?>" width="400px"; height="405px">
            </div>
            <div class="Username">
                <a href="profile.php?id=<?php echo $creator_id; ?>">
                    <?php echo $username; ?>
                </a>
            </div>
            <div class="Description">
                <p><?php echo $description_post; ?></p>
            </div>
            <div class="LikeNShare">
                <?php
                echo '<a href="like_content.php?id=' . $post_id . '"><button>AIMER &#129655;</button></a>';
                echo '<a href="share.php?id=' . $post_id . '"><button>PARTAGER &#128227;</button></a>'
                ?>
            </div>
            <div class="Likes">
                <?php

                // recupere les likes
                $get_likes = mysqli_prepare($conn, "SELECT users.username FROM likes JOIN users ON users.id = likes.user_id WHERE likes.post_id = ? LIMIT 10");
                mysqli_stmt_bind_param($get_likes, "i", $post_id);
                mysqli_stmt_execute($get_likes);
                $result_likes = mysqli_stmt_get_result($get_likes);
                
                if (mysqli_num_rows($result_likes) > 0) {
                    $likers = [];
                    while ($like_row = mysqli_fetch_assoc($result_likes)) {
                        $likers[] = '@' . htmlspecialchars($like_row['username'], ENT_QUOTES, 'UTF-8');
                    }
                    
                    // affiche les likes si yen a
                    if (count($likers) > 0) {
                        echo '<p><strong>Aimé par : </strong>' . implode(', ', $likers);
                        
                        $count_likes = mysqli_prepare($conn, "SELECT COUNT(*) as total FROM likes WHERE post_id = ?");
                        mysqli_stmt_bind_param($count_likes, "i", $post_id);
                        mysqli_stmt_execute($count_likes);
                        $count_result = mysqli_stmt_get_result($count_likes);
                        $count_row = mysqli_fetch_assoc($count_result);
                        
                        // si plus de 10, on ecrit 'et N/A autres'
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
                ?>
            </div>
            <div class="Commentaires">
                <?php
                $post_id = $row['post_id'];

                if (isset($_POST["submit"])) {
                    $comment = $_POST["comment"];

                    // insert les commentaires dans la DB
                    $insert_comment = mysqli_prepare($conn, "INSERT INTO comments (comment, user_id, post_id) VALUES (?, ?, ?)");
                    mysqli_stmt_bind_param($insert_comment, "sii", $comment, $user_id, $post_id);
                    mysqli_stmt_execute($insert_comment);
                }
                ?>
                <form action="" method="POST">
                    <input type="search" placeholder="Publier un commentaire :" name="comment"/>
                    <button id="BoutonCommentaire" name="submit">POSTER</button>
                </form>
            </div>
            <div class="EspaceCommentaires">
                <?php

                // recupere tous les commentaires
                $get_comments = mysqli_prepare($conn, "SELECT comments.comment, users.username FROM comments JOIN users ON users.id = comments.user_id WHERE comments.post_id = ?");
                mysqli_stmt_bind_param($get_comments, "i", $post_id);
                mysqli_stmt_execute($get_comments);
                $result_comments = mysqli_stmt_get_result($get_comments);

                // affiche les commentaires si yen a
                if (mysqli_num_rows($result_comments) > 0) {
                    while ($comment_row = mysqli_fetch_assoc($result_comments)) {
                        echo '<div class="Commentaire">';
                        echo '<p>' . $comment_row['username'] . ' : ' . ($comment_row['comment']) . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>Aucun commentaire pour le moment.</p>';
                }
                ?>
                </div>
            </div>
        </div>
</body>
</html>