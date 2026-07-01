<?php
session_start();
if($_SESSION["role"]!="admin"){
    header("location:login.php");
    exit();
}
include 'header.php';
include 'db.php';

// Fetch pending blogs
$stmt = $con->prepare("SELECT blogs.*, category.category_name, user.username
    FROM blogs
    INNER JOIN user ON blogs.user_id = user.id
    INNER JOIN category ON blogs.category_id = category.id
    WHERE blogs.status='pending'");
$stmt->execute();
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Approve / Reject logic
if(isset($_GET['action']) && isset($_GET['id'])){
    $id = $_GET['id'];
    $action = $_GET['action'];
    if($action == 'approve'){
        $update = $con->prepare("UPDATE blogs SET status='approved' WHERE id=:id");
    } elseif($action == 'reject'){
        $update = $con->prepare("UPDATE blogs SET status='rejected' WHERE id=:id");
    }
    $update->bindParam(':id', $id, PDO::PARAM_INT);
    $update->execute();
    header("Location: approve-blogs.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Approve Blogs</title>
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
  <a href="approve-blogs.php" class="bg-primary text-white rounded">📝 Approve Blogs</a>
  
  <a href="categories.php">📂 Categories</a>
  
</div>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <span class="navbar-brand">Approve Blogs</span>
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
        <h5 class="mb-0">📝 Pending Blogs Approval</h5>
      </div>
      <div class="card-body">
        <table class="table table-hover align-middle">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Category</th>
              <th>Author</th>
              <th>Thumbnail</th>
              <th>Status</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($blogs as $blog): ?>
            <tr>
              <td><?= htmlspecialchars($blog['id']) ?></td>
              <td><strong><?= htmlspecialchars($blog['title']) ?></strong></td>
              <td><span class="badge bg-info"><?= htmlspecialchars($blog['category_name']) ?></span></td>
              <td><?= htmlspecialchars($blog['username']) ?></td>
              <td>
                <?php if(!empty($blog['thumbnail'])): ?>
                  <img src="<?= $blog['thumbnail'] ?>" width="70" class="rounded shadow-sm">
                <?php else: ?>
                  <span class="text-muted">No Image</span>
                <?php endif; ?>
              </td>
              <td><span class="badge bg-warning text-dark">Pending</span></td>
              <td class="text-center">
                <a href="approve-blogs.php?action=approve&id=<?= $blog['id'] ?>" 
                   class="btn btn-success btn-sm me-1">✔ Approve</a>
                <a href="approve-blogs.php?action=reject&id=<?= $blog['id'] ?>" 
                   class="btn btn-danger btn-sm">✖ Reject</a>
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
