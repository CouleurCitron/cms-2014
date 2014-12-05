<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/include/autoprepend.php');

//include_once('bo/cms/composants.lib.php');

include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/include_cms.php');

include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/arbocarte.lib.php');



// Chargement de la classe

require_once('cms-inc/lib/fileUpload/upload.class.php');



activateMenu('gestioncarte');  //permet de d�rouler le menu contextuellement



// Instanciation d'un nouvel objet "upload"

$Upload = new Upload();

/**

 * Cr�ation du formulaire

 **/

 

 // D�finition du r�pertoire de destination

$Upload-> DirUpload = $CMS_ROOT_CLASSEUR_UPLOADIMG."/";





// Pour limiter la taille d'un  fichier (exprim�e en ko)

$Upload-> MaxFilesize  = '1000';



// N'autorise pas l'upload des fichiers dangereux executables ou scripts

$Upload-> SecurityMax = true;



/**

 * Gestion lors de la soumission du formulaire

 **/



	// force une extention d'image valide

	// l'upload ne fonctionnera pas si cette extention n'est pas bonne

	$Upload-> Extension = ".gif;.png;.jpeg;.jpg;.jpe";

	if($picto = getArbopictoCarte($_POST['node_id'])) {

	// Un picto existe d�j� (gif, png, jpg?)

	// on le supprime pour �viter les conflits

		unlink($CMS_ROOT_CLASSEUR_UPLOADIMG."/".$picto);

	}

	

	$Upload-> Filename = "picto_".$_POST['node_id'];

	$Upload-> Execute(); // On lance la proc�dure d'upload

	

	// V�rification du type du fichier, si png, gif, jpg, jpeg ou jpe ok, sinon pas cool

	if (!preg_match('/\.(gif|png|jpeg|jpg|jpe)/',$Upload-> _ext)) {



	?>

		<link href="<?php echo $URL_ROOT; ?>/css/bo.css" rel="stylesheet" type="text/css">

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	margin-right: 0px;

	margin-bottom: 0px;

}

-->

</style><br>

<br>

<br>

<span class="arbo"><strong>Le fichier transmis n'est pas au bon format<br><br>

L'image doit �tre au format png, gif, ou jpeg</strong></span>

<?php

	return false;

	}





?>

<br>

	<?php

	// Gestion erreur / succ�s

		if ($UploadError) {

			print 'Il y a eu une erreur :'; 

			var_dump($Upload-> GetError());

		} else {

			//print 'Upload effectu� avec succ�s :';

			//pArray($Upload-> GetSummary());

?>

<link href="<?php echo $URL_ROOT; ?>/css/bo.css" rel="stylesheet" type="text/css">

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	margin-right: 0px;

	margin-bottom: 0px;

}

-->

</style><br>

<br>

<br>



<span class="arbo"><strong>L'image a �t� transf�r� avec succ�s.</strong></span><br>



<?php

		}

?>