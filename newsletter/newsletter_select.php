<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/include/autoprepend.php');
include_once('functions.lib.php');

if (!isset($id)){
	if (is_post('id')){
		$id = $_POST['id'];
	}
	elseif (is_get('id')){
		$id = $_GET['id'];
	}
	else{
		die("La newsletter n'a pas �t� trouv�");
	}
}
 
selectNewsletter($id);
?>