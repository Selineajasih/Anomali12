<?php
session_start();
include('db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>JMA Cleaning Services | Professional Cleaning Solutions in Perth</title>
<meta name="description" content="JMA Cleaning Services in Perth is here to tidy up your home or office with care and professionalism. Reliable Aussie cleaning solutions for locals.">



  <!-- Tailwind CSS -->
  <link rel="stylesheet" href="src/output.css" />
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>

  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="bg-blue-30 min-h-screen">
  <!-- NAVBAR -->
  <nav class="w-full bg-blue-50 bg-opacity-50 backdrop-blur-md fixed z-50 flex justify-between p-2 md:p-4 items-center top-0 shadow-cyan-300 shadow-2xl rounded-b-3xl">
    <div class="font-bold text-2xl sm:text-xl">
      <span class="text-cyan-700">JMA Cleaning Services</span><span class="text-cyan-400">.</span>
    </div>

    <div class="text-sm text-cyan-950 ">
      <?php if (isset($_SESSION['user'])): ?>
        <span class="hidden md:inline-block">Welcome, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>!</span>
        <!-- Button Logout -->
        <a href="logout.php" class="font-bold hover:underline ml-2 p-3 hover:text-red-600">Logout</a>
      <?php else: ?>
        <a href="login.php" class="border-2 border-transparent bg-cyan-950 p-2 px-3 md:p-3 md:px-4 text-white hover:bg-cyan-800 rounded-2xl font-semibold">Login</a>
        <a href="signup.php" class="border-2 border-cyan-950 p-2 px-3 md:p-3 md:px-4 hover:border-cyan-500 rounded-2xl hover:text-cyan-500 font-semibold">Sign Up</a>
      <?php endif; ?>
    </div>
  </nav>
  <!-- NAVBAR END -->


  <main class="mt-20 px-4 w-full">

    <!-- Banner -->
    <section class="text-center py-12 w-full">
      <h1 class="font-semibold text-gray-700 text-2xl md:text-4xl lg:text-5xl">Perth Cleaning Service<br>
        <span id="element" class="text-cyan-700 font-bold"></span>
      </h1>
      <p class="text-gray-600 mt-2 md:px-26 px-6 lg:px-32 md:text-base text-xs md:mt-5">Looking for a cleaning service in Perth that actually delivers? We’ve got you covered.

We provide high-quality, stress-free cleaning solutions for homes, hotels, and workplaces across the Perth metro area. Whether you need a regular house clean, a spotless hotel room turnaround, or a sparkling office environment — our friendly, reliable team is ready to make it shine.

Our cleaners are fully trained, police-checked, and show up on time (with all the gear, no worries). We use eco-friendly products that are safe for pets and people, but tough on dirt, dust, and grime.</p>

      <div class="w-full px-10 py-10 md:px-20 lg:px-40 flex justify-center items-center">
        <img src="assets/7426287.svg" alt="cleaner-image" class="">
      </div>
    </section>`
    <!-- Services -->
    <section class="justify-center w-full">
      <h2 class="text-xl md:text-2xl lg:text-3xl font-semibold text-cyan-700 mb-4 w-full text-center">Our Service</h2>

      <!-- container -->
      <div class="flex-col flex md:flex-row gap-4 justify-center w-full items-center">

        <!-- service option -->
        <div class=" p-6 shadow-xl rounded-2xl w-2/3 lg:w-1/4">
          <div class="font-bold text-cyan-500 text-center text-xl">
            Home Cleaning
          </div>
          <div class="font-normal text-xs text-black text-center my-2">
          We are ready to clean your house from end to end, creating a new home atmosphere.
          </div>
          <div class="text-center">
            <a 
              href="https://wa.me/6285945661386" 
              target="_blank" 
              class="inline-block bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-2 rounded-full text-xs font-semibold transition">
              Contact Us
            </a>
          </div>
        </div>

        <!-- service option -->
        <div class=" p-6 shadow-xl rounded-2xl w-2/3 lg:w-1/4">
          <div class="font-bold text-cyan-500 text-center text-xl">
            Office Cleaning
          </div>
          <div class="font-normal text-xs text-black text-center my-2">
          Clean your stuffy workplace to make it cleaner and more comfortable
          </div>
          <div class="text-center">
            <a 
              href="https://wa.me/6285945661386" 
              target="_blank" 
              class="inline-block bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-2 rounded-full text-xs font-semibold transition">
              Contact Us
            </a>
          </div>
        </div>

        <!-- service option -->
        <div class=" p-6 shadow-xl rounded-2xl w-2/3 lg:w-1/4">
          <div class="font-bold text-cyan-500 text-center text-xl">
            Hotel Cleaning
          </div>
          <div class="font-normal text-xs text-black text-center my-2">
          Clean the Hotel cleanly to make others comfortable with a clean situation
          </div>
          <div class="text-center">
            <a 
              href="https://wa.me/6285945661386" 
              target="_blank" 
              class="inline-block bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-2 rounded-full text-xs font-semibold transition">
              Contact Us
            </a>
          </div>
        </div>


      </div>
    </section>

    <!-- Comments -->
    <section class="py-8 mt-20">
      <h2 class="text-xl md:text-2xl lg:text-3xl font-semibold text-cyan-700 mb-4 sm:text-xl">Comment</h2>

      <?php if (isset($_SESSION['user'])): ?>
        <form id="commentForm" method="POST" action="process_comment.php" onsubmit="return validateComment();" class="space-y-4">
          <textarea name="comment" id="comment" class="w-full p-2 border rounded" placeholder="Write your comments..."></textarea>
          <div>
            <label class="block mb-1">Rating:</label>
            <select name="rating" id="rating" class="border p-1 rounded w-full max-w-xs">
              <option value="">Choose </option>
              <option value="1">1 Star</option>
              <option value="2">2 Star</option>
              <option value="3">3 Star</option>
              <option value="4">4 Star</option>
              <option value="5">5 Star</option>
            </select>
          </div>
          <button type="submit" class="bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-2 rounded">Send</button>
        </form>
      <?php else: ?>
        <p class="text-gray-600">You must be logged in to post comments/suggestions..</p>
      <?php endif; ?>

      <div class="mt-6 space-y-4">
        <?php
        $sql = "SELECT * FROM comments ORDER BY created_at DESC";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<div class='bg-white p-4 rounded shadow'>";
            echo "<strong>" . htmlspecialchars($row['username']) . "</strong> ";
            echo "(Rating: " . htmlspecialchars($row['rating']) . " Star)";
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

  <footer class="bg-cyan-800 text-white p-4 mt-8 flex items-center justify-between">
    <p class="w-full">&copy; 2025 JMA Cleaning Services.</p>
    <div class="flex gap-2 text-white">
      <i data-feather="mail"></i>
      <p class="">jmacleaningservice@hotmail.com</p>
    </div>
  </footer>

  <script>
    function validateComment() {
      const comment = document.getElementById('comment').value;
      const rating = document.getElementById('rating').value;
      if (comment.trim() === '' || rating === '') {
        alert('Comments and ratings must be filled in');
        return false;
      }
      return true;
    }

    var typed = new Typed('#element', {
    strings: [
      'Welcome to our Website',
      'Ready to clean your place',
      'JMA Cleaning Services<span class="text-cyan-400">.</span>'
    ],
    typeSpeed: 50,
    backSpeed: 25,
    loop: true
  });

  feather.replace();
    
  </script>
</body>
</html>
