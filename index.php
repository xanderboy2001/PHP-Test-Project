<?php
$scripts = [
    'hello_world' => 'scripts/hello_world.sh',
    'datetime' => 'scripts/datetime.sh',
    'disk_usage' => 'scripts/disk_usage.sh',
    'list_files' => 'scripts/list_files.sh',
    'random_number' => 'scripts/random_number.sh',
    'sysinfo' => 'scripts/sysinfo.sh',
    'ping_google' => 'scripts/ping_google.sh',
    'cowsay' => 'scripts/cowsay.sh'
];

$output = '';
$require_input = false;
if (isset($_POST['run_script'])) {
    $selected = $_POST['run_script'];

    if (array_key_exists($selected, $scripts)) {
        if ($selected === 'cowsay') {
            $text = escapeshellarg($_POST['cowsay_input'] ?? '');
            $command = "cowsay $text";
        } else {
            $command = escapeshellcmd($scripts[$selected]);
        }
        $output = shell_exec($command . ' 2>&1');
    } else {
        $output = "Invalid script selected.";
    }
}

if (isset($_POST['run_cowsay'])) {
    $user_input = escapeshellarg($_POST['cowsay_input']); //sanitize input
    $command = $scripts['cowsay'] . " " . $user_input;
    $output = shell_exec($command . ' 2>&1');
}

if (isset($_POST['reset'])) {
    $output = '';
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
            <?php if ($name === 'cowsay'): ?>
                <button type="button" onclick="runCowsay()">
                    <?= htmlspecialchars($name) ?>
                </button><br><br>
            <?php else: ?>
                <button type="submit" name="run_script" value="<?= htmlspecialchars($name) ?>">
                    <?= htmlspecialchars($name) ?>
                </button><br><br>
            <?php endif; ?>
        <?php endforeach; ?>
        <button type="submit" name="reset" value="1">Reset Output</button>
        <input type="hidden" id="cowsay_input" name="cowsay_input">
    </form>

    <?php if ($output): ?>
        <h2>Output:</h2>
        <pre><?= htmlspecialchars($output) ?></pre>
    <?php endif; ?>
</body>

<script>
    function runCowsay() {
        const msg = prompt("Enter text");

        if (msg === null) {
            return;
        }

        document.getElementById('cowsay_input').value = msg;

        const form = document.querySelector('form');
        const hiddenScript = document.createElement('input')
        hiddenScript.type = 'hidden';
        hiddenScript.name = 'run_script';
        hiddenScript.value = 'cowsay';
        form.appendChild(hiddenScript);
        form.submit();
    }
</script>

</html>