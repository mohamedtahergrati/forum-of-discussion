<?php session_start();
include_once 'function/function.php';
include_once 'function/inscription.class.php';
$bdd = bdd();

if(isset($_POST['pseudo']) AND isset($_POST['email']) AND isset($_POST['mdp']) AND isset($_POST['mdp2'])){
    
    $inscription = new inscription($_POST['pseudo'],$_POST['email'],$_POST['mdp'],$_POST['mdp2']);
    $verif = $inscription->verif();
    if($verif == 'ok'){
        //tout est bon
        if($inscription->enregistrement()){
            if($inscription->session()){
                //tout est mis en session
                header('Location: index.php');
            }
        }else{
            echo 'une erreur est survenue';
        }
    } else {
        echo $erreur=$verif;
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
    <script src="main.js"></script>
</head>
<body>
    <h1>Inscription</h1>
    <div id="Cforum">
        <form method="post" action="inscription.php">
            <p>
                <input name="pseudo" type="text" placeholder="Pseudo..." required /><br/>
                <input name="email" type="email" placeholder="Adresse email..." required /><br/>
                <input name="mdp" type="password" placeholder="Mot de passe..." required /><br/>
                <input name="mdp2" type="password" placeholder="Confirmation..." required /><br/>
                <input type="submit" value="S'inscrire" /><br/>
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

