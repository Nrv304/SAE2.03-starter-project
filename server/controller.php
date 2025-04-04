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
  $debug = []; // Tableau pour stocker les messages de débogage
  $data = json_decode(file_get_contents("php://input"), true);
  $debug[] = "Données reçues : " . print_r($data, true);

  if (!$data) {
      $debug[] = "Erreur : Les données JSON sont nulles ou invalides.";
      return json_encode(["success" => false, "debug" => $debug]);
  }

  $name = $data['name'];
  $year = $data['year'];
  $length = $data['length'];
  $description = $data['description'];
  $director = $data['director'];
  $image = $data['image'];
  $id_category = $data['id_category'];
  $trailer = $data['trailer'];
  $min_age = $data['min_age'];

  $debug[] = "Paramètres extraits : name=$name, year=$year, length=$length, description=$description, director=$director, image=$image, id_category=$id_category, trailer=$trailer, min_age=$min_age";

  $ok = addMovies($length, $description, $year, $name, $director, $image, $trailer, $min_age, $id_category);
  
  if ($ok != 0) {
      $debug[] = "Film ajouté avec succès : $name";
      return json_encode(["success" => true, "message" => "$name a été ajouté avec succès !", "debug" => $debug]);
  } else {
      $debug[] = "Erreur lors de l'ajout du film : $name";
      return json_encode(["success" => false, "message" => "Erreur lors de l'ajout de $name !", "debug" => $debug]);
  }
}