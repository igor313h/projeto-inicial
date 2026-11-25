<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    ]);
    session_start();
}

function obterVariavelAmbiente(string $nome): ?string
{
    $valor = getenv($nome);

    if (!is_string($valor) || $valor === '') {
        $valor = $_SERVER[$nome] ?? $_ENV[$nome] ?? null;
    }

    return is_string($valor) && $valor !== '' ? $valor : null;
}

function exigirAutenticacao(): void
{
    if (($_SESSION['admin_autenticado'] ?? false) !== true) {
        header('Location: login.html');
        exit;
    }
}
