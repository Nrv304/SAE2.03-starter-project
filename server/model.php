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
    try {
        $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        $sql = "SELECT id, name, image FROM Movie";
        $answer = $cnx->query($sql);
        return $answer->fetchAll(PDO::FETCH_OBJ);
    } catch (Exception $e) {
        error_log("Erreur SQL : " . $e->getMessage()); // Log dans les erreurs PHP
        return false;
    }
}

function addMovies($l, $d, $y, $n, $r, $i, $t, $m, $id){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD); 
    // Requête SQL de mise à jour du menu avec des paramètres
    $sql = "INSERT INTO Movie (name, director, length, description, year, image, trailer, min_age, id_category) 
            VALUES (:name, :director, :length, :description, :year, :image, :trailer, :min_age, :id_category)";
    // Prépare la requête SQL
    $stmt = $cnx->prepare($sql);
    // Lie les paramètres aux valeurs
    $stmt->bindParam(':length', $l);
    $stmt->bindParam(':description', $d);
    $stmt->bindParam(':year', $y);
    $stmt->bindParam(':name', $n);
    $stmt->bindParam(':director', $r);
    $stmt->bindParam(':image', $i);
    $stmt->bindParam(':trailer', $t);
    $stmt->bindParam(':min_age', $m);
    $stmt->bindParam(':id_category', $id);
    // Exécute la requête SQL
    $stmt->execute();
    $res = $stmt->rowCount(); 
    return $res;
}

function getMovieDetail($id) {
    try {
        $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Requête SQL pour récupérer les détails du film
        $sql = "SELECT id, name, director, year, length, description, image, trailer, min_age, id_category 
                FROM Movie 
                WHERE id = :id";

        $stmt = $cnx->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ); // Retourne les détails du film sous forme d'objet
    } catch (Exception $e) {
        error_log("Erreur SQL : " . $e->getMessage()); // Log dans les erreurs PHP
        return false;
    }
}