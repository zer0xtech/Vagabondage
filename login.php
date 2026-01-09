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
    
    $login_request = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
    mysqli_stmt_bind_param($login_request, "s", $username);
    mysqli_stmt_execute($login_request);
    $result = mysqli_stmt_get_result($login_request);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row["password"])) {
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];
            header("Location: index.php");
            exit();
        }
        else {
            echo "<script> alert('Incorrect password'); </script>"; 
        }
    }
    else {
        echo "<script> alert('User not registered'); </script>";
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
            <a href="register.php">Créer un compte</a>
        </div>
    </div>

    <div class="login-form">
        <form action ="" method="POST">
            <div class="Images">
                <img src="images\VagabondLogo.jpg" witdh="100px"; height="150px">
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
            <a href="register.php">Register</a>
        </form>
    </div>
</body>
</html>