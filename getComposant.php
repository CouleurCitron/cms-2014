<script src="/backoffice/cms/js/AC_RunActiveContent.js" type="text/javascript"></script>
<?php

// R�cup�re le HTML d'une brique

include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/arbominisite.lib.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/composants.lib.php');

$id=$_GET['id'];

$composant = getComposantById($id);

if ($composant!=false) {

	$sChaine = $composant['html'];
	
	$sChaine = ereg_replace("<\?(.*)\?>", "[code php dynamique]", $sChaine);

	echo $sChaine;
}

?>
