<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Sign Up</title>
	
	<link rel="stylesheet" href="StyleSheet2.css">
</head>
<body>
	<form method="POST" action="register.php">
		<div class="container">
			<h2 style="color: black;font-family: Algerian;font-size: 30px;">Sign Up</h2>
			<p>Please fill this form to create an account.</p>
			<hr>
			 <div>
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" required>
                        </div>

			<div>
				<label>Email</label>
				<input type="text" name="email" class="form-control" required>
			</div>

	
			<div>
				<label>Password</label>
				<input type="password" name="password" class="form-control" required>
				
			</div>
			 <div>
                                <label>Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control" required>

                         </div>
			 <?php
			session_start();
			if(isset($_SESSION['sign_msg'])){
			?>
			<div style="height: 40px;"></div>
				<div style="padding: 15px;
                            margin-bottom: 20px;
                            border: 1px solid transparent;
                            border-radius: 4px;background-color: #f2dede;
                            border-color: #ebccd1;
                            color: #a94442;">
				<span>
					<center>
						<?php echo $_SESSION['sign_msg'];
						unset($_SESSION['sign_msg']);
						?>
					</center>
				</span>
			</div>
			<?php
			}
			?>

			<div>
			 
				<input type="submit" class="registerbtn" value="Submit" style=" background-color:black;border-radius:10px;">

			</div>
			<p>Already have an account? <a href="index.php">Login here</a>.</p>
		</div>
	</form>
	

</body>
</html>