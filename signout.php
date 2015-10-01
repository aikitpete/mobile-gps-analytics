<!DOCTYPE html>
<html>
<head>
<!--<title>User Login</title>
<link href="style.css" rel="stylesheet" type="text/css">-->
</head>
<body>
<div id="logout">
<!--<h3>User Login</h3>-->
<form action="" method="post">
<label>Logged in as: </label><span><?php echo $_COOKIE['user_name']; ?></span>
<input name="submit" type="submit" value=" Sign Out ">
</form>
</div>
</body>
</html>