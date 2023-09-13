<?php
// Pfad zur JSON-Datei (bitte anpassen, falls nötig)
$jsonFilePath = "gerichte.json";

// JSON-Datei lesen und in ein PHP-Array konvertieren
$gerichte = json_decode(file_get_contents($jsonFilePath), true);

if (isset($_GET['message']) && $_GET['message'] == 'success') {
    echo "<p>Sie wurden erfolgreich für den Newsletter angemeldet!</p>";
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
            <th>Bild</th>
            <th>Gericht</th>
            <th>Preis intern</th>
            <th>Preis extern</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($gerichte as $gericht): ?>
            <tr>
                <td><img src="/praktikum_2/werbeseite/img/<?php echo $gericht['bild']; ?>" alt="<?php echo $gericht['name']; ?>" style="width: 50px;"></td>
                <td><?php echo $gericht['name']; ?></td>
                <td><?php echo $gericht['intern']; ?></td>
                <td><?php echo $gericht['extern']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


    <h2 id="numbers">E-Mensa in Zahlen</h2>

    <div class="statistics">
        <p>X Besuche</p>
        <p>Y Anmeldungen zum Newsletter</p>
        <p>Z Speisen</p>
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
        <p>&copy; E-Mensa GmbH | &lt;Ihre Namen hier&gt; | <a href="#">Impressum</a></p>
    </footer>
</body>
</html>
