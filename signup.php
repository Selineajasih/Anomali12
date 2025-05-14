<?php
// signup.php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // 1. Validasi field
    if (empty($username) || empty($email) || empty($password)) {
        $error = "Semua field harus diisi.";
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid.";
    }
    else {
        // 2. Cek duplikat email
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();
        if ($check->num_rows > 0) {
            $error = "email already exist, please <a href='login.php' class='text-blue-500 underline'>login</a>.";
            $check->close();
        } else {
            $check->close();
            // 3. Simpan user
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, verified) VALUES (?, ?, ?, 1)");
            $stmt->bind_param("sss", $username, $email, $hash);
            if ($stmt->execute()) {
                $_SESSION['message'] = "create account succes, please log in again";
                header("Location: login.php");
                exit;
            } else {
                $error = "Pendaftaran gagal: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up</title>
  <link rel="stylesheet" href="src/output.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-blue-50 flex justify-center items-center min-h-screen px-4">
  <div class="xl:w-5/6 md:w-5/6 rounded-4xl flex items-center justify-between min-h-[600px] p-8 overflow-hidden shadow-2xl bg-cover bg-center" style="background-image: url('assets/abstract-triangle.jpg');">
    
    <!-- Sign Up Form -->
    <div class="bg-white p-8 rounded-4xl shadow-lg w-full md:w-full lg:w-1/2 h-full">
      <!-- Error Message -->
      <?php if(isset($error)): ?>
        <p class="mb-4 text-red-600"><?= $error ?></p>
      <?php endif; ?>

      <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-center mb-6 text-cyan-500">Create Account</h1>
      <form method="POST" action="" class="space-y-4">
        <div>
          <input type="text" name="username" placeholder="Username" required
                 value="<?= isset($username)?htmlspecialchars($username):'' ?>"
                 class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" />
        </div>
        <div>
          <input type="email" name="email" placeholder="Email" required
                 value="<?= isset($email)?htmlspecialchars($email):'' ?>"
                 class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" />
        </div>
        <div class="relative">
          <input id="password" type="password" name="password" placeholder="Password" required
                 class="w-full p-3 border border-gray-300 rounded-md pr-12 focus:outline-none focus:ring-2 focus:ring-blue-400" />
          <button type="button" onclick="togglePassword()" 
                  class="absolute top-1/2 right-3 transform -translate-y-1/2 text-gray-500 hover:text-blue-500">
            <!-- eye icon -->
            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 
                       7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
          </button>
        </div>
        <div>
          <button type="submit" class="w-full bg-cyan-700 text-white p-3 rounded-md hover:bg-cyan-900 transition">
            Sign Up
          </button>
        </div>
      </form>

      <p class="block lg:hidden mt-4 text-center text-sm">
        Already have an account? <a href="login.php" class="text-blue-500 hover:underline">Sign In</a>
      </p>
    </div>
    <!-- end sign up -->

    <!-- Side Info -->
    <div class="hidden lg:block w-1/2 bg-cover bg-center rounded-l-4xl">
      <div class="p-8">
        <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-center mb-6 text-cyan-900">Hello, Customer!</h1>
        <p class="font-normal text-center mb-6 text-cyan-900">
          To keep connected with us please login with your personal info
        </p>
        <div class="flex justify-center">
          <a href="login.php" class="block text-center w-1/2 border-2 border-cyan-900 text-cyan-900 p-3 rounded-full hover:bg-cyan-900 hover:text-white transition">
            Sign In
          </a>
        </div>
      </div>
    </div>
    <!-- end side info -->

  </div>

  <script>
    function togglePassword() {
      const pwd = document.getElementById('password');
      pwd.type = pwd.type === 'password' ? 'text' : 'password';
    }
  </script>
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
</script>
