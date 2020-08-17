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
<!--
Displays a form in which the user can write a new post. This form 
 submit via POST to the /message/doPost action      
-->
<form action="doPost" method="POST">
New post:
<input type="text" name="string" title="New Post" required>
<br/>
<br/>
<input type="submit" value="Post" id="submit">
</form>
</div>
</body>
</html>