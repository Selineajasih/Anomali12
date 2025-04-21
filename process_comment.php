<?php
// process_comment.php
session_start();
include('db.php');
// Cek apakah user sudah login dan terverifikasi
if(!isset($_SESSION['user'])){
    header("Location: index.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $comment = trim($_POST['comment']);
    $rating = intval($_POST['rating']);
    if(empty($comment) || empty($rating)){
        $_SESSION['message'] = "Komentar dan rating harus diisi.";
        header("Location: index.php");
        exit;
    }
    $user_id = $_SESSION['user']['id'];
    $username = $_SESSION['user']['username'];
    $stmt = $conn->prepare("INSERT INTO comments (user_id, username, comment, rating) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issi", $user_id, $username, $comment, $rating);
    if(!$stmt->execute()){
        die("Error saat insert komentar: " . $stmt->error);
    }
    if($stmt->execute()){
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['message'] = "Gagal mengirim komentar.";
        header("Location: index.php");
        exit;
    }
}

?>