<?php

$dataFile = 'newsletter_data.txt';

// Daten aus Datei lesen
$entries = file($dataFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$registrations = array_map('json_decode', $entries, array_fill(0, count($entries), true));

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$itemsPerPage = 10;
$offset = ($page - 1) * $itemsPerPage;

// Sortierung und Filterung
$sortKey = $_GET['sort'] ?? ''; // 'name' oder 'email'
$filterName = $_GET['filterName'] ?? '';

if ($sortKey) {
    usort($registrations, function ($a, $b) use ($sortKey) {
        return strcmp($a[$sortKey], $b[$sortKey]);
    });
}

if ($filterName) {
    $registrations = array_filter($registrations, function ($entry) use ($filterName) {
        return stripos($entry['name'], $filterName) !== false;
    });
}

$totalEntries = count($registrations);
$totalPages = ceil($totalEntries / $itemsPerPage);
$registrations = array_slice($registrations, $offset, $itemsPerPage);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Newsletter Admin</title>
</head>
<body>
    <h1>Übersicht Newsletteranmeldungen</h1>

    <form action="nl-admin.php" method="get">
        Sortieren nach: 
        <select name="sort">
            <option value="name">Name</option>
            <option value="email">E-Mail</option>
        </select>
        <br>
        Filtern nach Name: <input type="text" name="filterName" value="<?php echo htmlspecialchars($filterName); ?>">
        <br>
        <input type="submit" value="Aktualisieren">
    </form>

    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>E-Mail</th>
                <th>Sprache</th>
                <th>Datenschutz (Zustimmung)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($registrations as $registration): ?>
            <tr>
                <td><?php echo htmlspecialchars($registration['name']); ?></td>
                <td><?php echo htmlspecialchars($registration['email']); ?></td>
                <td><?php echo htmlspecialchars($registration['language']); ?></td>
                <td>Ja</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
    for ($i = 1; $i <= $totalPages; $i++) {
    echo "<a href='nl-admin.php?page=$i";
    if ($sortKey) {
        echo "&sort=$sortKey";
    }
    if ($filterName) {
        echo "&filterName=" . urlencode($filterName);
    }
    echo "'>$i</a> ";
}?>
</body>
</html>
