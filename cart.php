<?php
include "include/config.php";
// Check if the user is logged in
if(isset($_SESSION['user'])){
    $user_id = $_SESSION['user_id'];
    
    if(isset($_SERVER['REQUEST_METHOD'])){
        // Update the quantity
        if(isset($_POST['update_Quantity'])){
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'quantity_') === 0 && is_numeric($value)) {
                    // Get the product ID and quantity
                    $productId = substr($key, strlen('quantity_'));
                    $quantity = intval($value);
                    $sql_update= "UPDATE `orders` SET `Quantity` = :Quantity  where id=:id";
                    $stmt=$conn->prepare($sql_update);
                    $stmt->execute(["Quantity"=>$quantity, "id"=>$productId]);
                }
            } 
        }
    }
    // Confirm the order in the database, if it has been confirmed by the user
    if(isset($_POST['confirm_order'])){

        foreach ($_POST as $key => $value) {
            if (strpos($key, 'quantity_') === 0 && is_numeric($value)){
                
                // get the product id
                $productId = substr($key, strlen('quantity_'));
                
                // Check if the user has entered his address and contact number before confirming
                $sql="SELECT `Address`,`Contact_info` FROM member where `id` = $user_id";
                $stmt=$conn->prepare($sql);
                $stmt->execute();
                $info=$stmt->fetch();
                // If the information is found, confirm the order
                if($info['Contact_info'] !== null && $info['Address'] !== null ){
                    
                    $sql_update= "UPDATE `orders` SET `order_state` = :oreder_state where id=:id";
                    $stmt=$conn->prepare($sql_update);
                    $stmt->execute(["id"=>$productId,"oreder_state"=> 1 ]);
                    
                    $success['add']="The Order Has Been Confirmed And We Will Contact You";
                    
                // Else Show error messages to the user
                }else{
                    $error ="To confirm the order, please go to the profile and add the address and contact number";
                }
                
            }
            
        }
}

// include the header and navbar for the bage
$titel="Cart";
include "$head";
include "$nav";

// Get all orders for the user
$sql_select = "SELECT `product_name`, `price`, `order_date`, orders.`id` as order_id, `Quantity`,
  `Quantity` * mid(`price`,2,11) as total_price, products.`id` as product_id, `order_state`
FROM `products` 
JOIN `orders`, `member` 
WHERE products.id = orders.id_for_product 
AND member.id = orders.id_for_user
AND member.id = :user_id";

$stmt = $conn->prepare($sql_select);
$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT); 
$stmt->execute();
$rows = $stmt->fetchAll();

?>
<div class="center-content">
    <div class="container">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h4 class="box-title"><i class="fa fa-calendar"></i> <b>Your orders</b></h4>
            </div>
            <div class="box-body">
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post"> 
                    <table class="table table-bordered" id="example1">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th> 
                                <th>Total Price</th> 
                                <th>Orders Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $confirmedOrdersTotal = 0;
                            
                            foreach($rows as $row) {
                                if($row["order_state"] != 2 ){
                                    $result = $stmt->rowCount();
                                    ?>
                                <tr>
                                    <td><?php echo $row['order_date'] ?></td>
                                    <td><?php echo $row['product_name'] ?></td>
                                    <td><?php echo $row['price'] ?></td>
                                    <td>
                                        <?php if ($row['order_state'] == 0) { ?>
                                            <input type="number" name="quantity_<?php echo $row['order_id']?>" value="<?php echo $row['Quantity']?>" min="1">
                                            <input type="submit" class="btn btn-secondary btn-sm" value="Done" name="update_Quantity">
                                        <?php } elseif ($row['order_state'] == 1) {
                                            echo $row['Quantity'];
                                            $confirmedOrdersTotal += intval($row['total_price']); 
                                        } ?>  
                                    </td>
                                    <td>
                                        <?php
                                         echo "$". $row['total_price'] ;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($row['order_state'] == 0) {
                                            ?>
                                            <a href="admin/delete.php?cart_id=<?php echo $row['order_id']?>" class="delete" title="Delete" data-toggle="tooltip">DELETE</a>
                                            <?php } elseif ($row['order_state'] == 1) {
                                            echo "Order is Confirmed";
                                        }?>
                                    </td>
                                </tr>
                            <?php
                             }
                            } // end foreach
                            ?>
                            <tr>
                                <td colspan="3"><b>Total Confirmed Orders Price:</b></td>
                                <td colspan="3"><b><?php echo "$".$confirmedOrdersTotal; ?></b></td>
                            </tr>
                        </tbody>
                    </table>
                    <?php if (!empty($success["add"])) {
                        echo "<div class='form-group'><div class='alert alert-success' role='alert'><center><h4>".$success["add"]."</h4></center></div></div>";
                        $success = [];
                    }elseif(!empty ($error)){
                        echo "<div class='form-group'><div class='alert alert-danger' role='alert'><center><h4>".$error."</h4></center></div></div>";

                    } 
                    if(isset($result) > 0){
                    ?>
                    <input type="submit" class="btn btn-secondary btn-block" value="Confirm Order" name="confirm_order">
              <?php  } ?>
                </form>
            </div>
        </div>
    </div>
</div>


<?php 
include "$footer";
// If the user not logged in 
}else{
?>
    <div class="container">
    <h3>You Must Login To View This Page</h3>
    </div>
<?php } ?>