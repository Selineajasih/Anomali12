<?php
session_start();
include('db.php');

if(!isset($_SESSION['user']) || !isset($_GET['id'])){
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT comment, rating, user_id FROM comments WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($oldComment, $oldRating, $owner_id);

if(!$stmt->fetch() || $owner_id != $_SESSION['user']['id']){
    $stmt->close();
    header("Location: index.php");
    exit;
}
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Komentar</title>

   <!-- Tailwind CSS -->
   <link rel="stylesheet" href="src/output.css" />
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />


  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>

</head>
<body class="min-h-screen">

  <!-- NAVBAR -->
  <nav class="w-full fixed z-50 flex justify-between p-4 items-center top-0">
    <div class="font-bold text-2xl">
      <span class="text-cyan-700">Joni Clean</span><span class="text-cyan-400">.</span>
    </div>
  </nav>
  <!-- NAVBAR END -->


  <main class="flex justify-center min-h-screen items-center">
    
  <!-- CARD -->
  <div class="w-1/3 justify-self-center shadow-2xl rounded-4xl p-8 items-center">
    <!-- image  -->
    <div class=" justify-self-center w-1/3">
      <img src="assets/17294438.png" alt="">
    </div>

    <div class="font-bold text-3xl text-center w-full my-6">Edit Komentar Anda</div>
    
    <label class="font-semibold">Komentar</label>
    <form method="POST" action="update_comment.php">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <textarea name="comment" required class="w-full border-2 mt-2 border-gray-500 focus:border-cyan-400 p-2 rounded-xl"><?php echo htmlspecialchars($oldComment); ?></textarea>

    <div class="mt-2">
      <label class="font-semibold">Rating</label>
      <div class="flex gap-2">
        <?php for ($i = 1; $i <= 5; $i++): ?>
          <div class="flex">
              <input type="radio" name="rating" value="<?= $i ?>" class="hidden" <?= ($oldRating == $i) ? 'checked' : '' ?>>
              <i class="fa-star fa-regular text-yellow-400 text-2xl cursor-pointer hover:scale-110 transition duration-150"></i>
          </div>
        <?php endfor; ?>
      </div>
    </div>

    <!-- BUTTON  -->
    <div class="flex items-center gap-2 mt-6">
      <button class="border-2 border-cyan-950 p-3 w-full hover:border-cyan-700 rounded-2xl hover:text-cyan-700 font-semibold"><a href="index.php">Batal</a></button>
      <button type="submit" class="border-2 border-transparent w-full bg-cyan-950 p-3 text-white hover:bg-cyan-800 rounded-2xl font-semibold">Update Komentar</button>   
    </div>
    </form>
  </div>
  <!-- CARD END -->


  </main>

</body>
</html>

<script>
      const stars = document.querySelectorAll('input[name="rating"] + i');
      stars.forEach((star, index) => {
        star.addEventListener('click', () => {
          stars.forEach((s, i) => {
            const input = s.previousElementSibling;
            if (i <= index) {
              s.classList.remove('fa-regular');
              s.classList.add('fa-solid');
              input.checked = true;
            } else {
              s.classList.add('fa-regular');
              s.classList.remove('fa-solid');
            }
          });
        });
      });
    </script>