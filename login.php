<?php include 'header.php';
session_start();

 ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">My Blogs</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php">Blogs</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="registration.php">Register</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container">
  
  <div class="inner">
     <?php
    if(isset($_SESSION["wrong"])){
      echo $_SESSION["wrong"];
      unset($_SESSION["wrong"]);
    }
    ?>
   
        <h1 style="margin-right: 290px;color:green;">Login</h1>
    
<form style="width:35%; margin-top: 20px;"action="logindata.php" method="post">
 
    <div class="mb-3">
      
      <input type="email" id="disabledTextInput" class="form-control" placeholder="Enter your email" name="email">
    </div>
    <div class="mb-3">
      
      <input type="password" id="disabledTextInput" class="form-control" placeholder="Password" name="password">
    </div>
   

    <div class="mb-3">
      <p>Don't have an account?<a href="registration.php">Create one</a></p>
    </div>
    
  </fieldset>
  <button type="submit" class="btn btn-primary"style="margin-left: 120px; width:160px;"name="submit">Login</button>
</form>

</div>

</div>

<?php include 'footer.php';


?>