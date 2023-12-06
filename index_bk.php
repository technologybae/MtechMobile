<?php
session_start();
if(!empty($_SESSION['id']))
{
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
<section class="">
<div class="slide-form justify-content-center">
<form action="javascript:login_user();" class="glass">
<div class="content">
<h2>Login</h2>
<p>Please sign in to continue</p>
	<p id="errordiv"></p>

</div>
<div class="content_form">
<div class="mb-3">
<label for="email" class="form-label">Email</label>
<input type="text" id="email" name="f" class="form-control" placeholder="Email" required="" autocomplete="off">
			<div id="email_error" style="color:red"></div>

</div>
<div class="mb-4">
<label for="password" class="form-label">Password</label>
<input type="password" id="password" name="password" class="form-control" placeholder="Password" required="" autocomplete="off">
		<div id="password_error" style="color:red"></div>

</div>
<div class="mb-0">
<button type="submit" class="btn btn-primary float-end">Submit</button>
</div>
</div>


</form>
</div>
</section>
	<footer style="text-align: center;">
<p><?=date("Y")?> © Developed & Designed by Mtech. All Rights Reserved.</p>
</footer>
</body>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/jquery-3.6.0.min.js"></script>
	<script src="assets/js/pagescall.js"></script>

</html>