<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/include/autoprepend.php');
$aCustom = array();
$aCustom["JS"] = " // js
function loadnodes(id){
		document.##classePrefixe##_list_form.display.value = id;
		document.##classePrefixe##_list_form.actiontodo.value = \"LOAD\";
		document.##classePrefixe##_list_form.action = \"load_cms_assoclassenode.php?display=\"+id+\"&\";
		document.##classePrefixe##_list_form.submit();
}
 ";
$aCustom["JS"] .= " // js
function savenodes(id){
		document.##classePrefixe##_list_form.display.value = id;
		document.##classePrefixe##_list_form.actiontodo.value = \"SAVE\";
		document.##classePrefixe##_list_form.action = \"save_cms_assoclassenode.php?display=\"+id+\"&\";
		document.##classePrefixe##_list_form.submit();
}
 ";
$aCustom["Action"] = "<a href=\"javascript:loadnodes(##id##);\" title=\"Charger les objets d'apr�s les dossiers\"><img src=\"/backoffice/cms/img/2013/icone/right.png\" alt=\"Charger les objets d'apr�s les dossiers\" border=\"0\" /></a>";
$aCustom["Action"] .= "&nbsp;&nbsp;<a href=\"javascript:savenodes(##id##);\" title=\"Ecrire les dossier d'apr�s les objets\"><img src=\"/backoffice/cms/img/2013/icone/left.png\"   alt=\"Ecrire les dossier d'apr�s les objets\" border=\"0\" /></a>";

include('cms-inc/autoClass/list.php'); ?>