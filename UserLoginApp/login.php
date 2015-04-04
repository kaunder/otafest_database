<html>
    <head>
        <title>Login</title>
		<script>
	function gotoregister() {
    location.href = "register.php";
}
</script>
    </head>
    <body bgcolor="#FFFFCC">
<center>
<h3>User Login</h3>
<hr />
<form method="post" action="member.php" >
<table border="0" >
<tr>
<td>
<b>Username</b>
</td>
<td><input type="text" name="username">
</tr>
<tr>
<td><b>Password</b></td>
<td><input name="password" type="password"></input></td>
</tr> <br/>
<tr>
<td><input type="submit" value="Submit"/>
<td><input type="button" value="Register" onclick="gotoregister()">
</tr>
</table>
</form>
</center>
</body>
</html>
