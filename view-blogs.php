<?php
$show=$_GET["category"];
include 'db.php';
$fetch=$con->prepare("SELECT blogs.*,user.username AS name
 FROM blogs
INNER JOIN category
ON blogs.category_id=category.id
INNER JOIN user
ON blogs.user_id=user.id
WHERE category.id=:id AND status='approved'");
$fetch->bindParam(':id',$show);
$fetch->execute();
$blogs=$fetch->fetchall();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Blogs | My Blog Website</title>
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
        <li class="nav-item"><a class="nav-link active" href="view-blogs.php">Blogs</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Page Header -->
<div class="bg-light p-5 text-center shadow-sm">
  <h1 class="display-5 fw-bold">Browse Blogs</h1>
  <p class="lead">Explore approved blogs by category</p>
</div>

<!-- Blogs Section -->
<div class="container my-5">
  <div class="row">
    <?php if($blogs): ?>
      <?php foreach($blogs as $blog): ?>
        <div class="col-md-4 mb-4">
          <div class="card h-100 shadow-lg border-0">
            <div class="card-body">
              <h5 class="card-title"><?= $blog['title']; ?></h5>
              <p class="card-text"><?= substr($blog['description'], 0, 120); ?>...</p>
              <a href="single-blog.php?id=<?= $blog['id']; ?>" class="btn btn-primary">Read More</a>
            </div>
            <div class="card-footer text-muted">
              ✍️ <?= $blog['name']; ?> | 📅 <?= date('d M Y', strtotime($blog['created_at'])); ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="alert alert-warning">No blogs found for this category.</div>
    <?php endif; ?>
  </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center p-3 mt-5 shadow-sm">
  <p>&copy; <?= date('Y'); ?> My Blog Website. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

