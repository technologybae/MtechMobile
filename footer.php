<?php
$lang = $_SESSION['lang'];
$enDisplay = $lang == 1 ? 'block' : 'none';
$arDisplay = $lang == 2 ? 'block' : 'none';
?>

<footer style="text-align: center">
	<p class="enBtn" style="display: <?= $enDisplay; ?>;">Developed & Designed by Mtech. All Rights Reserved.</p>
	<p class="arBtn" style="display: <?= $arDisplay; ?>;"> .<?= getArabicTitle('Developed & Designed by Mtech. All Rights Reserved') ?></p>
</footer>

<!-- Language Chagne Popup -->
<div class="modal fade" id="exampleModal" aria-labelledby="exampleModalCenterTitle" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h2>Choose Option</h2>
			</div>
			<div class="modal-body">
				<button type="button" onclick="changeLanguage(1)" class="btn btn-secondary" data-dismiss="modal" style="width: 100%;margin-bottom: 8px;">English</button>
				<button type="button" onclick="changeLanguage(2)" class="btn btn-primary" data-dismiss="modal" style="width: 100%;margin-bottom: 8px;">Arabic</button>
			</div>

		</div>
	</div>
</div>