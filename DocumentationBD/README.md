Itération 5 : Création de la table profil
Pour permettre la gestion des profils utilisateurs, j’ai ajouté une table profil avec les colonnes suivantes :

id (INT, auto-incrémentée)

name (VARCHAR(255))

avatar (VARCHAR(255))

min_age (INT)

Les valeurs utilisées sont cohérentes avec celles des tables movie et category. Par souci d’uniformité, tous les noms de colonnes et de tables sont en anglais et en minuscules.

Itération 9 : Création de la table favorites
Afin de permettre aux utilisateurs d’ajouter des films en favoris, j’ai créé une table favorites avec les colonnes suivantes :

id (INT, auto-incrémentée)

id_profile (clé étrangère vers profil.id)

id_movie (clé étrangère vers movie.id)

Comme précédemment, les noms sont en anglais et en minuscules.

Itération 11 : Ajout de la colonne is_featured à la table movie
Pour mettre en avant certains films, j’ai ajouté la colonne is_featured de type TINYINT(1), simulant un booléen. La valeur par défaut est définie à 0 (non mis en avant).

Itération 14 : Création de la table ratings
Afin d’implémenter un système de notation, j’ai créé la table ratings avec les colonnes suivantes :

id (INT, auto-incrémentée)

id_profile (clé étrangère vers profil.id)

id_movie (clé étrangère vers movie.id)

rating (TINYINT(4)) pour stocker la note attribuée par l’utilisateur

Itération 15 : Création de la table comments
Pour permettre aux utilisateurs de laisser des commentaires sur les films, j’ai ajouté une table comments comprenant :

id (INT, auto-incrémentée)

id_profile (clé étrangère vers profil.id)

id_movie (clé étrangère vers movie.id)

comment_text (TEXT)

created_at (DATETIME) pour enregistrer la date et l’heure de publication

Itération 16 : Ajout de la colonne status à la table comments
Dans un souci de modération, j’ai ajouté une colonne status à la table comments avec les valeurs possibles suivantes : 'pending', 'approved' et 'deleted' (type ENUM). La valeur par défaut est 'pending', ce qui permet de masquer les commentaires jusqu’à validation.

Itération 17 : Ajout de la colonne created_at à la table movie
Pour permettre l’affichage d’un badge "new" sur les films récemment ajoutés, j’ai ajouté une colonne created_at (de type DATETIME) à la table movie. Celle-ci permet d’enregistrer la date et l’heure d’ajout de chaque film.