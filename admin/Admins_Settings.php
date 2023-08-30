<?php
$error=[];
$succese_messege=[];
?>
<!-- 
###################    
Admin_Profile Page
###################
-->
<?php if($do === "Admin_Profile"){
    // Check if the HTTP request method is POST
    if($_SERVER['REQUEST_METHOD']=="POST"){
        if(isset($_POST["Edit"])){
            foreach($_POST as $key => $value){
                $$key=testinput($value);
                // check if the faild is not empty
                if(empty($value)){
                    $error["Edit"]="All Faild Is Requerd.";
                }
            }
            // Put the updated data into the database
            if(empty($error)){
                $update_query= "UPDATE `member` SET `f_name`=:f_name, `l_name`=:l_name, `email`=:email WHERE `username`=:username";
                $stmt=$conn->prepare($update_query);
                $stmt->execute(
                    ["f_name" =>$first_name,
                    "l_name" => $last_name,
                    "email" => $email,
                    "username" => $Admin_user
                ]);
                if($stmt){
                    $succese_messege["Edit"]="Update is Done";
                }
            }
            }
        }
        // Get admin_information from  the database
        if(isset($_SESSION['Admin'])){
            $select_query="SELECT `f_name`, `l_name`, `email`,`date` FROM `member` WHERE `username`=:username";
            $stmt=$conn->prepare($select_query);
            $stmt->execute(["username"=>$Admin_user]);
            $rows=$stmt->fetchAll();
        }
        ?>
    <!-- View Admin information -->
    <main>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Admin Information</h5>
                            <form id='Edit_admin' action="<?php echo $_SERVER['PHP_SELF'] ?>?do=Admin_Profile" method="POST">
                                <?php   foreach($rows as $row):  ?>
                                    <div class="form-group">
                                        <label for="First_name">FIrst name</label>
                                        <input type="text" class="form-control" id="First_name" name="first_name" value="<?php echo $row['f_name'] ?>">
                                    </div>
                                    <div class="form-group">
                                    <label for="Last_name">Last name</label>
                                    <input type="text" class="form-control" id="Last_name" name="last_name" value="<?php echo $row['l_name'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="Email">Email</label>
                                    <input type="email" class="form-control" name="email" id="Email"
                                    value="<?php echo $row['email'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="Date">Joined since</label>
                                    <input type="text" class="form-control" id="Date"
                                    value="<?php echo $row['date'] ?>" disabled>
                                </div>
                            <?php 
                                        endforeach;
                               if(isset($succese_messege["Edit"])){
                                   echo "<div class='form-group'>
                                   <div class='alert alert-success' role='alert'>"
                                   .$succese_messege["Edit"].
                                   "</div>
                                   </div>";
                                   $succese_messege=[];
                                   
                                }elseif(isset($error['Edit'])){
                                    
                                    echo "<div class='form-group'>
                                    <div class='alert alert-danger' role='alert'>"
                                    .$error['Edit'].
                                    "</div>
                                    </div>";
                                    $error=[];
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
            <!-- 
    ###################    
    Add_Admin Page
    ###################
-->
<?php }elseif($do ==="Add_Admin"){ 

    // Check if the HTTP request method is POST
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        if(isset($_POST["Add"])){
            foreach($_POST as $key => $value){
                $$key=testinput($value);
                // check if the faild is not empty
                if(empty($value)){
                    $error["Add"]="All Faild Is Requerd.";
                }
            }
            
            if($password !== $re_password){
                $error["Add"]="The Passwords Must Be Match.";
            }
                // ADD New Admin
            if(empty($error)){
                $hash_pass=hash_pass($password);
                $hash_repass=hash_pass($re_password);
                $insert_query="INSERT INTO `member`(`username`, `f_name`, `l_name`, `email`, `password`, `re_password` , `type`) 
                VALUES (:username, :f_name, :l_name, :email, :password, :re_password ,:type)";
                $stmt=$conn->prepare($insert_query);
                $stmt->execute(["username"=>$username,
                "f_name"=>$first_name,
                "l_name"=>$last_name,
                "email"=>$email,
                "password"=>$hash_pass,
                "re_password"=>$hash_repass,
                "type" =>1]);
                if($stmt->rowCount()>0){
                    $succese_messege["Add"]="Added Done";
                }
                
            }
        }       
    }
?>
    <main>
        <!-- Add New Admin -->
        <div class="container mt-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Add Admin</h5>
                                        <form id='Add_admin' action="<?php echo $_SERVER['PHP_SELF'] ?>?do=Add_Admin" method="POST">
                                    <div class="form-group">
                                        <label for="add_username">Username</label>
                                        <input type="text" class="form-control" name="username" id="add_username"
                                        placeholder="Enter Username">
                                    </div>
                                    <div class="form-group">
                                        <label for="add_f_name">First name</label>
                                        <input type="text" class="form-control" name="first_name" id="add_f_name"
                                        placeholder="Enter First name">
                                    </div>
                                    <div class="form-group">
                                        <label for="add_l_name">Last name</label>
                                        <input type="text" class="form-control" name="last_name" id="add_l_name"
                                        placeholder="Enter Last name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email">
                                    </div>
                                    <div class="form-group">
                                        <label for="addpassword">Password</label>
                                        <input type="password" class="form-control" name="password" id="addpassword"
                                        placeholder="Enter password">
                                    </div>
                                    <div class="form-group">
                                        <label for="re_password">Re Password</label>
                                        <input type="password" class="form-control" name="re_password" id="re_password"
                                        placeholder="Retype password">
                                    </div>
                                    <?php if(isset($succese_messege["Add"])){
                                        
                                        echo "<div class='form-group'>
                                    <div class='alert alert-success' role='alert'>"
                                    .$succese_messege["Add"].
                                    "</div>
                                    </div>";
                                    $succese_messege=[];
                                }elseif(isset($error['Add'])){
                                    
                                    echo "<div class='form-group'>
                                    <div class='alert alert-danger' role='alert'>"
                                    .$error['Add'].
                                    "</div>
                                    </div>";
                                    $error=[];
                                }
                                ?>
                                <div class="form-group">
                                    <input type="submit" class="form-control btn-secondary" name="Add">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </main>
            
<!-- 
###################    
View_Admins Page
###################
-->
        <?php  }elseif($do ==="View_Admins"){ ?>
            
        <main>
            <!-- Get And view All admin from database -->
            <?php 
                $select_all_query='SELECT `f_name`,`email`,`id` FROM member WHERE `type`=:type';
                $stmt=$conn->prepare($select_all_query);
                $stmt->execute(["type"=>1]);
                $rows=$stmt->fetchAll();
                ?>
            <div class="container mt-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Admins List</h5>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Admin Name</th>
                                            <th>Email</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php    foreach($rows as $row){ ?>
                                            <tr>
                                                <td><?php echo $row['f_name'] ?></td>
                                                <td><?php echo $row['email'] ?></td>
                                                <td>
                                                <a  href="delete.php?admin_id=<?php echo $row['id']?>"
                                                class="delete" title="Delete" data-toggle="tooltip"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr> 
                                            <?php  }   ?> 
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</main>
<?php } ?> 
