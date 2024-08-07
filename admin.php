<?php
require 'includes/db.php'; // Assicurati di usare require per fermare l'esecuzione se c'è un problema

if (!isset($pdo)) {
    die('Database connection failed.');
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Libri</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<h1>Gestione Libri</h1>
<a href="index.php">Torna alla lista di libri</a>

<h2>Aggiungi un nuovo libro</h2>
<form action="admin.php" method="post" enctype="multipart/form-data">
    <label for="title">Titolo:</label>
    <input type="text" id="title" name="title" required>
    <br>
    <label for="author">Autore:</label>
    <input type="text" id="author" name="author" required>
    <br>
    <label for="cover">Copertina:</label>
    <input type="file" id="cover" name="cover">
    <br>
    <button type="submit" name="add">Aggiungi</button>
</form>

<?php
if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $cover = '';

    if (!empty($_FILES['cover']['name'])) {
        $cover = basename($_FILES['cover']['name']);
        $target = 'images/' . $cover;
        move_uploaded_file($_FILES['cover']['tmp_name'], $target);
    }

    try {
        $stmt = $pdo->prepare('INSERT INTO books (title, author, cover) VALUES (?, ?, ?)');
        $stmt->execute([$title, $author, $cover]);
        header('Location: admin.php');
    } catch (PDOException $e) {
        echo 'Error adding book: ' . $e->getMessage();
    }
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    try {
        $stmt = $pdo->prepare('DELETE FROM books WHERE id = ?');
        $stmt->execute([$id]);
        header('Location: admin.php');
    } catch (PDOException $e) {
        echo 'Error deleting book: ' . $e->getMessage();
    }
}
?>

<h2>Libri esistenti</h2>
<ul>
    <?php
    try {
        $stmt = $pdo->query('SELECT * FROM books');
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<li>';
            echo '<h2>' . htmlspecialchars($row['title']) . '</h2>';
            echo '<p>' . htmlspecialchars($row['author']) . '</p>';
            if (!empty($row['cover'])) {
                echo '<img src="images/' . htmlspecialchars($row['cover']) . '" alt="' . htmlspecialchars($row['title']) . '">';
            }
            echo '<form action="admin.php" method="post" style="display:inline;">';
            echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
            echo '<button type="submit" name="delete">Elimina</button>';
            echo '</form>';
            echo '</li>';
        }
    } catch (PDOException $e) {
        echo 'Error fetching books: ' . $e->getMessage();
    }
    ?>
</ul>
</body>
</html>
