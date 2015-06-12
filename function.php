<?php 

/*  MESSAGE FLASH  *********************/

function flash(){
	if (isset($_SESSION['flash'])) {
		extract($_SESSION['flash']);
		unset($_SESSION['flash']);
		return "<div class='alert alert-$type alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
		$message
		</div>";
	}
}

function setFlash($message, $type = 'success'){
	$_SESSION['flash']['message'] = $message;
	$_SESSION['flash']['type'] = $type;
}



function raccourcirChaine($chaine, $tailleMax)
{
    // Variable locale
    $positionDernierEspace = 0;
    if( strlen($chaine) >= $tailleMax )
    {
      $chaine = substr($chaine,0,$tailleMax);
      $positionDernierEspace = strrpos($chaine,' ');
      $chaine = substr($chaine,0,$positionDernierEspace).'...';
  }
  return $chaine;
}


function MoisFrancais($pMois){
    $aMois = array(  
        "Janvier",
        "Février",
        "Mars",
        "Avril",
        "Mai",
        "Juin",
        "Juillet",
        "Août",
        "Septembre",
        "Octobre",
        "Novembre",
        "Décembre"
        );
    if($pMois < count($aMois)+1)
        return $aMois[$pMois-1] ;
}



function debug($variable){
    echo '<pre>' . print_r($variable, true) . '</pre>';
}

