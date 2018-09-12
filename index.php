<?php
session_start();
if(!empty($_POST["login"])) {
	$conn = mysqli_connect("localhost", "root", "", "cookie");
	$sql = "Select * from members where member_name = '" . $_POST["member_name"] . "' and member_password = '" . md5($_POST["member_password"]) . "'";
	$result = mysqli_query($conn,$sql);
	$user = mysqli_fetch_array($result);
	if($user) {
			$_SESSION["member_id"]		   = $user["id"];
			
			if(!empty($_POST["remember"])) {
				setcookie ("member_login",$_POST["member_name"],time()+ (10 * 365 * 24 * 60 * 60));
				setcookie ("member_password",$_POST["member_password"],time()+ (10 * 365 * 24 * 60 * 60));
			} else {
				if(isset($_COOKIE["member_login"])) {
					setcookie ("member_login","");
				}
				if(isset($_COOKIE["member_password"])) {
					setcookie ("member_password","");
				}
			}
	} else {
		$message = "Invalid Login";
	}
}
?>	
<style>
	#frmLogin {
		padding: 20px 60px;
		background: #B6E0FF;
		color: #555;
		display: inline-block;		
		border-radius: 4px;
	}
	.field-group {
		margin-top:15px;
	}
	.input-field {
		padding: 8px;
		width: 200px;
		border: #A3C3E7 1px solid;
		border-radius: 4px;
	}
	.form-submit-button {
		background: #65C370;
		border: 0;
		padding: 8px 20px;
		border-radius: 4px;
		color: #FFF;
		text-transform: uppercase;
	}
	.member-dashboard {
		padding: 40px;
		background: #D2EDD5;
		color: #555;
		border-radius: 4px;
		display: inline-block;
	}
	.member-dashboard a {
		color: #09F;
		text-decoration:none;
	}
	.error-message {
		text-align:center;
		color:#FF0000;
	}
</style>

<?php if(empty($_SESSION["member_id"])) { ?>
<form action="" method="post" id="frmLogin">
	<div class="error-message"><?php if(isset($message)) { echo $message; } ?></div>	
	<div class="field-group">
		<div><label for="login">Username</label></div>
		<div><input name="member_name" type="text" value="<?php if(isset($_COOKIE["member_login"])) { echo $_COOKIE["member_login"]; } ?>" class="input-field">
	</div>
	<div class="field-group">
		<div><label for="password">Password</label></div>
		<div><input name="member_password" type="password" value="<?php if(isset($_COOKIE["member_password"])) { echo $_COOKIE["member_password"]; } ?>" class="input-field"> 
	</div>
	<div class="field-group">
		<div><input type="checkbox" name="remember" id="remember" <?php if(isset($_COOKIE["member_login"])) { ?> checked <?php } ?> />
		<label for="remember-me">Remember me</label>
	</div>
	<div class="field-group">
		<div><input type="submit" name="login" value="Login" class="form-submit-button"></span></div>
	</div>       
</form>
<?php } else { ?>
<div class="member-dashboard">You have Successfully logged in!. <a href="logout.php">Logout</a></div>
<?php } ?>