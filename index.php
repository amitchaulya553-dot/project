<?php
include 'db.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Blog Website</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">My Blogs</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php">Blogs</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="registration.php">Register</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<div class="bg-light p-5 text-center">
  <h1 class="display-4">Welcome to My Blog</h1>
  <p class="lead">Discover the latest approved blogs from our authors</p>
</div>

<!-- Category Search -->
<div class="container my-4">
  <form method="GET" action="view-blogs.php" class="row g-3">
    <div class="col-md-6">
      <select name="category" class="form-select">
        <option value="">-- Select Category --</option>
        <?php
        $fetch=$con->prepare("SELECT * FROM category ORDER BY category_name ASC");
        $fetch->execute(); 
        $fetchs=$fetch->fetchall();       
        ?>
        <?php foreach($fetchs as $row){
            echo "<option value='{$row['id']}'>{$row['category_name']}</option>";

        }
        ?>
      </select>
    </div>
    
    <div class="col-md-2">
      <button type="submit"class="btn btn-primary w-100">Search</button>
    </div>
  </form>
</div>

<!-- Latest Blogs -->
<div class="container my-5">
  <h2 class="mb-4">Latest Blogs</h2>
  <div class="row">
    <?php
    $all=$con->prepare ( "SELECT * FROM blogs WHERE status='approved'ORDER BY created_at DESC LIMIT 6");
    $all->execute();
    $alls=$all->fetchall();?>
    <?php foreach($alls as $dat): ?>
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title"><?= $dat['title']; ?></h5>
            <p class="card-text"><?= substr($dat['description'], 0, 100); ?>...</p>
            <a href="single-blog.php?id=<?= $dat['id']; ?>" class="btn btn-primary">Read More</a>
          </div>
          
        </div>
      </div>
      <?php endforeach; ?>
    
  </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center p-3">
  <p>&copy; <?= date('Y'); ?> My Blog Website. All rights reserved.</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>