<?php

   require_once('../config/config.php');
   $error = false;

   $url = '';

 
     // Process form when post submit
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Sanitize POST
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    // Put post vars in regular vars
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = 'SELECT* FROM tbl_admin WHERE username = :username AND password = :password';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->execute();

    if($stmt->rowCount() === 1){

      
        session_start();
          $_SESSION['admin'] = true;
          header('location: index.php');
          $error = false;
         

    }else{

        $error = true;
    }

    
   
  }

?>
<?php require_once('header.php');?>

<?php if(isset($_SESSION['admin']) || !empty($_SESSION['admin'])):?>
    <?php include_once('index.php');?>
<?php else: ?>

<div class="login">
    <div class="inner-login">
        <?php if($error):?>
            <div class="alert alert-danger text-center">
                Username or password is incorrect!
            </div>
        <?php endif;?>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center"><span class="oi oi-account-login"></span> Login</h4>
                <hr>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Login" class="btn btn-success btn-block">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php endif;?>

<?php
    require_once('footer.php');
?>