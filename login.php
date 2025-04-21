<?php
// login.php
session_start();
include('db.php');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 1){
        $user = $result->fetch_assoc();
        if(password_verify($password, $user['password'])){
            $_SESSION['user'] = $user;
            header("Location: index.php");
            exit;
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Email tidak ditemukan.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <h2>Login</h2>
  <?php 
  if(isset($_SESSION['message'])) {
      echo "<p style='color:green;'>".$_SESSION['message']."</p>";
      unset($_SESSION['message']);
  }
  if(isset($error)) echo "<p style='color:red;'>$error</p>"; 
  ?>
  <form method="POST" action="">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>
  <p>Belum punya akun? <a href="signup.php">Sign Up</a></p>
</body>
</html>
