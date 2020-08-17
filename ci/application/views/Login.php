<!DOCTYPE html>
<html>
<head>
<title> Search </title>
<link rel="stylesheet" type="text/css"  href="<?php echo base_url(); ?>css/styling.css"><!-- link for the css file -->
<link rel="stylesheet" type="text/css"  href="http://raptor.kent.ac.uk/proj/co539c/microblog/kj257/css/styling.css"><!-- link for the css file. This is here because if the above one doesn't work -->

</head>
<body>
<div id="theBox">
<h1>IgniterBook</h1>
<?php echo $div; ?> 
<!--
Displays a login form for a user to supply their username and password.  
This form  submit via POST to /user/dologin
  -->
<form action="doLogin" method="POST">
UserName:
<input type="text" name="username" required>
<br/>
<br/>
Password: 
<input type="password" name="password" required>
<br/>
<br/>
<input type="submit" value="Login" id="submit">
</form>
</div>
</body>
</html>