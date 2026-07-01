<?php
session_start();
if($_SESSION["role"]!="admin"){
    header("location:login.php");
    exit();
}
include 'header.php';
include 'db.php';

// Add Category
if(isset($_POST['add'])){
    $name = $_POST['category_name'];
    $slug = strtolower(str_replace(" ", "-", $name));
    $stmt = $con->prepare("INSERT INTO category (category_name, slug) VALUES (:category,:cate)");
    $stmt->bindParam(':category',$name);
    $stmt->bindParam(':cate',$slug);
    $stmt->execute();
    header("Location: categories.php");
    exit();
}

// Delete Category
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $con->query("DELETE FROM category WHERE id=$id");
    header("Location: categories.php");
    exit();
}

// Fetch Categories
$stmt = $con->query("SELECT * FROM category ORDER BY id DESC");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Categories</title>
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
  <a href="approve-blogs.php">📝 Approve Blogs</a>
  
  <a href="categories.php" class="bg-primary text-white rounded">📂 Categories</a>
  
</div>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <span class="navbar-brand">Manage Categories</span>
    <div class="d-flex">
      <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<!-- Content Area -->
<div class="content">
  <div class="container-fluid">

    <!-- Add Category Form -->
    <div class="card shadow-sm mb-4">
      <div class="card-header bg-secondary text-white">
        <h5 class="mb-0">➕ Add New Category</h5>
      </div>
      <div class="card-body">
        <form method="POST" class="row g-3">
          <div class="col-md-6">
            <input type="text" name="category_name" class="form-control" placeholder="Enter Category Name" required>
          </div>
          <div class="col-md-6">
            <button type="submit" name="add" class="btn btn-primary">Add Category</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Category List -->
    <div class="card shadow-sm">
      <div class="card-header bg-dark text-white">
        <h5 class="mb-0">📂 Categories List</h5>
      </div>
      <div class="card-body">
        <table class="table table-hover align-middle">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Category Name</th>
              <th>Slug</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($categories as $row): ?>
            <tr>
              <td><?= htmlspecialchars($row['id']) ?></td>
              <td><?= htmlspecialchars($row['category_name']) ?></td>
              <td><span class="badge bg-info"><?= htmlspecialchars($row['slug']) ?></span></td>
              <td class="text-center">
                <a href="edit_category.php?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm me-1">✏️ Edit</a>
                <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this category?');">🗑️ Delete</a>
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
<?php include 'footer.php'; ?>
