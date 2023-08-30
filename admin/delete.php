<?php
include("../include/config.php");


// delete the category
if(isset($_GET['id_category'])){
    $category_id = $_GET['id_category'];
    if(Delete("categories",$category_id)){
        header("location:index.php?do=all_category");
    }
// delete the member
}elseif(isset($_GET['member_id'])){
    $member_id = $_GET['member_id'];
    if(Delete("member",$member_id)){
        header("location:index.php?do=Members");
    }
// delete the admin
}elseif(isset($_GET['admin_id'])){
    $admin_id = $_GET['admin_id'];
    if(Delete("member",$admin_id)){
        header("location:index.php?do=View_Admins");
    }
    
// delete the product
}elseif($_GET['product_id']){
    $product_id= $_GET['product_id'];
    if(Delete("products",$product_id)){
        header("location:index.php?do=show_Product");
    }
// delete orders from cart 
}elseif($_GET['cart_id']){
    $cart_id = $_GET['cart_id'];
    if(delete("orders",$cart_id)){
        header("location:../cart.php");
    }
// Delete pending orders by admin
}elseif($_GET['orders_id']){
    $order_id= $_GET['orders_id'];
    if(delete("orders",$order_id)){        
       header("location:index.php?do=Pending_orders");
    }
// Delete completed orders by admin
}elseif($_GET['orders_compelete']){
    $order_id= $_GET['orders_compelete'];
    if(delete("orders",$order_id)){        
       header("location:index.php?do=Completed_orders");
    }
}