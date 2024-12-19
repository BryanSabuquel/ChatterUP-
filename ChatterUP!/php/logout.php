<?php
session_start();
if(session_destroy())
{
	unset($_SESSION['unique_id']);
	header("Location: ../login.php");
	exit();
}
?>