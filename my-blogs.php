<?php
session_start();
if($_SESSION["role"]!="user"){
    header("location:login.php");
    exit();
}
include 'header.php';
include 'db.php';

// Fetch user blogs
$fetch = $con->prepare("SELECT blogs.*, category.category_name 
                        FROM blogs 
                        INNER JOIN category ON blogs.category_id=category.id 
                        WHERE user_id=:user_id");
$fetch->bindParam(':user_id', $_SESSION['user_id']);
$fetch->execute();
$blogs = $fetch->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Blogs</title>
  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; }
    .sidebar { height: 100vh; background: #343a40; color: #fff; position: fixed; width: 220px; }
    .sidebar a { color: #adb5bd; text-decoration: none; display: block; padding: 12px; }
    .sidebar a:hover { background: #495057; color: #fff; }
    .content { margin-left: 220px; padding: 20px; }
    .navbar { margin-left: 220px; }
    .table-hover tbody tr:hover { background-color: #f1f1f1; }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar p-3">
  <h4 class="text-white mb-4">User Panel</h4>
  <a href="userdashboard.php">🏠 Dashboard</a>
  <a href="create-blog.php">➕ Create Blog</a>
  <a href="my-blogs.php" class="bg-primary text-white rounded">📝 My Blogs</a>
</div>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <span class="navbar-brand">My Blogs</span>
    <div class="d-flex">
      <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<!-- Content Area -->
<div class="content">
  <div class="container-fluid">
    <div class="card shadow-sm">
      <div class="card-header bg-secondary text-white">
        <h5 class="mb-0">📝 My Blogs</h5>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-hover align-middle">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Category</th>
              <th>Status</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($blogs as $row): ?>
            <tr>
              <td><?= htmlspecialchars($row['id']) ?></td>
              <td><strong><?= htmlspecialchars($row['title']) ?></strong></td>
              <td><span class="badge bg-info"><?= htmlspecialchars($row['category_name']) ?></span></td>
              <td>
                <?php if($row['status'] == 'pending'): ?>
                  <span class="badge bg-warning text-dark">Pending</span>
                <?php elseif($row['status'] == 'approved'): ?>
                  <span class="badge bg-success">Approved</span>
                <?php else: ?>
                  <span class="badge bg-danger">Rejected</span>
                <?php endif; ?>
              </td>
              <td class="text-center">
                <a href="edit-blog.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-warning">✏️ Edit</a>
                <a href="delete-blog.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this blog?');">🗑️ Delete</a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
