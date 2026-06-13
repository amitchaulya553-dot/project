<?php
session_start();
if($_SESSION["role"]!="user"){
    header("location:login.php");
    }
    include 'header.php';
    include 'db.php';
    ?>


<!DOCTYPE html>
<html>
<head>
  <title>My Blogs</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <style>
    body { background-color: #f8f9fa; }
    .card-header { font-weight: bold; }
    .table-hover tbody tr:hover { background-color: #f1f1f1; }
  </style>
</head>
<body>
<div class="container mt-5">
  <div class="card shadow">
    <div class="card-header bg-primary text-white">
      My Blogs
    </div>
    <div class="card-body">
      <table class="table table-bordered table-hover">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $fetch=$con->prepare("SELECT blogs.*, category.category_name FROM blogs
          inner join category
         on blogs.category_id=category.id 
          WHERE user_id=:user_id");
          $fetch->bindParam(':user_id', $_SESSION['user_id']);
          $fetch->execute();
          $fetchs = $fetch->fetchAll();
          foreach($fetchs as $row): ?>
          <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['category_name']) ?></td>
            <td>
              <?php 
                if($row['status'] == 'pending'){
                  echo "<span class='badge bg-warning text-dark'>Pending</span>";
                } elseif($row['status'] == 'approved'){
                  echo "<span class='badge bg-success'>Approved</span>";
                } else {
                  echo "<span class='badge bg-danger'>Rejected</span>";
                }
              ?>
            </td>
            <td>
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
</body>
</html>
