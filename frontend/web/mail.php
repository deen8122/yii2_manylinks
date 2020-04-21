<?php
	

	$mail = $_REQUEST['email'];
	if(strlen($mail) < 5){
	 echo 'Ошибка, не указан email';
	 exit;
	}
	echo '<br>письмо отправлено на mail:'.$mail.'<br>';
	//echo mail($mail ,"sdfsdfsdfs","33333333333333333");