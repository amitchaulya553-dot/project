<?php
session_start();
if($_SESSION["role"]!="admin"){
    header("location:login.php");
    }
    include 'header.php';
    include 'db.php';
    
    if(isset($_POST['add'])){
    $name = $_POST['category_name'];
    $slug = strtolower(str_replace(" ", "-", $name));
    $stmt = $con->prepare("INSERT INTO category (category_name, slug) VALUES (:category,:cate)");
    $stmt->bindParam(':category',$name);
    $stmt->bindParam(':cate',$slug);
    $stmt->execute();
}

// Delete Category
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $con->query("DELETE FROM category WHERE id=$id");
}

// Fetch Categories
$result = $con->query("SELECT * FROM category ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Categories</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2>Manage Categories</h2>

  <!-- Add Category Form -->
  <form method="POST" class="mb-3">
    <div class="form-group">
      <input type="text" name="category_name" class="form-control" placeholder="Enter Category Name" required>
    </div>
    <button type="submit" name="add" class="btn btn-primary mt-2">Add Category</button>
  </form>

  <!-- Category List -->
  <table class="table table-bordered">
    <tr>
      <th>ID</th>
      <th>Category Name</th>
      <th>Slug</th>
      <th>Action</th>
    </tr>
    <?php $fetch=$con->prepare("SELECT * FROM category ORDER BY id DESC");
    $fetch->execute();
    $result = $fetch->fetchall();
    foreach($result as $row){
    echo "<tr>";
    echo "<td>".$row['id']."</td>";
    echo "<td>".$row['category_name']."</td>";
    echo "<td>".$row['slug']."</td>";
    echo "<td><a href='edit_category.php?edit=".$row['id']."' class='btn btn-warning btn-sm'>Edit</a>    
     <a href='?delete=".$row['id']."' class='btn btn-danger btn-sm'>Delete</a>
     </td>";
    
    echo "</tr>";
    }
    
    ?>
   
  </table>
</div>
</body>
</html>
<?php include 'footer.php'; ?>