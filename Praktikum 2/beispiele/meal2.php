<?php
const GET_PARAM_MIN_STARS = 'search_min_stars';
const GET_PARAM_SEARCH_TEXT = 'search_text';
const GET_PARAM_SHOW_DESC = 'show_description';
const GET_PARAM_LANGUAGE = 'sprache';

$language = isset($_GET[GET_PARAM_LANGUAGE]) && $_GET[GET_PARAM_LANGUAGE] == 'en' ? 'en' : 'de';

$translations = [
    'de' => [
        'title' => 'Gericht',
        'filter' => 'Filter',
        'search' => 'Suchen'
    ],
    'en' => [
        'title' => 'Meal',
        'filter' => 'Filter',
        'search' => 'Search'
    ]
];

$allergens = [
    11 => 'Gluten',
    12 => 'Krebstiere',
    13 => 'Eier',
    14 => 'Fisch',
    17 => 'Milch'
];

$meal = [
    'name' => 'Süßkartoffeltaschen mit Frischkäse und Kräutern gefüllt',
    'description' => 'Die Süßkartoffeln werden vorsichtig aufgeschnitten und der Frischkäse eingefüllt.',
    'price_intern' => 2.90,
    'price_extern' => 3.90,
    'allergens' => [11, 13],
    'amount' => 42
];

$ratings = [
    ['text' => 'Die Kartoffel ist einfach klasse. Nur die Fischstäbchen schmecken nach Käse.', 'author' => 'Ute U.', 'stars' => 2],
    ['text' => 'Sehr gut. Immer wieder gerne', 'author' => 'Gustav G.', 'stars' => 4],
    ['text' => 'Der Klassiker für den Wochenstart. Frisch wie immer', 'author' => 'Renate R.', 'stars' => 4],
    ['text' => 'Kartoffel ist gut. Das Grüne ist mir suspekt.', 'author' => 'Marta M.', 'stars' => 3]
];

// Searching for ratings
$searchTerm = strtolower($_GET[GET_PARAM_SEARCH_TEXT] ?? '');
$showRatings = array_filter($ratings, function($rating) use ($searchTerm) {
    return strpos(strtolower($rating['text']), $searchTerm) !== false;
});

// Average rating
function calcMeanStars($ratings): float {
    $sum = 0;
    foreach ($ratings as $rating) {
        $sum += $rating['stars'];
    }
    return $sum / count($ratings);
}
?>

<!DOCTYPE html>
<html lang="<?php echo $language; ?>">
<head>
    <meta charset="UTF-8"/>
    <title><?php echo $translations[$language]['title']; ?>: <?php echo $meal['name']; ?></title>
    <style type="text/css">
        * {
            font-family: Arial, serif;
        }
        .rating {
            color: darkgray;
        }
    </style>
</head>
<body>
<h1><?php echo $translations[$language]['title']; ?>: <?php echo $meal['name']; ?></h1>
<p><?php echo isset($_GET[GET_PARAM_SHOW_DESC]) && $_GET[GET_PARAM_SHOW_DESC] == 'yes' ? $meal['description'] : ''; ?></p>
<ul>
    <?php foreach ($meal['allergens'] as $allergen) { echo "<li>$allergens[$allergen]</li>"; } ?>
</ul>
<h1><?php echo $translations[$language]['title']; ?> (<?php echo number_format(calcMeanStars($ratings), 2, ',', ''); ?>)</h1>
<form method="get">
    <label for="search_text"><?php echo $translations[$language]['filter']; ?>:</label>
    <input id="search_text" type="text" name="search_text" value="<?php echo $searchTerm; ?>">
    <input type="submit" value="<?php echo $translations[$language]['search']; ?>">
</form>
<table class="rating">
    <thead>
    <tr>
        <td>Text</td>
        <td>Sterne</td>
        <td>Autor</td>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($showRatings as $rating) {
        echo "<tr>
              <td class='rating_text'>{$rating['text']}</td>
              <td class='rating_stars'>{$rating['stars']}</td>
              <td class='rating_author'>{$rating['author']}</td>
              </tr>";
    }
    ?>
    </tbody>
</table>

<!-- Language Links -->
<a href="?sprache=de">Deutsch</a>
<a href="?sprache=en">English</a>
</body>
</html>
