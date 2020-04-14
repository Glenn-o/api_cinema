<?php
class Artist
{
    public $id;
    public $nom;
    public $prenom;
    public $anneeNaiss;

    function __construct($nom, $prenom, $annee, $arme)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->anneeNaiss = $annee;
    }

    function Get($research)
    {
        global $conn;
        
        $sql = "SELECT artiste.nom, artiste.prenom, artiste.anneeNaiss FROM `artiste` 
        WHERE nom LIKE '%$research%' OR prenom LIKE '%$research%'";
        $result = mysqli_query($conn, $sql);
        $tab = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $ret = json_encode($tab,JSON_PRETTY_PRINT); //Tableau converti en json
        header('Content-Type: application/json');
        echo $ret;
    }

    function Post()
    {
        global $conn;
        $nom = htmlentities($_POST['nom']);
        $prenom = htmlentities($_POST['prenom']);
        $anneeNaiss = htmlentities($_POST['anneeNaiss']);
        $sql = "INSERT INTO `artiste`(`nom`, `prenom`, `anneeNaiss`) VALUES ('$nom', '$prenom', $anneeNaiss)";
        $result = mysqli_query($conn, $sql);

        if($result)
        {
            
            $retour["phrase"] = "insertion effectuée";
            $retour["value"]="true";
            $ret = json_encode($retour,JSON_PRETTY_PRINT); //Tableau converti en json
            header('Content-Type: application/json');
            echo $ret;
        }
        else
        {
            $retour["phrase"] = "insertion raté";
            $retour["value"]="false";
            $ret = json_encode($retour,JSON_PRETTY_PRINT); //Tableau converti en json
            header('Content-Type: application/json');
            echo $ret;
        }
    }
    
    function Update()
    {
        global $conn;
        
        $_PUT = array();
        parse_str(file_get_contents('php://input'), $_PUT);
        $id=$_PUT['idActeur'];
        $nom = htmlentities($_PUT['nom']);
        $prenom = htmlentities($_PUT['prenom']);
        $annee = htmlentities($_PUT['anneeNaiss']);
        $sql = "UPDATE `artiste`
        SET `nom` = '$nom',
        `prenom` = '$prenom',
        `anneeNaiss` = $annee
        WHERE `idActeur` = $id";
        $result = mysqli_query($conn, $sql);
        if($result){
            echo "update";
        }
        else{
            echo "loupé";
        }
    }
    
    function Delete()
    {
        global $conn;
        $_DELETE = array();
        parse_str(file_get_contents('php://input'), $_DELETE);
        $id=$_DELETE['idActeur'];
        $sql = "DELETE FROM `artiste` WHERE `idActeur` = $id";
        $result = mysqli_query($conn, $sql);
        if($result){
            echo "delete";
        }
        else{
            echo "loupé";
        }
    }
}
?>