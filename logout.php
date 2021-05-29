<!-- logout php code -->
<?php
	session_start();
	session_destroy();
	header('Location: index.php');
?>
