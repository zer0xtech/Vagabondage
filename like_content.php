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

$check_like = mysqli_prepare($conn,"SELECT id FROM likes WHERE user_id = ? AND post_id = ?");
mysqli_stmt_bind_param($check_like, "ii", $user_id, $post_id);
mysqli_stmt_execute($check_like);
$result = mysqli_stmt_get_result($check_like);

if (mysqli_num_rows($result) === 0) {
    $insert_like = mysqli_prepare($conn,"INSERT INTO likes (user_id, post_id) VALUES (?, ?)");
    mysqli_stmt_bind_param($insert_like, "ii", $user_id, $post_id);
    mysqli_stmt_execute($insert_like);
}
if(isset($_COOKIE['page1'])) {
    header('Location: index.php');
} else {
    header('Location: content.php?id=' . $post_id);
}
