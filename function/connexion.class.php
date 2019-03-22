<?php 
include_once 'function.php';

class connexion{
    private $pseudo;
    private $mdp;
    private $bdd;

    public function __construct($pseudo,$mdp) {
        $this->pseudo = $pseudo;
        $this->mdp = $mdp;
        $this->bdd = bdd();
    }

    public function verif(){
        $requete = $this->bdd->prepare('SELECT * FROM membres WHERE pseudo = :pseudo');
        $requete->execute(array('pseudo'=> $this->pseudo));
        $response = $requete->fetch();
        if($response){
            if($this->mdp == $response['mdp']){
                return 'ok';
            }else{
                $erreur = 'le mot de passe est incorrect';
                return $erreur;
            }
        }else{
            $erreur = 'le pseudo est inexistant';
            return $erreur;
        }

    }

    public function session(){
        $requete = $this->bdd->prepare('SELECT id FROM membres WHERE pseudo = :pseudo');
        $requete->execute(array('pseudo'=> $this->pseudo));
        $requete = $requete->fetch();
        $_SESSION['id'] = $requete['id'];
        $_SESSION['pseudo'] = $this->pseudo;

        return 1;
    }
}