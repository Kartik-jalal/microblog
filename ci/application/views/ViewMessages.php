<!DOCTYPE html>
<html>
<head>
<title>View Messages</title>
<link rel="stylesheet" type="text/css"  href="<?php echo base_url(); ?>css/styling.css"><!-- link for the css file -->
<link rel="stylesheet" type="text/css"  href="http://raptor.kent.ac.uk/proj/co539c/microblog/kj257/css/styling.css"><!-- link for the css file. This is here because if the above one doesn't work -->

</head>
<body>

<!--
Displays a list of messages, with details of user,
 content and time of each message. 
-->
<table>
<tr><th>User Name</th><th>Messages</th><th>Posted At</th><tr>
<?php 
	 $count = 1;// just for to count the number of rows
			foreach($results as $rows)// for loop, which loops around every element of $results as $row
				{	
?>
<tr>
<td>
			<?php
				echo $count . ". " .  $rows['user_username'];//echo  number the of row and the username
				$count++;
			?>
</td>
<td>
			<?php
					
				echo   $rows['text'];// echo the text
				
			?>
</td>					
<td>
			<?php
					
				echo   $rows['posted_at'];// echo the time at ehich the text was posted
				
			?>
</td>					
</tr>				
			
			<?php
				}// end of the for loop
			?>

</table>


</body>
</html>