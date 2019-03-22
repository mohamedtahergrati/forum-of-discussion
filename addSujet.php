<?php session_start();
include_once 'function/function.php';
include_once 'function/addSujet.class.php';
$bdd = bdd();

if(isset($_POST['name']) AND isset($_POST['sujet'])){
    $addSujet = new addSujet($_POST['name'],$_POST['sujet'],$_POST['categorie']);
    $verif = $addSujet->verif();
    if($verif == "ok"){
        if($addSujet->insert()){
            header('Location: index.php?sujet='.$_POST['name']);
        }
    }else{
        //on a une erreur
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
    <h1>Ajouter un sujet</h1>
    <div id="Cforum">
        <?php 
            echo 'Bienvenue '.$_SESSION['pseudo'].'   <a href="deconnexion.php">Deconnexion</a>';
        ?>
            <form method="post" action="addSujet.php?<?php echo $_GET['categorie']; ?>">
                <p>
                    <br/><input type="text" name="name" placeholder="Nom du sujet..." required/><br/>
                    <textarea name="sujet" palceholder="Contenu du sujet..."></textarea><br/>
                    <input type="hidden" value="<?php echo $_GET['categorie']; ?>" name="categorie" />
                    <input type="submit" value="Ajouter le sujet" />
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

