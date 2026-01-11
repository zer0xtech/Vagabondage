<?php
require 'config.php';

if (!isset($_GET['search_space'])) {
    header('Location: index.php');
    exit();
}

$search = trim($_GET['search_space']);

$find_user = mysqli_prepare($conn,"SELECT id FROM users WHERE username = ? LIMIT 1");
mysqli_stmt_bind_param($find_user, "s", $search);
mysqli_stmt_execute($find_user);
$result = mysqli_stmt_get_result($find_user);

if ($user = mysqli_fetch_assoc($result)) {
    header('Location: profile.php?id=' . $user['id']);
    exit();
} else {
    header('Location: index.php');
}
?>
