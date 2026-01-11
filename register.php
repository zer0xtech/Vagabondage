<?php 
require 'config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    $session_connecte = true;
}

if(!empty($_SESSION['id'])) {
    header('Location: index.php');
}

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $duplicate = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($duplicate) > 0){
        echo "<label>('Username has already been used.');</label>";
    }
    else{
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $create_account = mysqli_prepare($conn, "INSERT INTO users (username, password) VALUES (?, ?)");
        mysqli_stmt_bind_param($create_account, "ss", $username, $hashed_password);
        mysqli_stmt_execute($create_account);

        header("Location: login.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="register.css">
    <title>Création compte</title>
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
            if (!$session_connecte = true) {
                echo '<a href="upload.php">Créer</a>';
            }
            ?>
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

    <div class="registration-form">
        <form action="" method="POST">
            <div class="Images">
                <img src="images\VagabondLogo.jpg"; height="250px">
            </div>
            <div class="Title">
                <center>
                    <a>CREER UN COMPTE</a> 
                </center>
            </div>
            <hr>
            <div class="register-elements">
                <input type="text" name="username" placeholder="Username">
            </div>
            <div class="register-elements">
                <input type="password" name="password" placeholder="Password">
            </div>
            <div class="register-elements">
                <input type="submit" name="submit" value="Créer un compte">
            </div>
        </form>
    </div>
</body>
</html>