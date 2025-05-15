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
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <title>Admin Panel – JMA Cleaning</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="bg-white min-h-screen text-gray-700">

  <main class="mx-auto p-8 pt-24">
  
    <!-- NAVBAR -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/70 backdrop-blur-md shadow-md">
      <div class="mx-auto flex justify-between items-center py-4 px-6">
        <div class="font-bold md:text-2xl text-lg text-cyan-700 ">
          Admin JMA Cleaning<span class="text-cyan-400">.</span>
        </div>
        <a href="index.php" class="text-cyan-700 font-semibold hover:text-cyan-900 hover:underline transition duration-300">
          Back to Home
        </a>
      </div>
    </nav>

    <!-- Comments Section -->
    <section class="mb-16 ">
      <h2 class="text-3xl font-semibold mb-4 inline-block ">
        Manage Comments
      </h2>

      <div class="overflow-x-auto rounded-xl shadow-lg bg-white ring-1 ring-gray-200">
        <table class="w-full table-auto border-collapse text-left">
          <thead class="bg-cyan-100 text-cyan-800 uppercase tracking-wide text-sm font-semibold select-none">
            <tr>
              <th class="p-5">User</th>
              <th class="p-5">Rating</th>
              <th class="p-5">Comment</th>
              <th class="p-5">Date</th>
              <th class="p-5">Action</th>
            </tr>
          </thead>
          <tbody>
          <?php while($c = $comments->fetch_assoc()): ?>
            <tr class="border-t border-gray-100 hover:bg-cyan-50 transition-colors duration-300 ease-in-out cursor-default select-text">
              <td class="p-5 font-semibold text-cyan-700"><?= htmlspecialchars($c['username']) ?></td>
              <td class="p-5 font-bold text-yellow-400 text-xl tracking-wide"><?= htmlspecialchars($c['rating']) ?> ★</td>
              <td class="p-5 whitespace-pre-wrap text-gray-800 leading-relaxed"><?= nl2br(htmlspecialchars($c['comment'])) ?></td>
              <td class="p-5 text-sm text-gray-500 font-mono"><?= $c['created_at'] ?></td>
              <td class="p-5">
                <a href="admin.php?delete_comment=<?= $c['id'] ?>"
                   class="inline-block px-3 py-1 rounded-md bg-red-100 text-red-600 font-semibold hover:bg-red-200 hover:text-red-800 transition"
                   onclick="return confirm('Hapus komentar ini?')">
                  Delete
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </section>

    <!-- Users Section -->
    <section>
      <h2 class="text-3xl font-semibold mb-4 inline-block">
        Customers Account
      </h2>
      <div class="overflow-x-auto rounded-xl shadow-lg bg-white ring-1 ring-gray-200">
        <table class="w-full table-auto border-collapse text-left">
          <thead class="bg-cyan-100 text-cyan-800 uppercase tracking-wide text-sm font-semibold select-none">
            <tr>
              <th class="p-5">ID</th>
              <th class="p-5">Username</th>
              <th class="p-5">Email</th>
              <th class="p-5">Registered</th>
            </tr>
          </thead>
          <tbody>
          <?php while($u = $users->fetch_assoc()): ?>
            <tr class="border-t border-gray-100 hover:bg-cyan-50 transition-colors duration-300 ease-in-out cursor-default select-text">
              <td class="p-5 font-mono text-gray-600"><?= $u['id'] ?></td>
              <td class="p-5 font-semibold text-cyan-700"><?= htmlspecialchars($u['username']) ?></td>
              <td class="p-5 text-blue-600 underline font-medium"><?= htmlspecialchars($u['email']) ?></td>
              <td class="p-5 text-sm text-gray-500 font-mono"><?= $u['created_at'] ?></td>
            </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </section>
  </main>

  <footer class="bg-cyan-800 text-white p-4 mt-8 flex items-center justify-between md:text-base text-xs">
      <p class="w-full">&copy; 2025 JMA Cleaning Services.</p>
      <div class="md:flex gap-2 text-white hidden">
        <i data-feather="mail"></i>
        <p class="">jmacleaningservice@hotmail.com</p>
      </div>
    </footer>

</body>
</html>
<script>
  feather.replace();
</script>