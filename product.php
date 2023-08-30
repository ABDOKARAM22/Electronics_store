<?php 
include "include/config.php";
$titel="Products";

// Get the member ID if logged in
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (isset($_GET['id']) && isset($_SESSION['user'])) {
  // get the product id
  $product_id = $_GET['id'];
  // Insert the order into the database
  $result = addToCart($conn, $user_id, $product_id);
  // If a product is added to the cart
  if ($result > 0) {
    // Show the succese message
        $success['add'] = "The Product Added To Cart.";
      }else{
        $error['add'] = "There's a mistake, Or the product has already been added";
      }
    } elseif (isset($_GET['id']) && !isset($_SESSION['user'])) {
      $error['add'] = "You Must Login To Add To Cart.."; 
  }
  
  include "$head";
  include "$nav";
  if(isset($_GET['do'])){
    $do = $_GET['do'];
  }
  //####### Laptop bage ############
  
  if($do == 1){
    ?>
  <br>
  <section class="product">
    <div class="container">
      <h3>Laptops</h3>
      <?php
      // Show the success or error message
      if(!empty($success["add"])){                              
        echo "<div class='form-group'><div class='alert alert-success' role='alert'><center><h4>".$success["add"]."</h4></center></div></div>";
        $success=[];
      }elseif(!empty($error['add'])){
        echo "<div class='form-group'><div class='alert alert-danger' role='alert'><center><h4>".$error['add']."</h4></center></div></div>";
        $error=[];
      }
      ?>
      <div class="row">
        <?php
        // selsect the Laptops product from the database and view this
        view("Laptop",100,"?do=$do&id=")
        ?>
      </div>
    </div>
  </section>
<br>


<?php }elseif($do==2){ 
  //######### Phones bage ############
  ?>  
  <br>
  <br>
  <section class="Mobiles">
    <div class="container">
      <h3>Mobiles</h3>
      <?php
      // Show the success or error message
      if(!empty($success["add"])){                              
        echo "<div class='form-group'><div class='alert alert-success' role='alert'><center><h4>".$success["add"]."</h4></center></div></div>";
        $success=[];
      }elseif(!empty($error['add'])){
        echo "<div class='form-group'><div class='alert alert-danger' role='alert'><center><h4>".$error['add']."</h4></center></div></div>";
        $error=[];
      }
      ?>
      <div class="row">
        <?php
        // selsect the Phone products from the database and view this
        view("Phones",100,"?do=$do&id=")
        ?>
     </div>
    </div>
  </section>
  <br>
  <br>
  
  
  <?php }elseif($do==3){
    //######### Phones bage ############ 
    ?>
  <br>
  <br>
  <section class="product">
    <div class="container">
      <h3>Watches</h3>
        <?php
        // Show the success or error message
        if(!empty($success["add"])){                              
          echo "<div class='form-group'><div class='alert alert-success' role='alert'><center><h4>".$success["add"]."</h4></center></div></div>";
          $success=[];
        }elseif(!empty($error['add'])){
          echo "<div class='form-group'><div class='alert alert-danger' role='alert'><center><h4>".$error['add']."</h4></center></div></div>";
          $error=[];
        }
        ?>
      <div class="row">
        <?php
        // selsect the watches product from the database and view this
        view("Watches",100,"?do=$do&id=")
        ?>
        </div>
      </div>
    </section>
    
    
  <?php } ?>
  <br>
  <br>
<?php include "$footer" ?>