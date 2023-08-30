<?php
$error="";
$succese_messege="";


if($do == "show_Product"){
    
    // select products from database
    $sql = "SELECT `image`, products.`id` as id_product , `product_name`, `description`, `price`, `name` , categories.`id` as id_category
    FROM products JOIN categories ON products.category = categories.id";
    $stmt= $conn->prepare($sql);
    $stmt->execute();
    $rows=$stmt->fetchAll();

?>
<main>
    <!-- Products List -->
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Products List</h5>
                            
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product Image</th>
                                        <th>Product Name</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Product_category</th>
                                        <th>Delete/Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($rows as $row){ ?>
                                    <tr>
                                        <td><img height="50" src="<?php echo "../images/product_image/".$row['image']?>" alt="Faild To opene"></td>
                                        <td> <?php echo $row['product_name']?></td>
                                        <td> <?php echo $row['description']?></td>
                                        <td> <?php echo $row['price']?></td>
                                        <td> <?php echo $row['name']?></td>
                                        <td>
                                        <a  href="delete.php?product_id=<?php echo $row['id_product']?>"
                                        class="delete" title="Delete" data-toggle="tooltip"><i class="fas fa-trash"></i></a>
                                        /
                                        <a href="?do=edit&product_id=<?php echo $row['id_product']?>"
                                        class="edit" title="Edit" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                                        </td>

                                    </tr>
                                   <?php } ?> 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php


}elseif($do == "Add_Product"){
    $sql_query= "SELECT * FROM `categories`";
    $stmt=$conn->prepare($sql_query);
    $stmt->execute();
    $rows=$stmt->fetchAll();
    
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        if(isset($_POST["add"])){
            $product_name = $_POST["p_name"];
            $description = $_POST["description"];
            $price = $_POST["price"];
            $product_category=$_POST["Product_category"];
            $image_name = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            
            $image_allowed_extensions = ["jpeg", "jpg", "png", "webp"];
            $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
            
            // Check if the fields are not empty
            if(empty($product_name) || empty($description) || empty($price) || empty($image_name) || empty($product_category)){
                $error = "All Fields Are Required.";
            }
            // Check if the uploaded file is an image with allowed extension
            elseif(!in_array($image_extension, $image_allowed_extensions)){
                $error = "Only JPEG, JPG, PNG, and WebP images are allowed.";
            }
            // If there are no errors, proceed to insert the product into the database
            elseif(empty($error)){
                $image = rand(1,1000). "_" . $image_name;
                $insert_query = "INSERT INTO `products`(`product_name`, `description`, `price`, `image`, `category`) VALUES (:product_name ,:description,:price,:image,:category)";
                $stmt=$conn->prepare($insert_query);
                $stmt->execute(["product_name"=>$product_name,"description"=>$description,"price"=>$price,"image"=>$image,"category"=>$product_category]);
                $result=$stmt->rowCount();
                move_uploaded_file($image_tmp, '../images/product_image/' . $image); // Move the uploaded image to a specific folder
                if($result>0){
                    $succese_messege="Added Done.";
                }
            }
        }
    }
    ?>
 
 
 
 <!-- Add New Product Form -->
 <div class="container mt-4">
     <div class="row">
         <div class="col-md-12">
             <div class="card">
                 <div class="card-body">
                     <h5 class="card-title">Add New Product</h5>
                     <form  action="?do=Add_Product" method="POST" enctype="multipart/form-data">
                         <div class="form-group">
                             <label for="product-name">Product Name</label>
                             <input type="text" name="p_name" class="form-control" id="product-name" required
                             placeholder="Enter product name">
                            </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea  name="description" class="form-control" id="description" required
                                    placeholder="Enter Description For The product.."></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="product-price">Price</label>
                                        <input type="text" name="price" class="form-control" id="product-price" required
                                        placeholder="Enter price">
                                    </div>
                                <div class="form-group">
                                    <label for="product_image">Product image</label>
                                    <input type="file" name="image" class="form-control" id="product_image" required >
                                </div>
                                <div class="form-group">

                                    <label for="Product_category">Product Category</label>
                                    <select name="Product_category" id="Product_category" class="form-control">
                                        <?php
                                    foreach($rows as $row){ ?>
                                        <option value='<?php echo $row["id"]?>'> <?php  echo $row["name"] ?></option>;
                                        <?php  } ?>
                                    </select>
                                </div>
                                <?php    
                                if(!empty($succese_messege)){
                                   echo "<div class='form-group'>
                                   <div class='alert alert-success' role='alert'>"
                                   .$succese_messege.
                                   "</div>
                                   </div>";
                                   $succese_messege="";
                                   
                                }elseif(!empty($error)){
                                    
                                    echo "<div class='form-group'>
                                    <div class='alert alert-danger' role='alert'>"
                                    .$error.
                                    "</div>
                                    </div>";
                                    $error="";
                                }
                                ?>
                                <button type="submit" name="add" class="btn btn-primary">Add Product</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Edit product page -->
    <?php }elseif($do == "edit" && isset($_GET['product_id']) || isset($_POST["Edit"])){
        
        if(isset($_GET['product_id'])){
            $product_id = $_GET['product_id'];
        }
        
        if($_SERVER['REQUEST_METHOD']=="POST"){
            if(isset($_POST["Edit"])){
                foreach($_POST as $key => $value){
                    $$key=testinput($value);
                    // check if the faild is not empty
                    if(empty($value)){
                        $error= "All Faild Is Requerd." ;
                    }
                }
                
                
                
                // Put the updated data into the database
                if(empty($error)){

                    // if the user change the image >>> get information about this image  to put it in the database
                    if(!empty($_FILES['Product_Image']['name'])){
                        $image_name= $_FILES['Product_Image']['name'];
                        $image_tmp = $_FILES['Product_Image']['tmp_name'];
                        $image = rand(1,1000). "_" . $image_name;
                        move_uploaded_file($image_tmp, '../images/product_image/' . $image);

                    // else put the old image 
                    }else{
                        $image =  $old_image;
                    }
                    
                    $update_query= " UPDATE `products` 
                    SET `product_name`=:product_name, `description`=:description, `price`=:price ,`category`=:category , `image` = :image
                    WHERE `id`=$product_id";
                    $stmt=$conn->prepare($update_query);
                    $stmt->execute(
                        ["product_name" =>$product_name,
                        "description" => $Description,
                        "price" => $Price,
                        "category" => $Product_category,
                         "image" => $image
                    ]);
                    
                  
                    if($stmt){
                        $succese_messege = "Update is Done";
                        }
                    }
            }
        }

        // Get product information from  the database
        $sql = "SELECT image, products.id as id_product, product_name, description, price, name
        FROM products JOIN categories ON products.category = categories.id Where products.id = $product_id ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        
        
        
        ?>
        <main>
            <div class="container mt-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Product Information</h5>
                                <form  action="<?php echo $_SERVER['PHP_SELF'] ?>?do=edit" method="POST" enctype="multipart/form-data">
                                    <?php   foreach($rows as $row):  ?>

                                        <div class="form-group">
                                            <label for="product_name">Product name</label>
                                            <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $row['product_name'] ?>">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="Description">Description</label>
                                        <input type="text" class="form-control" id="Description" name="Description" value="<?php echo $row['description'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="Price">Price</label>
                                        <input type="text" class="form-control" id="Price" name="Price" value="<?php echo $row['price'] ?>">
                                    </div>
                                    <?php
                                    $categorySql = "SELECT * FROM categories";
                                    $categoryStmt = $conn->prepare($categorySql);
                                    $categoryStmt->execute();
                                    $categories = $categoryStmt->fetchAll();
                                    ?>
                                    <div class="form-group">
                                        <label for="Product_category">Product Category</label>
                                        <select name="Product_category" id="Product_category" class="form-control">
                                        <?php    foreach($categories as $category){ ?>
                                            <option value='<?php echo $category["id"]?>'> <?php  echo $category["name"] ?></option>;
                                            <?php } ?> 
                                        </select>

                                    
                                    <div class="form-group">
                                        <label for="Product_Image">Product Image</label>
                                        <img height="50" src="<?php echo "../images/product_image/".$row['image']?>" alt="Faild To opene">
                                        <input type="file" class="form-control" id="Product_Image" name="Product_Image"> 
                                    </div>
                                    
                                    <input type="hidden" name="product_id" value="<?php echo $row['id_product'] ?>">
                                    <input type="hidden" name="old_image" value="<?php echo $row['image']?>">
                                    
                                </div>
                                <?php 
                                endforeach;
                                if(!empty($succese_messege)){
                                   echo "<div class='form-group'><div class='alert alert-success' role='alert'>".$succese_messege."</div></div>";
                                   $succese_messege="";
                                }elseif(!empty($error)){
                                    echo "<div class='form-group'><div class='alert alert-danger' role='alert'>".$error."</div></div>";
                                    $error="";
                                }
                            ?>
                            <div class="form-group">
                                <input type="submit" value="Edit" name="Edit" class="form-control btn-secondary" ></input>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
  <?php  }else{
   echo "ERROR"; 
  }?>