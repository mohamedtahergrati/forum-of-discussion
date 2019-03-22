<?php include_once 'function.php';

class addSujet{

    private $name;
    private $sujet;
    private $categorie;
    private $bdd;

    public function __construct($name,$sujet,$categorie) {
        $this->name = htmlspecialchars($name);
        $this->categorie = htmlspecialchars($categorie);
        $this->sujet = htmlspecialchars($sujet);
        $this->bdd = bdd();
    }

    public function verif(){

        if(strlen($this->name) > 5 AND strlen($this->name) < 60){
            //nom sujet bon
            if(strlen($this->sujet) > 0){
                //on a un sujet
                return 'ok';
            }else{
                //pas de contenu
                $erreur = 'veuillez entrer le contenu du sujet';
                return $erreur;
            }
        }else{
            //nom sujet mauvais
            $erreur = 'nom du sujet doit contenir entre 5 et 20 caracteres';
            return $erreur;
        }
    }

    public function insert(){
        $requete = $this->bdd->prepare('INSERT INTO sujet(name,categorie) VALUES(:name,:categorie)');
        $requete->execute(array('name'=> $this->name,'categorie'=> $this->categorie));

        $requete2 = $this->bdd->prepare('INSERT INTO postSujet(propri,contenu,date,sujet) VALUES(:propri,:contenu,NOW(),:sujet)');
        $requete2->execute(array('propri'=>$_SESSION['id'],'contenu'=> $this->sujet,'sujet'=>
    $this->name));

        return 1;
    }
}