<?php
include 'db.php';
$ids=$_GET['id'];
$fetch=$con->prepare("SELECT blogs.*,user.username AS name
FROM blogs
INNER JOIN user
ON user.id=blogs.user_id
 WHERE blogs.id=$ids");
$fetch->execute();
$blog=$fetch->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $blog ? $blog['title'] : 'Blog Not Found'; ?> | My Blogs</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">My Blogs</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="view-blogs.php">Blogs</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Blog Content -->
<div class="container my-5">
  <?php if($blog): ?>
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card shadow-lg border-0">
  <?php if(!empty($blog['thumbnail'])): ?>
    <img src="<?= $blog['thumbnail']; ?>" 
         class="card-img-top" 
         alt="<?= htmlspecialchars($blog['title']); ?>" 
         style="max-height:350px; object-fit:cover;">
  <?php endif; ?>
  <div class="card-body p-5">
    <h1 class="card-title mb-3"><?= $blog['title']; ?></h1>
    <p class="text-muted mb-4">
      ✍️ By <strong><?= $blog['name']; ?></strong> | 
      📅 <?= date('d M Y', strtotime($blog['created_at'])); ?>
    </p>
    <hr>
    <p class="card-text fs-5 lh-lg"><?= nl2br($blog['description']); ?></p>
  </div>
</div>

        <div class="mt-4">
          <a href="index.php" class="btn btn-outline-secondary">← Back to Blogs</a>
        </div>
      </div>
    </div>
  <?php else: ?>
    <div class="alert alert-danger">Blog not found.</div>
  <?php endif; ?>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center p-3 mt-5 shadow-sm">
  <p>&copy; <?= date('Y'); ?> My Blog Website. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
