<?php
/**
 * Ce fichier contient toutes les fonctions qui réalisent des opérations
 * sur la base de données, telles que les requêtes SQL pour insérer, 
 * mettre à jour, supprimer ou récupérer des données.
 */

/**
 * Définition des constantes de connexion à la base de données.
 *
 * HOST : Nom d'hôte du serveur de base de données, ici "localhost".
 * DBNAME : Nom de la base de données
 * DBLOGIN : Nom d'utilisateur pour se connecter à la base de données.
 * DBPWD : Mot de passe pour se connecter à la base de données.
 */
define("HOST", "localhost");
define("DBNAME", "trelat2");
define("DBLOGIN", "trelat2");
define("DBPWD", "trelat2");


function getAllMovies(){
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT id, name, image FROM Movie";
    $answer = $cnx->query($sql);
    return $answer->fetchAll(PDO::FETCH_OBJ);;
}

function addMovies($l, $d, $y, $n, $r, $i, $t, $m, $id){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD); 
    $sql = "INSERT INTO Movie (name, director, length, description, year, image, trailer, min_age, id_category) 
            VALUES (:name, :director, :length, :description, :year, :image, :trailer, :min_age, :id_category)";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':length', $l);
    $stmt->bindParam(':description', $d);
    $stmt->bindParam(':year', $y);
    $stmt->bindParam(':name', $n);
    $stmt->bindParam(':director', $r);
    $stmt->bindParam(':image', $i);
    $stmt->bindParam(':trailer', $t);
    $stmt->bindParam(':min_age', $m);
    $stmt->bindParam(':id_category', $id);
    $stmt->execute();
    $res = $stmt->rowCount(); 
    return $res;
}

function getMovieDetail($id) {
    try {
        $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $sql = "SELECT 
                    Movie.id, 
                    Movie.name, 
                    Movie.director, 
                    Movie.year, 
                    Movie.length, 
                    Movie.description, 
                    Movie.image, 
                    Movie.trailer, 
                    Movie.min_age, 
                    Movie.id_category, 
                    Category.name AS category
                FROM Movie
                JOIN Category ON Movie.id_category = Category.id
                WHERE Movie.id = :id";

        $stmt = $cnx->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    } catch (Exception $e) {
        error_log("Erreur SQL : " . $e->getMessage());
        return false;
    }
}

function getMoviesCategory($age) {
    try {
        $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $sql = "SELECT 
                    Category.id AS category_id, 
                    Category.name AS category_name, 
                    Movie.id AS movie_id, 
                    Movie.name AS movie_name, 
                    Movie.image AS movie_image
                FROM Movie
                JOIN Category ON Movie.id_category = Category.id
                WHERE :age = 0 OR Movie.min_age <= :age
                ORDER BY Category.name, Movie.name";

        $stmt = $cnx->prepare($sql); // Utilisez prepare() au lieu de query()
        $stmt->bindParam(':age', $age, PDO::PARAM_INT); // Assurez-vous que :age est correctement lié
        $stmt->execute(); // Exécutez la requête
        $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

        $categories = [];
        foreach ($rows as $row) {
            if (!isset($categories[$row->category_id])) {
                $categories[$row->category_id] = [
                    "name" => $row->category_name,
                    "movies" => []
                ];
            }
            $categories[$row->category_id]["movies"][] = [
                "id" => $row->movie_id,
                "name" => $row->movie_name,
                "image" => $row->movie_image
            ];
        }

        return array_values($categories);
    } catch (Exception $e) {
        error_log("Erreur SQL : " . $e->getMessage());
        return false;
    }
}

function addProfile($id, $name, $avatar, $min_age) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);

    $sql = "REPLACE INTO Profil (id, name, avatar, min_age) 
            VALUES (:id, :name, :avatar, :min_age)";

    $stmt = $cnx->prepare($sql);

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':avatar', $avatar, PDO::PARAM_STR);
    $stmt->bindParam(':min_age', $min_age, PDO::PARAM_INT);

    try {
        $stmt->execute();
        return $stmt->rowCount();
    } catch (Exception $e) {
        error_log("Erreur SQL : " . $e->getMessage());
        return false;
    }
}

function getProfiles() {
        $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
        $sql = "SELECT id, name, avatar, min_age FROM Profil";
        $stmt = $cnx->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function addFavorites($id_profil, $id_movie) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "INSERT INTO Favorites (id_profil, id_movie) VALUES (:id_profil, :id_movie)";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id_profil', $id_profil, PDO::PARAM_INT);
    $stmt->bindParam(':id_movie', $id_movie, PDO::PARAM_INT);
    return $stmt->execute();
}

function getFavorites($id_profil) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT Movie.id, Movie.name, Movie.image FROM Favorites 
            JOIN Movie ON Favorites.id_movie = Movie.id 
            WHERE Favorites.id_profil = :id_profil";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id_profil', $id_profil, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function removeFavorites($id_profil, $id_movie) {
    try {
        $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
        $sql = "DELETE FROM Favorites WHERE id_profil = :id_profil AND id_movie = :id_movie";
        $stmt = $cnx->prepare($sql);
        $stmt->bindParam(':id_profil', $id_profil, PDO::PARAM_INT);
        $stmt->bindParam(':id_movie', $id_movie, PDO::PARAM_INT);
        $result = $stmt->execute();
        error_log("Requête SQL exécutée : $sql avec id_profil = $id_profil et id_movie = $id_movie");
        return $result;
    } catch (Exception $e) {
        error_log("Erreur lors de la suppression des favoris : " . $e->getMessage());
        return false;
    }
}

function isFavorites ($id_profil, $id_movie) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT COUNT(*) FROM Favorites WHERE id_profil = :id_profil AND id_movie = :id_movie";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id_profil', $id_profil, PDO::PARAM_INT);
    $stmt->bindParam(':id_movie', $id_movie, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;

}