<!DOCTYPE html>
<html>
<head>
<!--<title>User Login</title>
<link href="style.css" rel="stylesheet" type="text/css">-->
</head>
<body>
<div id="register">
<!--<h3>User Login</h3>-->
<fieldset><legend>Registration</legend>	
<p>Please provide your login information.</p><br/>
<br/>
<form action="" method="post">
	<label>Name: </label><br/>
	<input id="reg_name" name="reg_name" placeholder="" type="text"><br/>
	<br/>
	<label>Surname: </label><br/>
	<input id="reg_surname" name="reg_surname" placeholder="" type="text"><br/>
	<br/>
	<label>Email: </label><br/>
	<input id="reg_email" name="reg_email" placeholder="" type="text"><br/>
	<br/>
	<label>Password: </label><br/>
	<input id="reg_password" name="reg_password" placeholder="" type="password"><br/>
	<br/>
	<label>Repeat password: </label><br/>
	<input id="reg_password2" name="reg_password2" placeholder="" type="password"><br/>
	<br/>
	<label>Why did you choose to participate in our project?</label><br/>
	<textarea rows="4" cols="50" id="reg_feedback" name="reg_feedback"></textarea><br/>
	<h4>Select your role: (roles are subject to approval by our user admins)</h4>
	<input id="reg_category" type="radio" name="reg_category" class="mapuser" value="usability_analyst" 	checked>Usability analyst<br/>
	<input id="reg_category" type="radio" name="reg_category" class="mapuser" value="data_analyst">Data analyst<br/>
	<input id="reg_category" type="radio" name="reg_category" class="mapuser" value="data_admin">Data admin<br/>
	<input id="reg_category" type="radio" name="reg_category" class="mapuser" value="user_uadmin">User admin<br/>
	<br/>
	<input name="reg_submit" type="submit" value=" Register ">
	<span><?php echo $reg_error; ?></span>
</form>
</fieldset>
</div>
</body>
</html>