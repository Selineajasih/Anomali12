<?php
// admin.php
session_start();
include('db.php');

// Proteksi: hanya admin yang boleh akses
if(!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin'){
    header('Location: index.php');
    exit;
}

// Jika ada perintah delete komentar
if(isset($_GET['delete_comment'])){
    $cid = intval($_GET['delete_comment']);
    $d = $conn->prepare("DELETE FROM comments WHERE id = ?");
    $d->bind_param("i", $cid);
    $d->execute();
    $d->close();
    header('Location: admin.php');
    exit;
}

// Ambil semua komentar
$comments = $conn->query("SELECT * FROM comments ORDER BY created_at DESC");

// Ambil semua user kecuali admin
$users = $conn->query("SELECT id, username, email, created_at FROM users
                       WHERE email <> 'jmacleaningservice@hotmail.com'
                       ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel – JMA Cleaning</title>
  <link rel="stylesheet" href="src/output.css">
</head>
<body class="bg-gray-50 min-h-screen p-6 font-sans">
  <h1 class="text-3xl font-bold text-cyan-700 mb-6">Admin Panel</h1>
  <a href="index.php" class="text-blue-500 hover:underline mb-4 inline-block">← Back to Home</a>

  <!-- Comments Table -->
  <section class="mb-12">
    <h2 class="text-2xl font-semibold mb-4">Manage Comments</h2>
    <table class="w-full bg-white rounded shadow-md">
      <thead>
        <tr class="bg-gray-200 text-left">
          <th class="p-2">User</th>
          <th class="p-2">Rating</th>
          <th class="p-2">Comment</th>
          <th class="p-2">Date</th>
          <th class="p-2">Action</th>
        </tr>
      </thead>
      <tbody>
      <?php while($c = $comments->fetch_assoc()): ?>
        <tr class="border-t">
          <td class="p-2"><?= htmlspecialchars($c['username']) ?></td>
          <td class="p-2"><?= htmlspecialchars($c['rating']) ?> ★</td>
          <td class="p-2"><?= nl2br(htmlspecialchars($c['comment'])) ?></td>
          <td class="p-2 text-sm text-gray-600"><?= $c['created_at'] ?></td>
          <td class="p-2">
            <a href="admin.php?delete_comment=<?= $c['id'] ?>"
               class="text-red-600 hover:underline"
               onclick="return confirm('Hapus komentar ini?')">
              Delete
            </a>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </section>

  <!-- Users Table -->
  <section>
    <h2 class="text-2xl font-semibold mb-4">Manage Customers</h2>
    <table class="w-full bg-white rounded shadow-md">
      <thead>
        <tr class="bg-gray-200 text-left">
          <th class="p-2">ID</th>
          <th class="p-2">Username</th>
          <th class="p-2">Email</th>
          <th class="p-2">Registered</th>
        </tr>
      </thead>
      <tbody>
      <?php while($u = $users->fetch_assoc()): ?>
        <tr class="border-t">
          <td class="p-2"><?= $u['id'] ?></td>
          <td class="p-2"><?= htmlspecialchars($u['username']) ?></td>
          <td class="p-2"><?= htmlspecialchars($u['email']) ?></td>
          <td class="p-2 text-sm text-gray-600"><?= $u['created_at'] ?></td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </section>
</body>
</html>
