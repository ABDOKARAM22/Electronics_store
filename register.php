<?php
include "include/config.php";
$errors = [];
$titel="Sign up";
if(isset($_SESSION['user'])){
  header("location:index.php");
}
  // Check if the form is submitted via POST method and the "signup" button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signup"])) {
  $user_name= testinput($_POST["username"]);
  $f_n =  testinput($_POST["firstname"]);
  $l_n = testinput($_POST["lastname"]);
  $email =testinput($_POST["email"]);
  $password =testinput($_POST["password"]);
  $re_password =testinput($_POST["repassword"]);
  // Perform validation on the input fields
  if(empty($user_name)){
    $errors["username"] = "The username is required.";
  }elseif(!input_length($user_name,3,16)){
    
    $errors["username"] = "The username must be more 3 charcter and less than 16.";
    
  }

  if (empty($f_n)) {
    $errors["f_n"] = "The First name is required.";
  }
  elseif(!input_string($f_n)){
    
    $errors["f_n"] = "The name must be from (A) to (z).";
    
  }
  elseif(!input_length($f_n,3,12)){
    
    $errors["f_n"] = "The First name must be more 3 charcter and less 12.";
    
  }
  
  
  if (empty($l_n)) {
    $errors["l_n"] = " the Last name is required.";
  }
  elseif(!input_string($l_n)){
    
    $errors["l_n"] = "The name must be from (A) to (z).";
    
  }
  elseif(!input_length($l_n,3,12)){
        
        $errors["l_n"] = "The Last name must be more than 3 charcter and less 12.";
        
      }
      
      
      if (empty($email)) {
        $errors["email"] = "Email is required.";  
      }elseif(!valid_email($email)){
        
        $errors["email"] = "Inter valid email format.";
      }
      
      
      if (empty($password)) {
        $errors["pass"] = "Password is required.";
      }elseif(!input_length($password,8,16)){
        $errors["pass"] = "Password must be more than 8 charcter and less 16.";
      }
      
      if ($password !== $re_password) {
        $errors["repass"] = "Passwords do not match.";
      }
      
      if (empty($errors)) {
        // Process the registration and database insertion
        $hash_password=hash_pass($password);
        $hash_repassword=hash_pass($re_password);
        $_SESSION['user']= $user_name;

        $sql_query = "INSERT INTO `member` (`username`,`f_name`, `l_name`, `email`, `password`, `re_password`) VALUES (:username, :f_name, :l_name, :email, :password, :re_password)";
        $stmt=$conn->prepare($sql_query);
        $stmt->execute([
          "username" => $user_name,
          "f_name" => $f_n,
          "l_name" => $l_n,
          "email" => $email,
          "password" => $hash_password,
          "re_password"=>$hash_repassword
      ]);
        // get the user id from database
        $sql="SELECT `id` FROM `member` where `username`=:username";
        $stmt=$conn->prepare($sql);
        $stmt->execute(['username'=>$user_name]);  
        $row=$stmt->fetch();
        // Set the session for user
        $_SESSION['user_id']=$row['id'];
        $_SESSION['user']=$user_name;
        
        header("location:index.php");


        
      }
      
    }
    ?>
<?php
include "$head";
include "$nav";
?>
<br><br><br>
<br><br><br>
<br><br><br>
<div class="hold-transition register-page">
  <div class="container-fluid h-100">
    <div class="row h-100 justify-content-center align-items-center">
      <div class="col-md-6">
        <div class="register-box">
          <div class="register-box-body">
            <b><p class="login-box-msg">Register a new membership</p></b>
            <form method="POST" action="<?php $_SERVER["PHP_SELF"]?>" >


                  <div class="form-group has-feedback">
                  <input type="text" class="form-control" name="username" placeholder="Username to login">
                  <span class="glyphicon glyphicon-user form-control-feedback"></span>
                  </div>
                  <?php 
                  if(isset($errors["username"])){
                  ?>
                   <div class="alert alert-danger" role="alert">
                  <?php echo $errors["username"];
                  ?>
                  </div>
                 <?php } ?>

                  <div class="form-group has-feedback">
                  <input type="text" class="form-control" name="firstname" placeholder="Firstname" >
                  <span class="glyphicon glyphicon-user form-control-feedback"></span>
                  </div>
                  <?php 
                  if(isset($errors["f_n"])){
                  ?>
                   <div class="alert alert-danger" role="alert">
                  <?php echo $errors["f_n"];
                  ?>
                  </div>
                 <?php } ?>


                 <div class="form-group has-feedback">
                   <input type="text" class="form-control" name="lastname" placeholder="Lastname" >
                   <span class="glyphicon glyphicon-user form-control-feedback"></span>
                  </div>
                    <?php 
                    if(isset($errors["l_n"])){
                    ?>
                     <div class="alert alert-danger" role="alert">
                    <?php echo $errors["l_n"]; 
                    ?>
                    </div>
                   <?php } ?>


                  <div class="form-group has-feedback">
                    <input type="email" class="form-control" name="email" placeholder="Email" >
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                  </div>
                    <?php 
                    if(isset($errors["email"])){
                    ?>
                     <div class="alert alert-danger" role="alert">
                    <?php echo $errors["email"]; 
                    ?>
                    </div>
                   <?php } ?>


                   <div class="form-group has-feedback">
                     <input type="password" class="form-control" name="password" placeholder="Password" >
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <?php 
                if(isset($errors["pass"])){
                  ?>
                 <div class="alert alert-danger" role="alert">
                   <?php echo $errors["pass"]; 
                ?>
                </div>
                <?php } ?>
                
                
                <div class="form-group has-feedback">
                  <input type="password" class="form-control" name="repassword" placeholder="Retype password" >
                  <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                  </div>
                <?php 
                if(isset($errors["repass"])){
                ?>
                 <div class="alert alert-danger" role="alert">
                <?php echo $errors["repass"]; 
                ?>
                </div>
               <?php } ?>
                <div class="form-group" style="width:100%;">
                  <div class="g-recaptcha" data-sitekey="YOUR_RECAPTCHA_SITE_KEY"></div>
                </div>
                <div class="form-group">
                  <div class="col-xs-4">
                    <button type="submit" class="btn btn-secondary btn-block btn-flat" name="signup"><i class="fa fa-pencil"></i> Sign Up</button>
                  </div>
                </div>
                </form>
        <br>
        <a href="login.php">I already have a membership</a><br>
        <a href="index.php"><i class="fa fa-home"></i> Home</a>
      </div>
    </div>
                </div>
              </div>
            </div>
      </div>
      <br><br>
      <br><br>
      <?php include "$footer" ?>