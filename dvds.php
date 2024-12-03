<?php
require 'db.php';

// Ajouter un DVD
if (isset($_POST['ajouter_dvd'])) {
    $id = $_POST['id'];
    $duree = $_POST['duree'];

    $query = $pdo->prepare("INSERT INTO dvds (id, duree) VALUES (:id, :duree)");
    $query->execute([
        'id' => $id,
        'duree' => $duree
    ]);

    echo "DVD ajouté avec succès !";
}

// Afficher tous les DVDs
$query = $pdo->query("SELECT d.id, a.titre, d.duree 
                      FROM dvds d
                      JOIN articles a ON d.id = a.id");
$dvds = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Liste des DVDs</h2>
<table>
    <tr>
        <th>ID DVD</th>
        <th>Titre</th>
        <th>Durée (min)</th>
    </tr>
    <?php foreach ($dvds as $dvd): ?>
        <tr>
            <td><?= $dvd['id'] ?></td>
            <td><?= $dvd['titre'] ?></td>
            <td><?= $dvd['duree'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h3>Ajouter un DVD</h3>
<form method="POST">
    <input type="number" name="id" placeholder="ID de l'article" required>
    <input type="number" name="duree" placeholder="Durée (minutes)" required>
    <button type="submit" name="ajouter_dvd">Ajouter</button>
</form>
