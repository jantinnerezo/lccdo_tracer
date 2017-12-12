<?php 
    require_once('../config/globals.php');
    $courses = courses($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo PROJECT_NAME;?></title>

    <!-- Bootstrap 4 cdn -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

    <!-- Custom css -->
    <link rel="stylesheet" href="../resources/css/style.css">

    <!-- Icon fonts -->
    <link rel="stylesheet" href="../resources/css/open-iconic-bootstrap.css">

</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../resources/img/lc.png" width="30" height="30" class="d-inline-block align-top" alt="">
                Lourdes College Tracer System
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                <ul class="nav navbar-nav  bg-dark">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><span class="oi oi-home"></span> Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Courses
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php if($courses): ?>
                                    <a class="dropdown-item" href="graduates.php">All</a>
                                <?php foreach($courses as $course):?>
                                    <a class="dropdown-item" href="graduates.php?course=<?php echo $course->course_code;?>"><?php echo $course->course_code;?></a>
                                <?php endforeach;?>
                            <?php endif;?>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php"><span class="oi oi-pencil"></span> Registration</a>   
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php"><span class="oi oi-account-login"></span> Login</a>
                    </li>
                    </ul>
                </div>
        </div>
    </nav> 

    
    
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

    
    <script type="text/javascript" src="<?php echo ROOT_URL;?>/resources/js/jquery-1.11.1.js"></script>
	<script type="text/javascript" src="<?php echo ROOT_URL;?>/resources/js/jquery.validate.js"></script>
</body>
</html>