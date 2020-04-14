<?php
Class User
{
    public $idUser;
    public $login;
    public $apiKey;

    function __construct($login, $apiKey)
    {
        $this->login = $login;
        $this->apiKey = $apiKey;
    }

    function Get_api_key($num)
    {
        $hash_key = hash('md5', "$num");
        return $hash_key;
    }

    function Create_new_user()
    {
        global $conn;
        $login = htmlentities($_POST['login']);
        $sql = "SELECT COUNT(*) as count FROM utilisateur";
        $result = mysqli_query($conn, $sql);
        $tab = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $result = $tab[0];
        $apiKey = Get_api_key($result["count"]);
        $sql = "INSERT INTO utilisateur(`login`,`apiKey`) VALUES ('$login', '$apiKey')";
        $result = mysqli_query($conn, $sql);
        if($result){
            echo "create";
        }
        else{
            echo "loupé";
        }
    }
    function Authorization($api_key)
    {
        global $conn;
        $sql = "SELECT * from utilisateur where apiKey = '$api_key'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_num_rows($result);
        if($row > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function Get_user($api_key)
    {
        global $conn;
        $sql = "SELECT login from utilisateur where apiKey = '$api_key'";
        $result = mysqli_query($conn, $sql);
        $tab = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $result = $tab[0];
        return $result['login'];
    }

}
?>