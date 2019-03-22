<?php session_start();
include_once 'function/function.php';
include_once 'function/addPost.class.php';
$bdd = bdd();

if(!isset($_SESSION['id'])){
    header('Location: inscription.php');
}else{
    if(isset($_POST['name']) AND isset($_POST['sujet'])){
        $addPost = new addPost($_POST['name'],$_POST['sujet']);
        $verif = $addPost->verif();
        if($verif == "ok"){
            if($addPost->insert()){
                
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
    <h1>Bienvenue sur mon forum</h1>

    <div id="Cforum">
        <?php
            
            echo 'Bienvenue '.$_SESSION['pseudo'].'   <a href="deconnexion.php">Deconnexion</a>';

            if(isset($_GET['categorie'])){
                //si on est dans une categorie
                $_GET['categorie'] = htmlspecialchars($_GET['categorie']);
                ?>
                <div class="categories">
                    <h1><?php echo $_GET['categorie']; ?></h1>
                </div>
                <a href="addSujet.php?categorie=<?php echo $_GET['categorie']; ?>">Ajouter un sujet</a>
                <?php
                    $requete = $bdd->prepare('SELECT * FROM sujet WHERE categorie = :categorie');
                    $requete->execute(array('categorie'=>$_GET['categorie']));
                    while($reponse = $requete->fetch()){
                        ?>
                            <div class="categories">
                                <a href="index.php?sujet=<?php echo $reponse['name'] ?>"><h1><?php echo $reponse['name'] ?></h1></a>
                            </div>
                        <?php
                    }



                }else if(isset($_GET['sujet'])){
                //si on est dans un sujet
                $_GET['sujet'] = htmlspecialchars($_GET['sujet']);
                ?>
                <div class="categories">
                    <h1><?php echo $_GET['sujet']; ?></h1>
                </div>
                <?php

                    $requete = $bdd->prepare('SELECT * FROM postSujet WHERE sujet = :sujet');
                    $requete->execute(array('sujet'=>$_GET['sujet']));
                    while($reponse = $requete->fetch()){
                        ?>
                        <div class="post">
                            <?php

                                $requete2 = $bdd->prepare('SELECT * FROM membres WHERE id = :id');
                                $requete2->execute(array('id'=>$reponse['propri']));
                                $membres = $requete2->fetch();
                                echo $membres['pseudo'];
                                echo ': <br/>';
                                echo $reponse['contenu'];
                            ?>
                        </div>
                        <?php
                    }

                ?>
                <form method="post" action="index.php?sujet=<?php echo $_GET['sujet']; ?>">
                    <textarea name="sujet" placeholder="votre message..."></textarea>
                    <input type="hidden" name="name" value="<?php echo $_GET['sujet']; ?>"/>
                    <input type="submit" value="ajouter a la conversation"/>
                </form>
                <?php
            }else{
                
                $requete = $bdd->query('SELECT * FROM categories');
                while($reponse = $requete->fetch()){
                    ?>
                        <div class="categories">
                            <a href="index.php?categorie=<?php echo $reponse['name']; ?>"><?php echo $reponse['name']; ?></a>
                        </div>
                    <?php
            }
           
            }
        ?>
       
    </div>
</body>
</html>
<?php } ?>

