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
</head>
<body>
  <h2>Edit Komentar Anda</h2>
  <form method="POST" action="update_comment.php">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <textarea name="comment" required><?php echo htmlspecialchars($oldComment); ?></textarea><br>
    <label>Rating:</label>
    <select name="rating" required>
      <option value="">Pilih Rating</option>
      <?php for($i=1; $i<=5; $i++): ?>
        <option value="<?php echo $i; ?>" <?php if($oldRating==$i) echo 'selected'; ?>>
          <?php echo $i; ?> Bintang
        </option>
      <?php endfor; ?>
    </select><br>
    <button type="submit">Update Komentar</button>
  </form>
  <p><a href="index.php">← Kembali ke Halaman Utama</a></p>
</body>
</html>
