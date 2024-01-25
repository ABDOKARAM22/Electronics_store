<div class="container-fluid p-0">
  <nav class="navbar navbar-expand-md bg-secondary navbar-dark fixed-top">
    <div class="container">
      <a href="index.php" class="navbar-brand">
        <img src="images/logo.png" alt="Logo" class="logo">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsenavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse text-center" id="collapsenavbar">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a href="index.php" class="nav-link text-white">HOME</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Product
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <!-- get the categories list from database -->
              <?php $sql_query= "SELECT * FROM `categories`";
              $stmt=$conn->prepare($sql_query);
              $stmt->execute();
              $rows=$stmt->fetchAll();
              foreach($rows as $row){?>
              <a class="dropdown-item" href="product.php?do=<?php echo $row['id'] ?>"><?php echo $row['name'] ?></a>
              <?php  }  ?>
            </div>
          </li>
          <li class="nav-item">
            <a href="about.php" class="nav-link text-white">ABOUT</a>
          </li>
          <li class="nav-item">
            <a href="contact.php" class="nav-link text-white">CONTACT</a>
          </li>
          <?php if (isset($_SESSION['user'])) { ?>

          <li class="nav-item">
            <a href="cart.php" class="nav-link text-white"><i class="fa fa-cart-plus" aria-hidden="true"></i></a>
          </li>
         <?php } ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-user-circle" aria-hidden="true"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <?php if (!isset($_SESSION['user'])) { ?>
                <a class="dropdown-item" href="login.php">Login</a>
                <a class="dropdown-item" href="register.php">Register</a>
              <?php } ?>
              <?php if (isset($_SESSION['user'])) { ?>
                <a class="dropdown-item" href="profile.php">Profile</a>
                <a class="dropdown-item" href="logout.php">Logout</a>
              <?php } ?>
            </div>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
          <input class="form-control mr-sm-2" name="Search" type="text" placeholder="Search" aria-label="Search">
          <input class="btn btn-outline-success my-2 my-sm-0" type="submit" name="submit" value="Search">
        </form>
      </div>
    </div>
  </nav>
</div>
