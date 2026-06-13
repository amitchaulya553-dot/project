<?php
session_start();
if($_SESSION["role"]!="admin"){
    header("location:login.php");
}
include 'header.php';
include 'db.php';


if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $stmt = $con->prepare("SELECT * FROM category WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $category = $stmt->fetch();
}
?>
 <form method="POST" class="mb-3">
    <div class="form-group">
      <input type="text" name="category_name" class="form-control" placeholder="Enter Category Name" required value="<?=$category['category_name']?>">
    </div>
    <button type="submit" name="add" class="btn btn-primary mt-2">Edit Category</button>
  </form>


<?php
if(isset($_POST['add'])){
    $name = $_POST['category_name'];
    $slug = strtolower(str_replace(" ", "-", $name));
    $stmt = $con->prepare("UPDATE category SET category_name = :category, slug = :cate WHERE id = :id");
     $stmt->bindParam(':id', $id);
    $stmt->bindParam(':category',$name);
    $stmt->bindParam(':cate',$slug);
    $stmt->execute();
    header("location:categories.php");
}
?>