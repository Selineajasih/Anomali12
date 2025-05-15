<?php
// delete_account.php
session_start();
include('db.php');

// Pastikan user login
if(!isset($_SESSION['user'])){
    header('Location: index.php');
    exit;
}

$user_id = $_SESSION['user']['id'];

// Jika user men-submit form konfirmasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Hapus komentar user
    $stmt = $conn->prepare("DELETE FROM comments WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    // Hapus akun user
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        $stmt->close();
        session_destroy();
        header('Location: index.php');
        exit;
    } else {
        $error = "Failed to delete the account: " . $stmt->error;
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Konfirmasi Hapus Akun</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

<!-- CARD  -->
  <div class="bg-white p-8 rounded-2xl shadow-md text-center lg:rounded-4xl lg:w-1/3 w-4/5">
    <div class="w-full ">
      <i data-feather="trash-2" alt="trash-icon" class="text-red-500 w-full h-16"></i>
    </div>
    <h2 class="text-xl font-semibold mt-4">Are you sure you want to delete this Account?</h2>
    <?php if (isset($error)): ?>
      <p class="text-red-600 mt-4"><?php echo $error; ?></p>
    <?php endif; ?>

    <!-- Timer Display -->
    <p id="timerText" class=" text-gray-700">If you already delete this account, you can't login anymore. <br>
    <span id="timer" class="font-semibold">5</span> second...</p>

    <form method="POST" class="mt-6">
      <button id="confirmBtn" type="submit" disabled class="w-full px-4 py-2 bg-red-400 text-white rounded-lg opacity-50 cursor-not-allowed">
        Delete Account
      </button>
      <a href="index.php" class="inline-block mt-2 text-gray-600 hover:underline hover:text-black hover:font-semibold">Cancel</a>
    </form>
  </div>
  <!-- CARD END -->

  <script>
    // Timer sebelum tombol aktif
    let timeLeft = 5;
    const timerElem = document.getElementById('timer');
    const timerText = document.getElementById('timerText');
    const confirmBtn = document.getElementById('confirmBtn');

    const interval = setInterval(() => {
      timerElem.textContent = timeLeft;
      if (timeLeft <= 0) {
        clearInterval(interval);
        confirmBtn.disabled = false;
        confirmBtn.classList.remove('opacity-50', 'cursor-not-allowed', 'bg-red-400');
        confirmBtn.classList.add('bg-red-500');
        timerText.textContent = 'Click the button below if you already want to delete this account';
      }
      timeLeft--;
    }, 1000);
  </script>

  <script>
    feather.replace();
  </script>
</body>
</html>

