<?php
require 'db.php';

// Ajouter un compte
if (isset($_POST['ajouter_compte'])) {
    $idMembre = $_POST['idMembre'];
    $dateCreation = $_POST['dateCreation'];

    $query = $pdo->prepare("INSERT INTO comptes (idMembre, dateCreation) VALUES (:idMembre, :dateCreation)");
    $query->execute([
        'idMembre' => $idMembre,
        'dateCreation' => $dateCreation
    ]);

    echo "Compte ajouté avec succès !";
}

// Afficher tous les comptes
$query = $pdo->query("SELECT c.idCompte, m.prenom, m.nom, c.dateCreation 
                      FROM comptes c
                      JOIN membres m ON c.idMembre = m.idMembre");
$comptes = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Liste des comptes</h2>
<table>
    <tr>
        <th>ID Compte</th>
        <th>Membre</th>
        <th>Date de création</th>
    </tr>
    <?php foreach ($comptes as $compte): ?>
        <tr>
            <td><?= $compte['idCompte'] ?></td>
            <td><?= $compte['prenom'] . ' ' . $compte['nom'] ?></td>
            <td><?= $compte['dateCreation'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h3>Ajouter un compte</h3>
<form method="POST">
    <input type="number" name="idMembre" placeholder="ID du membre" required>
    <input type="date" name="dateCreation" required>
    <button type="submit" name="ajouter_compte">Ajouter</button>
</form>
