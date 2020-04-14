<?php

class Role
{
    public $idFilm;
    public $idActeur;
    public $nomRole;

    function __construct($nom)
    {
        $this->nomGenre = $nom;
    }
    
    function Get($id = 1)
    {
        global $conn;
        $sql = "SELECT * FROM artiste WHERE idActeur=$id";
        $result = mysqli_query($conn, $sql);
        $tab = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $ret = json_encode($tab, JSON_PRETTY_PRINT);
        header('Content-Type: application/json');
        echo $ret;
    }
    function postRole()
    {
        global $conn;
        $idFilm = htmlentities($_POST['idfilm']);
        $idActeur = htmlentities($_POST['idActeur']);
        $nomRole = htmlentities($_POST['nom']);
        $sql = "INSERT INTO `Artiste`(`idfilm`, `idActeur`, `nomRole`) VALUES ('$idFilm','$idActeur', $nomRole)";
        $result = mysqli_query($conn, $sql);
    
    
        if ($result) {
            $retour["phrase"] = "insertion effectuée";
            $retour["value"] = "true";
            $ret = json_encode($retour, JSON_PRETTY_PRINT);
            header('Content-Type: application/json');
            echo $ret;
        } else {
            $retour["phrase"] = "insertion ratée";
            $retour["value"] = "false";
            $ret = json_encode($retour, JSON_PRETTY_PRINT);
            header('Content-Type: application/json');
            echo $ret;
        }
    }
    function Delete()
    {
        global $conn;
        $_DELETE = array();
        parse_str(file_get_contents('php://input'), $_DELETE);
        print_r($_DELETE);
        $id = $_DELETE['id'];
        $sql = "DELETE FROM Genre WHERE id=$id";
        echo $sql;
        $result = mysqli_query($conn, $sql);
        if ($result)
            echo "Suppression du genre effectuée";
        else echo "Suppression du genre échouée";
    }
}


?>