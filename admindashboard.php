<?php
session_start();
if($_SESSION["role"]!="admin"){
    header("location:login.php");
    }
    include 'header.php';
    include 'db.php';
    $id=$_SESSION["user_id"];
    $fetch=$con->prepare("SELECT * FROM user WHERE id=$id");
    $fetch->execute();
    $data=$fetch->fetch();

  ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <!-- Bootstrap CDN -->
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
  <h4 class="text-white mb-4">Admin Panel</h4>
  <a href="admindashboard.php">🏠 Dashboard</a>
  <a href="pending-blogs.php">📝 Approve Blogs</a>
  <!-- <a href="manage-users.php">👥 Manage Users</a> -->
  <a href="categories.php">📂 Categories</a>
  <!-- <a href="reports.php">📊 Reports</a> -->
</div>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <span class="navbar-brand">Welcome to <?=$data["username"];?></span>
    <div class="d-flex">
      <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<!-- Content Area -->
<div class="content">
  <div class="container-fluid">
    <div class="row g-4">
      <!-- Quick Stats Cards -->
      <div class="col-md-3">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <h5 class="card-title">👥 Users</h5>
            <?php $fetch=$con->prepare("SELECT COUNT(*) FROM user");
            $fetch->execute();
            $fetchs=$fetch->fetchcolumn();
            
           echo "<p class='display-6'>$fetchs</p>";
            ?>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <h5 class="card-title">📂 Categories</h5>
            <?php $fetch=$con->prepare("SELECT COUNT(*) FROM category");
            $fetch->execute();
            $fetchs=$fetch->fetchcolumn();
            echo"<p class='display-6'>$fetchs</p>";
            ?>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <h5 class="card-title">📝 Blogs</h5>
            <?php $fetch=$con->prepare("SELECT COUNT(*) FROM blogs WHERE status='approved'");
            $fetch->execute();
            $fetchs=$fetch->fetchcolumn();
            echo "<p class='display-6'>$fetchs</p>";
            ?>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <h5 class="card-title">⏳ Pending</h5>
             <?php $fetch=$con->prepare("SELECT COUNT(*) FROM blogs WHERE status='pending'");
            $fetch->execute();
            $fetchs=$fetch->fetchcolumn();
            echo "<p class='display-6'>$fetchs</p>";
            ?>
            
          </div>
        </div>
      </div>
    </div>

    
    <div class="card shadow-sm mt-4">
      <div class="card-header bg-secondary text-white">
        
        <h5 class="mb-0">Welcome, Admin</h5>
      </div>
      <div class="card-body">
        <p>This is your dashboard panel. Use the sidebar to navigate to different sections like Approve Blogs, Manage Users, Categories, and Reports.</p>
      </div>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
