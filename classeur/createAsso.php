<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/include/autoprepend.php');

include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/include_cms.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/arbocarte.lib.php');

activateMenu('gestioncarte');  //permet de d�rouler le menu contextuellement

// Si pas de dossier choisi, on met la carte � la racine
$node_id = ($_POST['node_id']!="") ? $_POST['node_id'] : 0;
?>

<link href="<?php echo $URL_ROOT; ?>/css/bo.css" rel="stylesheet" type="text/css" />

<span class="arbo2"><b>Stockage du composant <?php echo stripslashes($_POST['nom']); ?> dans le classeur</b></span>

<?php

// Remplacement des :;,./ par des , dans la liste des mots cl�s
// Et ajustement des espaces
$_POST['motscles'] = preg_replace('/[\s]*[\:\;\.\,\/\_][\s]*/',', ',$_POST['motscles']);

	// ok, on enregistre
	$id = $_GET['id'];
	$idclasse = $_GET['idclasse'];
	if($_POST['id']!="") $id = $_POST['id'];
	$idnodeold= $_POST['idnode'];
	$idnodenew= $_POST['node_id'];
	if (strlen($id) > 0 ) {
		$test = storeEnregistrement($idnodenew, $idnodeold, $id, $idclasse);

	} else {
		$test = storeEnregistrement($idnodenew, $idnodeold, $id, $idclasse);
	}
	
	if($test) {
?>
<br />
<br />
<span class="arbo">L'association a �t� correctement sauvegard�. <br />
<br />
<script language="javascript" type="text/javascript">bOpen=false; OpenMenu('nav'); </script>
<?php
	} else {
?>
<br />
<br />
Une erreur s'est produite lors de la sauvegarde de la carte. Veuillez r�essayer. Si le probl�me persiste, veuillez contacter l'administrateur</span>
<?php
	}

?>
</span>