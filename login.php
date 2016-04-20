<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Log In</title>
  <script src="js/sha512.js"></script>
  <script src="js/forms.js"></script>
</head>
<body>
<form action='login.php?prev=
<?php
	echo $_GET['prev'];
?>
' method='post' enctype='multipart/form-data'>

<br>
<br>

Username: <input type="text" name="u">
Password: <input type="password" name="p">

<br>
<br>

<input type="button" value="Log In" onclick="formhash(this.form,this.form.p);"/>

<?php

echo "<input type='hidden' name='part' value='".$_POST['part']."'>";
echo "<input type='hidden' name='id' value='".$_POST['id']."'>";


if(isset($_POST['u']) && isset($_POST['p'])){


	include('../../Submission_p_secure_pages/connect.php');

	$sqlu = mysql_real_escape_string($_POST['u']);
	$htmlu = htmlspecialchars($_POST['u']);


	mysql_query("USE cmsfpix_u", $connection);

	$func = "SELECT password FROM members WHERE username=\"".$_POST['u']."\"";

	$output = mysql_query($func, $connection);

	$row = mysql_fetch_assoc($output);

	if($row['password'] == $_POST['p']){
                ini_set('session.gc_maxlifetime',28800);
                session_set_cookie_params(28800);
                session_start();
                ini_set('session.gc_maxlifetime',28800);
                session_set_cookie_params(28800);
		$_SESSION['user'] = $htmlu;
		echo "<br>";
		echo "You have logged in successfully";
	}
	else{
		echo "<br>";
		echo "Username or password incorrect. Please try again.";
	}
}
?>
</form>

<br>

<form method="link" action="
<?php
	echo $_GET['prev'];
?>
">
<input type="submit" value="BACK">
</form>

<br>

<form method="link" action="index.php">
<input type="submit" value="MAIN MENU">
</form>

</body>
</html>
