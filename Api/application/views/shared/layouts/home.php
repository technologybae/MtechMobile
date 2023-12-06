<?php
$blockIPs = array();
$sqlBlock = 'SELECT * FROM block_ip';
$query = $this->db->query($sqlBlock);
$blockResults = $query->result_array();
foreach($blockResults as $blockResult)
{
	$blockIPs[] = $blockResult['ip'];
}
$currentUserIp = $this->input->ip_address();
if(in_array($currentUserIp, $blockIPs)){
?>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Ropa+Sans" rel="stylesheet">
<style>
body{
    font-family: 'Ropa Sans', sans-serif;
    margin-top: 30px;
    background-color: #F0CA00;
    background-color: #F3661C;
    text-align: center;
    color: #fff;
}
.error-heading{
    margin: 50px auto;
    width: 250px;
    border: 5px solid #fff;
    font-size: 126px;
    line-height: 126px;
    border-radius: 30px;
    text-shadow: 6px 6px 5px #000;
}
.error-heading img{
    width: 100%;
}
.error-main h1{
    font-size: 72px;
    margin: 0px;
    color: #F3661C;
    text-shadow: 0px 0px 5px #fff;
}
</style>
</head>
<body>
	<div class="error-main">
		<h1>Access Denied</h1>
		<div class="error-heading">403</div>
		<p>You do not have permission to access the page.</p>
	</div>
</body>
</html>
<?php
exit();
}

session_start();
$currentPage = strtolower($this->uri->segment(1));
$this->session->set_userdata('redirectAfterLogin', current_url());
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Favicon -->
<?php $homeTags = getHomeTags(); ?>
<meta name="title" content="<?php echo clean_new($homeTags->title); ?>">
<?php if($homeTags->keywords) {?>
<meta name="keywords" content="<?php echo clean_new($homeTags->keywords); ?>">	
<?php } ?>
<meta name="description" content="<?php echo clean_new($homeTags->description); ?>">
<link rel="shortcut icon" type="image/png" href="<?php echo getSiteFaviconSrc();?>"/>
 <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900|Open+Sans:300,400,600,700,800|Roboto:100,300,400,500,700,900" rel="stylesheet"> 
<link media="all" rel="stylesheet" type="text/css" href="<?php echo SITE_ASSETS_PATH;?>css/main.css" />

<title><?php if(isset($homeTags->title)){ echo clean_new($homeTags->title);} else { echo SITE_NAME;} ?></title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript">window.jQuery || document.write('<script src="<?php echo SITE_ASSETS_PATH;?>js/jquery-1.11.2.min.js"><\/script>')</script>
<script type="text/javascript" src="<?php echo SITE_ASSETS_PATH;?>js/jquery.main.js"></script>
<script src="<?php echo base_url().'assets/admin';?>/js/jquery.magnific-popup.js"></script>	
<script src="<?php echo SITE_ASSETS_PATH;?>js/custom.js"></script>
<script src="<?php echo SITE_ASSETS_PATH;?>js/custom/functions.js"></script>
<script>var BASE_URL = '<?php echo base_url();?>';</script>
<script type="text/javascript" async="async" defer="defer" data-cfasync="false" src="https://mylivechat.com/chatinline.aspx?hccid=19954888"></script>
<script src ="https://cdn.perfdrive.com/static/jscall_min.js" async="true"></script>

<?php getAllTags('head','(sitewide_home = "sitewide" OR sitewide_home = "home")'); ?>
</head>

<body>
<?php getAllTags('body_start','(sitewide_home = "sitewide" OR sitewide_home = "home")'); ?>
<?php addtoActivityLog('Home'); ?>
<div class="popup-bg" style="display: none;"></div>
<div id="wrapper">
	
	<?php $this->load->helper('admin/admin'); ?>
	<?php $specialCoupon = getTodaySpecialCoupon(); 
	if($specialCoupon != 0) {
		$expiryDateTime = $specialCoupon->expiry_date;
		$expiryDate = date('Y-m-d', strtotime($expiryDateTime));
		$expiryDateTime = $expiryDate." 23:59:59";
		$timeNow = date('Y-m-d H:i:s');
		$timeRemaining = strtotime($expiryDateTime) - strtotime($timeNow);
		$timeRem = date('H:i:s', $timeRemaining);
		?>
	<div class="topDiscountBar"><h5><span id="couponDesc"><?php echo $specialCoupon->coupon_desc; ?></span> - <span> Ends In </span><span id="coupontimeRem"><?php echo '00:00:00';//echo $timeRem; ?></span><span> Coupon code: </span><span id="couponCodeBx"><?php echo $specialCoupon->coupon_code; ?></span></h5>
	<span class="closeBtn" onclick="closeDisBox(); return false;">X</span></div>
	<?php } ?>
	<style>
		.topDiscountBar {
			width: 100%;
			background: <?php echo $specialCoupon->bar_color; ?>;
			padding: 10px;
			text-align: center;
			color: #fff;
			font: 400 18px/22px 'Open Sans', sans-serif;
			position:relative;
		}
		.topDiscountBar h5 {
			margin-bottom: 0px;
			margin-top: 0px;
			font-size: inherit;
			line-height: 30px;
		}
		#coupontimeRem {
			font-weight: bold;
			margin: 0px 5px;
		}
		#couponCodeBx {
			background: <?php echo $specialCoupon->coupon_code_color; ?>;
			color: <?php echo $specialCoupon->bar_color; ?>;
			padding: 5px 10px;
		}
		.closeBtn {
			float: right;
			font-size: 22px;
			cursor: pointer;
			position: absolute;
			right: 100px;
			top: 10px;
		}
		@media only screen and (max-width: 1050px) {
            .closeBtn {
                float: none !important;
                font-size: 22px;
                cursor: pointer;
                position: relative !important;
                right: 0px;
                top: 5px;
            }
        }
	</style>
	<script>
		function closeDisBox(){
			$('.topDiscountBar').hide();
		}
	// Set the date we're counting down to
		var countDownDate = new Date("<?php echo date('M j, Y H:i:s',strtotime($expiryDateTime)); ?>").getTime();

		// Update the count down every 1 second
		var x = setInterval(function() {

		  // Get today's date and time
		  var now = new Date().getTime();

		  // Find the distance between now and the count down date
		  var distance = countDownDate - now;

		  // Time calculations for days, hours, minutes and seconds
		  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
		  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
		  document.getElementById("coupontimeRem").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";
		  // If the count down is finished, write some text
		  if (distance < 0) {
			clearInterval(x);
			document.getElementById("coupontimeRem").innerHTML = "EXPIRED";
		  }
		}, 1000);
	</script>
	
	
	
	<?php $this->load->view('shared/partials/top_menu');?>
	<?php $this->load->view('shared/partials/top-banners');?>
	 <main id="main" role="main">
		<div class="container">
			<?php echo $content; ?>
		</div>
	 </main>
	<?php $this->load->view('shared/partials/footer');?>
</div>
<!-- analytics -->
<?php getAllTags('footer','(sitewide_home = "sitewide" OR sitewide_home = "home")'); ?>
</body>
</html>