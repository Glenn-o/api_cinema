<?php
require 'fonction.php';
require 'Artist.php';
$arg1 = 0;
$arg2 = 0;
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
if(authorization($apiKey))
{
    switch($verb){
        case 'GET':
            if($type == "film")
            {
                if($arg1 == "")
                {
                    get_all_films();
                }
                else if(intval($arg1) < intval($arg2))
                {
                    get_films_by_year($arg1, $arg2);
                }
                else
                {
                    get_films($arg1);
                    get_role_for_film($arg1);
                }
            }
            if($type == "genre")
            {
                if($arg1 != "")
                {
                    get_films_by_genre($arg1);
                }
            } 
            if($type == "artist")
            {
                if($arg1 != "")
                {
                    get_artist_by_name($arg1);
                }
            }
        break;
        case 'POST':
            if($type == "film")
                post_a_film();
            else if($type == "artist")
                post_an_artist();
            else if ($type == "utilisateur")
                create_new_user();
        break;
        case 'PUT': 
            if($type == "artist")
            {
                update_artist();
            }
            else if($type == "film")
            {
                update_film();
            }
            
        break;
        case'DELETE':
            if($type == "artist")
            {
                delete_artist();
            }
            else if($type == "film")
            {
                delete_film();
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
?>