<?php if($do == "Members"){
    
    // Get And view All admin from database
        $select_all_query='SELECT `f_name`,`l_name`,`email`,`Date`,`id` FROM member WHERE `type`=:type';
        $stmt=$conn->prepare($select_all_query);
        $stmt->execute(["type"=>0]);
        $rows=$stmt->fetchAll();

?>
<main>
    <!-- Products List -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Members List</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Total Orders</th>
                                        <th>Member since</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php    foreach($rows as $row){ ?>
                                            <tr>
                                                <td><?php echo $row['f_name'] ?></td>
                                                <td><?php echo $row['l_name'] ?></td>
                                                <td><?php echo $row['email'] ?></td>
                                                <td> 0 </td>
                                                <td><?php echo $row['Date'] ?></td>
                                                <td>
                                                 <a  href="delete.php?member_id=<?php echo $row['id']?>"
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
</main>
<?php } ?>