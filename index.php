<?php
session_start();
include('db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Joni Cleaner</title>

  <!-- Tailwind CSS -->
  <link rel="stylesheet" href="src/output.css" />
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="bg-blue-30 min-h-screen">
  <!-- NAVBAR -->
  <nav class="w-full bg-blue-50 bg-opacity-50 backdrop-blur-md fixed z-50 flex justify-between p-4 items-center top-0 shadow-cyan-300 shadow-2xl rounded-b-3xl">
    <div class="font-bold text-2xl">
      <span class="text-cyan-700">Joni Clean</span><span class="text-cyan-400">.</span>
    </div>

    <div class="text-sm text-cyan-950">
      <?php if (isset($_SESSION['user'])): ?>
        <span>Welcome, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>!</span>
        <!-- Button Logout -->
        <a href="logout.php" class="font-bold hover:underline ml-2 p-3 hover:text-red-600">Logout</a>
      <?php else: ?>
        <a href="login.php" class="border-2 border-transparent bg-cyan-950 p-3 text-white hover:bg-cyan-800 rounded-2xl font-semibold">Login</a>
        <a href="signup.php" class="border-2 border-cyan-950 p-3 hover:border-cyan-500 rounded-2xl hover:text-cyan-500 font-semibold">Sign Up</a>
      <?php endif; ?>
    </div>
  </nav>
  <!-- NAVBAR END -->


  <main class="mt-20 px-4 w-full">

    <!-- Banner -->
    <section class="text-center py-12 w-full">
      <h1 class="text-2xl font-semibold text-gray-700 md:text-4xl">Selamat Datang di Website<br>
      <span class="text-cyan-700 font-bold">Joni Clean</span><span class="text-cyan-400">.</span></h1>
      <p class="text-gray-600 mt-2 md:px-26 px-6 lg:px-32 md:text-base text-xs md:mt-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus hic iste, voluptatibus voluptatem provident facere dicta, sunt, consectetur quia totam sapiente quidem. Reprehenderit sint officia aliquid, similique, autem quia laboriosam ipsum nisi voluptatum iste natus?</p>

      <div class="w-full px-10 py-10 md:px-20 lg:px-40 flex justify-center items-center">
        <img src="assets/7426287.svg" alt="cleaner-image" class="">
      </div>
    </section>

    <!-- Services -->
    <section class="justify-center w-full">
      <h2 class="text-3xl font-semibold text-cyan-700 mb-4 w-full text-center">Layanan Kami</h2>

      <!-- container -->
      <div class="flex-col flex md:flex-row gap-4 justify-center w-full items-center">

        <!-- service option -->
        <div class=" p-6 shadow-xl rounded-2xl w-4/5 lg:w-1/3">
          <div class="font-bold text-cyan-500 text-center text-xl">
            Pantat Cleaning
          </div>
          <div class="font-normal text-xs text-black text-center my-2">
            Siyap membersihkan pantat dengan sangat bersih dan wangy.
          </div>
          <div class="text-center">
            <a 
              href="https://wa.me/6285945661386" 
              target="_blank" 
              class="inline-block bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-2 rounded-full text-xs font-semibold transition">
              WhatsApp Etmin
            </a>
          </div>
        </div>

        <!-- service option -->
        <div class=" p-6 shadow-xl rounded-2xl w-4/5 lg:w-1/3">
          <div class="font-bold text-cyan-500 text-center text-xl">
            Pantat Cleaning
          </div>
          <div class="font-normal text-xs text-black text-center my-2">
            Siyap membersihkan pantat dengan sangat bersih dan wangy.
          </div>
          <div class="text-center">
            <a 
              href="https://wa.me/6285945661386" 
              target="_blank" 
              class="inline-block bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-2 rounded-full text-xs font-semibold transition">
              WhatsApp Etmin
            </a>
          </div>
        </div>

        <!-- service option -->
        <div class=" p-6 shadow-xl rounded-2xl w-4/5 lg:w-1/3">
          <div class="font-bold text-cyan-500 text-center text-xl">
            Pantat Cleaning
          </div>
          <div class="font-normal text-xs text-black text-center my-2">
            Siyap membersihkan pantat dengan sangat bersih dan wangy.
          </div>
          <div class="text-center">
            <a 
              href="https://wa.me/6285945661386" 
              target="_blank" 
              class="inline-block bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-2 rounded-full text-xs font-semibold transition">
              WhatsApp Etmin
            </a>
          </div>
        </div>

      </div>
    </section>

    <!-- Comments -->
    <section class="py-8 mt-20">
      <h2 class="text-2xl font-semibold text-cyan-700 mb-4">Komentar</h2>

      <?php if (isset($_SESSION['user'])): ?>
        <form id="commentForm" method="POST" action="process_comment.php" onsubmit="return validateComment();" class="space-y-4">
          <textarea name="comment" id="comment" class="w-full p-2 border rounded" placeholder="Tulis komentar anda..."></textarea>
          <div>
            <label class="block mb-1">Rating:</label>
            <select name="rating" id="rating" class="border p-1 rounded w-full max-w-xs">
              <option value="">Pilih Rating</option>
              <option value="1">1 Bintang</option>
              <option value="2">2 Bintang</option>
              <option value="3">3 Bintang</option>
              <option value="4">4 Bintang</option>
              <option value="5">5 Bintang</option>
            </select>
          </div>
          <button type="submit" class="bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-2 rounded">Kirim Komentar</button>
        </form>
      <?php else: ?>
        <p class="text-gray-600">Anda harus login untuk mengirim komentar.</p>
      <?php endif; ?>

      <div class="mt-6 space-y-4">
        <?php
        $sql = "SELECT * FROM comments ORDER BY created_at DESC";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<div class='bg-white p-4 rounded shadow'>";
            echo "<strong>" . htmlspecialchars($row['username']) . "</strong> ";
            echo "(Rating: " . htmlspecialchars($row['rating']) . " Bintang)";
            echo "<p class='mt-2'>" . nl2br(htmlspecialchars($row['comment'])) . "</p>";
            echo "<small class='text-gray-500'>" . $row['created_at'] . "</small>";

            if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $row['user_id']) {
              echo "<div class='mt-2 text-sm'>";
              echo "<a href='edit_comment.php?id=" . $row['id'] . "' class='text-blue-600'>Edit</a> | ";
              echo "<a href='delete_comment.php?id=" . $row['id'] . "' class='text-red-600' onclick='return confirm(\"Hapus komentar ini?\");'>Delete</a>";
              echo "</div>";
            }

            echo "</div>";
          }
        } else {
          echo "<p class='text-gray-500'>Belum ada komentar.</p>";
        }
        ?>
      </div>
    </section>

  </main>

  <footer class="bg-cyan-800 text-white text-center py-4 mt-8">
    <p>&copy; 2025 MyWebsite. All rights reserved.</p>
  </footer>

  <script>
    function validateComment() {
      const comment = document.getElementById('comment').value;
      const rating = document.getElementById('rating').value;
      if (comment.trim() === '' || rating === '') {
        alert('Komentar dan rating harus diisi.');
        return false;
      }
      return true;
    }
  </script>

</body>
</html>
