<?php
require_once __DIR__ . '/includes/session.php';

if (trim($_SESSION['registration']['ime_prezime']) === '') {
    $_SESSION['registration']['flash_error'] = 'Molimo unesite ime i prezime!';
    header('Location: step1.php');
    exit;
}

if (!filter_var($_SESSION['registration']['email'], FILTER_VALIDATE_EMAIL)) {
    $_SESSION['registration']['flash_error'] = 'Email adresa nije u odgovarajucem formatu!';
    header('Location: step2.php');
    exit;
}

if ($_SESSION['registration']['max_allowed_step'] < 3) {
    $_SESSION['registration']['flash_error'] = 'Molimo popunite prethodne korake registracije.';
    header('Location: step2.php');
    exit;
}

$error = get_flash_error();
$imePrezime = $_SESSION['registration']['ime_prezime'] ?? '';
$email = $_SESSION['registration']['email'] ?? '';
$prihvaceniUslovi = $_SESSION['registration']['prihvaceni_uslovi'] ?? false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prihvaceniUslovi = isset($_POST['prihvaceni_uslovi']);
    $_SESSION['registration']['prihvaceni_uslovi'] = $prihvaceniUslovi;

    if (!$prihvaceniUslovi) {
        $error = 'Molimo prihvatite uslove registracije!';
    } else {
        if ($_SESSION['registration']['max_allowed_step'] < 4) {
            $_SESSION['registration']['max_allowed_step'] = 4;
        }
        header('Location: step4.php');
        exit;
    }
}
?>


<!DOCTYPE html>
<head>
    <title>Tamara Arsenijevic zadatak</title>
</head>
<body>
    <h3>Registracija - korak 3</h3>
    <?php if ($error !== null) { ?>
        <p style="color: red;"><?= $error ?></p>
    <?php } ?>

    <p>Ime i prezime: <?= $imePrezime ?></p>
    <p>Email: <?= $email ?></p>

    <form id="step3Form" method="post" action="step3.php" novalidate>
        <div>
            <label>
                <input
                    type="checkbox"
                    name="prihvaceni_uslovi"
                    value="1"
                    <?= $prihvaceniUslovi ? 'checked' : '' ?>
                >
                Prihvatam uslove registracije
            </label>
        </div>

        <button type="submit">Zavrsi registraciju</button>
    </form>

    <nav>
        <a href="step1.php">Korak 1</a> |
        <a href="step2.php">Korak 2</a> |
        <a href="step3.php">Korak 3</a> |
        <a href="step4.php" id="step4Link">Kraj</a>
    </nav>

    <script>
        document.getElementById('step4Link').addEventListener('click', (event) => {
            event.preventDefault();
            document.getElementById('step3Form').requestSubmit();
        });
    </script>
</body>
</html>