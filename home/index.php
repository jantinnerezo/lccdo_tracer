<?php require_once('header.php');?>

<div class="container">
    <br>
    <div class="jumbotron">
        <h2 class="display-4 text-center">Welcome to</h2>
        <h2 class="display-3 text-center"><?php echo PROJECT_NAME;?></h2>
        <hr class="my-4">
        <?php if(!isset($_SESSION['username']) || empty($_SESSION['username'])):?>
            <p class="end text-center">
            <span class="lead">Are you a Lourdes College graduate?</span><a  class="btn btn-link" href="register.php" role="button"> Register now!</a>
            </p>
        <?php else: ?>
            <p class="end text-center">
                <a class="btn btn-outline-info btn-lg" href="profile.php" role="button"><span class="oi oi-person"></span> Go to my Profile</a>
            </p>
        <?php endif;?>
        
    </div>


</div>

<?php require_once('footer.php');?>