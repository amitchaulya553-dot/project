<?php
session_start();
if($_SESSION["role"]!="user"){
    header("location:login.php");
    }
    include 'header.php';
    include 'db.php';
    $ids=$_GET['id'];
    $stmt=$con->prepare("SELECT * FROM blogs 
    inner join category
    on blogs.category_id=category.id
WHERE blogs.id=:id");
    $stmt->bindParam(':id',$ids);
    $stmt->execute();
    $blog = $stmt->fetch();
?>


<!DOCTYPE html>
<html>
<head>
  <title>Create Blog</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2>Create Blog</h2>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Title</label>
      <input type="text" name="title" class="form-control" value="<?= $blog['title'] ?>" required>
    </div>
    <div class="mb-3">
      <label>Description</label>
      <textarea name="description" class="form-control" rows="5" required><?= $blog['description'] ?></textarea>
    </div>
    <div class="mb-3">
      <label>Category</label>
      <select name="category_id" class="form-control" required>
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
    <div class="mb-3">
        <img src="<?=$blog['thumbnail']?>" width="100px" alt="Current blog thumbnail preview">
      <label>Thumbnail</label>
      <input type="file" name="thumbnail" class="form-control">
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Submit Blog</button>
  </form>
</div>
</body>
</html>
<?php

if(isset($_POST['submit'])){
    $title = $_POST['title'];
     $slug = strtolower(str_replace(" ", "-", $title));
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $author_id = $_SESSION['user_id'];
    $photo=$_FILES['thumbnail'];
    $photo_name=$photo['name'];
    $photo_tmp=$photo['tmp_name'];  
    $path=pathinfo($photo_name,PATHINFO_EXTENSION);
    $rename=time().".".$path;
    $rename_path="image/".$rename;
    move_uploaded_file($photo_tmp,$rename_path);
    $update=$con->prepare("UPDATE blogs SET title=:title,description=:description,category_id=:category_id,user_id=:author_id,thumbnail=:thumbnail,slug=:slug WHERE id=:id");
    $update->bindParam(':id', $ids);
    $update->bindParam(':title', $title);
    $update->bindParam(':description', $description);
    $update->bindParam(':category_id', $category_id);
    $update->bindParam(':author_id', $author_id);
    $update->bindParam(':thumbnail', $rename_path);
    $update->bindParam(':slug', $slug);
    $update->execute();
}



       