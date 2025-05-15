<?php
// logout.php
session_start();
// Jika user sudah menekan konfirmasi
if(isset($_GET['confirm']) && $_GET['confirm'] === 'yes'){
    session_destroy();
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logout Confirmation</title>
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
  <div class="bg-white p-6 rounded-2xl shadow-md text-center">
    <div class="w-full flex justify-center h-16 items-center">
      <i data-feather="log-out" class="w-12 h-full text-red-500"></i>
    </div>
    <h2 class="text-xl font-semibold mt-4">Are you sure you want to logout?</h2>
    <div class="flex justify-center gap-2 mt-4 w-full">
      <a href="index.php" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-xl hover:bg-gray-400 w-full">No</a>
      <a href="logout.php?confirm=yes" class="px-4 py-2 bg-red-500 text-white rounded-xl hover:bg-red-600 w-full">Yes</a>
    </div>
    <div class="w-full mt-4">
      <a href="delete_account.php" class="hover:underline hover:font-semibold">Delete Account</a>
    </div>
  </div>
  <!-- CARD END -->

  <script>
    feather.replace();
  </script>

</body>
</html>
