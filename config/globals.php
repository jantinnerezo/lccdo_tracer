<?php

    require_once('config.php');

    function unverified($pdo){
        $sql = 'SELECT* from tbl_graduates WHERE status = 0';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':course_code', $course, PDO::PARAM_STR);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return $result = $stmt->fetchAll();
        }else{
            return false; 
        }
    }


    function graduates($pdo,$course = NULL, $year = NULL, $search = NULL){

        
         if(!IS_NULL($course) && $year == NULL && $search == NULL){

            $sql = 'SELECT* from tbl_graduates WHERE course_code = :course_code and status = 1';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':course_code', $course, PDO::PARAM_STR);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                return $result = $stmt->fetchAll();
            }else{
                return false; 
            }
          
         }
         
        else if(!IS_NULL($year) && $course == NULL && $search == NULL){

            $sql = 'SELECT* from tbl_graduates WHERE year_graduated = :year_graduated and status = 1';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':year_graduated', $year, PDO::PARAM_STR);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                return $result = $stmt->fetchAll();
            }else{
                return false; 
            }
         }
         
        else if(!IS_NULL($search)  && $year == NULL && $course == NULL){

            $sql = 'SELECT* from tbl_graduates WHERE firstname LIKE :firstname OR lastname LIKE :lastname OR graduate_id LIKE :graduate_id and status = 1';
            $stmt = $pdo->prepare($sql);

            $param1 = "%$search%";
            $stmt->bindParam(':firstname', $param1, PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $param1, PDO::PARAM_STR);
            $stmt->bindParam(':graduate_id', $param1, PDO::PARAM_STR);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                return $result = $stmt->fetchAll();
            }else{
                return false; 
            }
            
         }

        else if(!IS_NULL($course) && !IS_NULL($year)){

            $sql = 'SELECT* from tbl_graduates WHERE course_code = :course_code AND year_graduated = :year_graduated and status = 1';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':course_code', $course, PDO::PARAM_STR);
            $stmt->bindParam(':year_graduated', $year, PDO::PARAM_STR);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                return $result = $stmt->fetchAll();
            }else{
                return false; 
            }
           
         }

         else if(($course != NULL) && ($year != NULL) && ($search != NULL) ){
            
            $sql = 'SELECT* from tbl_graduates WHERE course_code = :course_code AND year_graduated = :year_graduated AND (firstname LIKE :firstname OR lastname LIKE :lastname OR graduate_id LIKE :graduate_id) and status = 1';
            $stmt = $pdo->prepare($sql);
            $param1 = "%$search%";
            $stmt->bindParam(':course_code', $course, PDO::PARAM_STR);
            $stmt->bindParam(':year_graduated', $year, PDO::PARAM_STR);
            $stmt->bindParam(':firstname', $param1, PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $param1, PDO::PARAM_STR);
            $stmt->bindParam(':graduate_id', $param1, PDO::PARAM_STR);
            $stmt->execute();
           
            if($stmt->rowCount() > 0){
                return $result = $stmt->fetchAll();
            }else{
                return false; 
            }
            
            }
         else{

            $sql = 'SELECT* from tbl_graduates WHERE status = 1'; // default query
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                return $result = $stmt->fetchAll();
            }else{
                return false; 
            }

         }
           


    }

    

    function years($pdo,$course = FALSE){

        $sql = 'SELECT DISTINCT year_graduated from tbl_graduates ORDER BY year_graduated DESC';

        if($course)
            $sql = 'SELECT DISTINCT year_graduated from tbl_graduates WHERE course_code = :course_code ORDER BY year_graduated DESC';
            

        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':course_code', $course, PDO::PARAM_STR);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return $result = $stmt->fetchAll();
        }else{
            return false;
        }
    }


    function courses($pdo){

        $sql = 'SELECT* from tbl_courses';

        $stmt = $pdo->prepare($sql);
		$stmt->execute();

		if($stmt->rowCount() > 0){
			return $result = $stmt->fetchAll();
		}else{
            return false;
		}

    }

   


       
        

