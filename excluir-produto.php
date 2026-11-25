<?php

require 'src/autenticacao.php';
exigirAutenticacao();
require 'src/conexao-bd.php';
require 'src/Modelo/produtos.php';  
require 'src/Repositorio/produtoRepositorio.php';

$produtoRepositorio = new produtoRepositorio($pdo);
$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
if ($id > 0) {
    $produtoRepositorio->deletar($id);
}

header('Location: admin.php');
exit;
?>

