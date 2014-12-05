<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/include/autoprepend.php'); 

include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/include_cms.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/include_class.php'); 

activateMenu("gestionclasse"); 

?>


<div class="ariane"><span class="arbo2">MODULE >&nbsp;</span><span class="arbo3">G�n�ration du fichier Crontab</span></div>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="savePage" class="arbo">
	<input type="hidden" name="node_id" id="node_id" value=""/>
	<div id="virginie">
	<p> <br />Pour �diter une crontab : <br /><br />
	<input type="text" value="EDITOR=ee crontab -e" /></p>
	<p> <br />
	Pour connaitre les taches programm�es faire : <br /><br />
	<input type="text" value="crontab -e" /></p>
 	<p>
	  <br />
		Copier coller : <br /> <br />
	  <textarea name="description" class="arbo textareaEdit" id="form_description"><?php echo getAllCronTab(); ?></textarea>
	  </p>
 <p> <br /> <br />Le format de la crontab est le suivant : mm hh jj MMM JJJ t�che<br /><br />

* mm repr�sente les minutes (de 0 � 59)<br />
* hh repr�sente l'heure (de 0 � 23)<br />
* jj repr�sente le num�ro du jour du mois (de 1 � 31)<br />
* MMM repr�sente le num�ro du mois (de 1 � 12) ou l'abr�viation du nom du mois (jan, feb, mar, apr, �)<br />
* JJJ repr�sente l'abr�viation du nom du jour ou le chiffre correspondant au jour de la semaine (0 repr�sente le dimanche, 1 repr�sente le lundi, ..)<br />
* t�che repr�sente la commande ou le script shell � ex�cuter<br />
</p>
 <p>  <br /><br />Pour chaque unit� de temps (minute/heure/�) les notations sont possibles:<br /> <br />

* * : � chaque unit� de temps (0, 1, 2, 3, 4�)<br />
* 5,8 : les unit�s de temps 5 et 8<br />
* 2-5 : les unit�s de temps de 2 � 5 (2, 3, 4, 5)<br />
* */3 : toutes les 3 unit�s de temps (0, 3, 6, 9�)<br />
* 10-20/3 : toutes les 3 unit�s de temps, entre la dixi�me et la vingti�me (10, 13, 16, 19)
</p>
 <p>  <br /><br /> Par exemple ex�cution d'un script php toutes les 30 minutes :<br />

*/30 * * * * /usr/local/bin/php -f /home/k1001/scripts/test.php\\<br /><br />

Ex�cution d'un script php (via http) tous les jours ouvr�s � 11h 15 sans conserver la sortie :<br />

15 11 * * 1-5 /usr/bin/fetch -o /dev/null http://www.monsite.com/test.php<br /><br />

Le m�me en envoyant la sortie par mail :<br />

15 11 * * 1-5 /usr/bin/fetch -o - http://www.monsite.com/test.php | mail -s "Mon Cron" moi@mondomaine.com<br /><br />

En cas d'erreur vous trouverez les informations n�cessaires en consultant (par exemple dans le webmail), <br />
les mails de l'utilisateur en question (dans notre exemple k1001). <br />
</p>
	</div> 
</form>


<?php

function getCronTab ($id_cron) {
	
	
	 
	if (isObjectById("cms_cron", $id_cron)	) {
	
		$oObj = getObjectById("cms_cron", $id_cron);
		 
		$cron = $oObj->get_mm().' '.$oObj->get_hh().' '.$oObj->get_jj().' '.$oObj->get_mmm().' '.$oObj->get_jjj().' /usr/bin/fetch http://'.$_SERVER['HTTP_HOST'].''.$oObj->get_file();
		
		return $cron;
		
	}
	else {
	
		return $false;
		
	}
		 
}


function getAllCronTab () {
	 
	$aObj = dbGetObjectsFromFieldValue2("cms_cron", array('get_statut'),  array(DEF_ID_STATUT_LIGNE), array('get_ordre'), array('ASC'));
	if (sizeof($aObj) > 0 && $aObj != false) {
		
		$cron = '';
		
		foreach ($aObj as $oObj ) {
			$cron.= getCronTab($oObj->get_id())."\n";
		} 
		return $cron;
		
	}
	else {
	
		return $false; 
	}
		 
}

?>