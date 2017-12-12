<?php 

    require_once('header.php');
    require_once('controller.php');
    
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
   
    if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
        header('location: login.php');
        exit;
    }else{
        $profile = view_profile($pdo,$_SESSION['graduate_id']);
        $jobs = job_history($pdo,$_SESSION['graduate_id']);
    }

?>

<div class="container">
    <div class="row profile-cover">
        <div class="overlay"></div>
        <div class="col-md-4">
        </div>
        <div class="col-md-4 text-center">
            <div class="avatar" style="background-image:url('../resources/img/avatar/<?php echo $profile->img;?>')">
            </div>
            <a href="#!" class="btn btn-link" data-toggle="modal" data-target="#addImage">Change</a>
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
            <a href="#" class="list-group-item list-group-item-action text-info" data-toggle="modal" data-target="#editProfile"><span class="oi oi-pencil"></span> Edit Profile</a>
        </ul>
           
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                             <h3 class="card-title text-info">
                                <span class="oi oi-briefcase"></span> Job History
                            </h3>
                        </div>
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-4 text-right">
                            <button class="btn btn-success" data-toggle="modal" data-target="#jobModal"><span class="oi oi-plus"></span> Add job</button>
                        </div>
                    </div>
                  
                    <?php if($jobs):?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <th>Date hired</th>
                                    <th>Company</th>
                                    <th>Position</th>
                                    <th>Remarks</th>
                                    <th></th>
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
                                            <td class="dropdown">
                                            <button class="btn btn-outline-info dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item edit" href="#!" data-target="#editJob" data-toggle="modal" 
                                                data-id="<?php echo $job->job_id;?>"
                                                data-date_hired="<?php echo $job->date_hired;?>"
                                                data-company="<?php echo $job->company;?>"
                                                data-position="<?php echo $job->position;?>"
                                                data-remarks="<?php echo $job->remarks;?>"

                                                ><span class="oi oi-pencil"></span> Edit</a>
                                                <a class="dropdown-item" href="controller.php?delete_job=<?php echo $job->job_id;?>"><span class="oi oi-trash"></span> Remove</a>
                                            </div>

                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                    <hr>
                        <div class="alert alert-warning text-center">
                            You haven't yet added a job history yet.
                        </div>
                    <?php endif;?>
                        
                  

                </div>

                <div class="card-footer">
                    <?php if($jobs):?>
                         Total records: <?php echo count($jobs);?>
                    <?php else: ?>
                         Total records: 0
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>

<hr>



<!-- Add job modal -->
<div class="modal fade" id="jobModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span class="oi oi-briefcase"></span> Add job history</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="controller.php" method="POST">
        <div class="modal-body">
            
                <input type="hidden" class="form-control" name="graduate_id" value="<?php echo $_SESSION['graduate_id'];?>" readonly required>

                <div class="form-group">
                    <label>Date hired:</label>
                    <input type="date" class="form-control" name="date_hired" required>
                </div>
                <div class="form-group">
                    <label>Company:</label>
                    <input type="text" class="form-control" name="company" required>
                </div>
                <div class="form-group">
                    <label>Position:</label>
                    <input type="text" class="form-control" name="position" required>
                </div>
                <div class="form-group">
                    <label>Remarks:</label>
                    <select name="remarks" class="form-control">
                        <option value="1">Current job</option>
                        <option value="2">Past job</option>
                    </select>
                </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" name="add_job">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Add job modal -->
<div class="modal fade" id="editJob" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span class="oi oi-pencil"></span> Edit Job</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="controller.php" method="POST">
        <div class="modal-body">
            
                <input type="hidden" class="form-control" name="job_id" id="job_id" readonly required>

                <div class="form-group">
                    <label>Date hired:</label>
                    <input type="date" class="form-control" name="date_hired" id="date_hired" required>
                </div>
                <div class="form-group">
                    <label>Company:</label>
                    <input type="text" class="form-control" name="company" id="company" required>
                </div>
                <div class="form-group">
                    <label>Position:</label>
                    <input type="text" class="form-control" name="position" id="position" required>
                </div>
                <div class="form-group">
                    <label>Remarks:</label>
                    <select name="remarks" class="form-control" id="remarks">
                        <option value="1">Current job</option>
                        <option value="2">Past job</option>
                    </select>
                </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" name="edit_job">Update job</button>
        </div>
      </form>
    </div>
  </div>
</div>



<!-- Edit profile modal -->
<div class="modal fade" id="editProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span class="oi oi-pencil"></span> Edit Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="controller.php" method="POST">
        <div class="modal-body">
            
                <input type="hidden" class="form-control" name="graduate_id" value="<?php echo $_SESSION['graduate_id'];?>" readonly required>

                <div class="form-group">
                    <label>First Name:</label>
                    <input type="text" class="form-control" name="firstname" value="<?php echo $profile->firstname;?>" required>
                </div>
                <div class="form-group">
                    <label>Last Name:</label>
                    <input type="text" class="form-control" name="lastname" value="<?php echo $profile->lastname;?>" required>
                </div>
                <div class="form-group">
                    <label>Gender:</label>
                    <select name="gender" class="form-control" name="gender" >
                        <option value="<?php echo $profile->gender;?>"><?php echo $profile->gender;?></option>
                        <option value="male" >Male</option>
                        <option value="female" >Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Age:</label>
                    <input type="number" class="form-control" name="age" value="<?php echo $profile->age;?>" required>
                </div>
                <div class="form-group">
                    <label>Course graduated:</label>
                    <select name="course_code" class="form-control" id="course_code">
                        <option value="<?php echo $profile->course_code;?>"><?php echo $profile->course_code;?></option>
                        <?php if($courses): ?>
                            <?php foreach($courses as $course):?>
                                <option value="<?php echo $course->course_code;?>" ><?php echo $course->course_description;?></option>
                            <?php endforeach;?>
                        <?php endif;?>
                    </select>   
                </div>
                <div class="form-group">
                    <label>Year graduated:</label>
                    <?php
                        $present = Date('Y');
                        $since = 1928;
                        
                        echo '<select name="year_graduated" class="form-control" id="year_graduated">';
                            echo '<option value="'.$profile->year_graduated.'">'.$profile->year_graduated.'</option>';
                            foreach (range(date('Y'), $since) as $x) {
                                echo '<option value="'.$x.'"'.($x === $present ? ' selected="selected"' : '').'>'.$x.'</option>';
                            }
                        echo '</select>';
                        ?>
                </div>
                <div class="form-group">
                    <label>Phone:</label>
                    <input type="number" class="form-control" name="phone" value="<?php echo $profile->phone;?>" required>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" name="edit_profile">Update profile</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Upload image -->
<div class="modal fade" id="addImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Change profile picture</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <form action="controller.php" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
                <input type="hidden" name="graduate_id" value="<?php echo $profile->graduate_id;?>" class="form-control">
                Select image to upload:
                <div class="form-group">
                    <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
                </div>
            
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" name="add_image">Save picture</button>
        </div>
    </form>
  </div>
</div>
</div>

<script>

  

    var url = window.location.href;  

    $('.edit').click(function(){
        $('#job_id').val($(this).data("id"));
        $('#date_hired').val($(this).data("date_hired"));
        $('#company').val($(this).data("company"));
        $('#position').val($(this).data("position"));
        $('#remarks').val($(this).data("remarks"));

    });


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