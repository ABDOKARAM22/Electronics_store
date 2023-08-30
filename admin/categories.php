<?php
if($do == "add_category"){
    
    if($_SERVER["REQUEST_METHOD"]=="POST"){

        if(isset($_POST["add"])){
            
            $category_name=testinput($_POST["c_name"]);
            
            if(!empty($category_name)){
                $sql_query="INSERT INTO `categories` (`name`) VALUE (:name)";
                $stmt=$conn->prepare($sql_query);
                $stmt->execute(["name"=>$category_name]);
                $row=$stmt->rowCount();

                if($row >0 ){

                    $succese_messege="Added Done";
                }
            }else{
                $error="The Category Name Is Required..";
            }
        }
    }
?>
<!-- Add New category Form -->
    <main>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Add New Category</h5>
                            <form  action="?do=add_category" method="POST">
                                <div class="form-group">
                                    <label for="category-name">Category Name</label>
                                    <input type="text" name="c_name" class="form-control" id="category-name"
                                    placeholder="Enter Category name">
                                </div>
                                <?php
                                if(isset($error)){
                                    echo "<div class='form-group'>
                                    <div class='alert alert-danger' role='alert'>"
                                    .$error.
                                    "</div>
                                    </div>";
                                }elseif(isset($succese_messege)){
                                    echo "<div class='form-group'>
                                    <div class='alert alert-success' role='alert'>"
                                    .$succese_messege.
                                    "</div>
                                    </div>";
                                }
                            ?>
                                <button type="submit" name="add" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php }elseif($do=="all_category"){
    $sql_query= "SELECT * FROM `categories`";
    $stmt=$conn->prepare($sql_query);
    $stmt->execute();
    $rows=$stmt->fetchAll();
    ?>
    <!--view categories List -->     
    <main>
            <div class="container mt-4">
                <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Categories List</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Category Name</th>
                                        <th>Delete/Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($rows as $row){?>
                                        <tr>
                                        <td><?php echo $row['id'] ?></td>
                                        <td><?php echo $row['name'] ?></td>
                                        <td>
                                        <a  href="delete.php?id_category=<?php echo $row['id']?>"
                                        class="delete" title="Delete" data-toggle="tooltip"><i class="fas fa-trash"></i></a>
                                        /
                                        <a href="?do=edit_cat&id=<?php echo $row['id']?>"
                                        class="edit" title="Edit" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                                        </td>
                                        </td>
                                        
                                        </tr> 
                                    <?php  } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php }elseif($do === "edit_cat" && isset($_GET['id']) ||isset($_POST["Edit_cat"]) ){

        if(isset($_GET['id'])){
            $category_id=$_GET['id'];
        }

        if($_SERVER['REQUEST_METHOD']=="POST"){
            if(isset($_POST["Edit_cat"])){
            $category_name =  $_POST['category_name'];
            $category_id =  $_POST['category_id'];
            if(empty($category_name)){
                $error= "The Name Is Requerd." ;
            }  
            }
            
            if(empty ($error)){
                // update the name in the database
            $sql_update= "UPDATE categories SET `name` = :name WHERE `id`=$category_id";
            $stmt=$conn->prepare($sql_update);
            $stmt->execute(['name'=>$category_name]);
            $result=$stmt->rowCount();
            if($result>0){
                $succese_messege ="The Edit Is Done.";
            }
            
        }
    }
        // Select the category information from database
        $categorySql = "SELECT * FROM categories WHERE id=$category_id";
        $categoryStmt = $conn->prepare($categorySql);
        $categoryStmt->execute();
        $categories = $categoryStmt->fetchAll();
    ?>



        <main>
            <div class="container mt-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Edit Category</h5>
                                <form  action="<?php echo $_SERVER['PHP_SELF'] ?>?do=edit_cat" method="POST" >
                                    <?php   foreach($categories as $category):  ?>

                                        <div class="form-group">
                                            <label for="category_name">Category Name</label>
                                            <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo $category['name'] ?>">
                                        </div>
                                        
                                    <input type="hidden" name="category_id" value="<?php echo $category['id'] ?>">
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
                                <input type="submit" value="Edit" name="Edit_cat" class="form-control btn-secondary" ></input>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
<?php }else{
    echo "<center>ERRor</center>";
} ?>