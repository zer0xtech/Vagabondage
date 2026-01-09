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
        echo "<script> alert('Username is already used');</script>";
    }
    else{
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = mysqli_prepare($conn, "INSERT INTO users (username, password) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);
        mysqli_stmt_execute($stmt);

        echo "<script> alert('Registration successful');</script>";
        header("Location: login.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="login.css">
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

    <div class="login-form">
        <form action ="" method="POST">
            <div class="Images">
                <img src="images\VagabondLogo.jpg" witdh="100px"; height="250px">
            </div>
            <div class="form-inputs">
                <div class="UsernameInput">
                    <input type="text" name="username" placeholder="Username">
                </div>
                <div class="PasswordInput">
                    <input type="password" name="password" placeholder="Password">
                </div>
                <div class="SubmitInput">
                    <input type="submit" name="submit">
                </div>
            </div>
            <a href="login.php">Login</a>
        </form>
    </div>
</body>
</html>