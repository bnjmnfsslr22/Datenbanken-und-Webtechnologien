<?php

$dataFile = 'newsletter_data.txt';

$servername = "localhost";
$username = "root"; // Standardbenutzer von XAMPP
$password = ""; // Standardmäßig kein Passwort bei XAMPP
//$dbname = "emensa";

// Verbindung zur emensa Datenbank
$dbname1 = "emensa";
$connEmensa = new mysqli($servername, $username, $password, $dbname1);
if ($connEmensa->connect_error) {
    die("Verbindung mit emensa fehlgeschlagen: " . $connEmensa->connect_error);
}

// Verbindung zur emansawerbeseite Datenbank
$dbname2 = "emensawerbeseite";
$connEmanWerbeseite = new mysqli($servername, $username, $password, $dbname2);
if ($connEmanWerbeseite->connect_error) {
    die("Verbindung mit emansawerbeseite fehlgeschlagen: " . $connEmanWerbeseite->connect_error);
}

// Gerichte aus der Datenbank laden
$sql = "SELECT * FROM Gericht ORDER BY name ASC LIMIT 8";
$result = $connEmanWerbeseite->query($sql);

$gerichte = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $gerichte[] = $row;
    }
}
/*
echo "<pre>";
print_r($gerichte);
echo "</pre>";
*/
// Allergene für jedes Gericht laden
foreach ($gerichte as &$gericht) {
    $sql_allergene = "SELECT Allergen.code FROM Allergen
                      JOIN gericht_hat_allergen ON Allergen.code = gericht_hat_allergen.code
                      WHERE gericht_hat_allergen.gericht_id = " . $gericht['id'];
    $result_allergene = $connEmanWerbeseite->query($sql_allergene);

    $allergene = [];
    if ($result_allergene->num_rows > 0) {
        while($row_allergene = $result_allergene->fetch_assoc()) {
            $allergene[] = $row_allergene['code'];
        }
    }
    $gericht['allergene'] = $allergene;
}
unset($gericht);

if (isset($_GET['message']) && $_GET['message'] == 'success') {
    echo "<p>Sie wurden erfolgreich für den Newsletter angemeldet!</p>";
}

$newsletterEntries = file($dataFile , FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$newsletterCount = count($newsletterEntries);

$ip = $connEmensa->real_escape_string($_SERVER['REMOTE_ADDR']);
$sql = "SELECT * FROM visitors WHERE ip_address = '$ip' AND visit_date = CURDATE()";
$result = $connEmensa->query($sql);

if ($result->num_rows == 0) {
    $sql = "INSERT INTO visitors (ip_address, visit_date) VALUES ('$ip', CURDATE())";
    $connEmensa->query($sql);
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>E-Mensa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: auto;
            border: 2px solid black;
            padding: 20px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            border: 2px solid black;
            padding: 10px;
        }

        nav {
            border: 2px solid black;
            padding: 10px;
        }

        nav a {
            margin: 0 10px;
            text-decoration: none;
            color: black;
        }

        hr {
            border: 1px solid black;
            margin: 20px 0;
        }

        .diagonal-box {
            border: 2px solid black;
            width: 100px;
            height: 100px;
            background: linear-gradient(45deg, transparent 25%, black 25%, black 50%, transparent 50%),
                        linear-gradient(-45deg, transparent 25%, black 25%, black 50%, transparent 50%);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        footer {
            text-align: center;
            margin-top: 20px;
        }

        .statistics {
            display: flex;
            justify-content: space-between;
        }

        .form-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">E-Mensa Logo</div>
        <nav>
            <a href="#announcement">Ankündigung</a>
            <a href="#dishes">Speisen</a>
            <a href="#numbers">Zahlen</a>
            <a href="#contact">Kontakt</a>
            <a href="#important">Wichtig für uns</a>
        </nav>
    </header>

    <hr>

    <div class="diagonal-box"></div>

    <h1 id="announcement">Bald gibt es Essen auch online ;)</h1>

    <div style="border: 2px solid black; padding: 10px;">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin tristique nulla nec eros vehicula, in consequat elit vehicula.
    </div>

    <h2 id="dishes">Köstlichkeiten, die sie erwarten</h2>

<table>
    <thead>
        <tr>
            <!-- Das Bild wurde hier entfernt -->
            <th>Gericht</th>
            <th>Preis intern</th>
            <th>Preis extern</th>
            <th>Allergene</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($gerichte as $gericht):?>
            <tr>
                <!-- Auch hier wurde der Bild-Teil entfernt -->
                <td><?php echo $gericht['name']; ?></td>
                <td><?php echo $gericht['preis_intern']; ?></td>
                <td><?php echo $gericht['preis_extern']; ?></td>
                <td><?php echo implode(', ', $gericht['allergene']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h3>Allergene Legende:</h3>
<ul>
    <?php 
    $allergenCodesSql = "SELECT code, name FROM Allergen";
    $allergenCodesResult = $connEmanWerbeseite->query($allergenCodesSql);
    while($allergen = $allergenCodesResult->fetch_assoc()): ?>
        <li><strong><?php echo $allergen['code']; ?>:</strong> <?php echo $allergen['name']; ?></li>
    <?php endwhile; ?>
</ul>


    <h2 id="numbers">E-Mensa in Zahlen</h2>

    <div class="statistics">
    <p><?php echo $connEmensa->query("SELECT COUNT(*) as count FROM visitors")->fetch_assoc()['count']; ?> Besuche</p>
    <p><?php echo $newsletterCount; ?> Anmeldungen zum Newsletter</p>
    <p><?php echo count($gerichte); ?> Speisen</p>
</div>


    <h2 id="contact">Interesse geweckt? Wir informieren Sie!</h2>

    <form action="newsletter.php" method="post">
    <div>
        <label for="name">Ihr Name</label>
        <input type="text" id="name" name="name" placeholder="Vorname">
    </div>
    <div>
        <label for="email">Ihre E-Mail</label>
        <input type="email" id="email" name="email">
    </div>
    <div>
        <label for="language">Newsletter bitte in:</label>
        <select id="language" name="language">
            <option value="de">Deutsch</option>
            <option value="en">English</option>
        </select>
    </div>
    <div style="margin-top: 20px;"> 
        <input type="checkbox" id="terms" name="terms">
        <label for="terms">Den Datenschutzbestimmungen stimme ich zu.</label>
    </div>
    <button type="submit">Zum Newsletter anmelden</button>
</form>

    <h2 id="important">Das ist uns wichtig</h2>

    <ul>
        <li>Beste frische saisonale Zutaten</li>
        <li>Ausgewogene abwechslungsreiche Gerichte</li>
        <li>Sauberkeit</li>
    </ul>

    <footer>
        <p>Wir freuen uns auf Ihren Besuch!</p>
        <hr style="margin-top: 20px;">
        <p>&copy; E-Mensa GmbH | &lt;Benjamin Füßler&gt; | <a href="#">Impressum</a></p>
    </footer>
</body>
</html>
<?php 
$connEmensa->close();
$connEmanWerbeseite->close(); ?>