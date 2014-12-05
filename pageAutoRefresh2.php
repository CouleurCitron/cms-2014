<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/include/autoprepend.php');
/*
	
*****************************************************
*** R�g�n�ration automatique de pages             ***
***                                               ***
*** R�cup�r� du fichier pageAutoEditor4.php       ***
*****************************************************
*/

	include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/arbopage.lib.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/pages.lib.php');
	activateMenu('gestionpage');  //permet de d�rouler le menu contextuellement
	
	$DIR_GABARITS = $_SERVER['DOCUMENT_ROOT']."/backoffice/cms/gabarits";
	
	$virtualpath = $_POST['v_comp_path'];

	if($virtualpath=="")
		die('<b>Un probl�me est survenu, il manque des informations (arguments manquants).</b><br />');


	function modif_page($id_page) {
	// Avec l'id page fourni on r�g�n�re la page
	// cette modif se fait dans la base et dans le fichier physique
		$div_array = getPageStructure($id_page);
		$infopage = getPageById($id_page);

		$id_page = savePage($div_array,$infopage['node_id'],$infopage['name'],"","true","true",null,$id_page,$div_array['titre'],$div_array['motscles'],$div_array['description']);
		if($id_page>0 && saveStruct($id_page,$div_array) && storeInfosPage($id_page, $div_array['titre'], $div_array['motscles'], $div_array['description'], "")) {

				// enregistrement en base OK
				$generateFile = true;
?><link rel="stylesheet" type="text/css" href="/backoffice/cms/css/bo.css">
	<body class="arbo">
	<li>Les param�tres de la page <?php echo  $div_array['titre'] ; ?> ont �t� correctement sauvegard�e.</li>
<?php
			} else {
				$error++;
				$generateFile=false;
				die('<b>Un probl�me est survenu durant l\'enregistrement de la page '.$div_array['titre'].'.</b><br />');	
			}
			if ($generateFile) { // G�n�ration du fichier physique
				$arrayresult = generateFile($id_page,$div_array['titre'], $div_array['motscles'], $div_array['description']);
				if (is_array($arrayresult)) {
?>
	<li>Le fichier <?php echo $arrayresult['filename']; ?> a �t� cr�� dans le dossier <?php echo $arrayresult['foldername']; ?>.</li>
	<li>chemin complet : <b><?php echo $_SERVER['DOCUMENT_ROOT']."/content".$arrayresult['path'].$arrayresult['filename']; ?></b></li></ul>
	<a href="/content<?php echo $arrayresult['path'].$arrayresult['filename']; ?>" target="_blank" class="arbo">Visualiser</a> la page g�n�r�e.
<?php
				}
			} else {
				// On tente de continuer meme si erreur sur ce fichier
				echo '<b>Un probl�me est survenu durant l\'enregistrement de la page '.$div_array['titre'].'.</b><br />';
			}
	}

	function getPageListRecursDir($VPath) {
	// Retourne tous les ID des pages du dossier courant et de ses sous dossiers
		global $db;
		$childs = getNodeChildren($db,$VPath);
		$Arraychilds = Array();
		if (count($childs)!=0) {
			// Il existe encore des sous r�pertoires
			// => on relance la fonction pour chaque enfant
			foreach($childs as $key => $child) {
				$pagelistchild = getPageListRecursDir($VPath.",".$child['id']);
				if($pagelistchild)
					$Arraychilds = array_merge( $Arraychilds, $pagelistchild );
			}
		}
		$listpages = Array();
		$listpages = getFolderPages($VPath);
		$listpagesid = Array();
		if($listpages) {
			foreach($listpages as $k => $page) {
				array_push($listpagesid, $page['id']);
			}
		}
		return  array_merge( $listpagesid , $Arraychilds);
	}
	
	// R�cup�ration des pages du dossier en cours
	$listpages = getPageListRecursDir($virtualpath);

	if($listpages) {
		foreach($listpages as $k => $page_id) {
			modif_page($page_id);
		}
	}
	else {
		die('<b>Probl�me: le dossier s�lectionn� ne contient pas de pages!!</b><br />');	
	}
?>