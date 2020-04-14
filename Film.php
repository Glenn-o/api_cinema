<?php
class Film
{
    public $idFilm;
    public $titre;
    public $annee;
    public $idGenre;
    public $resume;

    function __construct($titre, $annee, $resume)
    {
       $this->titre = $titre;
       $this->annee = $annee;
       $this->resume = $resume;
    }
    
    function Get_all_films()
    {
        global $conn;
        $sql = "select * from film where 1";
        $result = mysqli_query($conn, $sql);
        $tab = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $ret = json_encode($tab,JSON_PRETTY_PRINT); //Tableau converti en json
        header('Content-Type: application/json');
        echo $ret;
    }

    function Get_film($name)
    {
        global $conn;
        $sql = "SELECT * FROM film WHERE titre LIKE '%$name%'";
        $result = mysqli_query($conn, $sql);
        $tab = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $ret = json_encode($tab,JSON_PRETTY_PRINT); //Tableau converti en json
        header('Content-Type: application/json');
        echo $ret;
    }

    function Get_films_by_genre($name)
    {
        global $conn;
        $sql = "SELECT film.titre, film.resume from film
        JOIN genre on film.idGenre = genre.id
        where genre.nomGenre LIKE '%$name%'";
        $result = mysqli_query($conn, $sql);
        $tab = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $ret = json_encode($tab,JSON_PRETTY_PRINT); //Tableau converti en json
        header('Content-Type: application/json');
        echo $ret;
    }
    function Get_films_by_year($annee1, $annee2)
    {
        global $conn;
        $sql = "SELECT * FROM `film`
        where annee BETWEEN $annee1 and $annee2";
        $result = mysqli_query($conn, $sql);
        $tab = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $ret = json_encode($tab,JSON_PRETTY_PRINT); //Tableau converti en json
        header('Content-Type: application/json');
        echo $ret;
    }
    function Get_role_for_film($name)
{
    global $conn;
    $sql = "SELECT role.nomRole, artiste.nom, artiste.prenom FROM role
    JOIN artiste ON artiste.idActeur = role.idActeur
    JOIN film ON film.idfilm = role.idfilm
    WHERE film.titre LIKE '%$name%'";
    $result = mysqli_query($conn, $sql);
    $tab = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $ret = json_encode($tab,JSON_PRETTY_PRINT); //Tableau converti en json
    header('Content-Type: application/json');
    echo $ret;
}

    function Post()
    {
        global $conn;
        $titre = htmlentities($_POST['titre']);
        $annee = htmlentities($_POST['annee']);
        $genre = htmlentities($_POST['idGenre']);
        $resume = htmlentities($_POST['resume']);
        $sql = "INSERT INTO `Film`(`titre`, `annee`, `idGenre`, `resume`) VALUES ('$titre', $annee, $genre, '$resume')";
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

    function Delete()
    {
        global $conn;
        $_DELETE = array();
        parse_str(file_get_contents('php://input'), $_DELETE);
        $id=$_DELETE['idfilm'];
        $sql = "DELETE FROM `film` WHERE `idfilm` = $id";
        $result = mysqli_query($conn, $sql);
        if($result){
            echo "delete";
        }
        else{
            echo "loupé";
        } 
    }
    
    function Update()
    {
        global $conn;
        $_PUT = array();
        parse_str(file_get_contents('php://input'), $_PUT);
        $id=$_PUT['idfilm'];
        $titre = htmlentities($_PUT['titre']);
        $annee = htmlentities($_PUT['annee']);
        $genre = htmlentities($_PUT['idGenre']);
        $resume = htmlentities($_PUT['resume']);
        $sql = "UPDATE `film`
        SET `titre` = '$titre',
        `annee` = $annee,
        `idGenre` = $genre,
        `resume` = '$resume'
        WHERE `idfilm` = $id";
        $result = mysqli_query($conn, $sql);
        if($result){
            echo "update";
        }
        else{
            echo "loupé";
        }
    }
    
    
}
?>