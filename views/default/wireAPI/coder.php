<?php





ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

$secret = md5(time().rand());
		$token = md5(md5(time() .rand()+ time()));



echo $secret.';'.$token;



?>
