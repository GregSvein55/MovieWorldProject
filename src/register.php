<?php
	include('conn.php');
	session_start();
 
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
	function check_input($data){
		$data=trim($data);
		$data=stripslashes($data);
		$data=htmlspecialchars($data);
		return $data;
	}
         $username=check_input($_POST['username']);
	$email=check_input($_POST['email']);
	$password=md5(check_input($_POST['password']));
        $confirm_password=md5(check_input($_POST['confirm_password']));

        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);


	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  		$_SESSION['sign_msg'] = "Invalid email format";
  		header('location:signup.php');
	}


       elseif(!$lowercase || !$number || strlen($password) < 6) {
	$_SESSION['sign_msg'] = "Invalid password, it should include characters and numbers";
  		header('location:signup.php');
         
         }

	elseif($password != $confirm_password){
       	$_SESSION['sign_msg'] = "Password did not match";
  		header('location:signup.php');
       

}
 
	else{
 
		$query=mysqli_query($conn,"select * from user where email='$email'");
		if(mysqli_num_rows($query)>0){
			$_SESSION['sign_msg'] = "Email already taken";
  			header('location:signup.php');
		}
		else{
		//depends on how you set your verification code
		$set='123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$code=substr(str_shuffle($set), 0, 12);
 
		mysqli_query($conn,"insert into user (username,email, password, code) values ('$username','$email', '$password', '$code')");
		$uid=mysqli_insert_id($conn);
		//default value for our verify is 0, means it is unverified
                 $_SESSION["username"] = $username; 
		//sending email verification
		$to = $email;
			$subject = "Sign Up Verification Email";
			$message = "
				<html>
				<head>
				<title>Verification Email</title>
				</head>
				<body>
				<h2>Thank you for Registering in Movies World Website.</h2>
				<p>Your Account:</p>
				<p>Email: ".$email."</p>
				<p>Password: ".$_POST['password']."</p>
                                <p>Username: ".$_POST['username']."</p>
				<p>Please click the link below to activate your account.</p>
				<h4><a href='http://kaysaniye.ursse.org/Assignment3/activate.php?uid=$uid&code=$code'>Activate My Account</h4>
				</body>
				</html>
				";
			//dont forget to include content-type on header if your sending html
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= "From: Black47light@gmail.com". "\r\n";
 
		mail($to,$subject,$message,$headers);
 
		$_SESSION['sign_msg'] = "Verification link has been sent to your email.";
  		header('location:signup.php');
 
  		}
	}
	}
?>


