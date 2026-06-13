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
  <title>Create Blog</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2>Create Blog</h2>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Title</label>
      <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Description</label>
      <textarea name="description" class="form-control" rows="5" required></textarea>
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

 $add=$con->prepare("INSERT INTO blogs(title,description,category_id,user_id,thumbnail,slug) VALUES(:title,:description,:category_id,:author_id,:thumbnail,:slug)");
    $add->bindParam(':title', $title);
    $add->bindParam(':description', $description);
    $add->bindParam(':category_id', $category_id);
    $add->bindParam(':author_id', $author_id);
    $add->bindParam(':thumbnail', $rename_path);
    $add->bindParam(':slug', $slug);
    $add->execute();

    header("location:userdashboard.php");
}
?>