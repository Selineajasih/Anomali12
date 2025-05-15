<?php
session_start();
include 'db.php';

$success = '';
$error   = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email     = trim($_POST['email']);
    $pass      = $_POST['password'];
    $pass2     = $_POST['password2'];

    // 1. validasi
    if(empty($email) || empty($pass) || empty($pass2)){
      $error = "All fields need to be filled out, mate.";
  } 
  else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $error = "That email doesn’t look quite right.";
  } 
  else if($pass !== $pass2){
      $error = "Passwords don’t match — give it another crack.";
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
              $success = "Password changed successfully.";
          } else {
              $error = "Couldn’t save the changes: " . $upd->error;
          }
          $upd->close();
          } else {
              $stmt->close();
              $error = "Email not found, check and try again.";
          }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <!-- Tailwind CSS -->
  <link rel="stylesheet" href="src/output.css" />
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />


  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>

</head>
<body class="min-h-screen">
  <!-- NAVBAR -->
  <nav class="w-full fixed z-50 flex justify-between p-4 items-center top-0">
  <div class="font-bold md:text-2xl text-lg">
      <span class="text-cyan-700">JMA Cleaning Services</span><span class="text-cyan-400">.</span>
    </div>
  </nav>
  <!-- NAVBAR END -->

  <main class="w-full min-h-screen items-center flex justify-center">
  <!-- CARD -->
    <div class="lg:w-1/3 md:w-4/5 w-4/5 shadow-2xl bg-white p-6 rounded-4xl">
      <div class="p-4 justify-self-center w-1/3">
        <img src="assets/forgot-pass.png" alt="pass icon" class="bg-white">
      </div>

      <h2 class="font-bold md:text-2xl text-xl text-center w-full md:mt-6 mt-2">Reset Password</h2>

      <?php if($success): ?>      
          <p class="success text-center md:text-base text-xs">
          <?= $success ?> Feel free to <a href='login.php' class="hover:underline text-blue-500 font-bold">log in</a> with your new password.
          </p>
      <?php else: ?>
        <?php if($error): ?>
          <p class="error text-center text-red-500"><?= $error ?></p>
        <?php endif; ?>

        <form method="POST" action="" class="space-y-4 mt-4">
          <input type="email" name="email" placeholder="Your Email" required class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">

          <!-- PASS 1  -->
          <div class="relative">
            <input id="password" type="password" name="password" placeholder="Password" required class="w-full p-3 border border-gray-300 rounded-md pr-12 focus:outline-none focus:ring-2 focus:ring-blue-400 " />
            <button type="button" onclick="togglePassword()" class="absolute top-2/3 right-3 transform -translate-y-1/2 text-gray-500 hover:text-blue-500">
              <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </button>
          </div>
          
          <!-- PASS 2  -->
          <div class="relative">
            <input id="password2" type="password" name="password2" placeholder="Repeat Password" required class="w-full p-3 border border-gray-300 rounded-md pr-12 focus:outline-none focus:ring-2 focus:ring-blue-400" />
            <button type="button" onclick="togglePassword2()" class="absolute top-2/3 right-3 transform -translate-y-1/2 text-gray-500 hover:text-blue-500">
              <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </button>
          </div>

          <!-- BUTTON  -->
          <div class="relative flex gap-2 mt-10">
            <a href="index.php" class="border-2 border-cyan-950 text-center p-3 w-full hover:border-cyan-700 rounded-2xl hover:text-cyan-700 font-semibold">Cancel</a>
            <button type="submit" class="border-2 border-transparent w-full bg-cyan-950 p-3 text-white hover:bg-cyan-800 rounded-2xl font-semibold">Reset</button>   
          </div>
        </form>
      <?php endif; ?>
    </div>
    <!-- CARD END  -->
  </main>

</body>
</html>

<script>
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
      } else {
        passwordInput.type = 'password';
      }
    }
    function togglePassword2() {
      const passwordInput2 = document.getElementById('password2');
      const eyeIcon2 = document.getElementById('eyeIcon2');
      if (passwordInput2.type === 'password') {
        passwordInput2.type = 'text';
      } else {
        passwordInput2.type = 'password';
      }
    }

  </script>