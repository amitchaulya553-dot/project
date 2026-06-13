<?php
session_start();
if($_SESSION["role"]!="admin"){
    header("location:login.php");
    }
    include 'header.php';
    include 'db.php';
    $fetch=$con->prepare("SELECT blogs.*,category.category_name,user.username
    FROM blogs
    INNER JOIN user 
    ON blogs.user_id=user.id
    INNER JOIN category
    ON blogs.category_id=category.id
    WHERE blogs.status='pending'");
    $fetch->execute();
    $fetchs=$fetch->fetchall();
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Approve Blogs</title>
  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Page Header -->
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="text-primary">📝 Pending Blogs Approval</h3>
    <a href="admindashboard.php" class="btn btn-outline-secondary btn-sm">⬅ Back</a>
  </div>

  <!-- Table -->
  <div class="card shadow-sm">
    <div class="card-body">
      <table class="table table-bordered table-hover align-middle">
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
          <?php foreach($fetchs as $data): ?>
          <tr>
            <td><?= htmlspecialchars($data['id']) ?></td>
            <td><strong><?= htmlspecialchars($data['title']) ?></strong></td>
            <td><span class="badge bg-info"><?= htmlspecialchars($data['category_name']) ?></span></td>
            <td><?= htmlspecialchars($data['username']) ?></td>
            <td>
              <?php if(!empty($data['thumbnail'])): ?>
                <img src="<?= $data['thumbnail'] ?>" width="70" class="rounded shadow-sm">
              <?php else: ?>
                <span class="text-muted">No Image</span>
              <?php endif; ?>
            </td>
            <td><span class="badge bg-warning text-dark">Pending</span></td>
            <td class="text-center">
              <a href="approve-blogs.php?action=<?= $data['id'] ?>" 
                 class="btn btn-success btn-sm me-1">✔ Approve</a>
              <a href="reject-blogs.php?action=<?= $data['id'] ?>" 
                 class="btn btn-danger btn-sm">✖ Reject</a>
            </td>
            
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

