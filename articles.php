<?php
require 'db.php';

// Ajouter un article
if (isset($_POST['ajouter_article'])) {
    $titre = $_POST['titre'];
    $statut = $_POST['statut'];

    $query = $pdo->prepare("INSERT INTO articles (titre, statut) VALUES (:titre, :statut)");
    $query->execute(['titre' => $titre, 'statut' => $statut]);
    echo "Article ajouté avec succès !";
}

// Supprimer un article
if (isset($_POST['supprimer_article'])) {
    $id = $_POST['id'];

    $query = $pdo->prepare("DELETE FROM articles WHERE id = :id");
    $query->execute(['id' => $id]);
    echo "Article supprimé avec succès !";
}

// Afficher tous les articles
$query = $pdo->query("SELECT * FROM articles");
$articles = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Liste des articles</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Titre</th>
        <th>Statut</th>
    </tr>
    <?php foreach ($articles as $article): ?>
        <tr>
            <td><?= $article['id'] ?></td>
            <td><?= $article['titre'] ?></td>
            <td><?= $article['statut'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h3>Ajouter un article</h3>
<form method="POST">
    <input type="text" name="titre" placeholder="Titre" required>
    <select name="statut">
        <option value="disponible">Disponible</option>
        <option value="emprunté">Emprunté</option>
    </select>
    <button type="submit" name="ajouter_article">Ajouter</button>
</form>

<h3>Supprimer un article</h3>
<form method="POST">
    <input type="number" name="id" placeholder="ID de l'article" required>
    <button type="submit" name="supprimer_article">Supprimer</button>
</form>
