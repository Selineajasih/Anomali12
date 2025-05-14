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
  <link rel="stylesheet" href="src/output.css">
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="bg-white p-6 rounded shadow-md text-center">
    <h2 class="text-xl font-semibold mb-4">Are you sure you want to logout?</h2>
    <div class="flex justify-center gap-4 mb-4">
      <a href="logout.php?confirm=yes" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Yes</a>
      <a href="index.php" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">No</a>
    </div>
    <a href="delete_account.php" class="text-red-600 hover:underline">Delete Account</a>
  </div>
</body>
</html>
