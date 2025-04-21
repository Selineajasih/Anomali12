<?php
session_start();
include('db.php');

if(!isset($_SESSION['user']) || $_SERVER['REQUEST_METHOD'] != 'POST'){
    header("Location: index.php");
    exit;
}

$id      = intval($_POST['id']);
$comment = trim($_POST['comment']);
$rating  = intval($_POST['rating']);

// 1) Cek kepemilikan sebelum update
$stmt = $conn->prepare("SELECT user_id FROM comments WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($owner_id);
$stmt->fetch();
$stmt->close();

// 2) Jika pemilik cocok, lakukan update
if($owner_id == $_SESSION['user']['id']){
    $upd = $conn->prepare("UPDATE comments SET comment = ?, rating = ? WHERE id = ?");
    $upd->bind_param("sii", $comment, $rating, $id);
    if(!$upd->execute()){
        die("Gagal update komentar: " . $upd->error);
    }
    $upd->close();
}

// 3) Redirect kembali
header("Location: index.php");
exit;
