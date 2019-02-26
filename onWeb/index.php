<?php
	session_start();
	if(isset($_POST['login'])){
		if($_POST['user_name']=='SAR' && $_POST['password']=='rfvtgbyhnujm'){
			$_SESSION['user_name']=$_POST['user_name'];
			header("Location:main.php");
			exit;
		}
		$error_ms='Not a valid user name or password';
	}
?>
<!DOCTYPE html>
<head>
	<meta charset=utf8>
</head>
<body>
	<?php
		if($error_ms)echo $error_ms;
		echo $_SESSION['user_name'];
	?>
	<form action=index.php method=POST>
		ID:<input type=text name=user_name>
		Password:<input type=password name=password>
		<input type=submit name=login value=login>
	</form>
</body>

