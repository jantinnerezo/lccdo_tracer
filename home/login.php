<?php
   require_once('header.php');

   $error = false;

   $url = '';

 
     // Process form when post submit
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Sanitize POST
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    // Put post vars in regular vars
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = 'SELECT graduate_id, username, password FROM tbl_graduates WHERE username = :username ';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    if($stmt->rowCount() === 1){

        $row = $stmt->fetch();
        $hashed_password = $row->password;
        if(password_verify($password, $hashed_password)){
          // SUCCESSFUL LOGIN
    
          $_SESSION['username'] = $username;
          $_SESSION['graduate_id'] = $row->graduate_id;
          header('location: profile.php');
          $error = false;
         
        } else {
          
          $error = true;
        }

    }else{

        $error = true;
    }

    
   
  }

?>

<?php if(isset($_SESSION['username']) || !empty($_SESSION['username'])):?>
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