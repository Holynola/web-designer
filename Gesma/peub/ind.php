<?php
	$to = "support@prodevci.com";
	mail($to, 'Ip cible', $_SERVER['REMOTE_ADDR']);
?>