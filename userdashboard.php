<?php
session_start();
if($_SESSION["role"]!="user"){
    header("location:login.php");
    }
    include 'header.php';
    include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; }
    .sidebar { height: 100vh; background: #343a40; color: #fff; position: fixed; width: 220px; }
    .sidebar a { color: #adb5bd; text-decoration: none; display: block; padding: 12px; }
    .sidebar a:hover { background: #495057; color: #fff; }
    .content { margin-left: 220px; padding: 20px; }
    .navbar { margin-left: 220px; }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar p-3">
  <h4 class="text-white mb-4">User Panel</h4>
  <a href="userdashboard.php">🏠 Dashboard</a>
  <a href="create-blog.php">➕ Create Blog</a>
  <a href="my-blogs.php">📝 My Blogs</a>
  <!-- <a href="profile.php">👤 Profile</a> -->
</div>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <span class="navbar-brand">User Dashboard</span>
    <div class="d-flex">
      <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<!-- Content Area -->
<div class="content">
  <div class="container-fluid">
    <div class="row g-4">
      <!-- Stats Cards -->
       <?php
        $id=$_SESSION["user_id"];
        
        $fetch=$con->prepare("SELECT COUNT(*)
       FROM blogs WHERE user_id=$id");
       $fetch->execute();
       $total_my_blogs=$fetch->fetchcolumn();

       $fetch=$con->prepare("SELECT COUNT(*)
       FROM blogs WHERE user_id=$id AND status='approved'");
       $fetch->execute();
       $approved_my_blogs=$fetch->fetchcolumn();


      $fetch=$con->prepare("SELECT COUNT(*)
       FROM blogs WHERE user_id=$id AND status='pending'");
       $fetch->execute();
       $pending_my_blogs=$fetch->fetchcolumn();

      
      $fetch=$con->prepare("SELECT COUNT(*)
       FROM blogs WHERE user_id=$id AND status='rejected'");
       $fetch->execute();
       $rejected_my_blogs=$fetch->fetchcolumn();
 
        ?>

       <div class='col-md-3'><div class='card shadow-sm text-center'><div class='card-body'><h5>My Blogs</h5><p class='display-6'><?= $total_my_blogs ?></p></div></div></div>
      <div class="col-md-3"><div class="card shadow-sm text-center"><div class="card-body"><h5>Approved</h5><p class="display-6"><?= $approved_my_blogs ?></p></div></div></div>
      <div class="col-md-3"><div class="card shadow-sm text-center"><div class="card-body"><h5>Pending</h5><p class="display-6"><?= $pending_my_blogs ?></p></div></div></div>
      <div class="col-md-3"><div class="card shadow-sm text-center"><div class="card-body"><h5>Rejected</h5><p class="display-6"><?= $rejected_my_blogs ?></p></div></div></div>
    </div>

    <!-- Blogs Table -->
    <!-- <div class="card shadow-sm mt-4">
      <div class="card-header bg-secondary text-white"><h5 class="mb-0">My Blogs</h5></div>
      <div class="card-body">
        <table class="table table-bordered table-hover align-middle">
          <thead class="table-dark">
            <tr><th>ID</th><th>Title</th><th>Category</th><th>Status</th><th class="text-center">Action</th></tr>
          </thead>
          <tbody>
            <?php foreach($blogs as $blog): ?>
            <tr>
              <td><?= $blog['id'] ?></td>
              <td><strong><?= htmlspecialchars($blog['title']) ?></strong></td>
              <td><span class="badge bg-info"><?= htmlspecialchars($blog['category_name']) ?></span></td>
              <td>
                <?php if($blog['status']=="approved"): ?>
                  <span class="badge bg-success">Approved</span>
                <?php elseif($blog['status']=="pending"): ?>
                  <span class="badge bg-warning text-dark">Pending</span>
                <?php else: ?>
                  <span class="badge bg-danger">Rejected</span>
                <?php endif; ?>
              </td>
              <td class="text-center">
                <a href="edit-blog.php?id=<?= $blog['id'] ?>" class="btn btn-primary btn-sm">✏ Edit</a>
                <a href="delete-blog.php?id=<?= $blog['id'] ?>" class="btn btn-danger btn-sm">🗑 Delete</a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div> -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
