<?php
class Genre
{
    public $idGenre;
    public $nomGenre;

    function __construct($nom)
    {
        $this->nomGenre = $nom;
    }
    
    function Get($id)
    {
        global $conn;
        $sql = "SELECT * FROM genre WHERE id=$id";
        $result = mysqli_query($conn, $sql);
        $tab = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $ret = json_encode($tab, JSON_PRETTY_PRINT);
        header('Content-Type: application/json');
        echo $ret;
    }
    function Post()
    {
        global $conn;
        $nom = htmlentities($_POST['nomGenre']);
        $sql = "INSERT INTO `Genre`(`nomGenre`) VALUES ('$nom')";
        $result = mysqli_query($conn, $sql);
    
    
        if ($result) 
        {
            $retour["value"] = "Insertion du genre effectuée";
            $retour["value"] = "true";
            $ret = json_encode($retour, JSON_PRETTY_PRINT);
            header('Content-Type: application/json');
            echo $ret;
        } 
        else 
        {
            $retour["value"] = "Insertion du genre échouée";
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