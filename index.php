<?php
session_start();
include('db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Website Komersial</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Navbar -->
  <nav>
    <div class="logo">MyWebsite</div>
    <div class="nav-links">
      <?php if(isset($_SESSION['user'])): ?>
        <span>Welcome, <?php echo htmlspecialchars($_SESSION['user']['username']); ?></span>
        <a href="logout.php">Logout</a>
      <?php else: ?>
        <a href="login.php">Login</a>
        <a href="signup.php">Sign Up</a>
      <?php endif; ?>
    </div>
  </nav>

  <!-- Banner Section -->
  <section class="banner">
    <h1>Selamat Datang di Website Kami</h1>
    <p>Website komersial sederhana dengan layanan terbaik.</p>
  </section>

  <!-- Service Section -->
  <section class="services">
    <h2>Layanan Kami</h2>
    <div class="service-item">Service 1</div>
    <div class="service-item">Service 2</div>
    <div class="service-item">Service 3</div>
  </section>

  <!-- Comment Section -->
  <section class="comments">
    <h2>Komentar</h2>
    <?php if(isset($_SESSION['user'])): ?>
      <form id="commentForm" method="POST" action="process_comment.php" onsubmit="return validateComment();">
        <textarea name="comment" id="comment" placeholder="Tulis komentar anda..."></textarea>
        <div>
          <label>Rating: </label>
          <select name="rating" id="rating">
            <option value="">Pilih Rating</option>
            <option value="1">1 Bintang</option>
            <option value="2">2 Bintang</option>
            <option value="3">3 Bintang</option>
            <option value="4">4 Bintang</option>
            <option value="5">5 Bintang</option>
          </select>
        </div>
        <button type="submit">Kirim Komentar</button>
      </form>
    <?php else: ?>
      <p>Anda harus login untuk mengirim komentar.</p>
    <?php endif; ?>

    <!-- Menampilkan Komentar -->
    <div class="comment-list">
      <?php
      $sql = "SELECT * FROM comments ORDER BY created_at DESC";
      $result = $conn->query($sql);
      if($result && $result->num_rows > 0){
          while($row = $result->fetch_assoc()){
              echo "<div class='comment-item'>";
              echo "<strong>" . htmlspecialchars($row['username']) . "</strong> ";
              echo "(Rating: " . htmlspecialchars($row['rating']) . " Bintang)";
              echo "<p>" . nl2br(htmlspecialchars($row['comment'])) . "</p>";
              echo "<small>" . $row['created_at'] . "</small>";

              // Tombol Edit/Delete hanya untuk pemilik komentar
              if(isset($_SESSION['user']) && $_SESSION['user']['id'] == $row['user_id']){
                  echo "<div class='comment-actions'>";
                  echo "<a href='edit_comment.php?id=" . $row['id'] . "'>Edit</a> | ";
                  echo "<a href='delete_comment.php?id=" . $row['id'] . "' onclick='return confirm(\'Hapus komentar ini?\');'>Delete</a>";
                  echo "</div>";
              }

              echo "</div>";
          }
      } else {
          echo "Belum ada komentar.";
      }
      ?>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <p>&copy; 2025 MyWebsite. All rights reserved.</p>
  </footer>

  <script>
    function validateComment() {
      var comment = document.getElementById('comment').value;
      var rating = document.getElementById('rating').value;
      if(comment.trim() == '' || rating == ''){
        alert('Komentar dan rating harus diisi.');
        return false;
      }
      return true;
    }
  </script>
</body>
</html>