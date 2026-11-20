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

if ($_SESSION['registration']['max_allowed_step'] < 4) {
    $_SESSION['registration']['flash_error'] = 'Molimo popunite prethodne korake registracije.';
    header('Location: step3.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nova_registracija'])) {
    reset_registration();
    header('Location: step1.php');
    exit;
}
?>

<!DOCTYPE html>
<head>
    <title>Tamara Arsenijevic zadatak</title>
</head>
<body>
    <h3>Registracija - uspesna</h3>
    <p>Hvala!</p>
    <form method="post" action="step4.php">
        <button type="submit" name="nova_registracija" value="1">Nova registracija</button>
    </form>
</body>
</html>