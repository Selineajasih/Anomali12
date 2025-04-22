<?php
session_start();
include 'db.php';

$success = '';
$error   = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email     = trim($_POST['email']);
    $pass      = $_POST['password'];
    $pass2     = $_POST['password2'];

    // 1. Validasi
    if(empty($email) || empty($pass) || empty($pass2)){
        $error = "Semua field harus diisi.";
    } 
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "Format email tidak valid.";
    } 
    else if($pass !== $pass2){
        $error = "Password dan konfirmasi tidak sama.";
    } 
    else {
        // 2. Cek apakah email terdaftar
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows === 1){
            $stmt->bind_result($user_id);
            $stmt->fetch();
            $stmt->close();

            // 3. Update password
            $newHash = password_hash($pass, PASSWORD_DEFAULT);
            $upd = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $upd->bind_param("si", $newHash, $user_id);

            if($upd->execute()){
                $success = "Password berhasil diubah. Silakan <a href='login.php'>login</a> dengan password baru Anda.";
            } else {
                $error = "Gagal menyimpan perubahan: " . $upd->error;
            }
            $upd->close();
        } else {
            $stmt->close();
            $error = "Email tidak ditemukan.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* Sedikit styling tambahan */
    body { font-family: Arial; padding: 20px; max-width: 400px; margin: auto; }
    h2 { margin-bottom: 1rem; }
    input { width: 100%; padding: 8px; margin: 6px 0; }
    button { padding: 10px 20px; margin-top: 10px; background: #ff4b2b; color: white; border: none; cursor: pointer; }
    .error { color: red; }
    .success { color: green; }
    a { color: #0066cc; text-decoration: none; }
  </style>
</head>
<body>

  <h2>Reset Password</h2>

  <?php if($success): ?>
    <p class="success"><?= $success ?></p>
  <?php else: ?>
    <?php if($error): ?>
      <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" action="">
      <input type="email" name="email" placeholder="Email Anda" required>
      <input type="password" name="password" placeholder="Password Baru" required>
      <input type="password" name="password2" placeholder="Konfirmasi Password" required>
      <button type="submit">Reset Password</button>
    </form>
  <?php endif; ?>

</body>
</html>
