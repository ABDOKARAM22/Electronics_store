<?php 
include "include/config.php";
$titel = "Login Page";
$errors = [];
if(isset($_SESSION['user'])){
  header("location:index.php");
}

// Form submission check and data sanitization
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $username = testinput($_POST["name"]);
    $password = testinput($_POST["pass"]);

    if (empty($username)) {
        $errors["username"] = "The username is required.";
    }

    if (empty($password)) {
        $errors["password"] = "The Password is required.";
    }

    if (empty($errors)) {
        // Check if the username exists in the database
        $sql_query = "SELECT `username`, `password` , `type` ,`id` FROM `member` WHERE `username` = :username";
        $stmt = $conn->prepare($sql_query);
        $stmt->execute(["username" => $username]);
        $result = $stmt->rowCount();

        // If username found, verify the password and check if passwords matches
        if ($result > 0) {
            $row = $stmt->fetch();
            $password_wt_hash = $row["password"];
            $user_id= $row['id'];
            if (password_verify($password, $password_wt_hash)) {
              $_SESSION['user']=$username;
              $_SESSION['user_id']= $user_id;
              header("location: index.php");
              
              // check if he Admin 
              if($row['type']==1){
                
                header("location:admin/index.php");
                $_SESSION['Admin']=$username;
              }
            } else {
              $errors["log"] = "The username or password is incorrect.";
            }
        }
    }
}

include "$head";
include "$nav";
?>



<br><br><br><br><br><br><br><br><br> 
<div class="container-fluid h-100">
  <div class="row h-100 justify-content-center align-items-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title text-center">Login</h4>
          <form action="<?php $_SERVER["PHP_SELF"] ?>" method="POST">
            <div class="form-group">
              <label for="username">Username:</label>
              <input type="text" class="form-control" id="username" name="name">
            </div>
            <?php 
                  if(isset($errors["username"])){
                  ?>
                   <div class="alert alert-danger" role="alert">
                  <?php echo $errors["username"];
                  ?>
                  </div>
                 <?php } ?>
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" id="password" name="pass">
            </div>
            <?php 
                  if(isset($errors["password"])){
                  ?>
                   <div class="alert alert-danger" role="alert">
                  <?php echo $errors["password"];
                  ?>
                  </div>
                 <?php } ?>
            <?php 
                  if(isset($errors["log"])){
                  ?>
                   <div class="alert alert-danger" role="alert">
                  <?php echo $errors["log"];
                  ?>
                  </div>
                 <?php } ?>

            <button type="submit" class="btn btn-secondary btn-block" name="submit">Login</button>
			<p>Don't have an account? <a href="register.php">Register here</a>.</p>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
	<br><br><br><br><br><br> 
	<br><br>
	<br><br>










  <?php include "$footer" ?>