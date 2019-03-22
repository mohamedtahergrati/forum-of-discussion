<?php session_start();
include_once 'function/function.php';
include_once 'function/connexion.class.php';
$bdd = bdd();
if(isset($_POST['pseudo']) AND isset($_POST['mdp'])){
    $connexion = new connexion($_POST['pseudo'],$_POST['mdp']);
    $verif = $connexion->verif();
    if($verif == 'ok'){
        if($connexion->session()){
            header('Location: index.php');
        }
    }else{
        $erreur = $verif;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Mon super forum</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
</head>
<body>
    <h1>Connexion</h1>
    <div id="Cforum">
        <form method="post" action="connexion.php">
            <p>
                <input name="pseudo" type="text" placeholder="Pseudo..." required /><br/>
                <input name="mdp" type="password" placeholder="Mot de passe..." required /><br/>
                <input type="submit" value="se connecter" /><br/>
                <?php
                    if(isset($erreur)){
                        echo $erreur;
                    }
                ?>
            </p>
        </form>
    </div>
</body>
</html>

