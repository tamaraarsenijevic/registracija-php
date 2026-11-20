<?php
require_once __DIR__ . '/includes/session.php';

$error = get_flash_error();
$imePrezime = $_SESSION['registration']['ime_prezime'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imePrezime = trim($_POST['ime_prezime'] ?? '');

    if ($imePrezime === '') {
        $error = 'Molimo unesite ime i prezime!';
    } else {
        $_SESSION['registration']['ime_prezime'] = $imePrezime;
        if ($_SESSION['registration']['max_allowed_step'] < 2) {
            $_SESSION['registration']['max_allowed_step'] = 2;
        }
        header('Location: step2.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<head>
    <title>Tamara Arsenijevic zadatak</title>
</head>
<body>
    <h3>Registracija - korak 1</h3>

    <?php if ($error !== null) { ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php } ?>

    <form id="step1Form" method="post" action="step1.php">
        <p>Ime i prezime:</p>
        <input
            type="text"
            name="ime_prezime"
            value="<?= htmlspecialchars($imePrezime) ?>"
        >
        <button type="submit">Submit</button>
    </form>

    <p>
        <a href="step1.php">Korak 1</a> |
        <a href="step2.php" id="step2Link">Korak 2</a> |
        <a href="step3.php">Korak 3</a> |
        <a href="step4.php">Kraj</a>
    </p>

    <script>
        document.getElementById('step2Link').addEventListener('click', (event) => {
            event.preventDefault();
            document.getElementById('step1Form').submit();
        });
    </script>
</body>
</html>