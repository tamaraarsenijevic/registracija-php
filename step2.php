<?php

require_once __DIR__ . '/includes/session.php';

if (trim($_SESSION['registration']['ime_prezime']) === '') {
    $_SESSION['registration']['flash_error'] = 'Molimo unesite ime i prezime!';
    header('Location: step1.php');
    exit;
}

if ($_SESSION['registration']['max_allowed_step'] < 2) {
    $_SESSION['registration']['flash_error'] = 'Molimo popunite prethodne korake registracije.';
    header('Location: step1.php');
    exit;
}

$error = get_flash_error();
$imePrezime = $_SESSION['registration']['ime_prezime'] ?? '';
$email = $_SESSION['registration']['email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email adresa nije u odgovarajucem formatu!';
    } else {
        $_SESSION['registration']['email'] = $email;
        if ($_SESSION['registration']['max_allowed_step'] < 3) {
            $_SESSION['registration']['max_allowed_step'] = 3;
        }
        header('Location: step3.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<head>
    <title>Tamara Arsenijevic zadatak</title>
</head>
<body>
    <h3>Registracija - korak 2</h3>

    <?php if ($error !== null) { ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php } ?>

    <form id="step2Form" method="post" action="step2.php" novalidate>
        <div>
            <label>Ime i prezime:</label>
            <p><?= htmlspecialchars($imePrezime) ?></p>
        </div>

        <div>
            <label for="email">Email:</label>
            <input
                type="email"
                name="email"
                id="email"
                placeholder="Email"
                value="<?= htmlspecialchars($email) ?>"
            >
        </div>

        <button type="submit">Submit</button>
    </form>

    <nav>
        <a href="step1.php">Korak 1</a> |
        <a href="step2.php">Korak 2</a> |
        <a href="step3.php" id="step3Link">Korak 3</a> |
        <a href="step4.php">Kraj</a>
    </nav>

    <script>
        document.getElementById('step3Link').addEventListener('click', (event) => {
            event.preventDefault();
            document.getElementById('step2Form').requestSubmit();
        });
    </script>
</body>
</html>