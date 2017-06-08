<?php
require_once "dbcon.php";
$insertData = "";
if(isset($_POST['done']) && $_POST['signupName']=='User') {
	$insertData = "insert into signup values('".$_POST['fname']."','".$_POST['lname']."','".$_POST['emailId']."','".$_POST[	'contact']."','".$_POST['loginpwd']."','".$_POST['pincode']."')";
}
elseif(isset($_POST['done']) && $_POST['signupName']=='Driver') {
	$insertData = "insert into driver_details (firstName,lastName,email,contact,password,pincode,car_name,car_no,car_color,license_no) values('".$_POST['Dfname']."','".$_POST['Dlname']."','".$_POST['DemailId']."','".$_POST['Dcontact']."','".$_POST['Dloginpwd']."','".$_POST['Dpincode']."','".$_POST['Cname']."','".$_POST['Cnumber']."','".$_POST['Ccolor']."','".$_POST['licenseNo']."')";
}
if(mysql_query($insertData, $connection)) {
		echo "<script>alert('Signed up successfully!');</script>";
		header('Location:http://localhost/uber/random-login-form/index.html');
	}
	else {
		echo "error:".mysql_error();
	}
	
	// check login 
	if(isset($_POST['login'])) {
	$username = $_POST['user'];
	$password = $_POST['password'];
	
	$checkUser = mysql_query("SELECT * FROM signup where firstName='".$username."' AND password='".$password."'", $connection);
	
	if(mysql_num_rows($checkUser)==1) {
		header('Location:http://localhost/uber/random-login-form/bs-test1.php');
	}
	elseif(!mysql_num_rows($checkUser)) {
		echo "<script>
		$('#loginError').val() = 'Incorrect Username and Password!';
		$(input).val() = '';
		</script>
		";
	}
	}
