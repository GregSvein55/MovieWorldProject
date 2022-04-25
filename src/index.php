
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
  
    <link rel="stylesheet" href="StyleSheet2.css">
</head>
<body>

    <form method="POST" action="login.php" >
        <div class="container">
            <h1 style="color: black;font-family: Algerian;font-size: 30px;">Login</h1>
            <p>Please fill in your credentials to login.</p>
            <hr>
            <div>
                <label>Email</label>
                <input type="text" name="email" class="form-control" />
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="password" class="form-control">
            </div>
	     <?php
			session_start();
			if(isset($_SESSION['log_msg'])){
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
						<?php echo $_SESSION['log_msg'];
						unset($_SESSION['log_msg']);
						?>
					</center>
				</span>
			</div>
			<?php
			}
			?>
            <div>
                <input type="submit" class="registerbtn" style="background-color:black;color:#f2f2f2;border-radius:10px;;" value="Login">
            </div>
            <p>Don't have an account? <a href="signup.php">Sign up now</a>.</p>
        </div>
    </form>
    

</body>
</html>
 