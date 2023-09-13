<?php

$famousMeals = [
    1 => ['name' => 'Currywurst mit Pommes', 'winner' => [2001, 2003, 2007, 2010, 2020]],
    2 => ['name' => 'Hähnchencrossies mit Paprikareis', 'winner' => [2002, 2004, 2008]],
    3 => ['name' => 'Spaghetti Bolognese', 'winner' => [2011, 2012, 2017]],
    4 => ['name' => 'Jägerschnitzel mit Pommes', 'winner' => 2019]
];

function missingYears($meals) {
    $allYears = range(2000, date('Y'));
    $winnerYears = [];
    foreach ($meals as $meal) {
        if (is_array($meal['winner'])) {
            $winnerYears = array_merge($winnerYears, $meal['winner']);
        } else {
            $winnerYears[] = $meal['winner'];
        }
    }
    return array_diff($allYears, $winnerYears);
}

?>

<style>
    li {
        margin-bottom: 10px;
    }
</style>

<ul>
<?php foreach ($famousMeals as $meal): ?>
    <li>
        <?php echo $meal['name']; ?> - Gewonnen in den Jahren: <?php echo is_array($meal['winner']) ? implode(", ", $meal['winner']) : $meal['winner']; ?>
    </li>
<?php endforeach; ?>
</ul>

Fehlende Jahre: <?php echo implode(", ", missingYears($famousMeals)); ?>
