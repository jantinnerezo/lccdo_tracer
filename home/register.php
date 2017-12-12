<?php 
    require_once('reg_header.php');
    $username_existed = false;
    $successful = false;

    if(isset($_GET['email_existed'])){

        $username_existed = true;
    }
    if(isset($_GET['successful'])){
        
        $successful = true;
    }
?>

<?php if($successful): ?>
    <div class="container">
        <br>
        <div class="jumbotron">
            <h2 class="display-4 text-center">Registration successful!</h2>
            <div class="container">
            <p class="lead text-center">Praised be Jesus and Mary! We will now review your information provided and we'll let you know if your account is verified by sending you a text message. Thank you!</p>
            </div>
        </div>
    </div>
<?php else: ?>
   
    <div class="is-flex">
    <div class="register">

    <?php if($username_existed): ?>
        <div class="alert alert-danger">
            <?php echo $_GET['username_existed'] . ' already exist!'; ?>
        </div>
    <?php endif;?>

        
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center"><span class="oi oi-pencil"></span> Registration</h4>
                <hr>
                <form action="controller.php" method="POST" id="registerForm">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Last Name" name="lastname" id="lastname">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="First Name" name="firstname" id="firstname">
                    </div>
                    <div class="form-group">
                        <select name="gender" class="form-control" id="gender" >
                            <option value="">Gender</option>
                            <option value="male" >Male</option>
                            <option value="female" >Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" placeholder="Age" name="age" id="age">
                    </div>
                    <div class="form-group">
                        <select name="course_code" class="form-control" id="course_code">
                            <option value="">Course graduated</option>
                            <?php if($courses): ?>
                                <?php foreach($courses as $course):?>
                                    <option value="<?php echo $course->course_code;?>" ><?php echo $course->course_description;?></option>
                                <?php endforeach;?>
                            <?php endif;?>
                        </select>   
                    </div>

                    <div class="form-group">
                        <?php
                            $present = Date('Y');
                            $since = 1928;
                            
                            echo '<select name="year_graduated" class="form-control" id="year_graduated">';
                                echo '<option value="">Year graduated</option>';
                                foreach (range(date('Y'), $since) as $x) {
                                    echo '<option value="'.$x.'"'.($x === $present ? ' selected="selected"' : '').'>'.$x.'</option>';
                                }
                            echo '</select>';
                            ?>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Username" name="username" id="username">
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Confirm password" name="password1" id="password1">
                    </div>

                    <div class="form-group">
                        <input type="number" class="form-control" placeholder="Phone" name="phone" id="phone">
                    </div>

                    <div class="form-group">
                        <input type="submit" value="Submit form" class="btn btn-info btn-block" name="register">
                    </div>
               </form>
            </div>
        </div>
        
    </div>
</div>


<?php endif;?>

<script>
    	
        
        $( document ).ready( function () {
			$( "#registerForm" ).validate( {
				rules: {
					firstname: "required",
                    lastname: "required",
                    gender: "required",
                    age: "required",
                    course_code: "required",
                    year_graduated: "required",
					password: {
						required: true,
						minlength: 8
					},
					password1: {
						required: true,
						minlength: 8,
						equalTo: "#password"
					},
					phone: {
						required: true,
						minlength: 11
					}

				},
				messages: {
					firstname: "Please enter your firstname",
                    lastname: "Please enter your lastname",
                    gender: "Please select your gender",
                    age: "Please enter your age",
                    course_code: "Please specify course graduated",
                    year_graduated: "Please specify year graduated",
					password: {
						required: "Please provide a password",
						minlength: "Your password must be at least 8 characters long"
					},
					password1: {
						required: "Please confirm your password",
						minlength: "Your password must be at least 8 characters long",
						equalTo: "Please enter the same password as above"
					},
					username: "Please choose a username",
                    phone: {
						required: "Phone number is required to keep it touch with you.",
						minlength: "Invalid phone number"
					
					}
				},
				errorElement: "em",
				errorPlacement: function ( error, element ) {
					// Add the `help-block` class to the error element
					error.addClass( "help-block" );

					if ( element.prop( "type" ) === "checkbox" ) {
						error.insertAfter( element.parent( "label" ) );
					} else {
						error.insertAfter( element );
					}
				},
				highlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
				},
				unhighlight: function (element, errorClass, validClass) {
					$( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
				}
            } );
            
        });
</script>

<?php require_once('footer.php'); ?>