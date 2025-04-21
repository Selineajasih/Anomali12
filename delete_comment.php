<?php
session_start();
include('db.php');

if(!isset($_SESSION['user'])){
    header("Location: index.php");
    exit;
}

if(isset($_GET['id'])){
    $id = intval($_GET['id']);

    // 1) Cek kepemilikan komentar
    $stmt = $conn->prepare("SELECT user_id FROM comments WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($owner_id);
    $stmt->fetch();
    $stmt->close();  // <-- Tutup statement sekali saja

    // 2) Jika pemilik cocok, lakukan delete
    if($owner_id == $_SESSION['user']['id']){
        $del = $conn->prepare("DELETE FROM comments WHERE id = ?");
        $del->bind_param("i", $id);
        if(!$del->execute()){
            die("Gagal menghapus komentar: " . $del->error);
        }
        $del->close();
    }
}

header("Location: index.php");
exit;
?>
