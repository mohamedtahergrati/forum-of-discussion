<?php 
include_once 'function.php';

class inscription{
    private $pseudo;
    private $email;
    private $mdp;
    private $mdp2;
    private $bdd;

    public function __construct($pseudo,$email,$mdp,$mdp2){

        $pseudo = htmlspecialchars($pseudo);
        $email = htmlspecialchars($email);

        $this->pseudo = $pseudo;
        $this->email = $email;
        $this->mdp = $mdp;
        $this->mdp2 = $mdp2;
        $this->bdd = bdd();
    }

    public function verif(){
        if(strlen($this->pseudo) > 5 AND strlen($this->pseudo) < 20){
            //pseudo bon
            $syntaxe = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
            if(preg_match($syntaxe,$this->email)){
                //email bon
                if(strlen($this->mdp) > 5 AND strlen($this->mdp) < 20){
                    //bon format mot de passe
                    if($this->mdp == $this->mdp2){
                        //deux mdp  egaux
                        return 'ok';
                    }else{
                        $erreur = 'les mots de passe doivent etre identiques';
                        return $erreur;
                    }
                }else{
                    //mauvais format de mot de passe
                    $erreur = 'le mot de passe doit contenir entre 5 et 20 caracteres';
                    return $erreur;
                }
            }else{
                $erreur = 'Syntaxe du mail incorrect';
                return $erreur;
            }
            return 'ok';
        }else{
            //mauvais pseudo
            $erreur = 'Pseudo doit etre entre 5 et 20';
            return $erreur;
        }
    }

    public function enregistrement(){

        $requete = $this->bdd->prepare('INSERT INTO membres(pseudo,email,mdp) VALUES(:pseudo,:email,:mdp)');
        $requete->execute(array(
            'pseudo' => $this->pseudo,
            'email' => $this->email,
            'mdp' =>$this->mdp
        ));

        return 1;
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