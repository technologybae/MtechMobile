<?php
session_start();
if (!empty($_SESSION['id'])) {
	printf("<script>location.href='home.php'</script>");
	die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="assets/fonts/barlow/stylesheet.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<title>Mtech Mobile</title>
</head>

<body>
<div class="container">
		<div class="form">
			<div class="sign-in-section">
				<img class="image" alt="logo" src="loader/logo.jpg">
				<h1>Log in</h1>
				<p>Please sign in to continue</p>
				<p id="errordiv" class="mb-0"></p>
				<form action="javascript:login_user();">
					<div class="form-field">
						<label for="email">Email</label>
						<input id="email" type="email" name="f" placeholder="Email" required="" autocomplete="off" />
						<div id="email_error" style="color:red"></div>
					</div>
					<div class="form-field">
						<label for="password">Password</label>
						<input id="password" type="password" name="password" placeholder="Password" placeholder="Password" required="" autocomplete="off" />
						<div id="password_error" style="color:red"></div>
					</div>
					<div class="form-field">
						<input type="submit" class="btn btn-signin" value="Submit" />
					</div>
				</form>
			</div>
		</div>
	</div>
	<footer style="text-align: center;">
		<p><?= date("Y") ?> © Developed & Designed by Mtech. All Rights Reserved.</p>
	</footer>
</body>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/pagescall.js"></script>

</html>