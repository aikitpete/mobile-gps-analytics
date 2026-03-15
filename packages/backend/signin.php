<!DOCTYPE html>
<html>
<head>
<!--<title>User Login</title>
<link href="style.css" rel="stylesheet" type="text/css">-->
</head>
<body>
<div id="login">
<fieldset><legend>User Login</legend>
<form action="" method="post">
<label>Email: </label>
<input id="login_email" name="login_email" placeholder="" type="text">
<label>Password: </label>
<input id="login_password" name="login_password" placeholder="" type="password">
<input name="login_submit" type="submit" value=" Login ">
<span><?php echo $login_error; ?></span>
</form>
</fieldset>
</div>
</body>
</html>