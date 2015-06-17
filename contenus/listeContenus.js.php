<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/include/autoprepend.php');
  header('Content-Type: application/x-javascript'); 
?>

	// cr�ation d'une nouvelle version de travail � partir de la version en ligne
	// un nouvel enregistrement CMS_CONTENT va �tre cr��
	// la version en ligne (CMS_ARCHI_CONTENT) reste jusqu'� ce qu'une nouvelle version en ligne la pousse
	function createNewVersion(idContent, idSite, bEcrase)
	{
		bConfirm=1;
		if (bEcrase) {

			sMessage = "ATTENTION !\n\n";
			sMessage+= "Il existe d�j� une version de travail de ce contenu\n\n";
			sMessage+= "En cr�ant une nouvelle version, vous allez �craser la version de travail\n\n";
			sMessage+= "Etes vous s�r ?";
			if (confirm	(sMessage))
			{
				bConfirm=1;
			} else bConfirm=0;
		}
		
		if (bConfirm) majContenu(idContent, idSite, "listeContenus.php");
	}

	// s�lection d'un noeud pour la recherche
	function chooseFolder() {
	  
		window.open("/backoffice/cms/chooseFolder.php?idSite=<?php echo $_SESSION['idSite_travail']; ?>","browser","scrollbars=yes,width=500,height=500,resizable=yes,menubar=no");
	}

	// s�lection d'un noeud pour la recherche
	function choosePage() {
	  
		window.open("/backoffice/cms/choosePage.php?idSite=<?php echo $_SESSION['idSite_travail']; ?>","browser","scrollbars=yes,width=650,height=500,resizable=yes,menubar=no");
	}

	// efface le chemin choisi
	function effacerFolder()
	{
		document.contenuListForm.foldername.value="";
		document.contenuListForm.node_id.value="";
	}

	// efface la page choisie
	function effacerPage()
	{
		document.contenuListForm.pagename.value="";
		document.contenuListForm.page_id.value="";
	}

	function majStatut(id, operation){
		if (document.contenuListForm.fZone.value == "Mots clefs"){
			document.contenuListForm.fZone.value = "";
		}
		document.contenuListForm.id.value=id;
		document.contenuListForm.operation.value=operation;
		document.contenuListForm.action="listeContenus.php";
		document.contenuListForm.submit();
	}

	// affinage de la liste des contenus
	// bandeau de recherche
	function recherche()
	{	
		if (document.contenuListForm.fZone.value == "Mots clefs"){
			document.contenuListForm.fZone.value = "";
		}
		document.contenuListForm.action = "listeContenus.php";
		document.contenuListForm.submit();
	}

	// mise � jour du contenu de la brique
	function majContenu(id, idSite, urlRetour)
	{
		document.contenuListForm.action = "contenuEditor.php?id=" + id + "&idSite=" + idSite + "&urlRetour="+urlRetour;
		document.contenuListForm.submit();
	}

	// plie les crit�tres de recherche
	function plier_recherche()
	{
		document.contenuListForm.bChercherOpen.value = "1";
		document.contenuListForm.action = "listeContenus.php";
		document.contenuListForm.submit();
	}

	// d�plie les crit�tres de recherche
	function deplier_recherche()
	{
		document.contenuListForm.bChercherOpen.value = "0";
		document.contenuListForm.action = "listeContenus.php";
		document.contenuListForm.submit();
	}