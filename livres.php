<?php
require 'db.php';

// Ajouter un livre
if (isset($_POST['ajouter_livre'])) {
    $id = $_POST['id'];
    $auteur = $_POST['auteur'];
    $isbn = $_POST['isbn'];

    $query = $pdo->prepare("INSERT INTO livres (id, auteur, isbn) VALUES (:id, :auteur, :isbn)");
    $query->execute([
        'id' => $id,
        'auteur' => $auteur,
        'isbn' => $isbn
    ]);

    echo "Livre ajouté avec succès !";
}

// Afficher tous les livres
$query = $pdo->query("SELECT l.id, a.titre, l.auteur, l.isbn 
                      FROM livres l
                      JOIN articles a ON l.id = a.id");
$livres = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Liste des livres</h2>
<table>
    <tr>
        <th>ID Livre</th>
        <th>Titre</th>
        <th>Auteur</th>
        <th>ISBN</th>
    </tr>
    <?php foreach ($livres as $livre): ?>
        <tr>
            <td><?= $livre['id'] ?></td>
            <td><?= $livre['titre'] ?></td>
            <td><?= $livre['auteur'] ?></td>
            <td><?= $livre['isbn'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h3>Ajouter un livre</h3>
<form method="POST">
    <input type="number" name="id" placeholder="ID de l'article" required>
    <input type="text" name="auteur" placeholder="Auteur" required>
    <input type="number" name="isbn" placeholder="ISBN" required>
    <button type="submit" name="ajouter_livre">Ajouter</button>
</form>
