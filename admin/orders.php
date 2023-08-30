<?php
// Get all orders from the database
$sql_select="SELECT `f_name`,`email`, orders.`id`,`product_name`, `Quantity` , `Quantity` * mid(`price`,2,11) as total_price ,
`order_date` ,`order_state` , `received_date`
FROM `products` 
join `orders`,`member` 
where products.id= orders.id_for_product 
AND member.id = orders.id_for_user";
$stmt=$conn->prepare($sql_select);
$stmt->execute();
$rows=$stmt->fetchAll();


// Pending orders page
if($do=="Pending_orders"){
    // Confirm orders that have been completed
    if($_SERVER['REQUEST_METHOD']=="POST") {
        if(isset($_POST['mark_done'])){
            $received_date= date("Y/m/d");

            $order_id=$_POST['orders_id'];
            $sql_update= "UPDATE `orders` SET `order_state` = :oreder_state , `received_date`=:received_date where id=:id";
            $stmt=$conn->prepare($sql_update);
            $stmt->execute(["id"=>$order_id,"oreder_state"=> 2 ,"received_date"=>$received_date ]);
            header("Refresh: 0 ;url=?do=Pending_orders");
            
        }
    }
    ?>
<main>
    <!--Pending Orders List -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Orders List</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Client Name</th>
                                        <th>Email</th>
                                        <th>Order id</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                        <th>Order Date</th>
                                        <th>Order Status</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($rows as $row){ 
                                     if($row["order_state"] == 1){ ?>
                                            <tr>
                                                <td><?php echo $row['f_name'] ?></td>
                                                <td><?php echo $row['email'] ?></td>
                                                <td><?php echo $row['id'] ?></td>
                                                <td><?php echo $row['product_name'] ?></td>
                                                <td><?php echo $row['Quantity'] ?></td>
                                                <td><?php echo $row['total_price'] ?></td>
                                                <td><?php echo $row['order_date'] ?></td>
                                                <td>
                                                <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?do=Pending_orders">
                                                    <input type="hidden" name="orders_id" value="<?php echo $row['id']; ?>">
                                                    <button type="submit" name="mark_done" class="Done btn-primary" title="Done" data-toggle="tooltip">
                                                        <i class="fas fa-check"></i> Done
                                                    </button>
                                                </form>
                                                <a href="delete.php?orders_id=<?php echo $row['id']; ?>"
                                                class="delete btn-primary" title="Delete" data-toggle="tooltip">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>
                                                </td>

                                            </tr> 
                                    <?php 
                                        }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </main>
    <?php
        // Completed orders page
}elseif($do=="Completed_orders"){
    ?>
    <main>
        <!--Completed Orders List -->
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Orders List</h5>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Client Name</th>
                                            <th>Email</th>
                                            <th>Order id</th>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Total Price</th>
                                            <th>Order Date</th>
                                            <th>Received Date</th>
                                            <th>Delete</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                     <?php foreach($rows as $row){ 
                                        if($row["order_state"]==2){ ?>
                                                <tr>
                                                    <td><?php echo $row['f_name'] ?></td>
                                                    <td><?php echo $row['email'] ?></td>
                                                    <td><?php echo $row['id'] ?></td>
                                                    <td><?php echo $row['product_name'] ?></td>
                                                    <td><?php echo $row['Quantity'] ?></td>
                                                    <td><?php echo $row['total_price'] ?></td>
                                                    <td><?php echo $row['order_date'] ?></td>
                                                    <td><?php echo $row['received_date'] ?></td>
                                                    <td><a href="delete.php?orders_compelete=<?php echo $row['id']; ?>"
                                                class="delete" title="Delete" data-toggle="tooltip">
                                                    <i class="fas fa-trash"></i>
                                                </a></td>
                                                </tr> 
                                        <?php 
                                            }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </main>

<?php } ?> 
