
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
    <title>Lista di Libri</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<h1>Lista di Libri</h1>
<a href="admin.php">Accedi per gestire i libri</a>
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
            echo '</li>';
        }
    } catch (PDOException $e) {
        echo 'Error fetching books: ' . $e->getMessage();
    }
    ?>
</ul>
</body>
</html>
