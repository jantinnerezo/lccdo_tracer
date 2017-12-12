<?php 

    require_once('header.php');
    require_once('controller.php');

   
    $profile = view_profile($pdo,$_GET['graduate_id']);
    $jobs = job_history($pdo,$_GET['graduate_id']);

?>

<div class="container">
<div class="row profile-cover">
        <div class="overlay"></div>
        <div class="col-md-4">
        </div>
        <div class="col-md-4 text-center">
            <div class="avatar" style="background-image:url('../resources/img/avatar/<?php echo $profile->img;?>')">
            </div>
            <br>    
            <h3><?php echo $profile->firstname . ' ' .$profile->lastname;?></h3>
        </div>
        <div class="col-md-4">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
        <ul class="list-group">
            <li class="list-group-item lead">Full Name: <?php echo $profile->firstname . ' ' .$profile->lastname;?></li>
            <li class="list-group-item lead">Gender: <?php echo $profile->gender;?></li>
            <li class="list-group-item lead">Age: <?php echo $profile->age;?></li>
            <li class="list-group-item lead">Course: <?php echo $profile->course_code;?></li>
            <li class="list-group-item lead">Year graduated: <?php echo $profile->year_graduated;?></li>
            <li class="list-group-item lead">Phone: <?php echo $profile->phone;?></li>
        </ul>
           
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-info">
                    <span class="oi oi-briefcase"></span> Job History
                    </h3>

                    <?php if(!isset($_SESSION['username']) || empty($_SESSION['username'])):?>
                        <div class="alert alert-warning text-center">
                            <a href="login.php">Login</a> to view <?php echo $profile->firstname;?>'s job history
                        </div>
                    <?php else: ?>

                        <?php if($jobs):?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <th>Date hired</th>
                                        <th>Company</th>
                                        <th>Position</th>
                                        <th>Remarks</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach($jobs as $job):?>
                                            <tr>
                                                <td><?php echo $job->date_hired;?></td>
                                                <td><?php echo $job->company;?></td>
                                                <td><?php echo $job->position;?></td>
                                                <td>
                                                <?php if($job->remarks == 1):?>
                                                     Current job
                                                <?php else: ?>
                                                     Past job
                                                <?php endif;?>
                                            </td>
                                            </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning text-center">
                                <?php echo $profile->firstname;?> haven't yet added a job history.
                            </div>
                        <?php endif;?>
                        
                    <?php endif;?>

                </div>
            </div>
        </div>
    </div>
</div>

<hr>


<script>

  

    var url = window.location.href;  


    function updateQueryStringParameter(uri, key, value) {
            var re = new RegExp("([?&])" + key + "=.*?(&|#|$)", "i");
            if( value === undefined ) {
            if (uri.match(re)) {
                return uri.replace(re, '$1$2');
            } else {
                return uri;
            }
            } else {
            if (uri.match(re)) {
                return uri.replace(re, '$1' + key + "=" + value + '$2');
            } else {
            var hash =  '';
            if( uri.indexOf('#') !== -1 ){
                hash = uri.replace(/.*#/, '#');
                uri = uri.replace(/#.*/, '');
            }
            var separator = uri.indexOf('?') !== -1 ? "&" : "?";    
            return uri + separator + key + "=" + value + hash;
            }
            }  
    }
   		
</script>

<?php require_once('footer.php');?>