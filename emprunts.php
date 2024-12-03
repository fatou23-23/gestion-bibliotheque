<?php
require 'db.php';

// Ajouter un emprunt
if (isset($_POST['ajouter_emprunt'])) {
    $idMembre = $_POST['idMembre'];
    $idArticle = $_POST['idArticle'];
    $dateEmprunt = $_POST['dateEmprunt'];

    // Vérifier si l'article est disponible
    $check = $pdo->prepare("SELECT statut FROM articles WHERE id = :idArticle");
    $check->execute(['idArticle' => $idArticle]);
    $article = $check->fetch(PDO::FETCH_ASSOC);

    if ($article && $article['statut'] === 'disponible') {
        // Ajouter l'emprunt
        $query = $pdo->prepare("INSERT INTO emprunts (idMembre, idArticle, dateEmprunt, dateRetour) 
                                VALUES (:idMembre, :idArticle, :dateEmprunt, NULL)");
        $query->execute([
            'idMembre' => $idMembre,
            'idArticle' => $idArticle,
            'dateEmprunt' => $dateEmprunt
        ]);

        // Mettre à jour le statut de l'article
        $update = $pdo->prepare("UPDATE articles SET statut = 'emprunté' WHERE id = :idArticle");
        $update->execute(['idArticle' => $idArticle]);

        echo "Emprunt ajouté avec succès !";
    } else {
        echo "Erreur : Cet article n'est pas disponible pour l'emprunt.";
    }
}

// Retourner un article
if (isset($_POST['retour_article'])) {
    $idEmprunt = $_POST['idEmprunt'];

    // Récupérer les informations de l'emprunt
    $query = $pdo->prepare("SELECT idArticle FROM emprunts WHERE idEmprunt = :idEmprunt");
    $query->execute(['idEmprunt' => $idEmprunt]);
    $emprunt = $query->fetch(PDO::FETCH_ASSOC);

    if ($emprunt) {
        // Mettre à jour la date de retour
        $update = $pdo->prepare("UPDATE emprunts SET dateRetour = CURDATE() WHERE idEmprunt = :idEmprunt");
        $update->execute(['idEmprunt' => $idEmprunt]);

        // Mettre à jour le statut de l'article
        $updateArticle = $pdo->prepare("UPDATE articles SET statut = 'disponible' WHERE id = :idArticle");
        $updateArticle->execute(['idArticle' => $emprunt['idArticle']]);

        echo "Article retourné avec succès !";
    } else {
        echo "Erreur : Emprunt non trouvé.";
    }
}

// Afficher tous les emprunts
$query = $pdo->query("SELECT e.idEmprunt, m.prenom, m.nom, a.titre, e.dateEmprunt, e.dateRetour 
                      FROM emprunts e
                      JOIN membres m ON e.idMembre = m.idMembre
                      JOIN articles a ON e.idArticle = a.id");
$emprunts = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Liste des emprunts</h2>
<table>
    <tr>
        <th>ID Emprunt</th>
        <th>Membre</th>
        <th>Article</th>
        <th>Date d'emprunt</th>
        <th>Date de retour</th>
    </tr>
    <?php foreach ($emprunts as $emprunt): ?>
        <tr>
            <td><?= $emprunt['idEmprunt'] ?></td>
            <td><?= $emprunt['prenom'] . ' ' . $emprunt['nom'] ?></td>
            <td><?= $emprunt['titre'] ?></td>
            <td><?= $emprunt['dateEmprunt'] ?></td>
            <td><?= $emprunt['dateRetour'] ?? 'Non retourné' ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h3>Ajouter un emprunt</h3>
<form method="POST">
    <input type="number" name="idMembre" placeholder="ID du membre" required>
    <input type="number" name="idArticle" placeholder="ID de l'article" required>
    <input type="date" name="dateEmprunt" required>
    <button type="submit" name="ajouter_emprunt">Ajouter</button>
</form>

<h3>Retourner un article</h3>
<form method="POST">
    <input type="number" name="idEmprunt" placeholder="ID de l'emprunt" required>
    <button type="submit" name="retour_article">Retourner</button>
</form>
