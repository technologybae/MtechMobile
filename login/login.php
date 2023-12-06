<?php
session_start();
error_reporting(0);
include("../config/main_connection.php");
if ($_POST) {

$email = strtolower(addslashes($_POST['email']));
$password = addslashes($_POST['password']);

if (!empty($email) && !empty($password)) {
//// Get Data From Master Data base
 $mm = "Select " . dbObjectMain . "logins.*,companies.name as compName,companies.logo as compLogo,companies.dbPort,companies.dbUser 
,companies.dbPass,companies.dbName,companies.version_field,companies.customer_id,companies.customer_id,companies.region,companies.storeCode,companies.isPaid,companies.dbHost,companies.dbPort,companies.lang
from " . dbObjectMain . "Logins inner JOIN " . dbObjectMain . "Companies companies on companies.id = " . dbObjectMain . "Logins.companyId where " . dbObjectMain . "Logins.isDeleted = 0 and (" . dbObjectMain . "Logins.email='".$email."' or " . dbObjectMain . "Logins.code='".$email."') and companies.isDeleted = 0";

$qu = RunMain($mm);
$getUserData = myfetchMain($qu);

if (!$getUserData->email) {
?>
<script>
document.getElementById('email').style.border = "1px solid red";
document.getElementById('email').focus();
document.getElementById('email_error').innerHTML = "Email Invalid";
</script>
<?php
die();
}
?>
<script>
document.getElementById('email').style.border = "1px solid green";
document.getElementById('email_error').innerHTML = "";
</script>
<?php
$userPassword = $getUserData->password;

if ($userPassword != $password) {
?>
<script>
document.getElementById('password').style.border = "1px solid red";
document.getElementById('password').focus();
document.getElementById('password_error').innerHTML = "Invalid Password";
</script>
<?php
die();
}
?>
<script>
document.getElementById('password').style.border = "1px solid green";
document.getElementById('password_error').innerHTML = "";
</script>
<?php
$status = $getUserData->status;
if ($status == 0) {
?>
<script>
document.getElementById('password_error').innerHTML = "Your status is deactivated Please Contact Admin.";
</script>
<?php
die();
}
$isPaid = $getUserData->isPaid;
if ($isPaid == 0) {
?>
<script>
document.getElementById('password_error').innerHTML = "Your Payment is Due Please Contact Admin.";
</script>
<?php
die();
}


$id = $getUserData->id;
$dbHost = $getUserData->dbHost;
$storeCode = $getUserData->code;
$dbPort = $getUserData->dbPort;
$dbUser = $getUserData->dbUser;
$dbPass = $getUserData->dbPass;
$dbName = $getUserData->dbName;
$isAdmin = $getUserData->isAdmin;
$name = $getUserData->name;
$name_ar = $getUserData->name_ar;
$version = $getUserData->version_field;
$logo = $getUserData->logo;
$customer_id = $getUserData->customer_id;
$user_id = $getUserData->user_id;
$customer_code = $getUserData->customer_code;
$region = $getUserData->region;
$is_completed = $getUserData->is_completed;
$companyId = $getUserData->companyId;
$uiType = $getUserData->uiType;
$lang = $getUserData->lang;
$expl = explode(",",$uiType);
$platForm = "Mobile";	
if (in_array($platForm, $expl))
{
}
	else
	{
	?>
<script>
document.getElementById('password').focus();
document.getElementById('password').style.border = "1px solid red";
document.getElementById('password_error').innerHTML = "You are not Allowed to Login From Mobile";
</script>
<?php
die();	
	}
	
	
	
$_SESSION['dbHost'] = $dbHost;
$_SESSION['storeCode'] = $storeCode;
$_SESSION['dbPort'] = $dbPort;
$_SESSION['dbUser'] = $dbUser;
$_SESSION['dbPass'] = $dbPass;
$_SESSION['dbName'] = $dbName;
$_SESSION['isAdmin'] = $isAdmin;
$_SESSION['name'] = $name;
$_SESSION['name_ar'] = $name_ar;
$_SESSION['version'] = $version;
$_SESSION['logo'] = $logo;
$_SESSION['customer_id'] = $customer_id;
$_SESSION['user_id'] = $user_id;
$_SESSION['customer_code'] = $customer_code;
$_SESSION['region'] = $region;
$_SESSION['id'] = $id;
$_SESSION['code'] = $getUserData->code;
$_SESSION['email'] = $email;
$_SESSION['is_completed'] = $is_completed;
$_SESSION['companyId'] = $companyId;
$_SESSION['lang'] = $lang;
if ($_SESSION['id']) {
printf("<script>location.href='home.php?value=welcome'</script>");
die();
}


}


}