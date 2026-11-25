<?php

require __DIR__ . '/src/autenticacao.php';

if (($_SESSION['admin_autenticado'] ?? false) === true) {
    header('Location: admin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.html');
    exit;
}

$emailConfigurado = obterVariavelAmbiente('ADMIN_EMAIL') ?? 'admin@limonedoro.com';
$senhaConfigurada = obterVariavelAmbiente('ADMIN_PASSWORD') ?? 'admin123';

$email = $_POST['email'] ?? '';
$senha = $_POST['password'] ?? '';
$emailConfigurado = strtolower(trim($emailConfigurado));

if (!is_string($email) || !is_string($senha) || !filter_var(trim($email), FILTER_VALIDATE_EMAIL) || !hash_equals($emailConfigurado, strtolower(trim($email))) || !hash_equals($senhaConfigurada, $senha)) {
    header('Location: login.html?erro=credenciais');
    exit;
}

session_regenerate_id(true);
$_SESSION['admin_autenticado'] = true;

header('Location: admin.php');
exit;
