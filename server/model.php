<?php

/**
 * Définition des constantes de connexion à la base de données.
 *
 * HOST : Nom d'hôte du serveur de base de données, ici "localhost".
 * DBNAME : Nom de la base de données
 * DBLOGIN : Nom d'utilisateur pour se connecter à la base de données.
 * DBPWD : Mot de passe pour se connecter à la base de données.
 */
define("HOST", "localhost");
define("DBNAME", "mora");
define("DBLOGIN", "root");
define("DBPWD", "root");

/**
 * Récupère le menu pour un jour spécifique dans la base de données.
 *
 * @param string $w La semaine pour laquelle le menu est récupéré.
 * @param string $j Le jour pour lequel le menu est récupéré.
 * @return array Un tableau d'objets contenant l'entrée, le plat principal et le dessert pour le jour spécifié.
 */
function getMenu($w, $j){
    // Connexion à la base de données
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    // Requête SQL pour récupérer le menu avec des paramètres
    $sql = "select entree, plat, dessert from Repas where jour=:jour and semaine=:semaine";
    // Prépare la requête SQL
    $stmt = $cnx->prepare($sql);
    // Lie le paramètre à la valeur
    $stmt->bindParam(':jour', $j);
    $stmt->bindParam(':semaine', $w);
    // Exécute la requête SQL
    $stmt->execute();
    // Récupère les résultats de la requête sous forme d'objets
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res; // Retourne les résultats
}


/**
 * Met à jour le menu pour un jour spécifique dans la base de données.
 *
 * @param string $w La semaine pour laquelle le menu est mis à jour.
 * @param string $j Le jour pour lequel le menu est mis à jour.
 * @param string $e La nouvelle entrée pour le menu.
 * @param string $p Le nouveau plat principal pour le menu.
 * @param string $d Le nouveau dessert pour le menu.
 * @return int Le nombre de lignes affectées par la requête de mise à jour.
 * 
 * A SAVOIR: une requête SQL de type update retourne le nombre de lignes affectées par la requête.
 * Si la requête a réussi, le nombre de lignes affectées sera 1.
 * Si la requête a échoué, le nombre de lignes affectées sera 0.
 */
function updateMenu($w, $j, $e, $p, $d){
    // Connexion à la base de données
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD); 
    // Requête SQL de mise à jour du menu avec des paramètres
    $sql = "REPLACE INTO Repas (semaine, jour, entree, plat, dessert) 
            VALUES (:semaine, :jour, :entree, :plat, :dessert)";
    // Prépare la requête SQL
    $stmt = $cnx->prepare($sql);
    // Lie les paramètres aux valeurs
    $stmt->bindParam(':entree', $e);
    $stmt->bindParam(':plat', $p);
    $stmt->bindParam(':dessert', $d);
    $stmt->bindParam(':jour', $j);
    $stmt->bindParam(':semaine', $w);
    // Exécute la requête SQL
    $stmt->execute();
    // Récupère le nombre de lignes affectées par la requête
    $res = $stmt->rowCount(); 
    return $res; // Retourne le nombre de lignes affectées
}



/**
 * Supprime le menu pour un jour spécifique dans la base de données.
 *
 * @param int $s La semaine  (numéro) pour laquelle le menu est supprimé.
 * @param string $j Le jour pour lequel le menu est supprimé.
 * @return int Le nombre de lignes affectées par la requête de suppression.
 * 
 * A SAVOIR: une requête SQL de type delete retourne le nombre de lignes affectées par la requête.
 * Si la requête a réussi, le nombre de lignes affectées sera 1.
 * Si la requête a échoué, le nombre de lignes affectées sera 0.
 */
function deleteMenu($s, $j){
    // Connexion à la base de données
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD); 
    // Requête SQL de suppression du menu avec des paramètres
    $sql = "DELETE FROM Repas WHERE semaine=:semaine AND jour=:jour";
    // Prépare la requête SQL
    $stmt = $cnx->prepare($sql);
    // Lie les paramètres aux valeurs
    $stmt->bindParam(':jour', $j);
    $stmt->bindParam(':semaine', $s);
    // Exécute la requête SQL
    $stmt->execute();
    // Récupère le nombre de lignes affectées par la requête
    $res = $stmt->rowCount(); 
    return $res; // Retourne le nombre de lignes affectées
}