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
    $categories = getMoviesCategory();
    return $categories ? $categories : false;
}

function addProfileController(){
    
    $name = $_REQUEST['name'];
    $avatar = $_REQUEST['avatar'];
    $min_age = $_REQUEST['min_age'];

    $ok = addProfile($name, $avatar, $min_age);
   
    if ($ok!=0){
        return "$name a été ajouté avec succès";
      }
      else{
        return "Le profile n'a pas pu être ajouté";
      }
}

function readProfilesController() {
    $profiles = getProfiles();
    return $profiles ? $profiles : false;
}