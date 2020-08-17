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
Displays a form with a search box, in which the user can enter search 
 terms. The form  submit to /search/dosearch via GET 
-->
<form action="doSearch" method="GET">
Search:
<input type="text" name="string" required>
<br/>
<br/>
<input type="submit" value="Search" id="submit">
</form>
</div>
</body>
</html>