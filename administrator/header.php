<?php 
    require_once('../config/globals.php');
    $courses = courses($pdo);
    $unverified = unverified($pdo);
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    
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


    <link rel="icon" href="<?php echo ROOT_URL;?>/resources/img/lc.ico">

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

                <?php if(!isset($_SESSION['admin']) || empty($_SESSION['admin'])):?>

                <?php else:?>
                <li class="nav-item">
                        <a class="nav-link" href="index.php"><span class="oi oi-people"></span> Graduates</a>
                    </li>

                    <?php if($unverified) :?>
                        <li class="nav-item">
                            <a class="nav-link" href="#!" data-toggle="modal" data-target="#notification"><span class="oi oi-bell"></span> Notifications <span class="badge badge-danger"><?php echo count($unverified);?></span></a>
                        </li>
                    <?php endif;?>                    
                    <li class="nav-item">
                        <a class="nav-link" href="controller.php?logout=true"><span class="oi oi-account-logout"></span> Logout</a>
                    </li>

                <?php endif;?>
                  
                </ul>
                </div>
        </div>
    </nav> 


    <div class="modal fade" id="notification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="list-group notification">
                        <?php if($unverified) :?>
                            <?php foreach($unverified as $unverify):?>
                                <div href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1"><?php echo $unverify->firstname .' '.$unverify->lastname;?></h5>
                                    <a href="controller.php?verify=<?php echo $unverify->graduate_id;?>" class="btn btn-success text-right">Verify</a>
                                </div>
                                <p class="mb-1">Course: <?php echo $unverify->course_code;?></p>
                                <p class="mb-1">Year graduated: <?php echo $unverify->year_graduated;?></p>
                                
                                </div>
                            <?php endforeach;?>
                        <?php endif;?>
                </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
    </div>
    </div>
    </div>

   
    
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

    
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
</body>
</html>