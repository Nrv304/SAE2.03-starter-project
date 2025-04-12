<?php

/** ARCHITECTURE PHP SERVEUR  : Rôle du fichier controller.php
 * 
 *  Dans ce fichier, on va définir les fonctions de contrôle qui vont traiter les requêtes HTTP.
 *  Les requêtes HTTP sont interprétées selon la valeur du paramètre 'todo' de la requête (voir script.php)
 *  Pour chaque valeur différente, on déclarera une fonction de contrôle différente.
 * 
 *  Les fonctions de contrôle vont éventuellement lire les paramètres additionnels de la requête, 
 *  les vérifier, puis appeler les fonctions du modèle (model.php) pour effectuer les opérations
 *  nécessaires sur la base de données.
 *  
 *  Si la fonction échoue à traiter la requête, elle retourne false (mauvais paramètres, erreur de connexion à la BDD, etc.)
 *  Sinon elle retourne le résultat de l'opération (des données ou un message) à includre dans la réponse HTTP.
 */

/** Inclusion du fichier model.php
 *  Pour pouvoir utiliser les fonctions qui y sont déclarées et qui permettent
 *  de faire des opérations sur les données stockées en base de données.
 */
require("model.php");

function readmoviesController(){
    $movies = getAllMovies();
    return $movies;
}

function addmoviesController(){
    $name = $_REQUEST['name'];
    $director = $_REQUEST['director'];
    $year = $_REQUEST['year'];
    $length = $_REQUEST['length'];
    $description = $_REQUEST['description'];
    $id_category = $_REQUEST['id_category'];
    $image = $_REQUEST['image'];
    $trailer = $_REQUEST['trailer'];
    $min_age = $_REQUEST['min_age'];

  $ok = addMovies($length, $description, $year, $name, $director, $image, $trailer, $min_age, $id_category);
  
  if ($ok != 0) {
      return "Film ajouté avec succès : $name";
  } else {
      return "Erreur lors de l'ajout du film : $name";
  }
}

function readMovieDetailController() {

    if (!isset($_REQUEST['id'])) {
        return false; 
    }

    $id = intval($_REQUEST['id']);
    $movie = getMovieDetail($id);

    if ($movie) {
        return $movie;
    } else {
        return false;
    }
}

function readMoviesCategoryController() {
    $age = isset($_REQUEST['age']) ? intval($_REQUEST['age']) : 0; // Par défaut, âge = 0
    $categories = getMoviesCategory($age);
    return $categories ? $categories : false;
}

function addProfileController(){
    if (!isset($_REQUEST['name']) || !isset($_REQUEST['min_age'])) {
        http_response_code(400); // Mauvaise requête
        echo json_encode(["error" => "Paramètres manquants pour ajouter un profil"]);
        return false;
    }

    $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
    $name = $_REQUEST['name'];
    $avatar = $_REQUEST['avatar'];
    $min_age = intval($_REQUEST['min_age']);

    $ok = addProfile($id, $name, $avatar, $min_age);

    if ($ok != 0) {
        echo json_encode(["success" => true, "message" => "$name a été ajouté avec succès"]);
    } else {
        http_response_code(500); // Erreur interne
        echo json_encode(["error" => "Le profil n'a pas pu être ajouté"]);
    }
}

function readProfilesController() {
    $profiles = getProfiles();
    return $profiles ? $profiles : false;
}

function addFavoritesController() {
    if (!isset($_REQUEST['id_profile']) || !isset($_REQUEST['id_movie'])) {
        http_response_code(400); // Bad Request
        return ["error" => "Paramètres manquants : id_profile ou id_movie"];
    }

    $id_profile = intval($_REQUEST['id_profile']);
    $id_movie = intval($_REQUEST['id_movie']);

    if (!$id_movie) {
        http_response_code(400); // Bad Request
        return ["error" => "ID de film invalide."];
    }

    if (isFavorites($id_profile, $id_movie)) {
        return ["message" => "Le film est déjà dans vos favoris."];
    }

    $ok = addFavorites($id_profile, $id_movie);
    return $ok ? ["message" => "Le film a été ajouté à vos favoris."] : ["error" => "Erreur lors de l'ajout aux favoris."];
}

function getFavoritesController() {
    $id_profile = $_REQUEST['id_profile'];
    error_log("ID Profil reçu : " . $id_profile);
    return getFavorites($id_profile);
}

function removeFavoritesController() {
    $id_profile = $_REQUEST['id_profile'];
    $id_movie = $_REQUEST['id_movie'];
    $ok = removeFavorites($id_profile, $id_movie);
    return $ok ? ["Le film a bien été retiré de vos favoris" => true] : ["error" => "Erreur lors de la suppression des favoris"];
}

function getFeaturedMoviesController() {
    $movies = getFeaturedMovies();
    return is_array($movies) ? $movies : [];
}

function searchMoviesController() {
    $keyword = isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
    $category = isset($_REQUEST['category']) ? intval($_REQUEST['category']) : null;
    $year = isset($_REQUEST['year']) ? intval($_REQUEST['year']) : null;

    if (empty($keyword)) {
        return [];
    }

    $movies = searchMovies($keyword, $category, $year);
    return $movies ? $movies : [];
}

function updateFeaturedStatusController() {
    $id_movie = $_REQUEST['movie_id'];
    $is_featured = $_REQUEST['is_featured'] === 'true' ? true : false;

    $ok = setFeaturedStatus($id_movie, $is_featured);

    if ($ok) {
        return ["success" => true, "message" => "Le statut du film a été mis à jour avec succès."];
    } else {
        return ["success" => false, "error" => "Erreur lors de la mise à jour du statut."];
    }
}

function addRatingController() {
    $id_profil = $_REQUEST['id_profil'];
    $id_movie = $_REQUEST['id_movie'];
    $rating = intval($_REQUEST['rating']);

    if (hasRated($id_profil, $id_movie)) {
        return ["error" => "Vous avez déjà noté ce film."];
    }

    $ok = addRating($id_profil, $id_movie, $rating);
    return $ok ? ["message" => "Votre note a été enregistrée."] : ["error" => "Erreur lors de l'enregistrement de la note."];
}

function getAverageRatingController() {
    $id_movie = $_REQUEST['id_movie'];
    return getAverageRating($id_movie);
}