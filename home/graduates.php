<?php 

    require_once('header.php');

    $course = '';
    $graduates = graduates($pdo);
    $years = years($pdo);

    if(isset($_GET['course'])){
        $graduates = graduates($pdo, $_GET['course'],'','');
        $years = years($pdo,$_GET['course']);
    }

    if(isset($_GET['year'])){
        $graduates = graduates($pdo, '',$_GET['year'],'');
    }

    if(isset($_GET['search'])){
        $graduates = graduates($pdo, '','',$_GET['search']);
    }

    if(isset($_GET['course']) && isset($_GET['year']) && isset($_GET['search'])){
        $graduates = graduates($pdo, $_GET['course'],$_GET['year'],$_GET['search']);
    }
    else{

    }


   
    if(isset($_GET['course'])){
        $course = $_GET['course'];
    }else{
        $course = 'All';
    }

?>

<div class="container-fluid">
    <br>
    <div class="row">
        <div class="col-md-3">
        <div class="card index">
            <div class="card-header text-center">
                <?php if(!$course == ''): ?>
                     <?php echo $course;?>
                <?php else: ?>
                   <p class="lead">All</p>
                <?php endif;?>
            </div>
            <li class="list-group-item">  <select id="course" class="form-control" required>
                        <option value="">Course</option>
                        <?php if($courses): ?>
                            <?php foreach($courses as $course):?>
                                <option value="<?php echo $course->course_code;?>" ><?php echo $course->course_code;?></option>
                            <?php endforeach;?>
                        <?php endif;?>
                    </select>   </li>
            <div class="card-body index-body">
            <ul class="list-group list-group-flush">
               

                <?php if($years): ?>
               
                <?php foreach($years as $year):?>
                    <a class="list-group-item year"  href="#!" data-year="<?php echo $year->year_graduated;?>"><span class="oi oi-folder"></span> <?php echo $year->year_graduated;?></a>
                <?php endforeach;?>
                 <?php endif;?>
       
               
            </ul>
            </div>
        </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                    <div class="card-body">
                    
                        <div class="row">
                            <div class="col-md-4">
                               <h3><span class="oi oi-people"></span> Graduates</h3>
                            </div>
                            <div class="col-md-4">
                                
                            </div>
                            <div class="col-md-4">
                                <div class="form-group text-right">
                                    <input type="text" class="form-control" placeholder="Search" id="search" required>
                                </div>
                            </div>
                        </div>
                        <?php if($graduates):?>
                            <div class="table-responsive">
                                <table class="table" id="graduate">
                                    <thead>
                                        <th>Graduate ID</th>
                                        <th>Full Name</th>
                                        <th>Gender</th>
                                        <th>Age</th>
                                        <th>Course</th>
                                        <th>School year</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        <?php foreach($graduates as $graduate):?>
                                            <tr>
                                                <td><?php echo $graduate->graduate_id;?></td>
                                                <td><?php echo $graduate->firstname . ' ' .$graduate->lastname ;?></td>
                                                <td><?php echo $graduate->gender;?></td>
                                                <td><?php echo $graduate->age;?></td>
                                                <td><?php echo $graduate->course_code;?></td>
                                                <td><?php echo $graduate->year_graduated;?></td>
                                                <td><a href="view_profile.php?graduate_id=<?php echo $graduate->graduate_id;?>" class="btn btn-outline-dark"><span class="oi oi-person"></span></a></td>
                                            </tr>
                                        <?php endforeach;?>
                                    
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning text-center">
                                No records found
                            </div>
                        <?php endif;?>
                    </div>
                    <div class="card-footer">
                            Total records: <?php if($graduates): ?>
                                     <?php echo count($graduates);?>
                                <?php else: ?>
                                         0
                                <?php endif;?>
                    </div>
                </div>
                
            </div>
    </div>

</div>

<hr>


<script>

    $('#graduate').DataTable( {
        "ordering": false,
        "info":     false
    } );

    var url = window.location.href;  

    $( "#course" ).change(function() {

        window.location.href = '?course=' + $(this).val();
         
    });

    $( ".year" ).click(function() {
        window.location.href =	updateQueryStringParameter( url, 'year', $(this).data("year") );
       
    });

    $('#search').keypress(function (e) {
        if (e.which == 13) {
            window.location.href =	updateQueryStringParameter( url, 'search', $(this).val() )
        }
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