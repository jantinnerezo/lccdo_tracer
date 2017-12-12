<?php

    require_once('../config/config.php');

  
    // When the user submits from registration page
    if(isset($_POST['register'])){

        $graduate_id = uniqid();
        $date_registered = Date('Y-m-d H:i:s'); // Registration date

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $lastname = trim($_POST['lastname']);
        $firstname = trim($_POST['firstname']);
        $gender = trim($_POST['gender']);
        $age = trim($_POST['age']);
        $course_code = trim($_POST['course_code']);
        $year_graduated = trim($_POST['year_graduated']);
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $phone = trim($_POST['phone']);
        $status = 0;

          // Check username if already exist first
        $existed = check_username($pdo, $username);

        if($existed){
            header('location:register.php?username_existed='.$username);
        }else{

            $modified = $year_graduated . '-01-01';
            $get_backyear = strtotime($modified.'-1 year');
            
            $school_year = Date('Y',$get_backyear) . '-'.$year_graduated;
    
            $hashed_password = password_encrypter($password); // encrypt password
            try{
                // Sql query
                $sql = 'INSERT INTO tbl_graduates(graduate_id, lastname, firstname,gender,age, course_code, year_graduated, username,password,phone,date_registered) VALUES(:graduate_id, :lastname, :firstname,:gender,:age, :course_code, :year_graduated, :username,:password,:phone,:date_registered)';
    
                $stmt    = $pdo->prepare($sql); // Prepared statement
                $stmt->bindParam(':graduate_id', $graduate_id, PDO::PARAM_STR);
                $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
                $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
                $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
                $stmt->bindParam(':age', $age, PDO::PARAM_STR);
                $stmt->bindParam(':course_code', $course_code, PDO::PARAM_STR);
                $stmt->bindParam(':year_graduated', $school_year, PDO::PARAM_STR);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
                $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
                $stmt->bindParam(':date_registered', $date_registered, PDO::PARAM_STR);
                $stmt->execute();
                
                header('location:register.php?successful=true');
    
            }
            catch(PDOException $e){
                return false;
            }

        }
            
    }


    if(isset($_POST['edit_profile'])){
        
        
        $date_registered = Date('Y-m-d H:i:s'); // Registration date

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $graduate_id = trim($_POST['graduate_id']);
        $lastname = trim($_POST['lastname']);
        $firstname = trim($_POST['firstname']);
        $gender = trim($_POST['gender']);
        $age = trim($_POST['age']);
        $course_code = trim($_POST['course_code']);
        $year_graduated = trim($_POST['year_graduated']);
        $phone = trim($_POST['phone']);

        $modified ='';
        $get_backyear = '';
        $school_year = $year_graduated;

        if(strlen($year_graduated) == 4){
            $modified = $year_graduated . '-01-01';
            $get_backyear = strtotime($modified.'-1 year');
            $school_year = Date('Y',$get_backyear) . '-'.$year_graduated;
        }


        try{
            // Sql query
            $sql = 'UPDATE tbl_graduates SET lastname = :lastname, firstname = :firstname, gender = :gender,age = :age, course_code = :course_code, year_graduated = :year_graduated, phone = :phone WHERE graduate_id = :graduate_id';

            $stmt    = $pdo->prepare($sql); // Prepared statement
            
            $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
            $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
            $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
            $stmt->bindParam(':age', $age, PDO::PARAM_STR);
            $stmt->bindParam(':course_code', $course_code, PDO::PARAM_STR);
            $stmt->bindParam(':year_graduated', $school_year, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->bindParam(':graduate_id', $graduate_id, PDO::PARAM_STR);
            $stmt->execute();
            
            header('location:profile.php');

        }
        catch(PDOException $e){
            return false;
        }

                    
    }

    if(isset($_GET['delete_job'])){

      
        $job_id = $_GET['delete_job'];

        try{
            // Sql query
            $sql = 'DELETE FROM tbl_job_history WHERE job_id = :job_id';

            $stmt    = $pdo->prepare($sql); // Prepared statement
            $stmt->bindParam(':job_id', $job_id, PDO::PARAM_STR);
            $stmt->execute();
            header('location:profile.php');

        }
        catch(PDOException $e){
            return false;
        }
        
    }

    if(isset($_POST['add_image'])){

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $graduate_id = trim($_POST['graduate_id']);

        $target_dir =  "../resources/img/avatar/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            update_picture($pdo, $graduate_id, basename( $_FILES["fileToUpload"]["name"]));
            $uploadOk = 0;
        }
     
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
              
                update_picture($pdo, $graduate_id, basename( $_FILES["fileToUpload"]["name"]));
                
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        
       
    }

     // Update or modify job
     function update_picture($pdo, $graduate_id, $image){

        try{
            // Sql query
            $sql = 'UPDATE tbl_graduates SET img = :img WHERE graduate_id = :graduate_id';

            $stmt    = $pdo->prepare($sql); // Prepared statement
            $stmt->bindParam(':img', $image, PDO::PARAM_STR);
            $stmt->bindParam(':graduate_id', $graduate_id, PDO::PARAM_STR);
            $stmt->execute();
            header('location:profile.php');

        }
        catch(PDOException $e){
            return false;
        }
        
                         
     }

   

    // Check if username already existed
    function check_username($pdo,$username){
        
        $sql = 'SELECT username FROM tbl_graduates WHERE username = :username';
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }


 

    function password_encrypter($password){
        
        $options = [
            'cost' => 12,
        ];
        
        return password_hash($password, PASSWORD_BCRYPT,$options);
    }


    function view_profile($pdo,$graduate_id){

        $sql = 'SELECT* FROM tbl_graduates WHERE graduate_id = :graduate_id';
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':graduate_id', $graduate_id, PDO::PARAM_STR);
        $stmt->execute();

        if($stmt->rowCount() === 1){
            return $stmt->fetch();
        }else{
            return false;
        }

    }

    // View job history
    function job_history($pdo,$graduate_id){
        
        $sql = 'SELECT* FROM tbl_graduates INNER JOIN tbl_job_history ON tbl_job_history.graduate_id = tbl_graduates.graduate_id WHERE tbl_job_history.graduate_id = :graduate_id ORDER BY tbl_job_history.date_hired DESC';
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':graduate_id', $graduate_id, PDO::PARAM_STR);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return $stmt->fetchAll();
        }else{
            return false;
        }
    }


     // When the user submits from add job history modal
     if(isset($_POST['add_job'])){
        
              
                $date_added = Date('Y-m-d H:i:s'); // Registration date
        
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $graduate_id = trim($_POST['graduate_id']);
                $date_hired = trim($_POST['date_hired']);
                $company = trim($_POST['company']);
                $position = trim($_POST['position']);
                $remarks = trim($_POST['remarks']);
              
                try{
                    // Sql query
                    $sql = 'INSERT INTO tbl_job_history(graduate_id, date_hired, company,position,remarks, date_added) VALUES(:graduate_id, :date_hired, :company,:position,:remarks, :date_added)';
        
                    $stmt    = $pdo->prepare($sql); // Prepared statement
                    $stmt->bindParam(':graduate_id', $graduate_id, PDO::PARAM_STR);
                    $stmt->bindParam(':date_hired', $date_hired, PDO::PARAM_STR);
                    $stmt->bindParam(':company', $company, PDO::PARAM_STR);
                    $stmt->bindParam(':position', $position, PDO::PARAM_STR);
                    $stmt->bindParam(':remarks', $remarks, PDO::PARAM_STR);
                    $stmt->bindParam(':date_added', $date_added, PDO::PARAM_STR);
                    $stmt->execute();
                    
                    header('location:profile.php');
        
                }
                catch(PDOException $e){
                    return false;
                }
        
                
                    
     }


     // Update or modify job
     if(isset($_POST['edit_job'])){
        
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $job_id = trim($_POST['job_id']);
        $date_hired = trim($_POST['date_hired']);
        $company = trim($_POST['company']);
        $position = trim($_POST['position']);
        $remarks = trim($_POST['remarks']);
        
        try{
            // Sql query
            $sql = 'UPDATE tbl_job_history SET date_hired = :date_hired, company = :company, position = :position, remarks = :remarks WHERE job_id = :job_id';

            $stmt    = $pdo->prepare($sql); // Prepared statement
            $stmt->bindParam(':date_hired', $date_hired, PDO::PARAM_STR);
            $stmt->bindParam(':company', $company, PDO::PARAM_STR);
            $stmt->bindParam(':position', $position, PDO::PARAM_STR);
            $stmt->bindParam(':remarks', $remarks, PDO::PARAM_STR);
            $stmt->bindParam(':job_id', $job_id, PDO::PARAM_STR);
            $stmt->execute();
            
            header('location:profile.php');

        }
        catch(PDOException $e){
            return false;
        }
        
                
                    
     }

     function disableLoginPage(){

        header('location: profile.php');
        
     }

    // Check logout click
    if(isset($_GET['logout'])){

         // Init session
        session_start();
    
        // Unset all session values
        $_SESSION = array();
    
        // Destroy session
        session_destroy();
    
        // Redirect to login
        header('location: login.php');
        exit;
    }

