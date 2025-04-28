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
            $error = 'Wrong password. <a href="forgot_password.php" class="font-bold hover:underline text-center">Reset Password</a>';
        }
    } else {
        $error = "Email not found.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Sign In</title>
  <link rel="stylesheet" href="src/output.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>

<body class="bg-blue-50 flex justify-center items-center min-h-screen px-4">

  <!-- main container -->
  <div class="xl:w-5/6 md:w-5/6 rounded-4xl flex items-center justify-between min-h-[600px] p-8 overflow-hidden shadow-2xl bg-cover bg-center" style="background-image: url('assets/abstract-triangle.jpg');">

    <!-- form login -->
    <div class="bg-white p-8 rounded-4xl shadow-lg w-full md:w-full lg:w-1/2 h-full">

      <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-center text-cyan-500">Sign in</h1>

      <!-- alert / error message -->
      <?php 
      if (isset($_SESSION['message'])) {
          echo "<p style='color:green;' class='text-center'>".$_SESSION['message']."</p>";
          unset($_SESSION['message']);
      }
      if (isset($error)) echo "<p style='color:red;' class='text-center'>$error</p>";
      ?>
      <!-- end alert -->
      
      <form method="POST" action="" class="space-y-4 mt-4">
        <div>
          <input type="text" name="email" placeholder="Email" required class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" />
        </div>
        <div class="relative">
          <input id="password" type="password" name="password" placeholder="Password" required class="w-full p-3 border border-gray-300 rounded-md pr-12 focus:outline-none focus:ring-2 focus:ring-blue-400" />
          <button type="button" onclick="togglePassword()" class="absolute top-2/3 right-3 transform -translate-y-1/2 text-gray-500 hover:text-blue-500">
            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
          </button>
        </div>
        <div>
          <button type="submit" class="w-full bg-cyan-700 text-white p-3 rounded-md hover:bg-cyan-900 transition">Sign In</button>
        </div>
      </form>

      <p class="block lg:hidden mt-4 text-center text-sm">
        Don't have an account? <a href="signup.php" class="text-blue-500 font-bold hover:underline">Sign Up</a>
      </p>
    </div>
    <!-- end form -->

    <!-- side info -->
    <div class="hidden lg:block w-1/2 bg-cover bg-center rounded-l-4xl">
      <div>
        <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-center mb-6 text-cyan-900">Welcome Back!</h1>
        <p class="font-normal shadow-2xl text-center mb-6 text-cyan-900">
          Click the bottom below for create an account.
        </p>
        <div class="flex justify-center">
          <a href="signup.php" class="block text-center w-1/2 bg-transparent border-cyan-900 border-2 text-cyan-900 p-3 rounded-full hover:bg-cyan-900 hover:text-white transition">
            Sign Up
          </a>
        </div>
      </div>
    </div>
    <!-- end side info -->

  </div>
  <!-- end container -->

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
  </script>

</body>
</html>