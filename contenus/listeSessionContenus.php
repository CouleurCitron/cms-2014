<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/include/autoprepend.php');
/* 
sponthus 23/09/2005
gestion des contenus

// mise en session

*/

//------------------------------------------
// crit�res de recherche et session
//------------------------------------------

// si on a un post : on le recherche et on le met en session
// sinon : on recherche le crit�re en session

// crit�res de recherche :: plier d�plier 
if (isset($_POST['bChercherOpen'])) {
	$rech_bChercherOpen = $_POST['bChercherOpen'];
	$_SESSION['rech_bChercherOpen'] = $_POST['bChercherOpen'];
}
else {
	$rech_bChercherOpen = $_SESSION['rech_bChercherOpen'];
}

// crit�res de recherche :: zone de texte
if (isset($_POST['fZone'])) {
	$rech_zone = $_POST['fZone'];
	$_SESSION['rech_fZone'] = $_POST['fZone'];
}
else {
	$rech_zone = $_SESSION['rech_fZone'];
}

// crit�res de recherche :: gabarit
if (isset($_POST['selectGabarit'])) {
	$rech_selectGabarit = $_POST['selectGabarit'];
	$_SESSION['rech_selectGabarit'] = $_POST['selectGabarit'];
}
else {
	$rech_selectGabarit = $_SESSION['rech_selectGabarit'];
}

// crit�res de recherche :: page
if (isset($_POST['page_id'])) {
	$rech_page_id = $_POST['page_id'];
	$_SESSION['rech_page_id'] = $_POST['page_id'];
}
else {
	$rech_page_id = $_SESSION['rech_page_id'];
}

// crit�res de recherche :: chemin
if (isset($_POST['node_id'])) {
	$rech_node_id = $_POST['node_id'];
	$_SESSION['rech_node_id'] = $_POST['node_id'];
}
else {
	$rech_node_id = $_SESSION['rech_node_id'];
}

?>