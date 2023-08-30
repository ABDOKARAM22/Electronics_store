<?php
include "include/config.php";
if(isset($_SESSION['user'])){
    $titel = "Profile";

	//Changes the data from the database if the user requests that 
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
		foreach($_POST as $key => $value){

			$$key=testinput($value);
            // check if the faild is not empty
            if(empty($value)){
                $error["Edit"]="All Faild Is Requerd.";
            }

		}
        if(empty($error)){

		$sql_query="UPDATE `member` SET `f_name`=:f_name,`l_name`=:l_name,`email`=:email ,`Address` = :Address ,`Contact_info`=:Contact_info" ;
		$stmt=$conn->prepare($sql_query);
		$stmt->execute(["f_name"=>$first_name, "l_name"=>$last_name, "email"=>$email , "Address"=>$address , "Contact_info"=>$contact]);

        $succese_messege["Edit"]="Update is Done";
        
        }
	}


    include "$head";
    include "$nav";
?>

<br><br>
<br><br>
<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="container">
                <?php
                // bring the user informtion from the database
                $username = $_SESSION['user'];
                $sql_query = "SELECT  `f_name`, `l_name`, `email`,`Date` ,`Address`,`Contact_info` FROM `member` WHERE `username`=:username";
                $stmt = $conn->prepare($sql_query);
                $stmt->execute(["username" => $username]);
                $rows = $stmt->fetchAll();
                ?>
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-solid">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <img src="images/user-img.png" width="100%">
                            </div>
                            <div class="col-sm-9">
                                <?php foreach ($rows as $row) { ?>
                                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                        <div class="form-group">
                                            <label for="first_name">First Name:</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $row['f_name'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="last_name">Last Name:</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $row['l_name'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email:</label>
                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="contact">Contact Info:</label>
                                            <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter Your Phone Number.." value="<?php echo $row['Contact_info'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Address:</label>
                                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter Your country, Governorate, Region.." value="<?php echo $row['Address'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="member_since">Member Since:</label>
                                            <input type="text" class="form-control" id="member_since" name="member_since" value="<?php echo $row['Date'] ?>" disabled>
                                        </div>
                                        <input type="submit" class="btn btn-primary" value="Edit" name="submit">
                                    </form>
                                    <?php
                                    } 
                                    if(isset($succese_messege["Edit"])){
                                        echo "<div class='form-group'><div class='alert alert-success' role='alert'>".$succese_messege["Edit"]."</div></div>";
                                    $succese_messege=[];
                                    }elseif(isset($error['Edit'])){
                                        echo "<div class='form-group'><div class='alert alert-danger' role='alert'>".$error['Edit']."</div></div>";
                                            $error=[];
                                        }
                                    ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
                <hr>
            </div>
        </div>
    </div>
    <?php
    // Get Completed orders from the database
    $sql_select="SELECT  orders.`id` , `product_name`, `Quantity` , `Quantity` * mid(`price`,2,11) as total_price 
    , `order_date` ,`order_state` , `received_date`
    FROM `products` 
    join `orders`,`member` 
    where products.id= orders.id_for_product 
    AND member.id = orders.id_for_user";
    $stmt=$conn->prepare($sql_select);
    $stmt->execute();
    $rows=$stmt->fetchAll();
    ?>
        <!--Completed Orders List -->
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Previous orders</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Order id</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                        <th>Order Date</th>
                                        <th>Received Date</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($rows as $row){ 
                                        if($row["order_state"]==2){ ?>
                                                <tr>
                                                    <td><?php echo $row['id'] ?></td>
                                                    <td><?php echo $row['product_name'] ?></td>
                                                    <td><?php echo $row['Quantity'] ?></td>
                                                    <td><?php echo $row['total_price'] ?></td>
                                                    <td><?php echo $row['order_date'] ?></td>
                                                    <td><?php echo $row['received_date'] ?></td>
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
            <br><br>
            <br><br>
    <?php include "$footer" ?>
<?php } else {
    header("location:index.php");
} ?>
