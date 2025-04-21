<!DOCTYPE html>
<html>
<head>
  <title>Sign Up</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <h2>Sign Up</h2>
  <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
  <form method="POST" action="">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Sign Up</button>
  </form>
  <p>Sudah punya akun? <a href="login.php">Login</a></p>
</body>
</html>?>


<?php
// signup.php
session_start();
include('db.php');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    // Validasi sederhana
    if(empty($username) || empty($email) || empty($_POST['password'])){
        $error = "Semua field harus diisi.";
    } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "Alamat email tidak valid.";
    } else {
        // Insert ke database, verified default 0
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, verified) VALUES (?, ?, ?, 1).");
        $stmt->bind_param("sss", $username, $email, $password);
        if($stmt->execute()){
            // Simulasi pengiriman email verifikasi (pada implementasi nyata, kirim email)
            $user_id = $stmt->insert_id;
            $_SESSION['message'] = "Pendaftaran berhasil! silahkan login ulang" ;
            header("Location: login.php");
            exit;
        } else {
            $error = "Pendaftaran gagal. Coba lagi.";
        }
    }
}
