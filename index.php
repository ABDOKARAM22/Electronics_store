<?php include "include/config.php";
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

// include the header and navbar  
include "$head";
include "$nav";
?>

<!-- Get the search result -->
<?php
if(isset($_GET['Search']) && isset($_GET['submit'])){
  $search= $_GET['Search'];
  $sql_quary ="SELECT  `image` , `product_name` , `description` , `price` , `id`  FROM products
  WHERE `product_name` LIKE '%$search%'";
  $stmt=$conn->prepare($sql_quary);
  $stmt->execute();
  $rows=$stmt->fetchAll();
  $count = $stmt->rowCount();
}

?>

  <!-- Slider -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img class="d-block w-100" src="images/876464.jpg" alt="First slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" src="images/77887878.jpg" alt="Second slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" src="images/454545.jpg" alt="Third slide">
        </div>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
    

<!-- product -->
<section class="laptops">
<div class="container"><br>
<?php
// Show the success or error message
if(!empty($success["add"])){                              
  echo "<div class='form-group'><div class='alert alert-success' role='alert'><h3>".$success["add"]."<h3></div></div>";
  $success=[];
}elseif(!empty($error['add'])){
  echo "<div class='form-group'><div class='alert alert-danger' role='alert'><h3>".$error['add']."</h3></div></div>";
  $error=[];
}

?>

<?php
if((isset($count) > 0) && isset($rows) && isset($_GET['submit'])){
  ?>
 <section class="product">
<div class="container">
<h3>Products</h3>
<div class="row">

<?php foreach ($rows as $row) { 

?>
<div class="col-lg-3 col-6 col-md-3 col-sm-6 d-block m-auto">
  <div class="card">
      <img class="card-img-top" src="<?php echo "images/product_image/" . $row['image'] ?>" alt="Card image cap" class="card-img img-fluid">
      <div class="card-body">
          <h6 class="card-title text-center"><?php echo $row['product_name'] ?></h6>
          <p class="card-text text-center"><?php echo $row['description'] ?></p>
          <p class="card-text text-center"><?php echo $row['price'] ?></p>
          <a href="<?php echo $path . $row['id'] ?>" class="btn btn-secondary btn-Sm btn-block">Add Cart</a>
      </div>
  </div>
</div>
<?php } ?>

    </div>
 </div>
 </section>
 
<?php   
}else{
  ?>
  <h3>Laptops</h3>
  <div class="row">
    <?php
    view("Laptop",3);
    // selsect the laptops product from the database and view this
    ?>
  </div>
  </div>
  
  </section> 
     <section class="Mobiles">
     <div class="container">
     <h3>Mobiles</h3>
     <div class="row">
     <?php
     view("Phones",3);
     ?>
     </div>
     </div>
     </section>
     
     
     
     <section class="product">
     <div class="container">
     <h3>Watches</h3>
     <div class="row">
     <?php
     view("Watches",3);
          ?>
       </div>
       </div>
       </section>
       
<?php    
}
?>
     <br>
     <?php include "$footer" ?>
     