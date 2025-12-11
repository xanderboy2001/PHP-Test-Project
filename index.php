<?php
$scripts = [
    'hello_world' => 'scripts/hello_world.sh',
    'datetime' => 'scripts/datetime.sh',
    'disk_usage' => 'scripts/disk_usage.sh',
    'list_files' => 'scripts/list_files.sh',
    'random_number' => 'scripts/random_number.sh',
    'sysinfo' => 'scripts/sysinfo.sh',
    'ping_google' => 'scripts/ping_google.sh'
];

$output = '';
if (isset($_POST['run_script'])) {
    $selected = $_POST['run_script'];

    if (array_key_exists($selected, $scripts)) {
        $command = escapeshellcmd($scripts[$selected]);
        $output = shell_exec($command . ' 2>&1');
    } else {
        $output = "Invalid script selected.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Script Menu</title>
</head>

<body>
    <h1>Script Menu</h1>
    <form method="post">
        <?php foreach ($scripts as $name => $path): ?>
            <button type="submit" name="run_script" value="<?= htmlspecialchars($name) ?>">
                <?= htmlspecialchars($name) ?>
            </button><br><br>
        <?php endforeach; ?>
    </form>

    <?php if ($output): ?>
        <h2>Output:</h2>
        <pre><?= htmlspecialchars($output) ?></pre>
    <?php endif; ?>
</body>

</html>