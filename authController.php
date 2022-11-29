<?php

session_start();
include 'db.php';
$errors = array(); 

// initially set the value of these varible an empty string 
$fullname=$dob=$phone=$fathername=$citztype=$citznum=$passwordconf=$idistrict=$gender=$idate=$state=$tole=$district=$municipality=$ward=$email=$password="" ;

 //making $error global variable;





 if(isset($_POST['submit1'])){

                $idate=$_POST["idate"];

                $fullname=$_POST['fullname'];
                $dob=$_POST['dob'];
                $phone=$_POST["phone"];
                $fathername=$_POST["fathername"];
                // $citztype=$_POST["citztype"];
                $citznum=$_POST["citznum"];



                $idistrict=$_POST["idistrict"];


                    $dob_val  = new DateTime($dob);
                    $today = new DateTime('today');
                    $obj = date_diff($dob_val , $today, FALSE);
                    $age=$obj->y;

                //for citz issue date

                    $idate_value=new DateTime($idate);
                    $obj=date_diff($idate_value,$today,FALSE);
                    $days=$obj->d;


                if( isset( $_POST['gender1'])) {
                    $gender=$_POST["gender1"];
                } 
                if( isset( $_POST['citztype'])) {
                    $citztype=$_POST["citztype"];
                } 




$state=$_POST["state"];
$tole=$_POST["tole"];
$district=$_POST["district"];
$municipality=$_POST["municipality"];
$ward=$_POST["ward"];
$email=$_POST["email"];
$password=$_POST["password"];
$passwordconf=$_POST["repassword"];



$phon_length=mb_strlen($phone);
if($phon_length>10 or $phon_length<10){
    $errors['phone'] = "Invalid Phone Number"; 
}



 $location1="upload/profile";
 $location2="upload/citzenships";

 
 $file1=$_FILES['pphoto']['name'];
 $file_tmp1=$_FILES['pphoto']['tmp_name'];

 $file2=$_FILES['citzphoto']['name'];
 $file_tmp2=$_FILES['citzphoto']['tmp_name'];

//generate voters id 


        $set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$voter = substr(str_shuffle($set), 0, 15);


    //validation of the user input
    if (empty($fullname)) {
        $errors['fullname'] = "fullname Required!";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please Enter a valid email!";
    }
    if (empty($email)) {
        $errors['email'] = "Email  Required!";
    }
    if (empty($password)) {
        $errors['password'] = "Password Required!";
    }
    if ($password !== $passwordconf) {
        $errors['password'] = "The two passwords do not match!";
    }

    //preg_match($pattern, $citznum);

    

    if (empty($dob)) {
        $errors['dob'] ="Date of Birth Required!";
    }
  
    if (empty($gender)) {
        $errors['gender'] ="Gender  Required!";
    }
    if (empty($fathername)) {
        $errors['fathername'] ="fathername Required!";
    }
    if (empty($citztype)) {
        $errors['citztype'] ="citzenship type Required!";
    }
    if (empty($citznum)) {
        $errors['citznum'] ="citzenship number Required!";
    }
    if (empty($idistrict)) {
        $errors['idistrict'] ="issued district Required!";
    }
    if (empty($idate)) {
        $errors['idate'] ="issued date Required!";
    }
    if (empty($state)) {
        $errors['state'] ="state Required!";
    }
    if (empty($district)) {
        $errors['district'] ="district  Required!";
    }
    if (empty($tole)) {
        $errors['tole'] ="street or tole Required!";
    }
    if (empty($municipality)) {
        $errors['municipality'] =" municipality Required!";
    }
    if (empty($ward)) {
        $errors['ward'] ="Ward Required!";
    }
    if ($age<18) {
        $errors['age'] = "Your age must be 18 or more to vote!!";
    }
    if ($days>1) {
        $errors['idate'] = "invalid Citzenship issue date";
    }


        //check douplicate email
        $emailQuery = "SELECT * FROM voters WHERE email=? LIMIT 1";
        $stmt = $conn->prepare($emailQuery);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $userCount = $result->num_rows;
        $stmt->close();
    
        if ($userCount > 0) {
            $errors['email'] = "Email Already Exists";
        }

        

  	$sql_citznum = "SELECT * FROM voters WHERE citznum='$citznum'";
  	
  	$res_citznum = mysqli_query($conn, $sql_citznum);


  	if (mysqli_num_rows($res_citznum) > 0) {
  	  $errors['citznum'] = "Doupicate Citzenship Number ";
  	}



    


    
    if(count($errors)===0){

        //if user click register button
      

        move_uploaded_file($file_tmp1, $location1.$file1);
		move_uploaded_file($file_tmp2, $location2.$file2);
        
        

        $code = rand(999999, 111111);
        $mailstatus = "notverified";
        $verified = 0;
        $sql = mysqli_query($conn, "INSERT INTO voters(voters_id, password,fullname, dob, gender,fathername
        ,citznum,idate,pphoto,citzphoto,district,municipality,email,verified, code, mailstatus,tole,wardnum,state,phon) 
         
         VALUES('$voter','$password','$fullname','$dob','$gender','$fathername','$citznum','$idate','$file1',' $file2','$district','$municipality','$email','$verified','$code','$mailstatus','$tole','$ward','$state','$phone')");
                 
                 if($sql){
                     $subject = "Email Verification Code";
                     $message = "Your verification code is $code";
                     $sender = 'From: krish.spm1999@gmail.com';
                     
                     
                     if(mail($email, $subject, $message, $sender)){ // true  bhayo bhane
                         $info = "We've sent a verification code to your email - $email";
                         $_SESSION['info'] = $info;
                         $_SESSION['email'] = $email;
                         $_SESSION['password'] = $password;
                         header('location: user-otp.php');
                         exit();
                     }else{
                         $errors['otp-error'] = "Failed while sending code!";
                     }
                 }else{
                     $errors['db-error'] = "Failed while inserting data into database!";
                 }
    }
}

                 //if user click verification code submit button
        if(isset($_POST['check'])){
        $_SESSION['info'] = "";
        $otp_code = mysqli_real_escape_string($conn, $_POST['otp']);
        $check_code = "SELECT * FROM voters WHERE code = $otp_code";
        $code_res = mysqli_query($conn, $check_code);
        if(mysqli_num_rows($code_res) > 0){
            $fetch_data = mysqli_fetch_assoc($code_res);
            $fetch_code = $fetch_data['code'];
            $email = $fetch_data['email'];
            $code = 0;
            $mailstatus = 'verified';
            $update_otp = "UPDATE voters SET code = $code, mailstatus = '$mailstatus' WHERE code = $fetch_code";
            $update_res = mysqli_query($conn, $update_otp);
            if($update_res){
                $_SESSION['fullname'] = $fullname;
                $_SESSION['email'] = $email;
                header('location: loginvoter.php');
                exit();
            }else{
                $errors['otp-error'] = "Failed while updating code!";
            }
        }else{
            $errors['otp-error'] = "You've entered incorrect code!";
        }
    }

        //if user click login button
        if(isset($_POST['login'])){

            $voter_id = mysqli_real_escape_string($conn, $_POST['voterid']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            // $check_voterid = "SELECT * FROM voters WHERE voters_id = '$voter_id'";
            $check = "SELECT * FROM voters WHERE voters_id = '$voter_id'  AND password='$password'";

            $res = mysqli_query($conn, $check);
          


            if(mysqli_num_rows($res) > 0){
                   $fetch = mysqli_fetch_assoc($res);
                   // $fetch_pass = $fetch['password'];
                    $email=$fetch['email'];
                    $_SESSION['email'] = $email;
                    $_SESSION['voter']=$fetch['id'];
                    $mailstatus = $fetch['mailstatus'];

                    if($mailstatus == 'verified'){
                      $_SESSION['voterid'] = $voter_id;
                      $_SESSION['password'] = $password;
                      header('location: loginvoter.php');
                    }
                }
                
                else{
                    $errors['email'] = "Incorrect voter Id or password!";
                }
            
           
        }

        
        
    
        //if user click continue button in forgot password form
        if(isset($_POST['check-email'])){
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $check_email = "SELECT * FROM voters WHERE email='$email'";
            $run_sql = mysqli_query($conn, $check_email);
            if(mysqli_num_rows($run_sql) > 0){
                $code = rand(999999, 111111);
                $insert_code = "UPDATE voters SET code = $code WHERE email = '$email'";
                $run_query =  mysqli_query($conn, $insert_code);
                if($run_query){
                    $subject = "Password Reset Code";
                    $message = "Your password reset code is $code";
                    $sender = "From: krish.spm1999@gmail.com";


                    if(mail($email, $subject, $message, $sender)){    //false
                        $info = "We've sent a password reset otp to your email - $email";
                        $_SESSION['info'] = $info;
                        $_SESSION['email'] = $email;
                        header('location: reset-code.php');
                        exit();
                    }
                    else{
                        $errors['otp-error'] = "Failed while sending code!";
                    }
                }
                else{
                    $errors['db-error'] = "Something went wrong!";
                }
            }else{
                $errors['email'] = "This email address does not exist!";
            }
        }
    
        //if user click check reset otp button
        if(isset($_POST['check-reset-otp'])){
            $_SESSION['info'] = "";
            $otp_code = mysqli_real_escape_string($conn, $_POST['otp']);
            $check_code = "SELECT * FROM voters WHERE code = $otp_code";
            $code_res = mysqli_query($conn, $check_code);
            if(mysqli_num_rows($code_res) > 0){
                $fetch_data = mysqli_fetch_assoc($code_res);
                $email = $fetch_data['email'];
                $_SESSION['email'] = $email;
                $info = "Please create a new password that you don't use on any other site.";
                $_SESSION['info'] = $info;
                header('location: new-password.php');
                exit();
            }else{
                $errors['otp-error'] = "You've entered incorrect code!";
            }
        }
    
        //if user click change password button
        if(isset($_POST['change-password'])){
            $_SESSION['info'] = "";
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
            if($password !== $cpassword){
                $errors['password'] = "Confirm password not matched!";
            }else{
                $code = 0;
                $email = $_SESSION['email']; //getting this email using session
                $encpass = password_hash($password, PASSWORD_BCRYPT);
                $update_pass = "UPDATE voters SET code = $code, password = '$encpass' WHERE email = '$email'";
                $run_query = mysqli_query($conn, $update_pass);
                if($run_query){
                    $info = "Your password changed. Now you can login with your new password.";
                    $_SESSION['info'] = $info;
                    header('Location: password-changed.php');
                }else{
                    $errors['db-error'] = "Failed to change your password!";
                }
            }
        }
        
       //if login now button click
        if(isset($_POST['login-now'])){
            header('Location: loginvoter.php');
        }

    

// if ($sql) {

//     echo '<script>
//     alert("You have successfully registered.Your account has to be verified before login!");
//     window.location="login.php";
//     </script>';
//     exit();
// } else {
//     $errors['db_error'] = "Database error:Failed to Register";
// }
?>