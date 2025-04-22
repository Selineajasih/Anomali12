<?php
// login.php

session_start();
include('db.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // Ambil user berdasarkan email
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows == 1){
        $user = $result->fetch_assoc();

        if(password_verify($password, $user['password'])){
            // Login sukses
            $_SESSION['user'] = $user;
            header("Location: index.php");
            exit;
        } else {
            // Password salah → tampilkan error + link reset
            $error = "Password salah. <a href='forgot_password.php'>Reset Password</a>";
        }
    } else {
        $error = "Email tidak ditemukan.";
    }

    $stmt->close();
}
// end login logic
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Login</h2>

  <?php 
  // Tampilkan notifikasi pendaftaran/verifikasi
  if(isset($_SESSION['message'])) {
      echo "<p class='info'>".$_SESSION['message']."</p>";
      unset($_SESSION['message']);
  }
  // Tampilkan error jika ada
  if(!empty($error)){
      echo "<p class='error'>{$error}</p>";
  }
  ?>

  <form method="POST" action="">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Sign In</button>
  </form>

  <p>Belum punya akun? <a href="signup.php">Sign Up</a></p>
</body>
</html>
