<?php
require 'Film.php';
require 'Genre.php';
require 'Role.php';
require 'Artist.php';
require 'fonction.php';
include 'User.php';
$Film = new Film;
$Artist = new Artist;
$Genre = new Genre;
$Role = new Role;
$User = new User;
$curl = acurl_init("localhost/api");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$return = curl_exec($curl);
$arg1 = 0; //Date1
$arg2 = 0; //Date2
$tab = explode('/',$_SERVER['PATH_INFO']);
$type = $tab[1];
if(!empty($tab[2])) $arg1=$tab[2];
if(!empty($tab[3])) $arg2=$tab[3];
$verb = $_SERVER['REQUEST_METHOD'];
$user = 'root';
$password = '';
$db = 'cinema_db';
$host = 'localhost:3307';
$conn = mysqli_connect($host, $user, $password, $db);

if(!$conn){
 die('Erreur : ' .mysqli_connect_error());
} 
mysqli_set_charset($conn, "utf8");

$apiKey = $_SERVER['HTTP_X_API_KEY'];
if($User->Authorization($apiKey))
{
    switch($verb){
        case 'GET':
            if($type == "film")
            {
                if($arg1 == "")
                {
                    $Film->Get_all_films();
                }
                else if(intval($arg1) < intval($arg2))
                {
                    $Film->Get_films_by_year($arg1, $arg2);
                }
                else
                {
                    $Film->Get_film($arg1);
                    $Film->Get_role_for_film($arg1);
                }
            }
            if($type == "genre")
            {
                if($arg1 != "")
                {
                    $Film->Get_films_by_genre($arg1);
                }
            } 
            if($type == "artist")
            {
                if($arg1 != "")
                {
                   $Artist->Get($arg1);
                }
            }
        break;
        case 'POST':
            if($type == "film")
                $Film->Post();
            else if($type == "artist")
                $Artist->Post();
            else if ($type == "utilisateur")
                $User->Create_new_user();
        break;
        case 'PUT': 
            if($type == "artist")
            {
                $Artist->Update();
            }
            else if($type == "film")
            {
                $Film->Update();
            }
            
        break;
        case'DELETE':
            if($type == "artist")
            {
                $Artiste->Delete();
            }
            else if($type == "film")
            {
                $Film->Delete();
            }
        break;
        default:  
            echo "ntm";
    }
}
else
{
    echo "Clé non existante";
}

$curl_close($curl);
?>