<?php

//On initialise la session (/!\ la variable $_SESSION est special)
                            // Ce sont les variables qui restent stockées sur la serveur le temps de la présence du visiteur. 
session_start(); 

// Déclaration du formulaire
$formulaire = '<form action="#" method="post">
                    <p>
                        <label>Jouons à un jeu : 1-100</label> 
                        <input name="nombre" type="text" autofocus/>
                        <input type="submit" value ="Je crois en ma chance !"/>
                    </p>
                </form>';

$nombreentre = $_POST['nombre'];
 
if (empty($_SESSION['nb_mystere']))
{
    $_SESSION['essais'] = array();
    $_SESSION['nb_mystere'] = mt_rand(0, 100);
    $_SESSION['nb_coups'] = 0;
    echo $formulaire;
    echo $bouton;
}
else
{
    $_SESSION['essais'][] = $nombreentre;
    $_SESSION['nb_coups']++;
     
    //Génération de l'historique des essais
    $histo = "<br /><br /><u>Nombre d'essais :</u><br />\n<ul>";
    foreach ($_SESSION['essais'] as $num => $nb) {
        $histo .='<li>'.$nb.' ==> C\'est ';
        if ($nb < $_SESSION['nb_mystere'])
            $histo .= 'plus grand !</li>'."\n";
        elseif ($nb > $_SESSION['nb_mystere'])
            $histo .= 'plus petit !</li>'."\n";
        else
            $histo .= 'gagné x) !</li>'."\n";
    }
     //Historique généré

     //Si le nombre mystere est plus grand que le nombre entrée, alors on affiche "plus ?"
    if ($_SESSION['nb_mystere'] > $nombreentre)
    {
        echo 'Plus ?';
        echo $formulaire;
        echo $histo;
        echo $bouton;
    }
    //Si le nombre mystere est plus petit que le nombre entrée, alors on affiche "moins ?"
    elseif ($nombreentre > $_SESSION['nb_mystere'])
    {
        echo 'Moins ?';
        echo $formulaire;
        echo $histo;
        echo $bouton;
    }
    //Si le nombre mystere est trouvé, alors on affiche "bingo"
    else
    {

        session_destroy();
        echo 'Bingo, tu as trouvé le nombre mystère !<br />';
        echo 'Tu as seulement mis '.$_SESSION['nb_coups'].' coups.';
        echo $histo;
        echo $bouton;
        // On crée un cookie si il n'existe pas déjà ou on le met à jour avec le dernier nombres de coups
        setcookie("Score",$_SESSION['nb_coups']);
        echo "<br><b>Ta dernière tentative était de </b>".$_COOKIE['Score']." <b>coups.</b>";



    }

}
?>