<?php
$servername = "localhost";
$username = "root"; // Standardbenutzer von XAMPP
$password = ""; // Standardmäßig kein Passwort bei XAMPP
$dbname = "emensawerbeseite"; // Name Ihrer Datenbank

// Verbindung zur Datenbank herstellen
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Überprüfen, ob die Verbindung erfolgreich war
if ($mysqli->connect_error) {
    die("Verbindungsfehler: " . $mysqli->connect_error);
}

// SQL-Abfrage ausführen (z.B. den Namen von Gerichten, deren Name mit einem „K“ beginnt.)
$query = "SELECT name FROM gericht WHERE name LIKE 'K%'";
$result = $mysqli->query($query);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Testdatenbank Ergebnisse</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }
    </style>
</head>
<body>

<h2>Ergebnisse:</h2>

<?php
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Name des Gerichts</th></tr>";
    
    // Ergebnisse in einer Tabelle ausgeben
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row['name'] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "Keine Ergebnisse gefunden!";
}

// Verbindung schließen
$mysqli->close();
?>

</body>
</html>
