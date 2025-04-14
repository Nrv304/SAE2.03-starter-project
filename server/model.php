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
                Category.name AS category,
                (Movie.created_at) >= DATE_SUB(NOW(), INTERVAL 7 DAY) AS is_new
            FROM Movie
            JOIN Category ON Movie.id_category = Category.id
            WHERE Movie.id = :id";

    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_OBJ);
}

function getMoviesCategory($age) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $sql = "SELECT 
                Category.id AS category_id, 
                Category.name AS category_name, 
                Movie.id AS movie_id, 
                Movie.name AS movie_name, 
                Movie.image AS movie_image,
                (Movie.created_at) >= DATE_SUB(NOW(), INTERVAL 7 DAY) AS is_new
            FROM Movie
            JOIN Category ON Movie.id_category = Category.id
            WHERE :age = 0 OR Movie.min_age <= :age
            ORDER BY Category.name, Movie.name";

    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':age', $age, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

    
    if (empty($rows)) {
        return [];
    }
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
            "image" => $row->movie_image,
            "is_new" => (bool)$row->is_new
        ];
    }

    return array_values($categories);
}

function addProfile($id, $name, $avatar, $min_age) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO Profil (id, name, avatar, min_age)
                VALUES (:id, :name, :avatar, :min_age)
                ON DUPLICATE KEY UPDATE name = VALUES(name), avatar = VALUES(avatar), min_age = VALUES(min_age)";
    $stmt = $cnx->prepare($sql);

    if ($id === null || $id === '') {
        $stmt->bindValue(':id', null, PDO::PARAM_NULL);
    } else {
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    }

    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':avatar', $avatar, PDO::PARAM_STR);
    $stmt->bindParam(':min_age', $min_age, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->rowCount();
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
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "DELETE FROM Favorites WHERE id_profil = :id_profil AND id_movie = :id_movie";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id_profil', $id_profil, PDO::PARAM_INT);
    $stmt->bindParam(':id_movie', $id_movie, PDO::PARAM_INT);
    return $stmt->execute();
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

function getFeaturedMovies() {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT id, name, image, description FROM Movie WHERE is_featured = TRUE";
    $stmt = $cnx->query($sql);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function searchMovies($keyword, $category = null, $year = null) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT 
                Movie.id, 
                Movie.name, 
                Movie.image, 
                Movie.is_featured, 
                Category.name AS category 
            FROM Movie
            LEFT JOIN Category ON Movie.id_category = Category.id
            WHERE Movie.name LIKE :keyword";
    
    if ($category) {
        $sql .= " AND Movie.id_category = :category";
    }
    if ($year) {
        $sql .= " AND Movie.year = :year";
    }

    $stmt = $cnx->prepare($sql);
    $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);

    if ($category) {
        $stmt->bindValue(':category', $category, PDO::PARAM_INT);
    }
    if ($year) {
        $stmt->bindValue(':year', $year, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function setFeaturedStatus($id_movie, $is_featured) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "UPDATE Movie SET is_featured = :is_featured WHERE id = :id_movie";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':is_featured', $is_featured, PDO::PARAM_BOOL);
    $stmt->bindParam(':id_movie', $id_movie, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->rowCount() > 0;
}

function addRating($id_profil, $id_movie, $rating) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "INSERT INTO Ratings (id_profil, id_movie, rating) 
            VALUES (:id_profil, :id_movie, :rating)";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id_profil', $id_profil, PDO::PARAM_INT);
    $stmt->bindParam(':id_movie', $id_movie, PDO::PARAM_INT);
    $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
    return $stmt->execute();
}

function getAverageRating($id_movie) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT AVG(rating) AS average_rating FROM Ratings WHERE id_movie = :id_movie";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id_movie', $id_movie, PDO::PARAM_INT);
    $stmt->execute();
    $average = $stmt->fetch(PDO::FETCH_OBJ)->average_rating;
    return $average !== null ? round($average, 1) : 0;
}

function hasRated($id_profil, $id_movie) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT COUNT(*) FROM Ratings WHERE id_profil = :id_profil AND id_movie = :id_movie";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id_profil', $id_profil, PDO::PARAM_INT);
    $stmt->bindParam(':id_movie', $id_movie, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

function addComment($id_movie, $id_profile, $comment_text) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "INSERT INTO Comments (id_movie, id_profile, comment_text) VALUES (:id_movie, :id_profile, :comment_text)";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id_movie', $id_movie, PDO::PARAM_INT);
    $stmt->bindParam(':id_profile', $id_profile, PDO::PARAM_INT);
    $stmt->bindParam(':comment_text', $comment_text, PDO::PARAM_STR);
    return $stmt->execute();
}

function getComments($id_movie) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT Comments.comment_text, Comments.created_at, Profil.name AS profile_name 
            FROM Comments 
            JOIN Profil ON Comments.id_profile = Profil.id 
            WHERE Comments.id_movie = :id_movie 
            ORDER BY Comments.created_at DESC";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id_movie', $id_movie, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getPendingComments() {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT Comments.id, Comments.comment_text, Comments.created_at, Profil.name AS profile_name, Comments.status 
            FROM Comments 
            JOIN Profil ON Comments.id_profile = Profil.id 
            WHERE Comments.status = 'pending' 
            ORDER BY Comments.created_at DESC";
    $stmt = $cnx->query($sql);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function approveComment($commentId) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "UPDATE Comments SET status = 'approved' WHERE id = :id";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id', $commentId, PDO::PARAM_INT);
    return $stmt->execute();
}

function deleteComment($commentId) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "DELETE FROM Comments WHERE id = :id";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id', $commentId, PDO::PARAM_INT);
    return $stmt->execute();
}