<?php

function addieren($a, $b = 0) {
    return $a + $b;
}

function multiplizieren($a, $b) {
    return $a * $b;
}

$result = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $a = $_POST['a'];
    $b = $_POST['b'];

    if (isset($_POST['addieren'])) {
        $result = addieren($a, $b);
    } elseif (isset($_POST['multiplizieren'])) {
        $result = multiplizieren($a, $b);
    }
}

?>

<form method="post">
    a: <input type="number" name="a"><br>
    b: <input type="number" name="b"><br>
    <input type="submit" name="addieren" value="addieren">
    <input type="submit" name="multiplizieren" value="multiplizieren">
</form>

<?php echo $result; ?>
