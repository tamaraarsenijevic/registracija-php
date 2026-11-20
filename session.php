<?php

session_start();

if (!isset($_SESSION['registration']) || !is_array($_SESSION['registration'])) {
    $_SESSION['registration'] = [
        'ime_prezime' => '',
        'email' => '',
        'prihvaceni_uslovi' => false,
        'max_allowed_step' => 1,
        'flash_error' => null,
    ];
}

function get_flash_error()
{
    $error = $_SESSION['registration']['flash_error'] ?? null;
    $_SESSION['registration']['flash_error'] = null;
    return is_string($error) ? $error : null;
}

function reset_registration()
{
    $_SESSION['registration'] = [
        'ime_prezime' => '',
        'email' => '',
        'prihvaceni_uslovi' => false,
        'max_allowed_step' => 1,
        'flash_error' => null,
    ];
}