<?php
// process_comment.php
session_start();
include('db.php');

// Cek apakah user sudah login
if(!isset($_SESSION['user'])){
    header("Location: index.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $comment = trim($_POST['comment']);
    $rating  = intval($_POST['rating']);
    
    if($comment === '' || $rating === 0){
        $_SESSION['message'] = "Comment and rating can’t be left empty, mate.";
        header("Location: index.php");
        exit;
    }

    $user_id  = $_SESSION['user']['id'];
    $username = $_SESSION['user']['username'];

    // Siapkan statement
    $stmt = $conn->prepare(
      "INSERT INTO comments (user_id, username, comment, rating) 
       VALUES (?, ?, ?, ?)"
    );
    $stmt->bind_param("issi", $user_id, $username, $comment, $rating);

    // Eksekusi sekali saja
    $success = $stmt->execute();

    if(!$success){
        // Jika gagal, hentikan dan tampilkan error (untuk debugging)
        die("Something went wrong while posting your comment: " . $stmt->error);
    }

    // Redirect setelah insert sukses
    $stmt->close();
    header("Location: index.php");
    exit;
}
?>
