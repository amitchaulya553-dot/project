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
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <!-- <li class="nav-item"><a class="nav-link" href="index.php">Blogs</a></li> -->
        <li class="nav-item"><a class="nav-link active" href="login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="registration.php">Register</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container d-flex justify-content-center align-items-center" style="min-height:80vh;">
  <div class="card shadow-lg" style="width: 400px;">
    <div class="card-header bg-primary text-white text-center">
      <h4>Login</h4>
    </div>
    <div class="card-body">
      <?php
      if(isset($_SESSION["wrong"])){
        echo "<div class='alert alert-danger'>".$_SESSION["wrong"]."</div>";
        unset($_SESSION["wrong"]);
      }
      ?>
      <form action="logindata.php" method="post">
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary w-100">Login</button>
      </form>
    </div>
    <div class="card-footer text-center">
      <small>Don't have an account? <a href="registration.php">Register</a></small>
    </div>
  </div>
</div>

    
  </fieldset>
</form>

</div>

</div>

<?php include 'footer.php';


?>