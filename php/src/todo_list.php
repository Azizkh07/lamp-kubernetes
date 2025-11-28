<?php
// Lecture des variables d'environnement avec valeurs par défaut
$user = getenv('DB_USER') ?: 'hamid';
$host = getenv('DB_HOST') ?: 'mysql';
$password = getenv('DB_PASSWORD') ?: 'Hamid123**A';
$database = getenv('DB_DATABASE') ?: 'example_database';
$table = "todo_list";

try {
    $db = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>TODO List</h2>";
    echo "<p style='color: #666; font-size: 0.9em;'>Connected to: $database@$host</p>";
    echo "<ol>";
    
    foreach($db->query("SELECT content FROM $table") as $row) {
        echo "<li>" . htmlspecialchars($row['content']) . "</li>";
    }
    
    echo "</ol>";
} catch (PDOException $e) {
    echo "<h2>Database Connection Error</h2>";
    echo "<p style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p>Connection details:</p>";
    echo "<ul>";
    echo "<li>Host: " . htmlspecialchars($host) . "</li>";
    echo "<li>Database: " . htmlspecialchars($database) . "</li>";
    echo "<li>User: " . htmlspecialchars($user) . "</li>";
    echo "</ul>";
    die();
}
?>
