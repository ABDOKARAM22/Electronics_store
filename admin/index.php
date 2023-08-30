<?php
include("../include/config.php");
if(isset($_SESSION['Admin'])){
    $Admin_user=$_SESSION['Admin'];
}else{
    echo "<h4>You Must Be Admin To View This Page.<h4>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Mangement</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link rel="stylesheet" href="../css/style_admin.css">


</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="list-group">
            <a href="index.php">
                <li class="list-group-item active">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </li>
            </a>
            <li class="list-group-item">
                <a>
                    <i class="fas fa-user"></i> Admin
                </a>
                <ul>
                    <li><a href="?do=Admin_Profile">Profile</a></li>
                    <li><a href="?do=Add_Admin">Add Admin</a></li>
                    <li><a href="?do=View_Admins">View Admins</a></li>
                </ul>
            </li>

            <li class="list-group-item">
                <a><i class="fas fa-users"></i> Members</a>
                <ul>
                    <li><a href="?do=Members">All Members</a></li>
                </ul>
            </li>

            <li class="list-group-item">
                <i class="fas fa-list"></i> Categories
                <ul>
                    <li><a href="?do=all_category">All Categories</a></li> 
                    <li><a href="?do=add_category">Add Categories</a></li> 
                </ul>
            </li>

            <li class="list-group-item">
                <i class="fas fa-box"></i> Products
                <ul>
                    <li><a href="?do=Add_Product">Add New Product</a></li>
                    <li><a href="?do=show_Product">Product List</a></li>
                </ul>
            </li>
            
            <li class="list-group-item">
                <i class="fas fa-shopping-cart"></i> Orders
                <ul>
                    <li><a href="?do=Pending_orders">Pending Orders</a></li>
                    <li><a href="?do=Completed_orders">Completed Orders</a></li>
                </ul>
            </li>
            
            <li class="list-group-item">
                <a href="../index.php">
                    <i class="fas fa-house"></i> Go to your site
                </a>
            </li>
            
        </ul>
    </div>

<?php

$do = '';
if (isset($_GET['do'])) {
    $do = $_GET['do'];
}else{
    echo"<br><br><center><h4>Welcome $Admin_user</h4></center><br><hr>";
}

                        
// includ Admin information page
if ($do == "Admin_Profile"|| $do=="Add_Admin"|| $do=="View_Admins") {
    include("Admins_Settings.php");
// includ Products page
}elseif($do == "Add_Product" || $do == "show_Product" || $do == "edit" ){
    include ("manage_Products.php");
// includ Members page
}elseif($do == "Members"){
    include ("Members.php");
// includ categories page
}elseif($do=="add_category"||$do=="all_category" || $do == "edit_cat"){
    include ("categories.php");
// includ orders page
}elseif($do == "Pending_orders" || $do =="Completed_orders"){
    include ("orders.php");
//else view main content
}else{
    ?>
<main>
    <br>
    <div class="container mt-4">

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h4 class="card-title">All Members</h4>
                        <?php
                        echo "<h6><p class='card-text'>" . count_item("id", "member") . "</p></h6>";
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h4 class="card-title">All Admins</h4>
                        <?php
                        echo "<h6><p class='card-text'>" . count_item("id", "member","WHERE `type`=1") . "</p></h6>";
                        ?>
                    </div>
                </div>
            </div>
            </div>

            
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h4 class="card-title">All Categories</h4>
                        <?php
                        echo "<h6><p class='card-text'>" . count_item("id", "categories") . "</p></h6>";
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h4 class="card-title">All Products</h4>
                        <?php
                        echo "<h6><p class='card-text'>" . count_item("id", "products") . "</p></h6>";
                        ?>
                    </div>
                </div>
            </div>
        </div>
     <div class="row mb-4">
         <div class="col-md-6">
             <div class="card text-center">
                <div class="card-body">
                    <h4 class="card-title">Pending Orders</h4>
                    <?php
                    echo "<h6><p class='card-text'>" . count_item("id", "orders", "WHERE `order_state`=1") . "</p></h6>";
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-body">
                    <h4 class="card-title">Completed Orders</h4>
                    <?php
                    echo "<h6><p class='card-text'>" . count_item("id", "orders","WHERE `order_state`=2") . "</p></h6>";
                    ?>
                </div>
            </div>
        </div>
    </div>   
        
    </div>
</main>

<?php } ?>

    <!-- Add Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
