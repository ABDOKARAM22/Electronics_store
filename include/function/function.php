<?php
// function filters the input from any tag
function testinput($value){
        trim($value);
        htmlentities($value);
        htmlspecialchars($value);
        strip_tags($value);
        return $value;
}

// function check valid email formate 
function valid_email($email){
if( filter_var($email,FILTER_VALIDATE_EMAIL)){
    filter_var($email,FILTER_SANITIZE_EMAIL);
    return true;
}else{
    return false;
}
}

   
// function check the length of character
function input_length($value,$length_min,$length_max){
        if((strlen($value) > $length_min && strlen($value) < $length_max )){
            return true;
    }else{
        return false;
    }
}

// function check if the name is string 
function input_string($value){
if(ctype_alpha($value)){
return true;
}else{
    return false;
}
}

// function to Hashing the passowrd
function hash_pass($passowrd){
 return password_hash($passowrd,PASSWORD_DEFAULT);
}

// function to delete any records from database
function Delete($table_name,$id) {
    global $conn;
    $sql="DELETE FROM `$table_name` WHERE `id`=:id";
    $stmt=$conn->prepare($sql);
    $stmt->execute(["id"=>$id]);
    $row=$stmt->rowCount();
    if($row > 0){
        return true;
    }
}

// function to view the products from database
function view($product_category,$limit=100,$path="?id="){
        global $conn;
        $sql="SELECT products.* , categories.name FROM products JOIN categories ON products.category = categories.id WHERE categories.name=:name LIMIT $limit";
        $stmt=$conn->prepare($sql);
        $stmt->execute(["name"=>$product_category]);
        $rows=$stmt->fetchAll();
        foreach($rows as $row){ ?>
        <div class="col-lg-3 col-6 col-md-3 col-sm-6 d-block m-auto" class="card-img img-fluid">
          <div class="card">
            <img class="card-img-top" src="<?php echo "images/product_image/".$row['image']?>" alt="Card image cap " class="card-img img-fluid">
            <div class="card-body">
              <h6 class="card-title text-center"><?php echo $row['product_name'] ?></h6>
              <P class="card-text text-center"><?php echo $row['description'] ?></P>
              <p class="card-text text-center"><?php echo $row['price'] ?></p>
              <a href="<?php echo $path. $row['id']  ?>" class="btn btn-secondary btn-Sm btn-block">Add Cart</a>
            </div>
          </div>
        </div>
        <?php } ?>
<?php } ?>

<?php
// finction to add the product to cart
function addToCart($conn, $user_id, $product_id) {
    $sql_insert = "INSERT INTO orders (`id_for_product`,`id_for_user`) VALUES (:id_for_product,:id_for_user)";
    try {
        $stmt = $conn->prepare($sql_insert);
        $stmt->execute(["id_for_user" => $user_id, "id_for_product" => $product_id]);
        return $stmt->rowCount();
    } catch (PDOException $e) {
        return 0;
    }
}

// function to count all items from any table
function count_item($item,$table,$where=""){
    global $conn;
    $sql="SELECT COUNT($item) FROM $table $where";
    $stmt=$conn->prepare($sql);
    $stmt->execute();
    $result=$stmt->fetchColumn();
    return $result;
} 

?>