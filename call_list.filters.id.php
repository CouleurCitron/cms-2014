<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/include/autoprepend.php');  

	include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/include_cms.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/include_class.php');
	
	$id = $_GET["id"];
	$classeName = $_GET["classeName"]; 
	
	$aObj =  dbGetObjectsFromFieldValue($classeName, array('get_id'), array($id), '');
	 
	echo sizeof($aObj);
	
?>