<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymou">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
</script>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/LoginCss.css">
	<link href="https://fonts.googleapis.com/css?family=Allerta+Stencil" rel="stylesheet">
	<title></title>
</head>
<h2></h2>
<body>
	
	<div class ="box">
		<img src="<?php echo base_url(); ?>/assets/resources/team.png" alt="Trulli" width="120" height="120" align="centre">
		<h1>Login</h1>
		<form action="<?php echo base_url(); ?>index.php/Onlinecontrol/LoginCheck" method="post">
			<div class="inputBox">
				<input type="text" name="username" >
                  <label>Username</label>
			</div>
			<div class="inputBox">
				<input type="password" name="password" >
                  <label>Password</label>
			</div>
			
			<div style="">
				<input class="a1" type="submit" name="" value="Submit">
				<input class="a2" type="submit" name="" value="Cancel">
			</div>

			<div class="offset-md-4 offset-sm-4 offset-xs-4 offset-lg-4" style="padding-top: 23px;">
				<a class="pull-right" href="<?php echo base_url(); ?>index.php\Onlinecontrol\Changepassword" style="color: #fff;">Change Password</a>
			</div>
			
		</form>

	</div>

</body>
</html>
