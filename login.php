<?php
/**
 * Login.php
 *
 * Like on most sites
 * the login form doesn't just have to be on the main page,
 * but re-appear on subsequent pages, depending on whether
 * the user has logged in or not.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 26, 2004
 */
include("include/session.php");
?>

<!DOCTYPE html>
<html>
<head>
<title>Login Script</title>
<style>
body { margin: 0; }
.topnav {
	overflow: hidden;
	background-color: white;
	font-size: 13pt;
}
/*Strip the ul of padding and list styling*/
ul {
    list-style-type:none;
    margin:0;
    padding:0;
}
/*Create a horizontal list with spacing*/
li {
    display:inline-block;
    float: left;
}
li a {
	background-color: #E0E0E0;
	float: left;
	display: block;
	color: #0000A0;
	text-align: center;
	padding: 10px 12px;
	margin-left: 6px;
	margin-right: 6px;
	margin-top: 24px;
	margin-bottom: 24px;  
	text-decoration: none;
	border: none;
}
li a:hover {
  background-color: #0000A0;
  color: white;
}
li ul {
	display: none;
    padding: 0;
	margin: 0;
	position: absolute;
	top: 201px;
	height: 0px !important;
}
li ul li {
    display: block;
    float: none;
}
/*Prevent text wrapping*/
li ul li a {
    width: auto;
    min-width: 100px;
    padding: 8px 12px;
	margin-left: 10px;
	background-color: #D5D5FF;
	font-size: 12pt;
	margin-top: 18px;
	margin-bottom: 24px;
	border: none;
}
/*Display the dropdown on hover*/
ul li a:hover + .hidden, .hidden:hover {
    display: block;
}
</style>
</head>
<body style="background-color: #069; margin: 14pt; font-family: Geneva, Arial, Helvetica, sans-serif; ">
<div style="background-color: white; padding: 20px; width: 800px; margin-left: auto; margin-right: auto; border-radius: 15px; -moz-border-radius: 15px; -webkit-box-shadow: 15px; ">
<?php
/**
 * User has already logged in, so display relavent links, including
 * a link to the admin center if the user is an administrator.
 */
if($session->logged_in) {
	echo "<h1 style='text-align: center; '>Logged In</h1>";
	echo "Welcome <b>$session->username</b>. You are logged in.<br /><br />";
	echo "<div class='topnav'>";
		echo "<ul>";
			echo "<li><a href='literacy_add_edit.php'>Add/Edit to the Database</a></li>";
			echo "<li><a href='literacy_manual_edit.php'>Manually edit an Item</a></li>";
			echo "<li><a href='literacy_delete.php'>Delete an Item From the Database</a></li>";
			echo "<li><a href=\"process.php\">Logout</a></li>";
		echo "</ul>";
	echo "</div>";
	if($session->isAdmin()){
		echo "<div class='topnav'>";
		echo "<ul><li><a href=\"admin/admin.php\">Admin Center</a></li>";
		echo "</ul>";
		echo "</div>";
	}
	echo "<div class='topnav'>";
	echo "<ul>";
	echo "<li><a href=\"userinfo.php?user=$session->username\">My Account</a></li>";
	echo "<li><a href=\"useredit.php\">Edit Account</a></li>";
	echo "</ul>";
	echo "</div>";
}
else {
	echo "<h1 style='text-align: center; '>Login</h1>";
	/**
	 * User not logged in, display the login form.
	 * If user has already tried to login, but errors were
	 * found, display the total number of errors.
	 * If errors occurred, they will be displayed.
	 */
	if($form->num_errors > 0) {
	   echo "<font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font>";
	}
	?>
	<form action="process.php" method="POST">
	<table width="100%" style="text-align: left; " border="0" cellspacing="0" cellpadding="3">
		<tr>
			<td width="10%">Username:</td>
			<td width="15%"><input type="text" name="user" autofocus maxlength="30" value="<?php echo $form->value("user"); ?>"></td>
			<td width="75%"><?php echo $form->error("user"); ?></td>
		</tr>
		
		<tr>
			<td>Password:</td>
			<td><input type="password" name="pass" maxlength="30" value="<?php echo $form->value("pass"); ?>"></td>
			<td><?php echo $form->error("pass"); ?></td>
		</tr>
	
		<tr>
			<td colspan="3" align="left"><input type="checkbox" name="remember" <?php if($form->value("remember") != ""){ echo "checked"; } ?>>
				<font size="2">Remember me next time</font> &nbsp;&nbsp;&nbsp;&nbsp;
				<input type="hidden" name="sublogin" value="1" />
				<input type="submit" value="Login" />
			</td>
		</tr>
	
	</table>
	</form>
	<br />
	<?php
}
/**
		
        <tr>
            <td colspan="3" align="left"><br>Not registered? <a href="register.php">Sign-Up</a></td>
        </tr>
		
		<tr>
			<td colspan="3" align="left"><br><font size="2">[<a href="forgotpass.php">Forgot Password?</a>]</font></td>
		</tr>

* Tells how many registered members
 * there are, how many users currently logged in and viewing site,
 * and how many guests viewing site. Active users are displayed,
 * with link to their user information.
 */
echo "<div style=\"text-align: center; \"><br /><br />";
echo "<b>Total Members:</b> ".$database->getNumMembers()."<br>";
echo "There are $database->num_active_users registered members and ";
echo "$database->num_active_guests guests viewing the site.</div><br>";
include("include/view_active.php");
?>

</div>
</body>
</html>
