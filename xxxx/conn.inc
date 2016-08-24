<?php 
$link = mysqli_connect('localhost','root','','user'); 
if (!$link) { 
	die('Could not connect to MySQL: ' . mysqli_error()); 
} 
?> 