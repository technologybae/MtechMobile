<?php
function getLoginUserCompanyData($id)
{
 $qq = "Select * from ".dbObjectMain."Logins where id = '".$id."'";
$qu = RunMain($qq);
$getUserData = myfetchMain($qu);
 $companyId = $getUserData->companyId;
 $qq = "Select * from ".dbObjectMain."Companies where id = '".$companyId."'";
$qu = RunMain($qq);	
	$getComData = myfetchMain($qu);

return $getComData;	
}
?>