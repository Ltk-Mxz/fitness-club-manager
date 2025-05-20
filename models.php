<?php
require_once 'db.php';

class Abonne
{
    public $id;
    public $nom;
    public $prenom;
    public $email;
    public $telephone;
    public $date_naissance;
    public $adresse;
    public $code_postal;
    public $ville;
    public $pays;
    public $date_inscription;
    public $date_expiration;
    public $photo;
    public $type_abonnement;
}

class Coach
{
    public $id;
    public $nom;
    public $prenom;
    public $email;
    public $telephone;
    public $specialite;
    public $date_embauche;
    public $photo;
}

class Discipline
{
    public $id;
    public $nom;
    public $description;
}

class Equipement
{
    public $id;
    public $nom;
    public $photo;
    public $etat;
}

class Paiement
{
    public $id;
    public $abonne_id;
    public $date_paiement;
    public $montant;
    public $type_abonnement;
    public $mois;
    public $annee;
    public $statut; // payé ou impayé
}

function getAbonnes()
{
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM abonnes");
    return $stmt->fetchAll();
}

function getCoachs()
{
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM coachs");
    return $stmt->fetchAll();
}

function getDisciplines()
{
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM disciplines");
    return $stmt->fetchAll();
}

function getEquipements()
{
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM equipements");
    return $stmt->fetchAll();
}

function getPaiements($mois = null, $annee = null, $statut = null)
{
    global $pdo;
    $sql = "SELECT p.*, a.nom AS abonne_nom, a.prenom AS abonne_prenom 
            FROM paiements p 
            LEFT JOIN abonnes a ON p.abonne_id = a.id";
    $params = [];
    $where = [];
    if ($mois !== null && $annee !== null) {
        $mois = (int)$mois;
        $annee = (int)$annee;
        $where[] = "p.mois = ?";
        $where[] = "p.annee = ?";
        $params[] = $mois;
        $params[] = $annee;
    }
    if ($statut !== null) {
        $where[] = "p.statut = ?";
        $params[] = $statut;
    }
    if ($where) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }
    // LOG: Affiche la requête SQL et les paramètres
    error_log("DEBUG getPaiements SQL: $sql");
    error_log("DEBUG getPaiements params: " . print_r($params, true));
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $result = $stmt->fetchAll();
    // Correction : forcer le typage mois/annee en int pour chaque paiement
    foreach ($result as &$row) {
        if (isset($row['mois'])) $row['mois'] = (int)$row['mois'];
        if (isset($row['annee'])) $row['annee'] = (int)$row['annee'];
    }
    // LOG: Affiche le résultat
    error_log("DEBUG getPaiements result: " . print_r($result, true));
    return $result;
}

function getImpayes($mois, $annee)
{
    global $pdo;
    $mois = (int)$mois; // <-- Conversion explicite
    $annee = (int)$annee;
    $stmt = $pdo->prepare("SELECT p.*, a.nom AS abonne_nom, a.prenom AS abonne_prenom 
        FROM paiements p 
        LEFT JOIN abonnes a ON p.abonne_id = a.id
        WHERE p.mois = ? AND p.annee = ? AND p.statut = 'impaye'");
    $stmt->execute([$mois, $annee]);
    return $stmt->fetchAll();
}

function getAbonnementTypes()
{
    return ['mensuel', 'annuel'];
}

function getAbonnesDropdown()
{
    global $pdo;
    $stmt = $pdo->query("SELECT id, nom, prenom FROM abonnes");
    return $stmt->fetchAll();
}

function getCoachAffectation($mois, $annee)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM coach_affectations WHERE mois = ? ET annee = ?");
    $stmt->execute([$mois, $annee]);
    return $stmt->fetchAll();
}
