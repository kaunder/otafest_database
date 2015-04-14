<?php
	
require_once 'connect.php';
  

    // If the values are posted, insert them into the database.
    if (isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
		$email = $_POST['email'];	
        $password = $_POST['password'];
 	if(!empty($username) && !empty($email) && !empty($password)){
        $query = "INSERT INTO `user` (username, password, email) VALUES ('$username', '$password','$email')";
        $result = mysqli_query($con,$query);
        if($result){
            $msg = "User Created Successfully.";
        }
		}else{
		$msg = "Please fill in all the fields.";
		}
    }
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
		<script>
	function gotologin() {
    location.href = "login.php";
}
</script>
    </head>
    <body bgcolor="#FFFFCC">
<center>
<h3>Register</h3>
<hr />
<form method="post" action="register.php" >
<table border="0" >
<tr>
<td>
<b>Username</b>
</td>
<td><input type="text" name="username">
</tr>
<tr>
<td>
<b>Email</b>
</td>
<td><input type="text" name="email">
</tr>
<tr>
<td><b>Password</b></td>
<td><input name="password" type="password"></input></td>
</tr> <br/>
<tr>
<td><input type="submit" value="Register"/>
<td><input type="button" value="Login" onclick="gotologin()">
</tr>
</table>
</form>
<br>
<br>
<?php
	if(isset($msg) & !empty($msg)){
		echo $msg;
	}
 ?>
</center>
</body>
</html>