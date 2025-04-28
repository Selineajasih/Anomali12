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
        $_SESSION['message'] = "Comment and rating can’t be left empty, mate.";
        header("Location: index.php");
        exit;
    }

    $user_id = $_SESSION['user']['id'];
    $username = $_SESSION['user']['username'];

    $stmt = $conn->prepare("INSERT INTO comments (user_id, username, comment, rating) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issi", $user_id, $username, $comment, $rating);

    if(!$stmt->execute()){
        die("Something went wrong while posting your comment: " . $stmt->error);
    }

    if($stmt->execute()){
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['message'] = "Couldn’t submit your comment. Give it another go.";
        header("Location: index.php");
        exit;
    }
}


?>