<?php
session_start();
if($_SESSION["role"]!="user"){
    header("location:login.php");
    exit();
}
include 'header.php';
include 'db.php';

// Handle blog submission
if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $slug = strtolower(str_replace(" ", "-", $title));
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $author_id = $_SESSION['user_id'];

    // Thumbnail upload
    $photo = $_FILES['thumbnail'];
    $photo_name = $photo['name'];
    $photo_tmp = $photo['tmp_name'];  
    $path = pathinfo($photo_name, PATHINFO_EXTENSION);
    $rename = time().".".$path;
    $rename_path = "image/".$rename;
    if(!empty($photo_name)){
        move_uploaded_file($photo_tmp, $rename_path);
    } else {
        $rename_path = "";
    }

    $add = $con->prepare("INSERT INTO blogs(title,description,category_id,user_id,thumbnail,slug) 
                          VALUES(:title,:description,:category_id,:author_id,:thumbnail,:slug)");
    $add->bindParam(':title', $title);
    $add->bindParam(':description', $description);
    $add->bindParam(':category_id', $category_id);
    $add->bindParam(':author_id', $author_id);
    $add->bindParam(':thumbnail', $rename_path);
    $add->bindParam(':slug', $slug);
    $add->execute();

    header("location:userdashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Blog</title>
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
  <h4 class="text-white mb-4">User Panel</h4>
  <a href="userdashboard.php">🏠 Dashboard</a>
  <a href="create-blog.php" class="bg-primary text-white rounded">➕ Create Blog</a>
  <a href="my-blogs.php">📝 My Blogs</a>
</div>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <span class="navbar-brand">Create Blog</span>
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
        <h5 class="mb-0">➕ New Blog Post</h5>
      </div>
      <div class="card-body">
        <form method="POST" enctype="multipart/form-data" class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required>
          </div>
          <div class="col-md-12">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="5" required></textarea>
          </div>
          <div class="col-md-6">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select" required>
              <?php
              $stmt = $con->prepare("SELECT * FROM category");
              $stmt->execute();
              $categories = $stmt->fetchAll();
              foreach($categories as $category){
                  echo "<option value='".$category['id']."'>".$category['category_name']."</option>";
              }
              ?>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Thumbnail</label>
            <input type="file" name="thumbnail" class="form-control">
          </div>
          <div class="col-md-12">
            <button type="submit" name="submit" class="btn btn-primary">Submit Blog</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
